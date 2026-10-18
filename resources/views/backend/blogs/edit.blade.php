<div class="modal fade" id="editBlogModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form id="editBlogForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editBlogId" name="blog_id">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-primary"></i>
                        <span>Edit Blog</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" id="editBlogTitle" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Slug
                            </label>
                            <input type="text" name="slug" id="editBlogSlug" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Category <span class="text-danger">*</span>
                            </label>
                            <select name="blog_category_id" id="editBlogCategory" class="form-select" required>
                                <option value="">
                                    Select Category
                                </option>
                                @foreach (\App\Models\BlogCategory::all() as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Date
                            </label>
                            <input type="date" name="date" id="editBlogDate" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Image
                            </label>
                            <input type="file" name="image" id="editImage" class="form-control">
                            <img id="previewEditImage" class="mt-2 rounded border" style="width:90px;display:none;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Status
                            </label>
                            <select name="status" id="editStatus" class="form-select">
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
                            <textarea name="description" id="editDescription" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Update Blog</button>
                </div>
            </form>
        </div>
    </div>
</div>
