@extends('backend.layouts.app')
@section('title', 'Cancelled Order List')

@section('content')
<div class="app-content-wrapper pt-3">
    <div class="container-fluid px-4">

        {{-- PAGE HEADER & BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1 fw-bold text-dark"><i class="bi bi-x-circle me-2 text-danger"></i> Cancelled Orders</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0" style="font-size: 14px;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark">Cancelled Orders</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- KPI STATS CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-6 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger-light text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-x-octagon fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Cancelled Orders</h6>
                            <h4 class="mb-0 fw-bold">{{ \App\Models\Order::where('status', 'cancelled')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning-light text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-exclamation-triangle fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Lost Revenue (Cancelled)</h6>
                            <h4 class="mb-0 fw-bold taka-font text-danger">? {{ number_format(\App\Models\Order::where('status', 'cancelled')->sum('total'), 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN DATA TABLE CARD --}}
        <div class="card modern-card border-0 shadow-sm rounded-4">
            <div class="modern-card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-list-ul text-primary me-2"></i> Cancelled Orders List</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive p-4">
                    <table id="cancelOrderTable" class="table table-modern table-hover w-100 align-middle">
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

<!-- ================= ORDER MODAL ================= -->
<div class="modal fade" id="showOrderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Order Details</h5>
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
        let table = $('#orderTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('order.cancelled') }}",
            columns: [
                { data: 'DT_RowIndex', orderable:false, searchable:false },
                { data: 'invoice_no' },
                { data: 'customer_name' },
                { data: 'order_date' },
                { data: 'total_amount' },
                { data: 'payment_status', orderable:false },
                { data: 'status', orderable:false, className: 'text-center' },
                { data: 'action', orderable:false, className: 'text-center' },
            ],
            dom: '<"row align-items-center mb-4"<"col-md-4"l><"col-md-4 d-flex justify-content-center"B><"col-md-4 d-flex justify-content-end"f>>rt<"d-flex justify-content-between align-items-center mt-4"ip>',
            buttons: [
                { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', exportOptions: { columns: ':not(:last-child)' } },
                { extend: 'excel', text: '<i class="fa-regular fa-file-excel"></i> Excel', exportOptions: { columns: ':not(:last-child)' } },
                { extend: 'csv', text: '<i class="fa-solid fa-file-csv"></i> CSV', exportOptions: { columns: ':not(:last-child)' } },
                { extend: 'pdf', text: '<i class="fa-regular fa-file-pdf"></i> PDF', exportOptions: { columns: ':not(:last-child)' } },
                { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', exportOptions: { columns: ':not(:last-child)' } }
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
            },
        });

        // View Order
        $(document).on('click', '.btn-show', function () {
            let id = $(this).data('id');
            $('#orderDetails').html('<div class="text-center py-5"><div class="spinner-border text-dark"></div></div>');
            $('#showOrderModal').modal('show');
            $.get("{{ url('admin/orders') }}/" + id, function (html) {
                $('#orderDetails').html(html);
            });
        });

        // Open Status Modal
        $(document).on('click', '.btn-status', function () {
            let orderId = $(this).data('id');
            $('#statusModalBody').html('<div class="text-center py-5"><div class="spinner-border text-dark"></div></div>');
            $('#statusModal').modal('show');
            $.get("{{ url('admin/orders/status-modal') }}/" + orderId, function (html) {
                $('#statusModalBody').html(html);
            });
        });

        // Submit Status
        $(document).on('submit', '#statusForm', function (e) {
            e.preventDefault();
            let orderId = $('#order_id').val();
            let status  = $('#statusSelect').val();

            $.ajax({
                url: "{{ route('single.status.update', ':id') }}".replace(':id', orderId),
                type: "PATCH",
                data: { _token: "{{ csrf_token() }}", status: status },
                success: function (res) {
                    toastr.success(res.message);
                    $('#statusModal').modal('hide');
                    $('#orderTable').DataTable().ajax.reload(null, false);
                },
                error: function () { toastr.error('Something went wrong!'); }
            });
        });
    });
</script>
@endpush

