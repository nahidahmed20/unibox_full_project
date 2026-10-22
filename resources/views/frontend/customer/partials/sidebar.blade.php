@once
<link rel="stylesheet" href="{{ asset('frontend/assets/css/account.css') }}?v={{ filemtime(public_path('frontend/assets/css/account.css')) }}">
@endonce
@php
    $user = auth('customer')->user();
    $userName = $user->name ?: 'Customer';
    $userInitial = mb_substr($userName, 0, 1);
    $userContact = $user->phone ?: $user->email;
@endphp

{{-- ================= MOBILE/TABLET HEADER & NAV (< 992px) ================= --}}
<div class="ub-account-mobile-card d-lg-none mb-3 shadow-xs">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center gap-2.5 overflow-hidden">
            @if($user->image && file_exists(public_path($user->image)))
                <img src="{{ asset($user->image) }}" alt="{{ $userName }}" class="ub-account-mobile-avatar flex-shrink-0">
            @else
                <span class="ub-account-mobile-avatar flex-shrink-0" aria-hidden="true">{{ $userInitial }}</span>
            @endif
            <div class="text-truncate">
                <div class="fw-bold text-dark text-truncate lh-sm" style="font-size: 15px;">{{ $userName }}</div>
                <div class="text-muted small text-truncate" style="font-size: 12px;">{{ $userContact }}</div>
            </div>
        </div>
        <form action="{{ route('account.logout') }}" method="POST" class="m-0 flex-shrink-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 11px;">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>লগআউট</span>
            </button>
        </form>
    </div>

    {{-- Horizontal Scrollable Nav Pills --}}
    <div class="ub-account-nav-pills-scroll" role="navigation" aria-label="Customer account navigation">
        <a href="{{ route('account.dashboard') }}" class="ub-nav-pill {{ request()->routeIs('account.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-table-cells-large"></i>
            <span>ড্যাশবোর্ড</span>
        </a>
        <a href="{{ route('account.orders.index') }}" class="ub-nav-pill {{ (request()->routeIs('account.orders.index') || request()->routeIs('account.orders.show')) ? 'active' : '' }}">
            <i class="fa-solid fa-bag-shopping"></i>
            <span>আমার অর্ডার</span>
        </a>
        <a href="{{ route('account.profile.edit') }}" class="ub-nav-pill {{ request()->routeIs('account.profile.edit') ? 'active' : '' }}">
            <i class="fa-solid fa-user-pen"></i>
            <span>প্রোফাইল ও ঠিকানা</span>
        </a>
        <a href="{{ route('account.password.edit') }}" class="ub-nav-pill {{ request()->routeIs('account.password.edit') ? 'active' : '' }}">
            <i class="fa-solid fa-shield-halved"></i>
            <span>পাসওয়ার্ড</span>
        </a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var activePill = document.querySelector(".ub-nav-pill.active");
        if (activePill && typeof activePill.scrollIntoView === "function") {
            try {
                activePill.scrollIntoView({ inline: "center", block: "nearest" });
            } catch (e) {}
        }
    });
</script>

{{-- ================= DESKTOP VERTICAL SIDEBAR (>= 992px) ================= --}}
<nav class="ub-account-nav shadow-xs d-none d-lg-block sticky-top" style="top: 90px; z-index: 10;" aria-label="Customer account navigation">
    <div class="ub-account-person">
        @if($user->image && file_exists(public_path($user->image)))
            <img src="{{ asset($user->image) }}" alt="{{ $userName }}" class="ub-account-avatar-img">
        @else
            <span class="ub-account-avatar" aria-hidden="true">{{ $userInitial }}</span>
        @endif
        <div class="ub-account-person-meta">
            <strong>{{ $userName }}</strong>
            <p>{{ $userContact }}</p>
            <span class="ub-verified-pill"><i class="fa-solid fa-circle-check"></i> ভেরিফাইড গ্রাহক</span>
        </div>
    </div>

    <div class="ub-account-menu-links">
        <a href="{{ route('account.dashboard') }}" @if(request()->routeIs('account.dashboard')) aria-current="page" @endif>
            <i class="fa-solid fa-table-cells-large" aria-hidden="true"></i>
            <span>ড্যাশবোর্ড (Dashboard)</span>
        </a>
        <a href="{{ route('account.orders.index') }}" @if(request()->routeIs('account.orders.index') || request()->routeIs('account.orders.show')) aria-current="page" @endif>
            <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
            <span>আমার অর্ডারসমূহ (Orders)</span>
        </a>
        <a href="{{ route('account.profile.edit') }}" @if(request()->routeIs('account.profile.edit')) aria-current="page" @endif>
            <i class="fa-solid fa-user-pen" aria-hidden="true"></i>
            <span>প্রোফাইল ও ঠিকানা (Profile)</span>
        </a>
        <a href="{{ route('account.password.edit') }}" @if(request()->routeIs('account.password.edit')) aria-current="page" @endif>
            <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
            <span>পাসওয়ার্ড পরিবর্তন (Security)</span>
        </a>
    </div>

    <div class="ub-account-sidebar-footer">
        <form action="{{ route('account.logout') }}" method="POST">
            @csrf
            <button type="submit" class="ub-logout-btn">
                <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                <span>লগআউট (Sign Out)</span>
            </button>
        </form>
    </div>
</nav>
