@php($cartCount = count(session('cart', [])))
<a class="ub-skip" href="#main-content">Skip to content</a>
<div class="ub-announcement">
    <div class="container"><span>Something for your business. Something for you.</span><a
            href="{{ route('track.order') }}">Track your order <i class="fa-regular fa-arrow-right"
                aria-hidden="true"></i></a></div>
</div>
<header class="ub-header">
    <div class="container ub-header-main">
        <a class="ub-brand" href="{{ route('home') }}" aria-label="Unibox home">
            @if (setting('header_logo'))
                <img src="{{ asset(setting('header_logo')) }}" alt="Unibox" width="140" height="44">
            @else
                <span class="ub-brand-symbol" aria-hidden="true">u.</span><span>uni<span
                        class="ub-brand-accent">box</span><small>IDEAS, DELIVERED.</small></span>
            @endif
        </a>
        <div class="category-form-wrap ub-search-wrap">
            <form class="ub-search" action="{{ route('search') }}" method="GET" role="search">
                <i class="fa-regular fa-magnifying-glass" aria-hidden="true"></i>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="What are you looking for today?" aria-label="Search products" autocomplete="off">
                <button type="submit">Search</button>
            </form>
            <div id="searchSuggestion" class="ub-search-results" aria-live="polite"></div>
        </div>
        <div class="ub-header-actions">
            <a class="ub-account"
                href="{{ auth('customer')->check() ? route('account.dashboard') : route('account.login') }}">
                <i class="fa-regular fa-user"
                    aria-hidden="true"></i><span><small>{{ auth('customer')->check() ? 'Welcome back' : 'Hello, welcome' }}</small>{{ auth('customer')->check() ? 'My account' : 'Sign in' }}</span>
            </a>
            <button type="button" class="ub-cart-button cart-toggle" aria-label="Open shopping cart"
                aria-controls="cart-drawer" aria-expanded="false">
                <i class="fa-regular fa-bag-shopping" aria-hidden="true"></i><span
                    class="ub-cart-label">Cart</span><span id="cart-count"
                    class="cart-item-count-render">{{ $cartCount }}</span>
            </button>
            <button type="button" class="ub-menu-toggle" aria-controls="store-navigation" aria-expanded="false"
                aria-label="Open navigation"><i class="fa-solid fa-bars" aria-hidden="true"></i></button>
        </div>
    </div>
    <div id="menu-overlay" hidden></div>
    <nav class="ub-navigation" id="store-navigation" aria-label="Main navigation">
        <div class="ub-mobile-nav-heading"><span>Explore Unibox</span><button id="menu-close" type="button" aria-label="Close navigation"><i class="fa-regular fa-xmark" aria-hidden="true"></i></button></div>
        <div class="container ub-nav-inner">
            <details class="ub-category-menu">
                <summary><i class="fa-solid fa-grip" aria-hidden="true"></i> Browse categories <i
                        class="fa-regular fa-chevron-down" aria-hidden="true"></i></summary>
                <div class="ub-category-dropdown">
                                        <a href="{{ route('search') }}">Shop all products <i class="fa-regular fa-arrow-right"
                            aria-hidden="true"></i></a>
                    @foreach ($categories as $category)
                        <a href="{{ route('category.show', $category->slug) }}" style="font-weight:600;">{{ $category->name }} <i
                                class="fa-regular fa-arrow-right" aria-hidden="true"></i></a>
                        @if($category->children && count($category->children) > 0)
                            @foreach($category->children as $sub)
                                <a href="{{ route('category.show', $sub->slug) }}" style="padding-left: 2rem; font-size: 14px; border-bottom: none; opacity: 0.9;">
                                    — {{ $sub->name }}
                                </a>
                                @if($sub->children && count($sub->children) > 0)
                                    @foreach($sub->children as $child)
                                        <a href="{{ route('category.show', $child->slug) }}" style="padding-left: 3rem; font-size: 13px; border-bottom: none; opacity: 0.7;">
                                            — {{ $child->name }}
                                        </a>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </details>
            <div class="ub-nav-links">
                <a href="{{ route('home') }}" @class(['is-current' => request()->routeIs('home')])>Home</a>
                <a href="{{ route('search') }}" @class(['is-current' => request()->routeIs('search')])>Shop all</a>
                <a href="{{ route('shop.bestsellers') }}">Bestsellers <span class="ub-mini-label">POPULAR</span></a>
                <a href="{{ route('about.us') }}">Our story</a>
                <a href="{{ route('contact.us') }}">Contact</a>
            </div>
            <a class="ub-nav-help" href="{{ route('contact.us') }}"><i class="fa-regular fa-headset"
                    aria-hidden="true"></i> Need a custom order?</a>
        </div>
    </nav>
</header>
<div id="cart-overlay" hidden></div>
<aside id="cart-drawer" role="dialog" aria-modal="true" aria-labelledby="cart-title" aria-hidden="true" inert>
    <div class="cart-header">
        <div><span class="ub-eyebrow">YOUR FINDS</span>
            <h2 id="cart-title">Shopping bag</h2>
        </div><button id="cart-close" type="button" aria-label="Close shopping cart"><i class="fa-regular fa-xmark"
                aria-hidden="true"></i></button>
    </div>
    <div id="cart-section" class="cart-body">@include('frontend.cart.partials.header-cart')</div>
    <div class="cart-footer"><a class="ub-button ub-button-primary" href="{{ route('checkout') }}">View cart &
            checkout <i class="fa-regular fa-arrow-right" aria-hidden="true"></i></a>
        <p>Delivery is calculated for your selected zone.</p>
    </div>
</aside>

