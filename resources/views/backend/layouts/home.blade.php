@extends('backend.layouts.app')
@section('title', 'Admin Dashboard')

@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;600;700&display=swap');

        :root {
            --bg: #f8fafc;
            --card: #ffffff;
            --text-main: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --primary: #3b82f6;
            --primary-light: #eff6ff;
            --success: #10b981;
            --success-light: #ecfdf5;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --radius: 16px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-hover: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg) !important;
        }

        .app-content {
            background: var(--bg);
        }

        /* Page Header */
        .dashboard-header {
            background: var(--primary);
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: var(--radius);
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px -5px rgba(37, 99, 216, 0.3);
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            width: 300px;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" stroke="rgba(255,255,255,0.1)" stroke-width="10" fill="none"/></svg>') repeat;
            opacity: 0.5;
        }

        .welcome-text {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .welcome-sub {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        /* KPI CARDS */
        .stat-card {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            padding: 24px;
            transition: all 0.3s ease;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .stat-card.sales .stat-icon {
            background: var(--primary-light);
            color: var(--primary);
        }

        .stat-card.orders .stat-icon {
            background: var(--success-light);
            color: var(--success);
        }

        .stat-card.customers .stat-icon {
            background: var(--warning-light);
            color: var(--warning);
        }

        .stat-card.stock .stat-icon {
            background: var(--danger-light);
            color: var(--danger);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 14px;
            font-weight: 500;
        }

        /* CARDS */
        .modern-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            height: 100%;
        }

        .modern-card .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 20px 24px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modern-card .card-body {
            padding: 24px;
        }

        /* TABLE */
        .modern-table th {
            background: #f8fafc;
            color: var(--muted);
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border);
            padding: 12px 16px;
        }

        .modern-table td {
            padding: 16px;
            vertical-align: middle;
            color: var(--text-main);
            font-weight: 500;
        }

        .modern-table tbody tr {
            transition: background 0.2s;
        }

        .modern-table tbody tr:hover {
            background: #f8fafc;
        }

        .taka-font {
            font-family: 'Noto Sans Bengali', 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
        }

        .btn-modern {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s;
        }
    </style>

    <main class="app-main pt-4">
        <div class="app-content">
            <div class="container-fluid px-4">

                {{-- HEADER BANNER --}}
                <div class="dashboard-header">
                    <div class="welcome-text">Welcome back, {{ auth()->user()->name ?? 'Admin' }}! 👋</div>
                    <div class="welcome-sub">Here's what's happening with your store today.</div>
                </div>

                {{-- ================= KPI CARDS ================= --}}
                <div class="row g-4 mb-4">
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="stat-card sales">
                            <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
                            <div class="stat-value taka-font">৳ {{ number_format($todayTotalSales, 2) }}</div>
                            <div class="stat-label">Today's Total Sales</div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="stat-card orders">
                            <div class="stat-icon"><i class="bi bi-bag-check"></i></div>
                            <div class="stat-value">{{ $newOrdersCount }}</div>
                            <div class="stat-label">New Orders Today</div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="stat-card customers">
                            <div class="stat-icon"><i class="bi bi-people"></i></div>
                            <div class="stat-value">{{ $customersCount }}</div>
                            <div class="stat-label">Total Customers</div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="stat-card stock">
                            <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
                            <div class="stat-value">{{ $productStock }}</div>
                            <div class="stat-label">Products in Stock</div>
                        </div>
                    </div>
                </div>

                {{-- ================= QUICK ACTIONS ================= --}}
                <div class="modern-card mb-4">
                    <div class="card-header">
                        <span><i class="bi bi-lightning-charge-fill text-warning me-2"></i> Quick Actions</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ route('orders.index') }}" class="btn btn-primary btn-modern"><i
                                    class="bi bi-cart me-2"></i> Manage Orders</a>
                            <a href="{{ route('products.create') ?? '#' }}" class="btn btn-outline-primary btn-modern"><i
                                    class="bi bi-plus-circle me-2"></i> Add Product</a>
                            <a href="{{ route('expenses.create') ?? '#' }}" class="btn btn-outline-danger btn-modern"><i
                                    class="bi bi-receipt me-2"></i> Record Expense</a>
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-dark btn-modern"><i
                                    class="bi bi-people me-2"></i> View Customers</a>
                            <a href="#" class="btn btn-outline-success btn-modern"
                                onclick="alert('POS Module coming soon!')"><i class="bi bi-pc-display-horizontal me-2"></i>
                                Open POS</a>
                        </div>
                    </div>
                </div>

                {{-- ================= CHARTS ================= --}}
                <div class="row g-4 mb-4">
                    <div class="col-lg-8">
                        <div class="modern-card">
                            <div class="card-header">
                                <span><i class="bi bi-graph-up text-primary me-2"></i> Sales Overview (Last 7 Days)</span>
                            </div>
                            <div class="card-body">
                                <canvas id="salesChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="modern-card">
                            <div class="card-header">
                                <span><i class="bi bi-pie-chart-fill text-danger me-2"></i> Income vs Expense (Today)</span>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div style="width: 80%;">
                                    <canvas id="pieChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ================= RECENT ORDERS ================= --}}
                <div class="modern-card mb-5">
                    <div class="card-header">
                        <span><i class="bi bi-clock-history text-success me-2"></i> Recent Orders</span>
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-light">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table modern-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Order No</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                        <tr>
                                            <td><span class="fw-bold text-primary">#{{ $order->order_number }}</span></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar bg-light text-primary rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold"
                                                        style="width: 32px; height: 32px; font-size: 14px;">
                                                        {{ substr($order->customer_name, 0, 1) }}
                                                    </div>
                                                    {{ $order->customer_name }}
                                                </div>
                                            </td>
                                            <td class="taka-font">৳ {{ number_format($order->total, 2) }}</td>
                                            <td class="text-muted">{{ $order->created_at->diffForHumans() }}</td>
                                            <td>
                                                @if (in_array(strtolower($order->order_status), ['completed', 'delivered']))
                                                    <span
                                                        class="badge bg-success-light text-success px-3 py-2 rounded-pill border border-success">Completed</span>
                                                @elseif(strtolower($order->order_status) == 'pending')
                                                    <span
                                                        class="badge bg-warning-light text-warning px-3 py-2 rounded-pill border border-warning">Pending</span>
                                                @elseif(in_array(strtolower($order->order_status), ['cancelled', 'return']))
                                                    <span
                                                        class="badge bg-danger-light text-danger px-3 py-2 rounded-pill border border-danger">{{ ucfirst($order->order_status) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-primary-light text-primary px-3 py-2 rounded-pill border border-primary">{{ ucfirst($order->order_status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">No recent orders found.
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
    </main>

    {{-- ================= CHART JS ================= --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Main Sales Line Chart
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        const gradientSales = ctxSales.createLinearGradient(0, 0, 0, 400);
        gradientSales.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
        gradientSales.addColorStop(1, 'rgba(59, 130, 246, 0)');

        new Chart(ctxSales, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Sales Amount (৳)',
                    data: @json($chartData),
                    borderColor: '#3b82f6',
                    backgroundColor: gradientSales,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5],
                            color: '#e2e8f0'
                        },
                        border: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });

        // Income vs Expense Doughnut Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'doughnut',
            data: {
                labels: ['Income', 'Expense'],
                datasets: [{
                    data: [
                        {{ $todayTotalSales }},
                        {{ $todayExpenses ?? 0 }}
                    ],
                    backgroundColor: ['#10b981', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    }
                }
            }
        });
    </script>

@endsection
