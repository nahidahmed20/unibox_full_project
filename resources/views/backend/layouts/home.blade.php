@extends('backend.layouts.app')
@section('title', 'Executive Dashboard')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;600;700&display=swap');

    :root {
        --dash-bg: #f8fafc;
        --dash-card: #ffffff;
        --dash-border: #edf2f7;
        --dash-text: #0f172a;
        --dash-muted: #64748b;
        --dash-primary: #2563eb;
        --dash-emerald: #10b981;
        --dash-amber: #f59e0b;
        --dash-rose: #ef4444;
        --dash-purple: #8b5cf6;
    }

    body {
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        background-color: var(--dash-bg) !important;
    }

    .app-main {
        background-color: var(--dash-bg);
    }

    /* Executive Hero Banner */
    .exec-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 16px;
        padding: 24px 28px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        position: relative;
        overflow: hidden;
    }

    .exec-hero::after {
        content: '';
        position: absolute;
        right: -50px;
        top: -50px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, rgba(0,0,0,0) 70%);
        pointer-events: none;
    }

    .exec-hero-title {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .exec-hero-subtitle {
        color: #94a3b8;
        font-size: 13px;
        margin: 0;
    }

    .exec-hero-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 1;
    }

    .hero-pos-btn {
        background: #10b981;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 13px;
        padding: 8px 18px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        transition: all 0.2s ease;
    }

    .hero-pos-btn:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    /* KPI Cards */
    .kpi-card {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3.5px;
        background: #e2e8f0;
    }

    .kpi-card.kpi-emerald::before { background: linear-gradient(90deg, #10b981, #059669); }
    .kpi-card.kpi-blue::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
    .kpi-card.kpi-amber::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .kpi-card.kpi-purple::before { background: linear-gradient(90deg, #8b5cf6, #6d28d9); }

    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px -5px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        display: inline-block;
        animation: pulseAnimation 2s infinite;
    }
    @keyframes pulseAnimation {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .kpi-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .kpi-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--dash-muted);
    }

    .kpi-icon-wrap {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .kpi-icon-emerald { background: #ecfdf5; color: #10b981; }
    .kpi-icon-blue { background: #eff6ff; color: #2563eb; }
    .kpi-icon-amber { background: #fffbeb; color: #f59e0b; }
    .kpi-icon-purple { background: #f5f3ff; color: #8b5cf6; }

    .kpi-value {
        font-size: 26px;
        font-weight: 800;
        color: var(--dash-text);
        letter-spacing: -0.5px;
        line-height: 1.1;
        margin-bottom: 8px;
    }

    .kpi-footer {
        font-size: 11px;
        color: var(--dash-muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Pipeline Filter Pills */
    .pipeline-wrapper {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 12px;
        padding: 8px 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        margin-bottom: 24px;
    }

    .pipeline-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        color: #475569;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: all 0.15s ease;
        white-space: nowrap;
    }

    .pipeline-pill:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }

    .pipeline-pill .pill-badge {
        background: rgba(0, 0, 0, 0.08);
        padding: 2px 7px;
        border-radius: 20px;
        font-size: 11px;
    }

    .pipeline-pill:hover .pill-badge {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    /* Cards */
    .exec-card {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .exec-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--dash-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .exec-card-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--dash-text);
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .exec-card-body {
        padding: 20px;
        flex: 1;
    }

    /* Modern Table */
    .exec-table {
        width: 100%;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .exec-table th {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--dash-muted);
        background: #f8fafc;
        padding: 10px 14px;
        border-bottom: 1px solid var(--dash-border);
    }

    .exec-table td {
        padding: 12px 14px;
        vertical-align: middle;
        font-size: 13px;
        border-bottom: 1px solid #f1f5f9;
        color: var(--dash-text);
    }

    .exec-table tr:hover td {
        background: #f8fafc;
    }

    .taka-font {
        font-family: 'Noto Sans Bengali', 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
    }

    .status-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        display: inline-block;
    }

    .status-pending { background: #fef3c7; color: #b45309; }
    .status-processing { background: #e0f2fe; color: #0369a1; }
    .status-completed { background: #dcfce7; color: #15803d; }
    .status-cancelled { background: #fee2e2; color: #b91c1c; }

    /* Quick Action Mini Cards */
    .quick-act-card {
        padding: 14px;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: var(--dash-text);
        transition: all 0.2s ease;
    }

    .quick-act-card:hover {
        background: #ffffff;
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transform: translateY(-2px);
    }

    .quick-act-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
</style>

<main class="app-main pt-3 pb-5">
    <div class="container-fluid px-4">

        {{-- ================= HERO BANNER ================= --}}
        <div class="exec-hero">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1 small fw-bold d-inline-flex align-items-center gap-1.5" style="font-size: 11px;">
                        <span class="pulse-dot"></span> LIVE STOREFRONT SYNCED
                    </span>
                    <span class="badge bg-white bg-opacity-10 text-white-50 rounded-pill px-2.5 py-1 small" style="font-size: 11px;">
                        <i class="bi bi-clock me-1"></i> {{ now()->format('h:i A') }}
                    </span>
                </div>
                <div class="exec-hero-title">
                    Welcome back, {{ auth()->user()->name ?? 'Admin' }}! 👋
                </div>
                <p class="exec-hero-subtitle">
                    Here's what's happening with your online store and POS terminal today ({{ now()->format('l, d M Y') }}).
                </p>
            </div>

            <div class="exec-hero-actions">
                <a href="{{ route('sales.create') }}" class="hero-pos-btn">
                    <i class="bi bi-pc-display-horizontal fs-5"></i>
                    <span>Open POS Terminal</span>
                </a>
                <a href="{{ route('products.create') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-2 fw-semibold">
                    <i class="bi bi-plus-lg me-1"></i> Add Product
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-light rounded-pill px-3 py-2 fw-semibold text-dark shadow-xs">
                    <i class="bi bi-box-arrow-up-right me-1 text-primary"></i> Visit Store
                </a>
            </div>
        </div>

        {{-- ================= 4 PRIMARY KPI METRICS ================= --}}
        <div class="row g-3 mb-4">

            {{-- 1: Today's Revenue --}}
            <div class="col-xl-3 col-sm-6">
                <div class="kpi-card kpi-emerald">
                    <div class="kpi-header">
                        <span class="kpi-label">Today's Total Sales</span>
                        <div class="kpi-icon-wrap kpi-icon-emerald">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                    <div class="kpi-value taka-font">
                        ৳{{ number_format($todayTotalSales, 2) }}
                    </div>
                    <div class="kpi-footer">
                        <span class="badge bg-success-subtle text-success fw-bold">Live</span>
                        <span>Online: ৳{{ number_format($todayOrderSales, 0) }} | POS: ৳{{ number_format($todayPosSales, 0) }}</span>
                    </div>
                </div>
            </div>

            {{-- 2: This Month's Revenue --}}
            <div class="col-xl-3 col-sm-6">
                <div class="kpi-card kpi-blue">
                    <div class="kpi-header">
                        <span class="kpi-label">This Month's Sales</span>
                        <div class="kpi-icon-wrap kpi-icon-blue">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                    <div class="kpi-value taka-font">
                        ৳{{ number_format($thisMonthTotalSales, 2) }}
                    </div>
                    <div class="kpi-footer">
                        <i class="bi bi-calendar3 text-muted"></i>
                        <span>Month of {{ now()->format('F Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- 3: Orders Pending Action --}}
            <div class="col-xl-3 col-sm-6">
                <div class="kpi-card kpi-amber">
                    <div class="kpi-header">
                        <span class="kpi-label">Pending Orders</span>
                        <div class="kpi-icon-wrap kpi-icon-amber">
                            <i class="bi bi-bag-check"></i>
                        </div>
                    </div>
                    <div class="kpi-value">
                        {{ $pendingOrdersCount }}
                    </div>
                    <div class="kpi-footer">
                        @if($pendingOrdersCount > 0)
                            <span class="badge bg-warning-subtle text-warning fw-bold">Action Needed</span>
                            <span>Orders waiting for dispatch</span>
                        @else
                            <span class="badge bg-success-subtle text-success fw-bold">Clean</span>
                            <span>All orders processed!</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 4: Inventory & Stock Status --}}
            <div class="col-xl-3 col-sm-6">
                <div class="kpi-card kpi-purple">
                    <div class="kpi-header">
                        <span class="kpi-label">Total Stock Quantity</span>
                        <div class="kpi-icon-wrap kpi-icon-purple">
                            <i class="bi bi-box-seam"></i>
                        </div>
                    </div>
                    <div class="kpi-value">
                        {{ number_format($productStock) }} <span class="fs-6 fw-bold text-muted">units</span>
                    </div>
                    <div class="kpi-footer">
                        <span>{{ $totalProducts }} Products in catalog</span>
                        @if($lowStockCount > 0)
                            <span class="badge bg-danger-subtle text-danger fw-bold ms-auto">{{ $lowStockCount }} Low Stock</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= ORDER PIPELINE TRACKER ================= --}}
        <div class="pipeline-wrapper">
            <span class="small fw-bold text-muted text-uppercase me-2 d-none d-md-inline" style="font-size: 11px;">
                <i class="bi bi-funnel me-1"></i> Order Pipeline:
            </span>
            <a href="{{ route('orders.index') }}" class="pipeline-pill">
                <span>All Orders</span>
                <span class="pill-badge">{{ $totalOrdersCount }}</span>
            </a>
            <a href="{{ route('orders.index', ['status' => 'pending']) }}" class="pipeline-pill">
                <i class="bi bi-clock-history text-warning"></i>
                <span>Pending</span>
                <span class="pill-badge">{{ $pendingOrdersCount }}</span>
            </a>
            <a href="{{ route('orders.index', ['status' => 'processing']) }}" class="pipeline-pill">
                <i class="bi bi-gear-wide-connected text-primary"></i>
                <span>Processing</span>
                <span class="pill-badge">{{ $processingOrdersCount }}</span>
            </a>
            <a href="{{ route('orders.index', ['status' => 'completed']) }}" class="pipeline-pill">
                <i class="bi bi-check2-circle text-success"></i>
                <span>Completed / Delivered</span>
                <span class="pill-badge">{{ $completedOrdersCount }}</span>
            </a>
            <a href="{{ route('orders.index', ['status' => 'cancelled']) }}" class="pipeline-pill">
                <i class="bi bi-x-circle text-danger"></i>
                <span>Cancelled / Returned</span>
                <span class="pill-badge">{{ $cancelledOrdersCount }}</span>
            </a>
        </div>

        {{-- ================= CHARTS SECTION ================= --}}
        <div class="row g-3 mb-4">

            {{-- 7-Day Revenue Trend --}}
            <div class="col-lg-8">
                <div class="exec-card">
                    <div class="exec-card-header">
                        <h6 class="exec-card-title">
                            <i class="bi bi-graph-up text-primary"></i>
                            Sales Revenue Trend (Last 7 Days)
                        </h6>
                        <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 11px;">
                            Online Orders vs POS
                        </span>
                    </div>
                    <div class="exec-card-body">
                        <canvas id="revenueChart" height="110"></canvas>
                    </div>
                </div>
            </div>

            {{-- Order Distribution Doughnut --}}
            <div class="col-lg-4">
                <div class="exec-card">
                    <div class="exec-card-header">
                        <h6 class="exec-card-title">
                            <i class="bi bi-pie-chart text-success"></i>
                            Order Status Breakdown
                        </h6>
                        <small class="text-muted" style="font-size: 11px;">Total: {{ $totalOrdersCount }}</small>
                    </div>
                    <div class="exec-card-body d-flex flex-column align-items-center justify-content-center">
                        <div style="width: 220px; height: 220px;">
                            <canvas id="orderStatusChart"></canvas>
                        </div>
                        <div class="d-flex justify-content-around w-100 mt-3 pt-2 border-top text-center" style="font-size: 11px;">
                            <div>
                                <span class="d-block fw-bold text-success">{{ $completedOrdersCount }}</span>
                                <span class="text-muted">Completed</span>
                            </div>
                            <div>
                                <span class="d-block fw-bold text-warning">{{ $pendingOrdersCount }}</span>
                                <span class="text-muted">Pending</span>
                            </div>
                            <div>
                                <span class="d-block fw-bold text-danger">{{ $cancelledOrdersCount }}</span>
                                <span class="text-muted">Cancel/Ret</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= 2-COLUMN SECTION: TOP PRODUCTS & QUICK ACTIONS / ALERTS ================= --}}
        <div class="row g-3 mb-4">

            {{-- Top Selling Products --}}
            <div class="col-lg-6">
                <div class="exec-card">
                    <div class="exec-card-header">
                        <h6 class="exec-card-title">
                            <i class="bi bi-trophy text-warning"></i>
                            Top Selling Products
                        </h6>
                        <a href="{{ route('reports.top-products') }}" class="btn btn-sm btn-light border py-0 px-2" style="font-size: 11px;">
                            View Report
                        </a>
                    </div>
                    <div class="exec-card-body p-0">
                        <div class="table-responsive">
                            <table class="exec-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Sold Units</th>
                                        <th class="text-end">Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topSellingItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    @if(optional($item->product)->image)
                                                        <img src="{{ asset($item->product->image) }}" class="rounded border" width="34" height="34" style="object-fit: contain;">
                                                    @else
                                                        <div class="rounded border bg-light d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                                            <i class="bi bi-image text-muted" style="font-size: 14px;"></i>
                                                        </div>
                                                    @endif
                                                    <div class="text-truncate" style="max-width: 220px;" title="{{ $item->product_name }}">
                                                        <span class="fw-bold text-dark d-block text-truncate" style="font-size: 12px;">{{ $item->product_name }}</span>
                                                        <small class="text-muted" style="font-size: 10px;">Stock: {{ optional($item->product)->stock ?? 'N/A' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center fw-bold">{{ $item->total_qty }}</td>
                                            <td class="text-end fw-bold taka-font text-primary">৳{{ number_format($item->total_sales, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted" style="font-size: 12px;">
                                                No product sales recorded yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Operations & Low Stock Alert --}}
            <div class="col-lg-6">
                <div class="exec-card">
                    <div class="exec-card-header">
                        <h6 class="exec-card-title">
                            <i class="bi bi-lightning-charge text-primary"></i>
                            Quick Store Operations
                        </h6>
                        <span class="badge bg-primary-subtle text-primary" style="font-size: 11px;">Shortcuts</span>
                    </div>
                    <div class="exec-card-body">
                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <a href="{{ route('sales.create') }}" class="quick-act-card">
                                    <div class="quick-act-icon bg-success-subtle text-success">
                                        <i class="bi bi-pc-display-horizontal"></i>
                                    </div>
                                    <div class="lh-sm">
                                        <div class="fw-bold" style="font-size: 13px;">POS Terminal</div>
                                        <small class="text-muted" style="font-size: 11px;">Instant barcode billing</small>
                                    </div>
                                </a>
                            </div>

                            <div class="col-sm-6">
                                <a href="{{ route('orders.index') }}" class="quick-act-card">
                                    <div class="quick-act-icon bg-primary-subtle text-primary">
                                        <i class="bi bi-cart-check"></i>
                                    </div>
                                    <div class="lh-sm">
                                        <div class="fw-bold" style="font-size: 13px;">Manage Orders</div>
                                        <small class="text-muted" style="font-size: 11px;">Dispatch & tracking</small>
                                    </div>
                                </a>
                            </div>

                            <div class="col-sm-6">
                                <a href="{{ route('products.create') }}" class="quick-act-card">
                                    <div class="quick-act-icon bg-purple-subtle text-purple" style="background: #f5f3ff; color: #8b5cf6;">
                                        <i class="bi bi-plus-circle"></i>
                                    </div>
                                    <div class="lh-sm">
                                        <div class="fw-bold" style="font-size: 13px;">Add Product</div>
                                        <small class="text-muted" style="font-size: 11px;">Create new inventory</small>
                                    </div>
                                </a>
                            </div>

                            <div class="col-sm-6">
                                <a href="{{ route('expenses.create') }}" class="quick-act-card">
                                    <div class="quick-act-icon bg-danger-subtle text-danger">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                    <div class="lh-sm">
                                        <div class="fw-bold" style="font-size: 13px;">Record Expense</div>
                                        <small class="text-muted" style="font-size: 11px;">Daily expense entry</small>
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- Low stock warning block --}}
                        @if($lowStockCount > 0)
                            <div class="alert alert-danger d-flex align-items-center justify-content-between p-2 mb-0" style="font-size: 12px; border-radius: 8px;">
                                <div>
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                    <strong>{{ $lowStockCount }} items</strong> are running low on stock!
                                </div>
                                <a href="{{ route('reports.low-stock') }}" class="btn btn-sm btn-danger py-0 px-2 fw-bold" style="font-size: 11px;">
                                    View Items
                                </a>
                            </div>
                        @else
                            <div class="alert alert-success d-flex align-items-center p-2 mb-0" style="font-size: 12px; border-radius: 8px;">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <span>All products have healthy inventory levels.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= RECENT ORDERS TABLE ================= --}}
        <div class="exec-card mb-4">
            <div class="exec-card-header">
                <h6 class="exec-card-title">
                    <i class="bi bi-clock-history text-primary"></i>
                    Recent Orders
                </h6>
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary fw-semibold px-3 py-1" style="font-size: 12px;">
                    View All Orders &rarr;
                </a>
            </div>
            <div class="exec-card-body p-0">
                <div class="table-responsive">
                    <table class="exec-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="fw-bold text-primary text-decoration-none">
                                            #{{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-light text-primary border d-flex align-items-center justify-content-center fw-bold" style="width: 30px; height: 30px; font-size: 12px;">
                                                {{ substr($order->full_name ?? ($order->customer->name ?? 'G'), 0, 1) }}
                                            </div>
                                            <div class="lh-sm">
                                                <div class="fw-bold" style="font-size: 12px;">{{ $order->full_name ?? ($order->customer->name ?? 'Guest') }}</div>
                                                <small class="text-muted" style="font-size: 11px;">{{ $order->phone ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 11px;">
                                            {{ $order->items->count() }} items
                                        </span>
                                    </td>
                                    <td class="taka-font fw-bold text-dark">
                                        ৳{{ number_format($order->total, 2) }}
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border text-uppercase" style="font-size: 10px;">
                                            {{ $order->payment_method ?? 'COD' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $st = strtolower($order->status ?? 'pending');
                                            $stClass = 'status-pending';
                                            if (in_array($st, ['completed', 'delivered'])) {
                                                $stClass = 'status-completed';
                                            } elseif (in_array($st, ['processing', 'confirmed'])) {
                                                $stClass = 'status-processing';
                                            } elseif (in_array($st, ['cancelled', 'return'])) {
                                                $stClass = 'status-cancelled';
                                            }
                                        @endphp
                                        <span class="status-badge {{ $stClass }}">
                                            {{ ucfirst($order->status ?? 'Pending') }}
                                        </span>
                                    </td>
                                    <td class="text-muted" style="font-size: 12px;">
                                        {{ $order->created_at->diffForHumans() }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-light border py-1 px-2" title="View Order">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 text-muted opacity-50"></i>
                                        No recent orders found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

{{-- ================= CHART JS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 7-Day Revenue Multi-Line Chart
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    const gradTotal = ctxRevenue.createLinearGradient(0, 0, 0, 300);
    gradTotal.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
    gradTotal.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'Total Revenue (৳)',
                    data: @json($chartData),
                    borderColor: '#2563eb',
                    backgroundColor: gradTotal,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Online Orders (৳)',
                    data: @json($orderChartData),
                    borderColor: '#10b981',
                    borderWidth: 2,
                    borderDash: [4, 4],
                    fill: false,
                    tension: 0.35,
                    pointRadius: 3
                },
                {
                    label: 'POS Sales (৳)',
                    data: @json($posChartData),
                    borderColor: '#f59e0b',
                    borderWidth: 2,
                    borderDash: [2, 2],
                    fill: false,
                    tension: 0.35,
                    pointRadius: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 10,
                        usePointStyle: true,
                        font: { size: 11, family: 'Plus Jakarta Sans', weight: '600' }
                    }
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleFont: { size: 12, family: 'Plus Jakarta Sans' },
                    bodyFont: { size: 12, family: 'Plus Jakarta Sans' },
                    padding: 10,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { size: 11 },
                        callback: function(value) { return '৳' + value; }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });

    // Order Status Doughnut Chart
    const ctxOrder = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(ctxOrder, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending', 'Processing', 'Cancelled/Return'],
            datasets: [{
                data: [
                    {{ $completedOrdersCount }},
                    {{ $pendingOrdersCount }},
                    {{ $processingOrdersCount }},
                    {{ $cancelledOrdersCount }}
                ],
                backgroundColor: ['#10b981', '#f59e0b', '#2563eb', '#ef4444'],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

@endsection
