@once
<link rel="stylesheet" href="{{ asset('frontend/assets/css/account.css') }}?v={{ filemtime(public_path('frontend/assets/css/account.css')) }}">
@endonce
<nav class="ub-account-nav" aria-label="Your account">
 <div class="ub-account-person"><span class="ub-account-avatar" aria-hidden="true">{{ mb_substr(auth('customer')->user()->name ?: 'U', 0, 1) }}</span><strong>{{ auth('customer')->user()->name ?: 'Your account' }}</strong><p>{{ auth('customer')->user()->phone ?: auth('customer')->user()->email }}</p></div>
 @foreach(['account.dashboard' => ['fa-grid-2', 'Overview'], 'account.orders.index' => ['fa-bag-shopping', 'My orders'], 'account.profile.edit' => ['fa-user', 'Personal details'], 'account.password.edit' => ['fa-lock', 'Password & security']] as $name => [$icon, $label])
 <a href="{{ route($name) }}" @if(request()->routeIs($name) || ($name === 'account.orders.index' && request()->routeIs('account.orders.show'))) aria-current="page" @endif><i class="fa-regular {{ $icon }}" aria-hidden="true"></i>{{ $label }}</a>
 @endforeach
 <form action="{{ route('account.logout') }}" method="POST">@csrf<button type="submit"><i class="fa-regular fa-arrow-right-from-bracket" aria-hidden="true"></i>Sign out</button></form>
</nav>
