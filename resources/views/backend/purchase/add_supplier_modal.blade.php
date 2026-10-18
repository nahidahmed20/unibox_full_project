<div class="modal fade" id="supplierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 580px;">
        <div class="modal-content">

            <form id="supplierForm">
                @csrf

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-truck-field text-primary"></i>
                        Add New Supplier
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">

                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small text-uppercase mb-1">
                                Supplier Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-building"></i></span>
                                <input type="text"
                                    class="form-control"
                                    name="name"
                                    placeholder="Enter company or supplier name"
                                    required>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase mb-1">
                                Phone
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-telephone"></i></span>
                                <input type="text"
                                    class="form-control"
                                    name="phone"
                                    placeholder="01XXXXXXXXX">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase mb-1">
                                Email
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                                <input type="email"
                                    class="form-control"
                                    name="email"
                                    placeholder="supplier@example.com">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small text-uppercase mb-1">
                                Address
                            </label>
                            <textarea class="form-control"
                                name="address"
                                rows="2"
                                placeholder="Warehouse or street address"></textarea>
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <div class="p-3 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-check-label fw-bold text-dark mb-0 d-block" for="supplierStatus">Active Status</label>
                                    <small class="text-muted" style="font-size: 11px;">Enable this vendor for upcoming purchases.</small>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="supplierStatus"
                                        name="status"
                                        value="1"
                                        checked
                                        style="width: 2.2em; height: 1.2em;">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check2-circle me-1"></i> Save Supplier
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>