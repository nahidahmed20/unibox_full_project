<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 bg-light px-4 pt-4 pb-3">
                <h5 class="modal-title fw-bold text-dark d-flex align-items-center">
                    <i class="bi bi-person-plus-fill text-primary me-2 fs-4"></i> Add New Customer
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <form id="addCustomerForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-muted">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-muted">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" placeholder="01XXXXXXXXX" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-muted">Email Address (Optional)</label>
                            <input type="email" class="form-control" name="email" placeholder="customer@example.com">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-muted">Delivery / Physical Address</label>
                            <textarea class="form-control" rows="2" name="address" placeholder="House, Road, Area..."></textarea>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="create_account" id="create_account" value="1">
                                <label class="form-check-label fw-bold small ms-1" for="create_account">Create Online Store Login Account?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark rounded-3 px-4 fw-bold">
                        <i class="bi bi-check-lg me-1"></i> Save Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>