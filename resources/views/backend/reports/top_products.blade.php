@extends('backend.layouts.app')
@section('title', 'Top Selling Products Report')

@section('content')
<style>
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.15); }
</style>

<div class="app-content-wrapper pt-3">
    <div class="container-fluid px-4">

        {{-- PAGE HEADER & BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1 fw-bold text-dark"><i class="bi bi-award-fill me-2 text-warning"></i> Best Selling Products</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0" style="font-size: 14px;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.sales') }}" class="text-decoration-none text-muted">Reports</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark">Top Products</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-fire text-danger me-2"></i> Top 20 Best Performing Products by Sales Volume</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th class="ps-4">Rank</th>
                                <th>Product Details</th>
                                <th>Category</th>
                                <th>Units Sold</th>
                                <th>Total Revenue Generated</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $item)
                                <tr>
                                    <td class="ps-4">
                                        @if($loop->iteration == 1)
                                            <span class="badge bg-warning text-dark fs-6 rounded-circle" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">🥇</span>
                                        @elseif($loop->iteration == 2)
                                            <span class="badge bg-secondary fs-6 rounded-circle" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">🥈</span>
                                        @elseif($loop->iteration == 3)
                                            <span class="badge bg-warning-light text-warning fs-6 rounded-circle border" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">🥉</span>
                                        @else
                                            <span class="badge bg-light text-muted border rounded-circle" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">#{{ $loop->iteration }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset($item->product->image) }}" class="rounded-3 me-2" style="width: 45px; height: 45px; object-fit: cover;" alt="">
                                            @else
                                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center me-2 text-muted" style="width: 45px; height: 45px;">
                                                    <i class="bi bi-box"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ $item->product_name }}</div>
                                                <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $item->product->category->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold fs-6 text-primary">{{ number_format($item->total_sold) }}</span> Units
                                    </td>
                                    <td>
                                        <span class="fw-bold fs-6 text-success">৳{{ number_format($item->total_revenue, 2) }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($item->product)
                                            <a href="{{ route('products.edit', $item->product_id) }}" class="btn btn-sm btn-light text-primary" title="View Product">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-bar-chart fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                        No sales records available yet.
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

