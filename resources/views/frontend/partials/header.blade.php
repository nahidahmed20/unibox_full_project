@php($cartCount = count(session('cart', [])))
<a class="ub-skip" href="#main-content">Skip to content</a>

{{-- ANNOUNCEMENT TOPBAR --}}
<div class="ub-announcement">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            @if(setting('free_shipping_threshold') && setting('free_shipping_threshold') > 0)
                <span><i class="fa-solid fa-gift me-1 text-warning"></i> <strong>স্পেশাল অফার:</strong> ৳{{ number_format(setting('free_shipping_threshold')) }} বা তার বেশি অর্ডারে সারা দেশে ডেলিভারি সম্পূর্ণ ফ্রি!</span>
            @else
                <span><i class="fa-solid fa-shield-halved me-1 text-info"></i> ১০০% অরিজিনাল প্রোডাক্ট • ক্যাশ অন ডেলিভারি সুবিধা সারা দেশে</span>
            @endif
        </div>
        <div class="d-flex align-items-center gap-3">
            @if(setting('hotline') || setting('phone'))
                <a href="tel:{{ preg_replace('/[^+0-9]/', '', setting('hotline', setting('phone'))) }}" class="text-white text-decoration-none">
                    <i class="fa-solid fa-phone-volume me-1"></i> হটলাইন: {{ setting('hotline', setting('phone')) }}
                </a>
            @endif
            <a href="{{ route('track.order') }}">
                <i class="fa-solid fa-truck-fast me-1"></i> Track Order
            </a>
        </div>
    </div>
</div>

