<style>
    .topbar-wrapper {
        height: 60px;
        background: #ffffff;
        border-bottom: 1px solid #edf2f7;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        padding: 0 16px;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .topbar-btn {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
        position: relative;
    }

    .topbar-btn:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
        transform: translateY(-1px);
    }

    .topbar-user-pill {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 4px 12px 4px 6px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 30px;
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
    }

    .topbar-user-pill:hover,
    .topbar-user-pill[aria-expanded="true"] {
        background: #ffffff;
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .topbar-avatar-wrap {
        position: relative;
        display: inline-block;
    }

    .topbar-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ffffff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .topbar-status-dot {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        background: #10b981;
        border: 2px solid #ffffff;
        border-radius: 50%;
    }

    .pos-btn-glow {
        background: #0f172a;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 13px;
        border-radius: 30px;
        padding: 6px 16px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #334155;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .pos-btn-glow:hover {
        background: #1e293b;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.2);
    }

    .pos-pulse-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: posPulse 2s infinite;
    }

    @keyframes posPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        }
        70% {
            box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }

    .notification-badge {
        position: absolute;
        top: -3px;
        right: -3px;
        background: #ef4444;
        color: #ffffff;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 5px;
        border-radius: 10px;
        border: 2px solid #ffffff;
        line-height: 1;
    }

    .modern-dropdown-menu {
        border-radius: 14px;
        border: 1px solid #edf2f7;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        padding: 8px;
        min-width: 250px;
    }

    .modern-dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 8px;
        color: #334155;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .modern-dropdown-item:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .modern-dropdown-item i {
        font-size: 16px;
        color: #64748b;
        transition: color 0.15s ease;
    }

    .modern-dropdown-item:hover i {
        color: #2563eb;
    }

    .modern-dropdown-item.text-danger:hover {
        background: #fef2f2;
        color: #dc2626 !important;
    }

    .modern-dropdown-item.text-danger:hover i {
        color: #dc2626 !important;
    }

    .store-link-btn {
        background: #eff6ff;
        color: #2563eb !important;
        font-weight: 600;
        font-size: 12px;
        border-radius: 20px;
        padding: 5px 12px;
        border: 1px solid #bfdbfe;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .store-link-btn:hover {
        background: #2563eb;
        color: #ffffff !important;
        border-color: #2563eb;
    }
</style>

@php
    $navPendingOrders = \App\Models\Order::where('status', 'pending')->count();
    $navLowStock = \App\Models\Product::where('stock', '<=', \Illuminate\Support\Facades\DB::raw('COALESCE(alert_quantity, 5)'))->count();
    $navTotalAlerts = $navPendingOrders + $navLowStock;
@endphp

