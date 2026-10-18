<div class="modal fade" id="showMemberModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Header -->
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold d-flex align-items-center gap-2 mb-1">
                            <i class="fa-solid fa-user-tag text-primary"></i>
                            Member Profile Details
                        </h5>
                        <small class="text-muted">Customer account and personal information</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Body -->
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <!-- Left Profile -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                                <img id="show_image" src="" class="rounded-circle mx-auto mb-3"
                                    width="120" height="120" style="object-fit:cover;">
                                <h5 id="show_name"
                                    class="fw-bold mb-1">
                                </h5>
                                <span id="show_status"
                                    class="badge rounded-pill px-3">
                                </span>
                                <hr>
                                <div class="text-start small">
                                    <p class="mb-2"><i class="fa-solid fa-id-card me-2 text-muted"></i>
                                        <span id="show_code_number"></span>
                                    </p>
                                    <p class="mb-2">
                                        <i class="fa-solid fa-phone me-2 text-muted"></i>
                                        <span id="show_phone"></span>
                                    </p>
                                    <p class="mb-2"><i class="fa-solid fa-envelope me-2 text-muted"></i>
                                        <span id="show_email"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Right Details -->
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                                <h6 class="fw-bold mb-4">
                                    Personal Information
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small"> Gender </label>
                                        <div class="fw-semibold"
                                            id="show_gender">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">
                                            Date Of Birth
                                        </label>
                                        <div class="fw-semibold"
                                            id="show_date_of_birth">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">
                                            Marital Status
                                        </label>
                                        <div class="fw-semibold"
                                            id="show_marital_status">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">
                                            Occupation
                                        </label>
                                        <div class="fw-semibold"
                                            id="show_occupation">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="text-muted small">
                                            Address
                                        </label>
                                        <div class="fw-semibold"
                                            id="show_address">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>