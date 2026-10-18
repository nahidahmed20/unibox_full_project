@extends('backend.layouts.app')
@section('title', 'Product Specifications')

@section('content')
<main class="app-main pt-3 pb-5">
    <div class="container-fluid px-4">

        {{-- PAGE HEADER & BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-card-checklist text-primary"></i> Product Specifications
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0" style="font-size: 13px;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Catalog Setup</li>
                        <li class="breadcrumb-item active fw-semibold text-dark">Specifications</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button type="button" class="btn btn-primary shadow-sm px-3 py-2 fw-semibold" id="addSpecificationBtn">
                    <i class="bi bi-plus-lg me-1"></i> Add Specification
                </button>
            </div>
        </div>

        {{-- KPI STATS CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-4 col-sm-6">
                <div class="card h-100 mb-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-shrink-0 rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px;">
                            <i class="bi bi-card-list"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 11px;">Total Specifications</span>
                            <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Specification::count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-sm-6">
                <div class="card h-100 mb-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-shrink-0 rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 11px;">Active Specifications</span>
                            <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Specification::where('status', 1)->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-sm-6">
                <div class="card h-100 mb-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-shrink-0 rounded-3 bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px;">
                            <i class="bi bi-dash-circle-fill"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 11px;">Inactive Specifications</span>
                            <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Specification::where('status', 0)->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN DATA TABLE CARD --}}
        <div class="card modern-card shadow-sm">
            <div class="modern-card-header">
                <h5 class="card-title m-0">
                    <i class="bi bi-list-check text-primary"></i>
                    All Specifications List
                </h5>
                <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 11px;">
                    Attributes & Technical Specs
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive p-3">
                    <table id="specificationTable" class="table table-modern table-hover w-100">
                        <thead>
                            <tr>
                                <th width="8%">#</th>
                                <th width="50%">Specification Name</th>
                                <th width="20%">Status</th>
                                <th width="22%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

{{-- ================= COMPACT & ELEGANT SPECIFICATION MODAL ================= --}}
<div class="modal fade" id="specificationModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="specificationForm">
                @csrf
                <input type="hidden" id="specification_id" name="specification_id">

                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="modalTitle">
                            <i class="bi bi-card-checklist text-primary"></i>
                            <span id="modalTitleText">Add Specification</span>
                        </h5>
                        <p class="text-muted mb-0 mt-1" style="font-size: 12px; font-weight: 500;">
                            Configure product technical specifications and attributes.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Specification Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Thickness, GSM, Material, Warranty" required>
                        <small class="text-muted" style="font-size: 11px;">Enter a unique attribute or specification label.</small>
                    </div>

                    <div class="mb-2">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveSpecBtn">
                        <i class="bi bi-check2 me-1"></i> Save Specification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let table = $('#specificationTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('specifications.index') }}",
            lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name', className: 'fw-bold text-dark' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            dom: '<"row align-items-center mb-3"' +
                '<"col-md-4"l>' +
                '<"col-md-4 d-flex justify-content-center"B>' +
                '<"col-md-4 d-flex justify-content-end"f>' +
                '>rt' +
                '<"d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4 px-1"ip>',
            buttons: [
                { extend: 'copy', text: '<i class="fa-regular fa-copy me-1"></i> Copy', className: 'btn btn-sm btn-light border shadow-sm' },
                { extend: 'excel', text: '<i class="fa-regular fa-file-excel me-1 text-success"></i> Excel', className: 'btn btn-sm btn-light border shadow-sm' },
                { extend: 'csv', text: '<i class="fa-solid fa-file-csv me-1 text-info"></i> CSV', className: 'btn btn-sm btn-light border shadow-sm' },
                { extend: 'print', text: '<i class="fa-solid fa-print me-1 text-dark"></i> Print', className: 'btn btn-sm btn-light border shadow-sm' }
            ],
            order: [[1, 'asc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search specifications...",
                lengthMenu: "Show _MENU_ entries",
                paginate: {
                    previous: '<i class="fa-solid fa-chevron-left"></i>',
                    next: '<i class="fa-solid fa-chevron-right"></i>'
                }
            }
        });

        $('#addSpecificationBtn').on('click', function() {
            $('#specificationForm')[0].reset();
            $('#specification_id').val('');
            $('#status').val('1');
            $('#modalTitleText').text('Add Specification');
            $('#specificationModal').modal('show');
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $.get("{{ url('admin/specifications') }}/" + id + "/edit", function(data) {
                $('#specification_id').val(data.id);
                $('#name').val(data.name);
                $('#status').val(data.status);
                $('#modalTitleText').text('Edit Specification: ' + data.name);
                $('#specificationModal').modal('show');
            }).fail(function() {
                toastr.error('Failed to load specification data.');
            });
        });

        $('#specificationForm').submit(function(e) {
            e.preventDefault();
            let id = $('#specification_id').val();
            let saveBtn = $('#saveSpecBtn');
            let origHtml = saveBtn.html();
            saveBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

            let url = id ? "{{ url('admin/specifications') }}/" + id : "{{ route('specifications.store') }}";
            let formData = { 
                name: $('#name').val(), 
                status: $('#status').val(),
                _token: "{{ csrf_token() }}"
            };
            
            if (id) {
                formData._method = "PUT";
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(res) {
                    saveBtn.prop('disabled', false).html(origHtml);
                    toastr.success(res.message || 'Specification saved successfully!');
                    $('#specificationModal').modal('hide');
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    saveBtn.prop('disabled', false).html(origHtml);
                    showErrors(xhr);
                }
            });
        });

        function showErrors(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = '';
                $.each(xhr.responseJSON.errors, function(key, value) {
                    errors += value + '<br>';
                });
                toastr.error(errors);
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                toastr.error(xhr.responseJSON.message);
            } else {
                toastr.error('Something went wrong!');
            }
        }
    });
</script>
@endpush
