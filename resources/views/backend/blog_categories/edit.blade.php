<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form id="editCategoryForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editCategoryId">
                {{-- HEADER --}}
                <div class="modal-header">
                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-primary"></i>
                        <span>Edit Blog Category</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- BODY --}}
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="editCategoryName" class="form-control"
                            placeholder="Enter category name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold"> Slug </label>
                        <input type="text" name="slug" id="editCategorySlug" class="form-control"
                            placeholder="Auto generated" readonly>
                    </div>
                </div>
                {{-- FOOTER --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
