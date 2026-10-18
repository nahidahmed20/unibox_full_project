@extends('backend.layouts.app')
@section('title', 'E-commerce Orders Report')

@section('content')
<style>
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
    .bg-danger-light { background-color: rgba(220, 53, 69, 0.1); }
    .bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
</style>

<div class="app-content-wrapper pt-3">
    <div class="container-fluid px-4">

        {{-- PAGE HEADER & BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1 fw-bold text-dark"><i class="bi bi-cart-check-fill me-2 text-primary"></i> E-commerce Orders Analytics</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0" style="font-size: 14px;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.sales') }}" class="text-decoration-none text-muted">Reports</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark">Online Orders Report</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- FILTER BAR --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <form action="{{ route('reports.orders') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Filter By Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">-- All Statuses --</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="on-the-way" {{ request('status') === 'on-the-way' ? 'selected' : '' }}>On The Way</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed (Delivered)</option>
                            <option value="return" {{ request('status') === 'return' ? 'selected' : '' }}>Returned</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">From Date</label>
                        <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">To Date</label>
                        <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1"><i class="bi bi-funnel me-1"></i> Filter</button>
                        <a href="{{ route('reports.orders') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- KPI STATS CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-bag-check fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Orders Placed</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalOrders }}</h4>
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
                            <h6 class="mb-1 text-muted">Completed (Delivered)</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalCompleted }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger-light text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-arrow-return-left fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Returned Orders</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalReturned }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info-light text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-cash-stack fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Delivered Revenue</h6>
                            <h4 class="mb-0 fw-bold">৳{{ number_format($totalRevenue, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ORDERS TABLE --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th class="ps-4">Order #</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Payment</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td class="ps-4">
                                        <a href="{{ route('orders.show', $order->id) }}" class="fw-bold text-primary text-decoration-none">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <small class="text-secondary">{{ $order->created_at->format('d M, Y h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $order->full_name }}</div>
                                        <small class="text-muted">{{ $order->phone }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ strtoupper($order->payment_method ?? 'COD') }}</span>
                                        <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ ucfirst($order->payment_status ?? 'unpaid') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $order->items->count() }} Items</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">৳{{ number_format($order->total, 2) }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $badges = [
                                                'pending' => 'bg-warning text-dark',
                                                'accepted' => 'bg-info',
                                                'on-the-way' => 'bg-primary',
                                                'completed' => 'bg-success',
                                                'return' => 'bg-danger',
                                                'cancelled' => 'bg-secondary'
                                            ];
                                        @endphp
                                        <span class="badge {{ $badges[$order->status] ?? 'bg-secondary' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-light text-primary" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-cart-x fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                        No online orders found matching current filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($orders->hasPages())
                    <div class="p-3 border-top">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

