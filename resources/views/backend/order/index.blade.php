@extends('backend.layouts.app')
@section('title', 'Order List')

@section('content')

@push('styles')
    <style>
        .status-badge{
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending{
            background:#fff4e5;
            color:#ff9800;
            border:1px solid #ff9800;
        }

        .status-processing{
            background:#e3f2fd;
            color:#1976d2;
            border:1px solid #1976d2;
        }

        .status-success{
            background:#e8f5e9;
            color:#2e7d32;
            border:1px solid #2e7d32;
        }

        .status-danger{
            background:#ffebee;
            color:#c62828;
            border:1px solid #c62828;
        }
        .form-select-lg{
            font-size: 1rem !important;
        }

    </style>
@endpush

<div class="app-content-wrapper pt-3">
    <div class="container-fluid px-4">

        {{-- PAGE HEADER & BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1 fw-bold text-dark"><i class="bi bi-shop me-2 text-primary"></i> Ecommerce Orders</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0" style="font-size: 14px;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark">Order List</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- KPI STATS CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Orders</h6>
                            <h4 class="mb-0 fw-bold">{{ \App\Models\Order::count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning-light text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Pending Orders</h6>
                            <h4 class="mb-0 fw-bold">{{ \App\Models\Order::where('status', 'pending')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success-light text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-check-circle fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Completed</h6>
                            <h4 class="mb-0 fw-bold">{{ \App\Models\Order::where('status', 'completed')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger-light text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-x-circle fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Cancelled</h6>
                            <h4 class="mb-0 fw-bold">{{ \App\Models\Order::where('status', 'cancelled')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN DATA TABLE CARD --}}
        <div class="card modern-card border-0 shadow-sm rounded-4">
            <div class="modern-card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-list-ul text-primary me-2"></i> All Orders</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive p-4">
                    <table id="orderTable" class="table table-modern table-hover w-100 align-middle">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th>#SL</th>
                                <th>Invoice No</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- ================= ORDER MODAL (EXPANDED XL WIDTH) ================= -->
<div class="modal fade" id="showOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-receipt text-primary me-2"></i>
                    Order & Invoice Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="orderDetails">
                <div class="text-center p-5"><i class="fa-solid fa-spinner fa-spin fs-2 text-muted"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- ================= STATUS MODAL ================= -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="statusModalBody">
                <div class="text-center p-5"><i class="fa-solid fa-spinner fa-spin fs-2 text-muted"></i></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        // DataTable Initialization
        let table = $('#orderTable').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
            dom: '<"row align-items-center mb-4"<"col-md-4"l><"col-md-4 d-flex justify-content-center"B><"col-md-4 d-flex justify-content-end"f>>rt<"d-flex justify-content-between align-items-center mt-4"ip>',
            buttons: [
                {
                    extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'excel', text: '<i class="fa-regular fa-file-excel"></i> Excel',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'csv', text: '<i class="fa-solid fa-file-csv"></i> CSV',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'pdf', text: '<i class="fa-regular fa-file-pdf"></i> PDF',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'print', text: '<i class="fa-solid fa-print"></i> Print',
                    exportOptions: { columns: ':not(:last-child)' }
                }
            ],
            ajax: "{{ route('orders.index') }}",
            columns: [
                { data: 'DT_RowIndex',    name: 'DT_RowIndex',    orderable: false, searchable: false },
                { data: 'invoice_no', className:'text-center' },
                { data: 'customer_name', className:'text-center' },
                { data: 'order_date', className:'text-center' },
                { data: 'total_amount', className:'text-center' },
                { data: 'payment_status', className:'text-center' },
                { data: 'status', className:'text-center' },
                { data: 'action', className:'text-center', orderable:false, searchable:false },
            ],
            order: [[1, 'asc']],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search orders...",
                lengthMenu: "Show _MENU_ entries",
                paginate: {
                    previous: '<i class="fa-solid fa-angle-left"></i>',
                    next: '<i class="fa-solid fa-angle-right"></i>'
                }
            }
        });

        // ================= VIEW ORDER MODAL =================
        $(document).on('click', '.btn-show', function () {
            let id = $(this).data('id');
            let btn = $(this);
            let originalHtml = btn.html();
            btn.html('<i class="fa-solid fa-spinner fa-spin"></i>').prop('disabled', true);
            $.get("{{ url('/admin/orders') }}/" + id, function (html) {
                $('#orderDetails').html(html);
                $('#showOrderModal').modal('show');

            }).always(function() {
                btn.html(originalHtml).prop('disabled', false);
            });
        });


        // ================= STATUS MODAL =================
        $(document).on('click', '.btn-status-change', function () {
            let id = $(this).data('id');
            let btn = $(this);
            let originalText = btn.html();
            btn.html('<i class="fa-solid fa-spinner fa-spin"></i>').prop('disabled', true);
            $.get("{{ url('/admin/orders/status-modal') }}/" + id, function (html) {
                $('#statusModalBody').html(html);
                $('#statusModal').modal('show');

            }).always(function() {
                btn.html(originalText).prop('disabled', false);
            });
        });


        $(document).on('submit', '#statusUpdateForm', function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function (res) {
                    $('#statusModal').modal('hide');
                    toastr.success(res.message);
                    table.ajax.reload(null, false);
                },
                error: function(xhr){
                    showErrors(xhr);
                }
            });
        });

    });

    // ERROR HANDLER
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

    // --- New Order Auto Reload Logic ---
    let lastOrderId = null;

    $.get("{{ route('orders.checkNew') }}", function (res) {
        lastOrderId = res.last_order_id;
    });

    setInterval(function () {
        $.get("{{ route('orders.checkNew') }}", function (res) {

            if (lastOrderId !== null && res.last_order_id > lastOrderId) {
                lastOrderId = res.last_order_id;

                window.location.reload();

                toastr.info('New Order Received!');

            }
        });
    }, 10000);
</script>
@endpush

