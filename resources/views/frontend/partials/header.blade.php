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
        <?php
            $headerLogo = setting('header_logo', setting('logo'));
            $brandName = setting('website_title') ?: setting('company_name', 'Unibox');
            $brandTagline = setting('website_tagline', 'IDEAS, DELIVERED.');
            $brandInitial = strtoupper(substr($brandName, 0, 1));
        ?>
        <a class="ub-brand" href="{{ route('home') }}" aria-label="{{ $brandName }} home">
            @if ($headerLogo && file_exists(public_path($headerLogo)))
                <img src="{{ asset($headerLogo) }}" alt="{{ $brandName }}" width="150" height="48" style="max-height: 48px; object-fit: contain;">
            @else
                <span class="ub-brand-symbol" aria-hidden="true">{{ $brandInitial }}.</span><span>{{ $brandName }}<small>{{ $brandTagline }}</small></span>
            @endif
        </a>

        {{-- SEARCH BAR --}}
        <div class="ub-search-wrap flex-grow-1" style="max-width: 580px;">
            <form class="ub-search d-flex align-items-center" action="{{ route('search') }}" method="GET" role="search">
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="পছন্দের প্রোডাক্ট বা ব্র্যান্ড সার্চ করুন..." aria-label="Search products" autocomplete="off" class="ub-search-input border-0 bg-transparent flex-grow-1">
                <button type="submit" class="ub-search-btn" aria-label="Search">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline">Search</span>
                </button>
            </form>
            <div id="searchSuggestion" class="ub-search-results" aria-live="polite"></div>
        </div>

        {{-- HEADER ACTIONS --}}
        <div class="ub-header-actions d-flex align-items-center">
            <a class="ub-account"
                href="{{ auth('customer')->check() ? route('account.dashboard') : route('account.login') }}"
                aria-label="{{ auth('customer')->check() ? 'My Account' : 'Sign In' }}">
                <i class="fa-regular fa-user" aria-hidden="true"></i>
                <div class="ub-account-text d-none d-sm-flex">
                    <small>{{ auth('customer')->check() ? 'My Account' : 'Welcome' }}</small>
                    <span>{{ auth('customer')->check() ? Str::limit(auth('customer')->user()->name, 12) : 'Sign In' }}</span>
                </div>
            </a>

            <button type="button" class="ub-cart-button cart-toggle" aria-label="Open shopping cart"
                aria-controls="cart-drawer" aria-expanded="false">
                <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
                <span id="cart-count" class="cart-item-count-render">{{ $cartCount }}</span>
            </button>

            <button type="button" class="ub-menu-toggle d-lg-none" aria-controls="store-navigation" aria-expanded="false"
                aria-label="Open navigation"><i class="fa-solid fa-bars" aria-hidden="true"></i></button>
        </div>
    </div>

    <div id="menu-overlay" hidden></div>

    {{-- NAVIGATION MENU --}}
    <nav class="ub-navigation" id="store-navigation" aria-label="Main navigation">
        <div class="ub-mobile-nav-heading p-3 border-bottom">
            <span class="fw-bold text-dark">Explore {{ $brandName }}</span>
            <button id="menu-close" type="button" class="btn btn-sm btn-light border rounded-circle" aria-label="Close navigation"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
        </div>

        <div class="container ub-nav-inner">
            {{-- CATEGORY DROPDOWN --}}
            <details class="ub-category-menu">
                <summary class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-grip text-primary" aria-hidden="true"></i>
                    <span>Browse Categories</span>
                    <i class="fa-solid fa-chevron-down ms-1" style="font-size: 11px;" aria-hidden="true"></i>
                </summary>
                <div class="ub-category-dropdown">
                    <a href="{{ route('search') }}" class="ub-category-header-banner">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-shapes text-primary"></i>
                            <span>Shop All Products</span>
                        </span>
                        <i class="fa-solid fa-arrow-right action-arrow"></i>
                    </a>
                    @foreach ($categories as $category)
                        <div class="category-menu-item">
                            <div class="category-header-row">
                                <a href="{{ route('category.show', $category->slug) }}" class="category-title-link">
                                    @if($category->image)
                                        <img src="{{ asset($category->image) }}" class="category-avatar" alt="{{ $category->name }}">
                                    @else
                                        <span class="category-avatar-placeholder">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </span>
                                    @endif
                                    <span>{{ $category->name }}</span>
                                    @if($category->children && count($category->children) > 0)
                                        <span class="category-count-badge">{{ count($category->children) }}</span>
                                    @endif
                                </a>
                                @if($category->children && count($category->children) > 0)
                                    <button type="button" class="category-expand-btn" aria-label="Toggle {{ $category->name }} subcategories" title="Click to open or close subcategories">
                                        <i class="fa-solid fa-chevron-right category-expand-arrow"></i>
                                    </button>
                                @endif
                            </div>
                            @if($category->children && count($category->children) > 0)
                                <div class="category-sub-menu" style="display: none;">
                                    @foreach($category->children as $sub)
                                        <div class="category-sub-item">
                                            <div class="category-sub-row">
                                                <a href="{{ route('category.show', $sub->slug) }}" class="category-sub-link">
                                                    <i class="fa-solid fa-chevron-right" style="font-size: 8px; color: #2563eb; opacity: 0.7;"></i>
                                                    <span>{{ $sub->name }}</span>
                                                </a>
                                                @if($sub->children && count($sub->children) > 0)
                                                    <button type="button" class="category-child-expand-btn" aria-label="Toggle {{ $sub->name }} child categories">
                                                        <i class="fa-solid fa-chevron-right child-expand-arrow"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            @if($sub->children && count($sub->children) > 0)
                                                <div class="category-child-sub-menu" style="display: none;">
                                                    @foreach($sub->children as $child)
                                                        <a href="{{ route('category.show', $child->slug) }}" class="category-chip-link">
                                                            {{ $child->name }}
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
            <div class="ub-nav-links">
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

            {{-- WHATSAPP / HELP LINK (DESKTOP) --}}
            <a class="ub-nav-help d-none d-lg-inline-flex align-items-center gap-2 fw-semibold text-decoration-none"
               href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp', '01640914338')) }}"
               target="_blank">
                <i class="fa-brands fa-whatsapp text-success fs-5" aria-hidden="true"></i>
                <span>WhatsApp Support</span>
            </a>

            {{-- WHATSAPP / HELP LINK (MOBILE) --}}
            <a class="ub-nav-help-mobile d-lg-none d-flex align-items-center justify-content-center gap-2 fw-semibold text-decoration-none mt-3 p-2.5 rounded-3"
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
        <a class="ub-button ub-button-primary w-100 d-flex justify-content-center align-items-center py-3 px-4 rounded-pill fw-bold text-decoration-none" href="{{ route('checkout') }}">
            <span>Proceed to Checkout</span>
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
        <p class="small text-muted text-center mt-2 mb-0">
            <i class="fa-solid fa-shield-halved text-success me-1"></i> Cash on Delivery available nationwide
        </p>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Category & Subcategory Accordion Toggle (Vanilla JS - 100% Reliable & Reversible)
        document.addEventListener('click', function(e) {
            // 1. Parent Category Toggle
            var expandBtn = e.target.closest('.category-expand-btn');
            if (expandBtn) {
                e.preventDefault();
                e.stopPropagation();

                var parentItem = expandBtn.closest('.category-menu-item');
                if (!parentItem) return;
                var subMenu = parentItem.querySelector('.category-sub-menu');
                if (!subMenu) return;

                var isOpen = parentItem.classList.contains('is-open');

                if (isOpen) {
                    // CLOSE THIS ONE
                    parentItem.classList.remove('is-open');
                    expandBtn.classList.remove('open');
                    subMenu.style.display = 'none';
                } else {
                    // CLOSE ALL OTHER OPEN MENUS IN THE DROPDOWN
                    var container = parentItem.parentElement;
                    if (container) {
                        var openItems = container.querySelectorAll('.category-menu-item.is-open');
                        openItems.forEach(function(item) {
                            if (item !== parentItem) {
                                item.classList.remove('is-open');
                                var otherSub = item.querySelector('.category-sub-menu');
                                if (otherSub) otherSub.style.display = 'none';
                                var otherBtn = item.querySelector('.category-expand-btn');
                                if (otherBtn) otherBtn.classList.remove('open');
                            }
                        });
                    }

                    // OPEN THIS ONE
                    parentItem.classList.add('is-open');
                    expandBtn.classList.add('open');
                    subMenu.style.display = 'block';
                }
                return;
            }

            // 2. Child Subcategory Toggle
            var childBtn = e.target.closest('.category-child-expand-btn');
            if (childBtn) {
                e.preventDefault();
                e.stopPropagation();

                var subItem = childBtn.closest('.category-sub-item');
                if (!subItem) return;
                var childSub = subItem.querySelector('.category-child-sub-menu');
                if (!childSub) return;

                var isChildOpen = subItem.classList.contains('is-open');
                if (isChildOpen) {
                    // CLOSE CHILD
                    subItem.classList.remove('is-open');
                    childBtn.classList.remove('open');
                    childSub.style.display = 'none';
                } else {
                    // OPEN CHILD
                    subItem.classList.add('is-open');
                    childBtn.classList.add('open');
                    childSub.style.display = 'flex';
                }
            }
        });
    });
</script>
