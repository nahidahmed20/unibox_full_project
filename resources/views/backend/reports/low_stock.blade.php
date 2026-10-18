@extends('backend.layouts.app')
@section('title', 'Low Stock Alert Report')

@section('content')
<style>
    .bg-danger-light { background-color: rgba(220, 53, 69, 0.1); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.15); }
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
</style>

<div class="app-content-wrapper pt-3">
    <div class="container-fluid px-4">

        {{-- PAGE HEADER & BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1 fw-bold text-dark"><i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i> Inventory & Stock Alerts</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0" style="font-size: 14px;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.sales') }}" class="text-decoration-none text-muted">Reports</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark">Low Stock Report</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('purchases.create') }}" class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg me-2"></i> Create Purchase Order</a>
            </div>
        </div>

        {{-- KPI STATS CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger-light text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-x-circle fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Out of Stock</h6>
                            <h4 class="mb-0 fw-bold text-danger">{{ $outOfStockCount }} Products</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning-light text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-exclamation-circle fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Low Stock Warning</h6>
                            <h4 class="mb-0 fw-bold text-warning">{{ $lowStockCount }} Products</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Needing Restock</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalItems }} Products</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-table me-2 text-primary"></i> Products Requiring Immediate Restock</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th class="ps-4">Product Details</th>
                                <th>Category</th>
                                <th>SKU / Barcode</th>
                                <th>Unit Price</th>
                                <th>Alert Threshold</th>
                                <th>Current Stock</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $prod)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($prod->image)
                                                <img src="{{ asset($prod->image) }}" class="rounded-3 me-2" style="width: 45px; height: 45px; object-fit: cover;" alt="">
                                            @else
                                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center me-2 text-muted" style="width: 45px; height: 45px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ $prod->name }}</div>
                                                <small class="text-muted">{{ $prod->brand->name ?? 'No Brand' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $prod->category->name ?? 'Uncategorized' }}</span>
                                    </td>
                                    <td>
                                        <div><small class="fw-bold">{{ $prod->sku ?? '-' }}</small></div>
                                        <small class="text-muted">{{ $prod->barcode ?? '' }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold">৳{{ number_format($prod->selling_price, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $prod->alert_quantity ?? 5 }} units</span>
                                    </td>
                                    <td>
                                        @if($prod->stock <= 0)
                                            <span class="badge bg-danger fs-6 px-3 py-2">Out of Stock ({{ $prod->stock }})</span>
                                        @else
                                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">Low Stock ({{ $prod->stock }})</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('products.edit', $prod->id) }}" class="btn btn-sm btn-light text-primary" title="Edit Product">
                                            <i class="bi bi-pencil-square"></i> Update Stock
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-check-circle-fill text-success fs-1 d-block mb-2"></i>
                                        All product stock levels are healthy! No products currently below alert threshold.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

