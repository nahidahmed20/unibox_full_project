<div class="modal fade" id="createBlogModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form id="createBlogForm" enctype="multipart/form-data">
                @csrf
                {{-- HEADER --}}
                <div class="modal-header">
                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                        <i class="fa-solid fa-blog text-primary"></i>
                        <span>Add Blog</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- BODY --}}
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="blogTitle" class="form-control"
                                placeholder="Enter title" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Slug</label>
                            <input type="text" name="slug" id="blogSlug" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                            <select name="blog_category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach (\App\Models\BlogCategory::all() as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Image</label>
                            <input type="file" name="image" id="createImage" class="form-control">
                            <img id="previewCreateImage" class="mt-2 rounded border" style="width:90px;display:none;">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="active">
                                    Active
                                </option>
                                <option value="inactive">
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">
                                Description
                            </label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Write description"></textarea>
                        </div>
                    </div>
                </div>
                {{-- FOOTER --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Save Blog</button>
                </div>
            </form>
        </div>
    </div>
</div>
