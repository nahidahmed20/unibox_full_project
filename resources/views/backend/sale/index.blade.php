@extends('backend.layouts.app')

@section('title', 'Sale List')

@push('styles')
<style>
    .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .12);
    }

    .modal-header-modern {
        background: #fff;
        border-bottom: 1px solid #eef2f7;
        padding: 20px 24px;
    }

    .modal-title-modern {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
    }

    .order-card {
        background: #f8fafc;
        border: 1px solid #eef2f7;
        border-radius: 16px;
        padding: 18px;
    }

    .info-label {
        font-size: 11px;
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: #111827;
    }

    .summary-card {
        background: #f8fafc;
        border: 1px solid #eef2f7;
        border-radius: 16px;
        padding: 18px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .summary-item:last-child {
        margin-bottom: 0;
    }

    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.15); }
</style>
@endpush

@section('content')
<div class="app-content-wrapper pt-3">
    <div class="container-fluid px-4">

        {{-- PAGE HEADER & BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1 fw-bold text-dark">
                    <i class="bi bi-pc-display-horizontal me-2 text-primary"></i> POS Sales
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0" style="font-size: 14px;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark">Sale List</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('sales.create') }}" class="btn btn-primary shadow-sm rounded-3">
                    <i class="bi bi-plus-lg me-2"></i> New POS Sale
                </a>
            </div>
        </div>

        {{-- KPI STATS CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-receipt fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Invoices</h6>
                            <h4 class="mb-0 fw-bold">{{ \App\Models\Sale::count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success-light text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-cash-stack fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total POS Revenue</h6>
                            <h4 class="mb-0 fw-bold">৳{{ number_format(\App\Models\Sale::sum('grand_total'), 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning-light text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-calendar-day fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Today's Revenue</h6>
                            <h4 class="mb-0 fw-bold">৳{{ number_format(\App\Models\Sale::whereDate('sale_date', today())->sum('grand_total'), 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN DATA TABLE CARD --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-list-ul text-primary me-2"></i> All Sales</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive p-4">
                    <table class="table table-hover w-100 align-middle" id="saleTable">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th>#SL</th>
                                <th class="text-center">Invoice No</th>
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Total Amount</th>
                                <th class="text-center">Total Discount</th>
                                <th class="text-center">Grand Total</th>
                                <th class="text-center">Status</th>
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

{{-- SALE DETAILS MODAL --}}
<div class="modal fade" id="saleModal" tabindex="-1" aria-labelledby="saleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-modern d-flex justify-content-between align-items-center">
                <h5 class="modal-title modal-title-modern" id="saleModalLabel">
                    <i class="bi bi-receipt me-2 text-primary"></i> Sale Invoice Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="saleModalBody">
                <!-- Content dynamically populated via JS -->
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        // Initialize DataTables
        let table = $('#saleTable').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
            dom: '<"row align-items-center mb-4"<"col-md-4"l><"col-md-4 d-flex justify-content-center"B><"col-md-4 d-flex justify-content-end"f>>rt<"d-flex justify-content-between align-items-center mt-4"ip>',
            buttons: [
                { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', exportOptions: { columns: ':not(:last-child)' } },
                { extend: 'excel', text: '<i class="fa-regular fa-file-excel"></i> Excel', exportOptions: { columns: ':not(:last-child)' } },
                { extend: 'csv', text: '<i class="fa-solid fa-file-csv"></i> CSV', exportOptions: { columns: ':not(:last-child)' } },
                { extend: 'pdf', text: '<i class="fa-regular fa-file-pdf"></i> PDF', exportOptions: { columns: ':not(:last-child)' } },
                { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', exportOptions: { columns: ':not(:last-child)' } }
            ],
            ajax: "{{ route('sales.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'invoice_no', className: 'text-center' },
                { data: 'customer_name', className: 'text-center' },
                { data: 'total_amount', className: 'text-center' },
                { data: 'discount', className: 'text-center' },
                { data: 'grand_total', className: 'text-center' },
                { data: 'status', className: 'text-center' },
                { data: 'action', className: 'text-center', orderable: false, searchable: false },
            ],
            order: [[1, 'desc']],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search sales...",
            }
        });

        // Handle Details Button Click
        $(document).on('click', '.btn-show', function () {
            let id = $(this).data('id');
            let btn = $(this);
            let originalHtml = btn.html();

            btn.html('<i class="fa-solid fa-spinner fa-spin"></i>').prop('disabled', true);

            $.get("{{ url('/admin/sales') }}/" + id, function (res) {
                if (res.status === 'success' || res.data) {
                    let s = res.data || res;

                    // Build items rows
                    let itemsHtml = '';
                    if (s.items && s.items.length > 0) {
                        s.items.forEach(item => {
                            let productName = item.product ? item.product.name : 'Unknown Product';
                            let sku = item.product ? item.product.sku : 'N/A';

                            let sizeStr = item.size ? `Size: ${item.size.name}` : '';
                            let colorStr = item.color ? `Color: ${item.color.name}` : '';
                            let metaArr = [sizeStr, colorStr].filter(Boolean);
                            let metaHtml = metaArr.length > 0 ? ` &nbsp;•&nbsp; ${metaArr.join(' &nbsp;•&nbsp; ')}` : '';

                            let qty = parseInt(item.quantity || 1);
                            let price = parseFloat(item.selling_price || 0);
                            let itemTotal = (qty * price).toFixed(2);

                            itemsHtml += `
                                <tr>
                                    <td class="align-middle">
                                        <div class="fw-semibold text-dark">${productName}</div>
                                        <div class="small text-muted">SKU: ${sku}${metaHtml}</div>
                                    </td>
                                    <td class="text-center align-middle">৳${price.toFixed(2)}</td>
                                    <td class="text-center align-middle">${qty}</td>
                                    <td class="text-end align-middle fw-bold">৳${itemTotal}</td>
                                </tr>
                            `;
                        });
                    } else {
                        itemsHtml = `<tr><td colspan="4" class="text-center py-4 text-muted">No sale items found.</td></tr>`;
                    }

                    let customerName = s.customer ? s.customer.name : (s.customer_name || 'Walk-in Customer');
                    let totalAmount = parseFloat(s.total_amount || 0).toFixed(2);
                    let discount = parseFloat(s.discount || 0).toFixed(2);
                    let grandTotal = parseFloat(s.grand_total || 0).toFixed(2);

                    let modalContent = `
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="order-card h-100">
                                    <div class="info-label">Invoice Details</div>
                                    <div class="info-value mt-1">#${s.invoice_no || 'N/A'}</div>
                                    <div class="small text-muted mt-1">
                                        <i class="bi bi-calendar-event me-1"></i> Date: ${s.sale_date || 'N/A'}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="order-card h-100">
                                    <div class="info-label">Customer Information</div>
                                    <div class="info-value mt-1">${customerName}</div>
                                    <div class="small text-muted mt-1">
                                        <i class="bi bi-telephone me-1"></i> ${s.customer?.phone || 'N/A'}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                            <div class="card-header bg-light py-3 border-bottom">
                                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-basket me-2"></i> Purchased Items</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted small text-uppercase">
                                        <tr>
                                            <th>Item</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${itemsHtml}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <div class="summary-card">
                                    <div class="summary-item">
                                        <span class="text-muted">Sub Total</span>
                                        <span class="fw-semibold">৳${totalAmount}</span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="text-muted">Discount</span>
                                        <span class="fw-semibold text-danger">- ৳${discount}</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="summary-item fs-5 fw-bold text-dark">
                                        <span>Grand Total</span>
                                        <span class="text-primary">৳${grandTotal}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    $('#saleModalBody').html(modalContent);
                    $('#saleModal').modal('show');
                }
            }).fail(function () {
                alert('Failed to load sale details.');
            }).always(function() {
                btn.html(originalHtml).prop('disabled', false);
            });
        });
    });
</script>
@endpush
