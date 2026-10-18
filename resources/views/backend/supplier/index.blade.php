@extends('backend.layouts.app')

@section('title', 'Supplier List')

@section('content')
    {{-- HEADER --}}
    <div class="app-content-header mb-4 mt-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold" style="color:#212b36;">
                        Suppliers
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">
                                Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active fw-bold text-dark">
                            Supplier List
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}

    <div class="app-content">
        <div class="container-fluid">
            <div class="card modern-card shadow-sm">
                {{-- HEADER --}}
                <div class="modern-card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title mb-0">
                        <i class="fa-solid fa-truck-field text-muted me-2"></i>
                        All Suppliers
                    </h4>
                    <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm" id="addSupplierBtn">
                        <i class="fa-solid fa-plus me-1"></i>
                        Add Supplier
                    </button>
                </div>
                {{-- TABLE --}}
                <div class="card-body p-0">
                    <div class="table-responsive p-4">
                        <table id="supplierTable" class="table table-modern table-hover w-100">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th width="15%" class="text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= ADD / EDIT SUPPLIER MODAL ================= --}}
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 760px;">
            <div class="modal-content">
                <form id="supplierForm">
                    @csrf
                    <input type="hidden" id="supplier_id" name="supplier_id">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa-solid fa-truck-field text-primary"></i>
                            <span id="modalTitle">Add Supplier</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        {{-- Section 1: Company & Contact Identity --}}
                        <div class="p-3 bg-light rounded-3 border mb-3">
                            <div class="fw-bold text-dark small text-uppercase mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-building text-primary"></i>
                                Company & Primary Contact
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small mb-1">Company / Supplier Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="bi bi-building"></i></span>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Apex Paper Mills Ltd" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small mb-1">Contact Phone</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="bi bi-telephone"></i></span>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="e.g. +8801XXXXXXXXX">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small mb-1">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="supplier@company.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small mb-1">Website URL</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="bi bi-globe"></i></span>
                                        <input type="text" class="form-control" id="website" name="website" placeholder="https://supplier.com">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Address & Location --}}
                        <div class="p-3 bg-light rounded-3 border mb-3">
                            <div class="fw-bold text-dark small text-uppercase mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-geo-alt text-primary"></i>
                                Location & Physical Address
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted small mb-1">Street Address / Warehouse</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="bi bi-signpost"></i></span>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="e.g. Plot #12, Road #4, Motijheel C/A">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold text-muted small mb-1">City</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="e.g. Dhaka">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold text-muted small mb-1">State / Division</label>
                                    <input type="text" class="form-control" id="state" name="state" placeholder="e.g. Dhaka">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold text-muted small mb-1">Zip / Postal Code</label>
                                    <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="e.g. 1000">
                                </div>
                            </div>
                        </div>

                        {{-- Section 3: Status --}}
                        <div class="p-3 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                            <div>
                                <label class="form-label fw-bold text-dark mb-0 d-block" for="status">Supplier Status</label>
                                <small class="text-muted" style="font-size: 11px;">Active suppliers will appear in Purchase orders and Inventory receipts.</small>
                            </div>
                            <select class="form-select form-select-sm w-auto fw-semibold" id="status" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveSupplierBtn">
                            <i class="bi bi-check2-circle me-1"></i> Save Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================= SHOW SUPPLIER DETAILS MODAL ================= --}}
    <div class="modal fade" id="showSupplierModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 580px;">
            <div class="modal-content">
                {{-- HEADER --}}
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-truck-field text-primary"></i>
                        Supplier Profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- BODY --}}
                <div class="modal-body p-4">
                    {{-- Profile Header Card --}}
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 border mb-3">
                        <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center shadow-sm" style="width: 54px; height: 54px; font-size: 26px;">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="fw-bold text-dark mb-1" id="show_name">Supplier Name</h5>
                                <div id="show_status"></div>
                            </div>
                            <span class="text-muted small" style="font-size: 12px;">Verified Partner / Vendor</span>
                        </div>
                    </div>

                    {{-- Contact & Address Details Grid --}}
                    <div class="row g-2">
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 border h-100">
                                <span class="text-muted d-block small fw-bold text-uppercase mb-1" style="font-size: 10px;">
                                    <i class="bi bi-telephone text-primary me-1"></i> Phone Number
                                </span>
                                <span class="fw-bold text-dark" id="show_phone">N/A</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 border h-100">
                                <span class="text-muted d-block small fw-bold text-uppercase mb-1" style="font-size: 10px;">
                                    <i class="bi bi-envelope text-primary me-1"></i> Email Address
                                </span>
                                <span class="fw-semibold text-dark text-break" id="show_email">N/A</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded-3 border">
                                <span class="text-muted d-block small fw-bold text-uppercase mb-1" style="font-size: 10px;">
                                    <i class="bi bi-geo-alt text-primary me-1"></i> Physical Address
                                </span>
                                <span class="fw-semibold text-dark d-block" id="show_address">N/A</span>
                                <small class="text-muted mt-1 d-block" id="show_city">City, State</small>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- FOOTER --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            let table = $('#supplierTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('suppliers.index') }}",
                lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: '<"row align-items-center mb-4"' +
                    '<"col-md-4"l>' +
                    '<"col-md-4 d-flex justify-content-center"B>' +
                    '<"col-md-4 d-flex justify-content-end"f>' +
                    '>rt' +
                    '<"d-flex justify-content-between align-items-center mt-4"ip>',

                buttons: [{
                        extend: 'copy',
                        text: '<i class="fa-regular fa-copy"></i> Copy'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa-regular fa-file-excel"></i> Excel'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fa-solid fa-file-csv"></i> CSV'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa-regular fa-file-pdf"></i> PDF'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa-solid fa-print"></i> Print'
                    }
                ],
                order:[[1,'asc']],

                language:{
                    search:"_INPUT_",
                    searchPlaceholder:"Search brands...",
                    lengthMenu:"Show _MENU_ entries",

                    paginate:{
                        previous:'<i class="fa-solid fa-angle-left"></i>',
                        next:'<i class="fa-solid fa-angle-right"></i>'
                    }
                }
            });
            // ADD
            $('#addSupplierBtn').click(function() {
                $('#supplierForm')[0].reset();
                $('#supplier_id').val('');
                $('#modalTitle').text('Add Supplier');
                $('#supplierModal').modal('show');
            });
            // EDIT
            $(document).on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get("{{ url('/admin/suppliers') }}/" + id + "/edit",
                    function(data) {
                        let s = data.supplier;
                        $('#supplier_id').val(s.id);
                        $('#name').val(s.name);
                        $('#email').val(s.email);
                        $('#phone').val(s.phone);
                        $('#address').val(s.address);
                        $('#city').val(s.city);
                        $('#state').val(s.state);
                        $('#zip_code').val(s.zip_code);
                        $('#website').val(s.website);
                        $('#status').val(s.status);
                        $('#modalTitle').text('Edit Supplier');
                        $('#supplierModal').modal('show');
                    });
            });
            // SAVE
            $('#supplierForm').submit(function(e) {
                e.preventDefault();
                let id = $('#supplier_id').val();
                let formData = new FormData(this);
                let url = id?
                    "{{ url('/admin/suppliers') }}/" + id :
                    "{{ route('suppliers.store') }}";
                if (id) {
                    formData.append('_method', 'PUT');
                }
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#supplierModal').modal('hide');
                        toastr.success(data.message);
                        table.ajax.reload(null, false);
                    },
                    error:function(xhr){
                        showErrors(xhr);
                    }
                });
            });
            function showErrors(xhr) {
                if (xhr.responseJSON &&
                    xhr.responseJSON.errors) {
                    let errors = '';
                    $.each(xhr.responseJSON.errors,
                        function(key, value) {
                            errors += value + '<br>';
                        });
                    toastr.error(errors);
                } else {
                    toastr.error('Something went wrong!');
                }
            }
            // SHOW
            $(document).on('click', '.show-btn', function() {
                let id = $(this).data('id');
                $.get("{{ url('/admin/suppliers') }}/" + id,
                    function(data) {
                        let s = data.supplier;
                        $('#show_name').text(s.name);
                        $('#show_phone').text(s.phone || 'N/A');
                        $('#show_email').text(s.email || 'N/A');
                        $('#show_address').text(s.address || 'N/A');
                        let locParts = [s.city, s.state, s.zip_code].filter(Boolean);
                        $('#show_city').text(locParts.length > 0 ? locParts.join(', ') : 'No location specified');
                        $('#show_status').html(
                            s.status == 1
                                ? '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i>Active</span>'
                                : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="bi bi-x-circle me-1"></i>Inactive</span>'
                        );
                        $('#showSupplierModal').modal('show');
                    });
            });
        });
    </script>
@endpush

