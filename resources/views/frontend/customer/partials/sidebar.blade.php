@once
<link rel="stylesheet" href="{{ asset('frontend/assets/css/account.css') }}?v={{ filemtime(public_path('frontend/assets/css/account.css')) }}">
@endonce
@php
    $user = auth('customer')->user();
    $userName = $user->name ?: 'Customer';
    $userInitial = mb_substr($userName, 0, 1);
    $userContact = $user->phone ?: $user->email;
@endphp
<nav class="ub-account-nav shadow-xs" aria-label="Customer account navigation">
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
