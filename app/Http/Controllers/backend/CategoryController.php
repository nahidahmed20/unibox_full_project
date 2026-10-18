<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view category', only: ['index', 'show']),
            new Middleware('permission:create category', only: ['create', 'store']),
            new Middleware('permission:edit category', only: ['edit', 'update']),
            new Middleware('permission:destroy category', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.category.index');
    }

        public function getData()
    {
        $categories = Category::with('parent')->latest();

        return datatables()->of($categories)
            ->addIndexColumn()
            ->addColumn('parent', function ($row) {
                return $row->parent ? e($row->parent->name) : '<span class="badge bg-secondary-subtle text-secondary border px-2 py-1">None</span>';
            })
            ->addColumn('image', function ($row) {
                if ($row->image && file_exists(public_path($row->image))) {
                    return '<img src="'.asset($row->image).'" class="rounded-3 border shadow-sm object-fit-cover" width="48" height="48" alt="'.e($row->name).'">';
                }
                return '<div class="d-inline-flex align-items-center justify-content-center rounded-3 bg-light border text-muted" style="width: 48px; height: 48px;" title="No Image"><i class="bi bi-image" style="font-size: 1.25rem;"></i></div>';
            })
            ->addColumn('description', function ($row) {
                return $row->description ? Str::limit(e($row->description), 50) : '<span class="text-muted fst-italic" style="font-size: 12px;">No description</span>';
            })
            ->addColumn('status', function ($row) {
                $isActive = in_array((string)$row->status, ['1', 'active', 'true'], true);
                return $isActive
                    ? '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i>Active</span>'
                    : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="bi bi-x-circle me-1"></i>Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                $buttons = '';
                if (auth()->user()->can('category-edit')) {
                    $buttons .= '
                        <button type="button" class="btn btn-icon btn-soft-primary btn-edit"
                            data-id="'.$row->id.'" title="Edit Category">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                    ';
                }

                if (auth()->user()->can('category-delete')) {
                    $buttons .= '
                        <form class="delete-form d-inline" action="'.route('categories.destroy', $row->id).'" method="POST">
                            '.csrf_field().method_field('DELETE').'
                            <button
                                type="button" class="btn btn-icon btn-soft-danger btn-delete" title="Delete Category">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>
                    ';
                }

                return '
                    <div class="d-flex align-items-center justify-content-center gap-2">'.$buttons.' </div>
                ';
            })
            ->rawColumns(['parent', 'image', 'description', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
        public function getChildCategories($id)
    {
        $children = Category::where('parent_id', $id)->get();
        return response()->json($children);
    }

    public function create()
    {
        return view('backend.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:4096',
            'status' => 'required',
        ]);

        $data['slug'] = Str::slug($request->name);
        $data['status'] = in_array((string)$request->status, ['1', 'active', 'true'], true) ? '1' : '0';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/categories'), $filename);
            $data['image'] = 'uploads/categories/'.$filename;
        }

        if ($request->category_id) {
            $category = Category::find($request->category_id);
            $category->update($data);
            $msg = 'Category updated successfully';
        } else {
            $category = Category::create($data);
            $msg = 'Category added successfully';
        }

        // **Return JSON response with new data**
        return response()->json([
            'message' => $msg,
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'image' => $category->image ? asset($category->image) : null,
                'status' => $category->status,
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        if ($category->image) {
            $category->image = asset($category->image);
        }
        $category->status = in_array((string)$category->status, ['1', 'active', 'true'], true) ? '1' : '0';

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required',
        ]);

        $data = $request->only(['parent_id', 'name', 'description', 'status']);
        $data['slug'] = Str::slug($request->name);
        $data['status'] = in_array((string)$request->status, ['1', 'active', 'true'], true) ? '1' : '0';

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/categories'), $filename);
            $data['image'] = 'uploads/categories/'.$filename;
        }

        $category->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully!',
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'image' => $category->image ? asset($category->image) : null,
                'status' => $category->status,
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully',
        ]);
    }
}