<nav class="app-header topbar-wrapper">

    {{-- LEFT: TOGGLE & STORE LINKS --}}
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="topbar-btn" data-lte-toggle="sidebar" title="Toggle Navigation Sidebar">
            <i class="bi bi-list fs-5"></i>
        </button>

        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light border-0 fw-bold d-none d-md-flex align-items-center gap-1.5 px-2 py-1 text-dark" style="font-size: 13px;">
            <i class="bi bi-speedometer2 text-primary"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('home') }}" target="_blank" class="store-link-btn d-none d-sm-inline-flex" title="View Frontend Storefront">
            <i class="bi bi-box-arrow-up-right"></i>
            <span>Live Store</span>
        </a>
    </div>

    {{-- RIGHT: POS BUTTON, NOTIFICATIONS, FULLSCREEN & USER PROFILE --}}
    <div class="d-flex align-items-center gap-2">

        {{-- QUICK POS SHORTCUT --}}
        <a href="{{ route('sales.create') }}" class="pos-btn-glow" title="Open POS Billing Register">
            <span class="pos-pulse-dot"></span>
            <i class="bi bi-pc-display-horizontal text-success"></i>
            <span class="d-none d-sm-inline">POS Register</span>
        </a>

        {{-- NOTIFICATIONS DROPDOWN --}}
        <div class="dropdown">
            <a class="topbar-btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications & Alerts">
                <i class="bi bi-bell"></i>
                @if($navTotalAlerts > 0)
                    <span class="notification-badge">{{ $navTotalAlerts }}</span>
                @endif
            </a>

            <ul class="dropdown-menu dropdown-menu-end modern-dropdown-menu shadow-lg p-2" style="width: 290px;">
                <li class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                    <span class="fw-bold text-dark" style="font-size: 13px;">Notifications</span>
                    @if($navTotalAlerts > 0)
                        <span class="badge bg-danger-subtle text-danger fw-bold" style="font-size: 11px;">{{ $navTotalAlerts }} Pending</span>
                    @else
                        <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 11px;">All Clean</span>
                    @endif
                </li>

                @if($navPendingOrders > 0)
                    <li class="mt-1">
                        <a href="{{ route('orders.index') }}" class="modern-dropdown-item">
                            <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center p-2" style="width: 32px; height: 32px;">
                                <i class="bi bi-bag-check-fill text-warning"></i>
                            </div>
                            <div class="lh-sm">
                                <div class="fw-bold text-dark" style="font-size: 12px;">{{ $navPendingOrders }} Orders Pending</div>
                                <small class="text-muted" style="font-size: 11px;">Click to review and process</small>
                            </div>
                        </a>
                    </li>
                @endif

                @if($navLowStock > 0)
                    <li class="mt-1">
                        <a href="{{ route('reports.low-stock') }}" class="modern-dropdown-item">
                            <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center p-2" style="width: 32px; height: 32px;">
                                <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                            </div>
                            <div class="lh-sm">
                                <div class="fw-bold text-dark" style="font-size: 12px;">{{ $navLowStock }} Low Stock Items</div>
                                <small class="text-muted" style="font-size: 11px;">Restock inventory soon</small>
                            </div>
                        </a>
                    </li>
                @endif

                @if($navTotalAlerts == 0)
                    <li class="p-3 text-center text-muted" style="font-size: 12px;">
                        <i class="bi bi-check-circle-fill text-success fs-4 d-block mb-1"></i>
                        No pending actions or stock alerts right now!
                    </li>
                @endif

                <li class="border-top mt-1 pt-1">
                    <a href="{{ route('orders.index') }}" class="dropdown-item text-center text-primary fw-bold py-1" style="font-size: 11px;">
                        View All Orders &rarr;
                    </a>
                </li>
            </ul>
        </div>

        {{-- FULLSCREEN TOGGLE --}}
        <a class="topbar-btn d-none d-md-inline-flex" data-lte-toggle="fullscreen" role="button" title="Toggle Fullscreen">
            <i class="bi bi-arrows-fullscreen"></i>
        </a>

        {{-- USER PROFILE DROPDOWN --}}
        <div class="dropdown">
            <div class="topbar-user-pill" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                <div class="topbar-avatar-wrap">
                    <img src="{{ Auth::user()?->image && file_exists(public_path(Auth::user()->image))
                        ? asset(Auth::user()->image)
                        : asset('backend/assets/img/user_image.png') }}"
                        class="topbar-avatar" alt="{{ Auth::user()?->name ?? 'Admin' }}">
                    <span class="topbar-status-dot"></span>
                </div>

                <div class="d-none d-md-flex flex-column text-start lh-1">
                    <span class="fw-bold text-dark text-truncate" style="font-size: 13px; max-width: 120px;">
                        {{ Auth::user()?->name ?? 'Admin' }}
                    </span>
                    <span class="text-muted text-uppercase" style="font-size: 10px; font-weight: 700;">
                        {{ Auth::user()?->roles?->pluck('name')->first() ?? (Auth::user()?->type ?? 'Super Admin') }}
                    </span>
                </div>

                <i class="bi bi-chevron-down text-muted" style="font-size: 11px;"></i>
            </div>

            <ul class="dropdown-menu dropdown-menu-end modern-dropdown-menu shadow-lg p-2" style="min-width: 250px;">
                {{-- USER HEADER --}}
                <li class="px-3 py-2 d-flex align-items-center gap-3 border-bottom mb-2">
                    <img src="{{ Auth::user()?->image && file_exists(public_path(Auth::user()->image))
                        ? asset(Auth::user()->image)
                        : asset('backend/assets/img/user_image.png') }}"
                        class="rounded-circle border" width="42" height="42" style="object-fit: cover;">

                    <div class="lh-sm overflow-hidden">
                        <div class="fw-bold text-dark text-truncate" style="font-size: 13px;">{{ Auth::user()?->name ?? 'Admin' }}</div>
                        <small class="text-muted text-truncate d-block" style="font-size: 11px;">{{ Auth::user()?->email ?? '' }}</small>
                        <span class="badge bg-primary-subtle text-primary fw-bold mt-1" style="font-size: 9px;">
                            {{ Auth::user()?->roles?->pluck('name')->first() ?? 'Super Admin' }}
                        </span>
                    </div>
                </li>

                {{-- PROFILE --}}
                <li>
                    <a class="modern-dropdown-item" href="{{ route('user-profiles.edit', Auth::user()?->id ?? 1) }}">
                        <i class="bi bi-person-gear"></i>
                        <span>My Profile</span>
                    </a>
                </li>

                {{-- SETTINGS --}}
                <li>
                    <a class="modern-dropdown-item" href="{{ route('settings.index') }}">
                        <i class="bi bi-sliders"></i>
                        <span>Store Settings</span>
                    </a>
                </li>

                {{-- POS TERMINAL --}}
                <li>
                    <a class="modern-dropdown-item" href="{{ route('sales.create') }}">
                        <i class="bi bi-pc-display-horizontal"></i>
                        <span>POS Terminal</span>
                    </a>
                </li>

                {{-- REPORTS --}}
                <li>
                    <a class="modern-dropdown-item" href="{{ route('reports.orders') }}">
                        <i class="bi bi-bar-chart-line"></i>
                        <span>Sales Reports</span>
                    </a>
                </li>

                <li class="border-top my-1"></li>

                {{-- LOGOUT --}}
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="modern-dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                            <i class="bi bi-box-arrow-right text-danger"></i>
                            <span>Sign out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>

</nav>
