<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Newsletter;
use App\Models\Order;
use App\Models\OurService;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)->whereNull('parent_id')->with('children')->withCount('products')->orderBy('name')->get();
        $catalog = Product::where('status', 1)->whereNull('deleted_at')->with(['category', 'variants']);
        $products = (clone $catalog)->latest()->take(8)->get();
        $bestsellers = (clone $catalog)->where('is_bestseller', 1)->latest()->take(4)->get();
        $services = OurService::where('status', 1)->latest()->take(3)->get();
        $sliders = Slider::where('status', '1')->whereNotNull('image')->where('image', '!=', '')->latest()->orderByDesc('id')->get();

        return view('frontend.home.index', compact('categories', 'products', 'bestsellers', 'services', 'sliders'));
    }

    public function modalData($id)
    {
        $product = Product::with([
            'images',
            'category',
            'colors.color',
            'colors.images',
            'variants.size',
            'variants.color',
        ])->findOrFail($id);

        $uniqueSizes = $product->variants->pluck('size')->filter()->unique('id');

        $sizes = $uniqueSizes->map(function ($size) use ($product) {
            $stock = $product->variants
                ->where('size_id', $size->id)
                ->sum('stock');

            return [
                'id' => $size->id,
                'name' => $size->name ?? 'N/A',
                'stock' => $stock,
            ];
        })->values();

        $colors = $product->colors->map(function ($color) use ($product) {
            $stock = $product->variants
                ->where('color_id', $color->color_id)
                ->sum('stock');

            return [
                'id' => $color->color_id,
                'name' => $color->color->name ?? '',
                'code' => $color->color->code ?? '#ccc',
                'stock' => $stock,
                'images' => $color->images ?? [],
            ];
        });

        $variants = $product->variants->map(function ($variant) {
            return [
                'size_id' => $variant->size_id,
                'color_id' => $variant->color_id,
                'stock' => $variant->stock,
                'selling_price' => $variant->selling_price,
            ];
        });

        $totalStock = $product->product_type === 'multiple'
                        ? $product->variants->sum('stock')
                        : $product->stock;

        return response()->json([
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->selling_price,
                'description' => $product->description,
                'category' => $product->category,
                'images' => $product->images,
            ],

            'sizes' => $sizes,
            'colors' => $colors,
            'variants' => $variants,
            'has_sizes' => $sizes->count() > 0,
            'has_colors' => $colors->count() > 0,
            'total_stock' => $totalStock,
        ]);
    }

        public function categoryProducts(Request $request, $slug)
    {
        $category = Category::with(['parent', 'children'])->where('slug', $slug)->firstOrFail();
        $categoryIds = [$category->id];
        $children = Category::where('parent_id', $category->id)->pluck('id')->toArray();
        if(count($children) > 0) {
            $categoryIds = array_merge($categoryIds, $children);
            $grandchildren = Category::whereIn('parent_id', $children)->pluck('id')->toArray();
            if(count($grandchildren) > 0) {
                $categoryIds = array_merge($categoryIds, $grandchildren);
            }
        }

        $query = Product::with(['category', 'variants'])->where('status', 1);
        $query->whereIn('category_id', $categoryIds);

        if ($request->filled('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        if ($request->filled('brand')) {
            $query->whereIn('brand_id', $request->brand);
        }

        if ($request->filled('size')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereIn('size_id', $request->size);
            });
        }

        if ($request->filled('min_price')) {
            $query->where('selling_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('selling_price', '<=', $request->max_price);
        }

        switch ($request->sort) {
            case 'price_low':  $query->orderBy('selling_price', 'asc');
                break;
            case 'price_high': $query->orderBy('selling_price', 'desc');
                break;
            default:           $query->latest();
                break;
        }

        $products = $query->paginate(16)->appends($request->all());

        $filterUrl = route('category.show', $slug);

        if ($request->ajax()) {

            return response()->json([
                'html' => view('frontend.home.partials.product_list', compact('products'))->render(),
            ]);
        }

        return view('frontend.home.category-products', compact(
            'category', 'products', 'filterUrl'
        ));
    }

    public function productShow($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 1)
            ->with([
                'images',
                'category',
                'brand',
                'colors.color',
                'colors.images',
                'variants.size',
                'variants.color',
                'attributes.options',
            ])
            ->firstOrFail();

        $uniqueSizes = $product->variants->pluck('size')->filter()->unique('id');
        $product->setRelation('sizes', $uniqueSizes);

        return view('frontend.home.single', compact('product'));
    }

    public function bestsellers(Request $request)
    {
        $query = Product::where('status', 1)
            ->where('is_bestseller', 1)
            ->with(['variants', 'category']);

        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('selling_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('selling_price', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
                break;
        }

        $bestsellers = $query->paginate(24)->appends($request->all());

        return view('frontend.bestsellers', compact('bestsellers'));
    }

    public function search(Request $request)
    {
        $query = Product::with([
            'category',
            'variants',
        ])->where('status', 1);

        // Product Name Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $category = null;

                // Category Search
        if ($request->filled('category_id')) {
            $catId = $request->category_id;

            // Get all nested IDs
            $categoryIds = [$catId];
            $children = Category::where('parent_id', $catId)->pluck('id')->toArray();
            if(count($children) > 0) {
                $categoryIds = array_merge($categoryIds, $children);
                $grandchildren = Category::whereIn('parent_id', $children)->pluck('id')->toArray();
                if(count($grandchildren) > 0) {
                    $categoryIds = array_merge($categoryIds, $grandchildren);
                }
            }

            $query->whereIn('category_id', $categoryIds);

            $category = Category::with(['parent', 'children'])
                ->where('id', $catId)
                ->where('status', 1)
                ->first();
        }

        $products = $query->latest()
            ->paginate(12)
            ->appends($request->all());

        // Ajax Filter URL
        if ($category) {
            $filterUrl = route('category.show', $category->slug);
        } else {
            $filterUrl = route('search');
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view(
                    'frontend.home.partials.product_list',
                    compact('products')
                )->render(),
            ]);
        }

        return response()
            ->view(
                'frontend.home.category-products',
                compact(
                    'category',
                    'products',
                    'filterUrl'
                )
            )
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function searchSuggestion(Request $request)
    {
        $products = Product::where('status', 1)
            ->select(['id', 'name', 'slug', 'image', 'selling_price'])
            ->where('name', 'like', '%'.$request->search.'%')
            ->take(8)
            ->get();

        return view('frontend.home.search-suggestion', compact('products'));
    }

    public function privacyPolicy()
    {
        return view('frontend.home.privacy-policy');
    }

    public function termsConditions()
    {
        return view('frontend.home.terms-conditions');
    }

    public function returnPolicy()
    {
        return view('frontend.home.return-policy');
    }

    public function shippingPolicy()
    {
        return view('frontend.home.shipping-policy');
    }

    public function contactUs()
    {
        return view('frontend.home.contact-us');
    }

    public function contactUsSend(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'subject' => $request->subject,
            'phone' => $request->phone,
        ];
        Contact::create($data);

        return back()->with('success', 'Thank you for contacting us!');
    }

    public function about()
    {
        $about_us = AboutUs::first();
        $teams = Team::where('status', 1)->get();
        $services = OurService::where('status', 1)->take(3)->get();
        $testimonials = Testimonial::where('status', 1)->get();
        $clients = Client::where('status', 1)->get();

        return view('frontend.home.about-us', compact('about_us', 'teams', 'services', 'testimonials', 'clients'));
    }

    public function newsletterSubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ], [
            'email.required' => 'Please enter your email.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already subscribed.',
        ]);
        Newsletter::create([
            'email' => $request->email,
        ]);

        $storeName = setting('website_title') ?: setting('company_name', 'our store');
        return back()->with('success', "Thanks for subscribing to {$storeName}!");
    }

    public function thankYou($order)
    {
        $order = Order::where('order_number', $order)->firstOrFail();
        abort_unless(session('placed_orders.'.$order->order_number) || (auth('customer')->check() && (int) $order->user_id === (int) auth('customer')->id()), 404);

        return view('frontend.home.thank-you', compact('order'));
    }

    public function orderTrack()
    {
        return view('frontend.home.order-track');
    }

    public function trackOrder(Request $request)
    {
        $order = null;

        // User jodi order_id diye search kore
        if ($request->has('order_id') && $request->order_id != '') {
            // Apnar Order model er nam onujayi khujbe (e.g., order_number ba id)
            $request->validate(['order_id' => 'required|string|max:64', 'phone' => ['required', 'regex:/^01[3-9][0-9]{8}$/']]);
            $order = Order::where('order_number', $request->order_id)->where('phone', $request->phone)->first();

            if (! $order) {
                return redirect()->back()->with('error', 'Order ID ti sothik noy!');
            }
        }

        return view('frontend.home.order-track', compact('order'));
    }

    public function ourBlogs()
    {
        $blogs = Blog::with('category')->where('status', 'active')->latest()->paginate(9);

        return view('frontend.home.our_blogs', compact('blogs'));
    }

    public function blogDetails($slug)
    {
        $blog = Blog::with(['category', 'user'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $recent_blogs = Blog::where('status', 'active')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(4)
            ->get();

        $categories = BlogCategory::withCount('blogs')->get();

        return view('frontend.home.blog_details', compact('blog', 'recent_blogs', 'categories'));
    }

    public function serviceDetails($slug)
    {
        $service = DB::table('our_services')->where('slug', $slug)->where('status', 1)->first();

        if (! $service) {
            abort(404);
        }

        return view('frontend.service.details', compact('service'));
    }
}