{{-- MAIN HEADER --}}
<header class="ub-header">
    <div class="container ub-header-main d-flex align-items-center justify-content-between gap-3">
        {{-- BRAND LOGO --}}
        <a class="ub-brand" href="{{ route('home') }}" aria-label="Unibox home">
            @if (setting('header_logo') && file_exists(public_path(setting('header_logo'))))
                <img src="{{ asset(setting('header_logo')) }}" alt="Unibox" width="150" height="48" style="max-height: 48px; object-fit: contain;">
            @else
                <span class="ub-brand-symbol" aria-hidden="true">u.</span><span>uni<span class="ub-brand-accent">box</span><small>IDEAS, DELIVERED.</small></span>
            @endif
        </a>

        {{-- SEARCH BAR --}}
        <div class="category-form-wrap ub-search-wrap flex-grow-1" style="max-width: 580px;">
            <form class="ub-search d-flex align-items-center" action="{{ route('search') }}" method="GET" role="search">
                <i class="fa-solid fa-magnifying-glass text-muted me-2" aria-hidden="true"></i>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="পছন্দের প্রোডাক্ট বা ব্র্যান্ড সার্চ করুন..." aria-label="Search products" autocomplete="off" class="border-0 bg-transparent flex-grow-1">
                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Search
                </button>
            </form>
            <div id="searchSuggestion" class="ub-search-results" aria-live="polite"></div>
        </div>

        {{-- HEADER ACTIONS --}}
        <div class="ub-header-actions d-flex align-items-center">
            <a class="ub-account d-flex align-items-center gap-2"
                href="{{ auth('customer')->check() ? route('account.dashboard') : route('account.login') }}">
                <i class="fa-regular fa-user fs-5 text-dark" aria-hidden="true"></i>
                <div class="d-none d-sm-block text-start leading-tight">
                    <small class="d-block text-muted" style="font-size: 11px;">{{ auth('customer')->check() ? 'My Account' : 'Welcome' }}</small>
                    <span class="fw-bold" style="font-size: 13.5px; color: #0f172a;">{{ auth('customer')->check() ? Str::limit(auth('customer')->user()->name, 12) : 'Sign In' }}</span>
                </div>
            </a>

            <button type="button" class="ub-cart-button cart-toggle" aria-label="Open shopping cart"
                aria-controls="cart-drawer" aria-expanded="false">
                <i class="fa-solid fa-bag-shopping fs-5" aria-hidden="true"></i>
                <span class="ub-cart-label d-none d-md-inline">Bag</span>
                <span id="cart-count" class="cart-item-count-render">{{ $cartCount }}</span>
            </button>

            <button type="button" class="ub-menu-toggle d-lg-none btn btn-light border rounded-circle p-2" aria-controls="store-navigation" aria-expanded="false"
                aria-label="Open navigation"><i class="fa-solid fa-bars" aria-hidden="true"></i></button>
        </div>
    </div>

    <div id="menu-overlay" hidden></div>

    {{-- NAVIGATION MENU --}}
    <nav class="ub-navigation" id="store-navigation" aria-label="Main navigation">
        <div class="ub-mobile-nav-heading d-lg-none d-flex justify-content-between align-items-center p-3 border-bottom">
            <span class="fw-bold text-dark">Explore Unibox</span>
            <button id="menu-close" type="button" class="btn btn-sm btn-light border rounded-circle" aria-label="Close navigation"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
        </div>

        <div class="container ub-nav-inner d-flex align-items-center justify-content-between">
            {{-- CATEGORY DROPDOWN --}}
            <details class="ub-category-menu position-relative">
                <summary class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-grip text-primary" aria-hidden="true"></i>
                    <span>Browse Categories</span>
                    <i class="fa-solid fa-chevron-down ms-1" style="font-size: 11px;" aria-hidden="true"></i>
                </summary>
                <div class="ub-category-dropdown position-absolute shadow-lg" style="width: 320px; z-index: 1050;">
                    <a href="{{ route('search') }}" class="d-flex align-items-center justify-content-between fw-bold border-bottom pb-2 mb-2 text-decoration-none">
                        <span><i class="fa-solid fa-border-all text-primary me-2"></i> Shop All Products</span>
                        <i class="fa-solid fa-chevron-right small text-muted" aria-hidden="true"></i>
                    </a>
                    @foreach ($categories as $category)
                        <div class="category-menu-item mb-1">
                            <div class="category-header-row d-flex align-items-center justify-content-between rounded-2 px-2 py-1.5 hover-bg-light">
                                <a href="{{ route('category.show', $category->slug) }}" class="category-title-link d-flex align-items-center flex-grow-1 text-decoration-none fw-semibold" style="font-size: 13.5px;">
                                    @if($category->image)
                                        <img src="{{ asset($category->image) }}" class="rounded me-2" style="width: 24px; height: 24px; object-fit: cover;" alt="{{ $category->name }}">
                                    @else
                                        <span class="rounded bg-light text-muted d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px; font-size: 11px;">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </span>
                                    @endif
                                    <span>{{ $category->name }}</span>
                                    @if($category->children && count($category->children) > 0)
                                        <span class="badge bg-light text-secondary border ms-auto me-1" style="font-size: 10px; font-weight: 600;">{{ count($category->children) }}</span>
                                    @endif
                                </a>
                                @if($category->children && count($category->children) > 0)
                                    <button type="button" class="category-expand-btn" aria-label="Toggle {{ $category->name }} subcategories" title="Click to view subcategories">
                                        <i class="fa-solid fa-chevron-right category-expand-arrow" style="font-size: 11px;"></i>
                                    </button>
                                @endif
                            </div>
                            @if($category->children && count($category->children) > 0)
                                <div class="category-sub-menu ps-3 pe-1 py-1" style="display: none;">
                                    @foreach($category->children as $sub)
                                        <div class="category-sub-item mb-1">
                                            <div class="d-flex align-items-center justify-content-between rounded-1 px-2 py-1 hover-bg-light">
                                                <a href="{{ route('category.show', $sub->slug) }}" class="category-sub-link d-flex align-items-center flex-grow-1 text-decoration-none">
                                                    <i class="fa-solid fa-angle-right me-1.5 text-primary opacity-75" style="font-size: 10px;"></i>
                                                    <span>{{ $sub->name }}</span>
                                                </a>
                                                @if($sub->children && count($sub->children) > 0)
                                                    <button type="button" class="category-child-expand-btn btn btn-sm p-0 border-0 text-muted ms-1" aria-label="Toggle child categories">
                                                        <i class="fa-solid fa-chevron-right child-expand-arrow" style="font-size: 9px;"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            @if($sub->children && count($sub->children) > 0)
                                                <div class="category-child-sub-menu ps-3 py-1" style="display: none;">
                                                    @foreach($sub->children as $child)
                                                        <a href="{{ route('category.show', $child->slug) }}" class="category-sub-link d-block py-1 ps-2 text-decoration-none">
                                                            • {{ $child->name }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </details>

            {{-- NAV LINKS --}}
            <div class="ub-nav-links d-flex align-items-center gap-1">
                <a href="{{ route('home') }}" @class(['is-current' => request()->routeIs('home')])>
                    <i class="fa-solid fa-house-chimney me-1 small opacity-75"></i> Home
                </a>
                <a href="{{ route('search') }}" @class(['is-current' => request()->routeIs('search')])>
                    Shop All
                </a>
                <a href="{{ route('shop.bestsellers') }}">
                    Bestsellers <span class="ub-mini-label">POPULAR</span>
                </a>
                <a href="{{ route('about.us') }}">Our Story</a>
                <a href="{{ route('contact.us') }}">Contact</a>
            </div>

            {{-- WHATSAPP / HELP LINK --}}
            <a class="ub-nav-help d-none d-lg-inline-flex align-items-center gap-2 fw-semibold text-decoration-none" 
               href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp', '01640914338')) }}" 
               target="_blank">
                <i class="fa-brands fa-whatsapp text-success fs-5" aria-hidden="true"></i> 
                <span>WhatsApp Support</span>
            </a>
        </div>
    </nav>
</header>

{{-- SLIDE-OVER SHOPPING BAG DRAWER --}}
<div id="cart-overlay" hidden></div>
<aside id="cart-drawer" role="dialog" aria-modal="true" aria-labelledby="cart-title" aria-hidden="true" inert>
    <div class="cart-header d-flex justify-content-between align-items-center p-3 border-bottom">
        <div>
            <span class="ub-eyebrow small text-uppercase text-muted" style="letter-spacing: 0.08em;">YOUR SHOPPING BAG</span>
            <h3 id="cart-title" class="fw-bold mb-0" style="font-size: 18px;">Selected Items</h3>
        </div>
        <button id="cart-close" type="button" class="btn btn-sm btn-light border rounded-circle" aria-label="Close shopping cart">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
    </div>
    <div id="cart-section" class="cart-body">
        @include('frontend.cart.partials.header-cart')
    </div>
    <div class="cart-footer p-3 border-top bg-light">
        <a class="ub-button ub-button-primary w-100 d-flex justify-content-between align-items-center py-3 px-4 rounded-pill fw-bold text-decoration-none" href="{{ route('checkout') }}">
            <span>Proceed to Checkout</span>
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
        <p class="small text-muted text-center mt-2 mb-0">
            <i class="fa-solid fa-shield-check text-success me-1"></i> Cash on Delivery available nationwide
        </p>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Topbar Category Accordion Toggle
        document.addEventListener('click', function(e) {
            // 1. Parent Category Expand/Collapse
            var parentBtn = e.target.closest('.category-expand-btn');
            if (parentBtn) {
                e.preventDefault();
                e.stopPropagation();

                var parentItem = parentBtn.closest('.category-menu-item');
                if (!parentItem) return;
                var subMenu = parentItem.querySelector(':scope > .category-sub-menu');
                if (!subMenu) return;

                var isClosed = subMenu.style.display === 'none' || subMenu.style.display === '';

                // Close other open category menus (Accordion behavior)
                var container = parentItem.parentElement;
                if (container) {
                    var openItems = container.querySelectorAll('.category-menu-item');
                    openItems.forEach(function(item) {
                        if (item !== parentItem) {
                            var otherSub = item.querySelector(':scope > .category-sub-menu');
                            var otherBtn = item.querySelector(':scope .category-expand-btn');
                            if (otherSub && otherSub.style.display !== 'none') {
                                if (window.jQuery) {
                                    $(otherSub).stop(true, true).slideUp(200);
                                } else {
                                    otherSub.style.display = 'none';
                                }
                            }
                            if (otherBtn) otherBtn.classList.remove('open');
                        }
                    });
                }

                if (isClosed) {
                    parentBtn.classList.add('open');
                    if (window.jQuery) {
                        $(subMenu).stop(true, true).slideDown(200);
                    } else {
                        subMenu.style.display = 'block';
                    }
                } else {
                    parentBtn.classList.remove('open');
                    if (window.jQuery) {
                        $(subMenu).stop(true, true).slideUp(200);
                    } else {
                        subMenu.style.display = 'none';
                    }
                }
                return;
            }

            // 2. Child Subcategory Expand/Collapse
            var childBtn = e.target.closest('.category-child-expand-btn');
            if (childBtn) {
                e.preventDefault();
                e.stopPropagation();

                var subItem = childBtn.closest('.category-sub-item');
                if (!subItem) return;
                var childSub = subItem.querySelector(':scope > .category-child-sub-menu');
                if (!childSub) return;

                var isChildClosed = childSub.style.display === 'none' || childSub.style.display === '';
                if (isChildClosed) {
                    childBtn.classList.add('open');
                    if (window.jQuery) {
                        $(childSub).stop(true, true).slideDown(180);
                    } else {
                        childSub.style.display = 'block';
                    }
                } else {
                    childBtn.classList.remove('open');
                    if (window.jQuery) {
                        $(childSub).stop(true, true).slideUp(180);
                    } else {
                        childSub.style.display = 'none';
                    }
                }
            }
        });
    });
</script>
