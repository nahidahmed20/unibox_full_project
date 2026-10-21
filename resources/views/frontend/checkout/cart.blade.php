@extends('frontend.layouts.app')
@section('title', 'Shopping Cart')

@section('content')

@php
    $cart = session('cart', []);
    $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
    $shippingRates = \App\Models\Shipping::pluck('shipping_cost', 'zone')->toArray();
    $insideDhakaCost = $shippingRates['inside_dhaka'] ?? 80;
    $nearDhakaCost = $shippingRates['near_dhaka'] ?? 100;
    $outsideDhakaCost = $shippingRates['outside_dhaka'] ?? 120;
    $selectedZone = session('shipping_zone', 'inside_dhaka');
    $shippingCost = session('shipping_cost', $shippingRates[$selectedZone] ?? $insideDhakaCost);
@endphp

<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/checkout-cart-1.css') }}?v={{ filemtime(public_path('frontend/assets/css/pages/checkout-cart-1.css')) }}">

<section class="cart-page-wrapper py-4 py-md-5">
    <div class="container">

        {{-- PAGE TITLE & BREADCRUMB --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4 pb-2 border-bottom">
            <div>
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none"><i class="fa-solid fa-house me-1"></i> Home</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Shopping Cart</li>
                    </ol>
                </nav>
                <h1 class="fw-bold text-dark mb-0 fs-3">Shopping Cart ({{ count($cart) }})</h1>
            </div>
            <div>
                <a href="{{ route('search') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold">
                    <i class="fa-solid fa-arrow-left me-1"></i> Continue Shopping
                </a>
            </div>
        </div>

        @if(!empty($cart) && count($cart) > 0)
        <div class="row g-4" id="cart-content-row">
            {{-- CART ITEMS LIST --}}
            <div class="col-lg-8">
                <div class="modern-card p-3 p-md-4">
                    <div class="table-responsive">
                        <table class="modern-cart-table">
                            <thead>
                                <tr>
                                    <th style="width: 48%;">Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-center" style="width: 50px;"></th>
                                </tr>
                            </thead>
                            <tbody id="cart-table-wrapper">
                                @include('frontend.cart.partials.cart-table', ['cart' => $cart])
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4 pt-3 border-top cart-actions">
                        <a href="{{ route('search') }}" class="btn-modern btn-outline-modern">
                            <i class="fa-solid fa-plus me-1"></i> Add More Products
                        </a>
                        <button type="button" class="btn-modern btn-outline-modern update-btn d-none">
                            <i class="fa-solid fa-rotate-right me-2"></i> Update Cart
                        </button>
                    </div>
                </div>

                {{-- TRUST BADGES --}}
                <div class="row g-3 mt-1">
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border shadow-xs">
                            <i class="fa-solid fa-truck-fast text-primary fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-0 small">দ্রুত ডেলিভারি</h6>
                                <p class="text-muted small mb-0" style="font-size: 11px;">সারা দেশে হোম ডেলিভারি</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border shadow-xs">
                            <i class="fa-solid fa-shield-halved text-success fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-0 small">১০০% অরিজিনাল</h6>
                                <p class="text-muted small mb-0" style="font-size: 11px;">প্রিমিয়াম কোয়ালিটি পণ্য</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border shadow-xs">
                            <i class="fa-solid fa-hand-holding-dollar text-warning fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-0 small">ক্যাশ অন ডেলিভারি</h6>
                                <p class="text-muted small mb-0" style="font-size: 11px;">পণ্য দেখে মূল্য পরিশোধ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ORDER SUMMARY --}}
            <div class="col-lg-4">
                <div class="modern-card p-4 position-sticky" style="top: 90px;">
                    <h4 class="summary-title mb-3 pb-2 border-bottom fw-bold fs-5 text-dark">Order Summary</h4>
                    
                    <div class="summary-row d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold text-dark currency subtotal-value">৳{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <h5 class="shipping-title fw-bold fs-6 mt-4 mb-2 text-dark">Shipping Destination</h5>
                    
                    <div class="shipping-options-list d-flex flex-column gap-2 mb-3">
                        <label class="shipping-box {{ $selectedZone == 'inside_dhaka' ? 'active-box' : '' }}" style="cursor: pointer;">
                            <input id="inside_dhaka" type="radio" name="shipping" value="inside_dhaka" {{ $selectedZone == 'inside_dhaka' ? 'checked' : '' }} class="d-none">
                            <div class="shipping-content flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="shipping-label fw-bold">Inside Dhaka</span>
                                    <span class="badge bg-light text-dark border">৳{{ number_format($insideDhakaCost, 0) }}</span>
                                </div>
                                <span class="shipping-desc text-muted small">১-২ কার্যদিবসে ডেলিভারি</span>
                            </div>
                            <i class="fa-solid fa-circle-check check-icon ms-2"></i>
                        </label>

                        <label class="shipping-box {{ $selectedZone == 'near_dhaka' ? 'active-box' : '' }}" style="cursor: pointer;">
                            <input id="near_dhaka" type="radio" name="shipping" value="near_dhaka" {{ $selectedZone == 'near_dhaka' ? 'checked' : '' }} class="d-none">
                            <div class="shipping-content flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="shipping-label fw-bold">Near Dhaka (Suburbs)</span>
                                    <span class="badge bg-light text-dark border">৳{{ number_format($nearDhakaCost, 0) }}</span>
                                </div>
                                <span class="shipping-desc text-muted small">২-৩ কার্যদিবসে ডেলিভারি</span>
                            </div>
                            <i class="fa-solid fa-circle-check check-icon ms-2"></i>
                        </label>

                        <label class="shipping-box {{ $selectedZone == 'outside_dhaka' ? 'active-box' : '' }}" style="cursor: pointer;">
                            <input id="outside_dhaka" type="radio" name="shipping" value="outside_dhaka" {{ $selectedZone == 'outside_dhaka' ? 'checked' : '' }} class="d-none">
                            <div class="shipping-content flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="shipping-label fw-bold">Outside Dhaka</span>
                                    <span class="badge bg-light text-dark border">৳{{ number_format($outsideDhakaCost, 0) }}</span>
                                </div>
                                <span class="shipping-desc text-muted small">কুরিয়ারের মাধ্যমে ৩-৪ দিন</span>
                            </div>
                            <i class="fa-solid fa-circle-check check-icon ms-2"></i>
                        </label>
                    </div>

                    <div class="summary-row d-flex justify-content-between py-2 border-top">
                        <span class="text-muted">Shipping Cost</span>
                        <span class="fw-bold text-dark currency shipping-value">৳{{ number_format($shippingCost ?? $insideDhakaCost, 2) }}</span>
                    </div>

                    <div class="summary-row total d-flex justify-content-between py-3 my-2 border-top border-bottom">
                        <span class="fw-bold fs-5 text-dark">Total</span>
                        <span class="currency total-value fw-bold fs-4" style="color: #008a7a;">৳{{ number_format($subtotal + ($shippingCost ?? $insideDhakaCost), 2) }}</span>
                    </div>

                    {{-- PROCEED TO CHECKOUT BUTTON --}}
                    @if(auth('customer')->check())
                        <a href="{{ route('cart.checkout') }}" class="btn-modern btn-primary-custom w-100 mt-3 py-3 text-center d-flex align-items-center justify-content-center gap-2 fw-bold text-decoration-none text-white shadow-sm" style="border-radius: 9999px; font-size: 16px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                            <i class="fa-solid fa-lock"></i>
                            <span>অর্ডার সম্পন্ন করুন (Checkout)</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @else
                        @php
                            session(['redirect_after_login' => route('cart.checkout')]);
                        @endphp
                        <a href="{{ route('account.login') }}" class="btn-modern btn-primary-custom w-100 mt-3 py-3 text-center d-flex align-items-center justify-content-center gap-2 fw-bold text-decoration-none text-white shadow-sm" style="border-radius: 9999px; font-size: 16px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                            <i class="fa-solid fa-user-check"></i>
                            <span>লগইন করে চেকআউট করুন</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @endif

                    <div class="text-center mt-3">
                        <span class="small text-muted" style="font-size: 12px;">
                            <i class="fa-solid fa-shield-halved text-success me-1"></i> ১০০% নিরাপদ ক্যাশ অন ডেলিভারি চেকআউট
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="modern-card p-5 text-center my-4" id="empty-cart-state">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 90px; height: 90px; border: 1px solid #e2e8f0;">
                <i class="fa-solid fa-bag-shopping" style="font-size: 38px; color: #94a3b8;"></i>
            </div>
            <h3 class="fw-bold text-dark mb-2">আপনার শপিং ব্যাগটি বর্তমানে খালি</h3>
            <p class="text-muted mb-4" style="max-width: 450px; margin: 0 auto;">আপনার পছন্দের পণ্যগুলো কার্টে যোগ করুন এবং এক ক্লিকে সহজ ডেলিভারি সুবিধা উপভোগ করুন।</p>
            <a href="{{ route('search') }}" class="btn-modern btn-primary-custom d-inline-flex align-items-center gap-2 px-4 py-3 text-white text-decoration-none shadow-sm" style="border-radius: 9999px; font-size: 15px; background: #0f172a;">
                <i class="fa-solid fa-arrow-left"></i> সকল প্রোডাক্ট দেখুন
            </a>
        </div>
        @endif

    </div>
</section>
@endsection

@push('javascript')
<script>
    function formatMoney(amount) {
        return Number(amount).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // Google Tag Manager Ecommerce Event
    window.dataLayer = window.dataLayer || [];
    function pushCartData(cart, subtotal, shipping) {
        let items = [];
        @foreach($cart as $id => $item)
            items.push({
                item_id: "{{ $id }}",
                item_name: "{{ $item['name'] }}",
                price: {{ $item['price'] }},
                quantity: {{ $item['quantity'] }}
            });
        @endforeach

        window.dataLayer.push({
            event: "view_cart",
            ecommerce: {
                currency: "BDT",
                value: subtotal + shipping,
                items: items
            }
        });
    }

    pushCartData(@json($cart), {{ $subtotal }}, {{ $shippingCost }});

    // Auto update cart quantity when +/- clicked
    let cartUpdateTimer = null;
    function triggerCartSync() {
        let quantities = {};
        $('.qty-input').each(function () {
            quantities[$(this).data('id')] = $(this).val();
        });

        $.ajax({
            url: "{{ route('cart.update') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                quantities: quantities
            },
            success: function (res) {
                if (res.status === 'success') {
                    if (res.table !== undefined) {
                        $('#cart-table-wrapper').html(res.table);
                    }
                    if (res.subtotal !== undefined) {
                        $('.subtotal-value').text('৳' + formatMoney(res.subtotal));
                    }
                    if (res.shipping !== undefined) {
                        $('.shipping-value').text('৳' + formatMoney(res.shipping));
                    }
                    if (res.cart_total !== undefined) {
                        $('.total-value').text('৳' + formatMoney(res.cart_total));
                    }
                    if (res.cart_count !== undefined) {
                        $('.cart-item-count-render').text(res.cart_count);
                    }
                    if (res.html !== undefined && document.getElementById('cart-section')) {
                        document.getElementById('cart-section').innerHTML = res.html;
                    }
                }
            },
            error: function (xhr) {
                console.log("Cart update error: ", xhr.responseText);
            }
        });
    }

    $(document).on('click', '.qty-plus', function (e) {
        e.preventDefault();
        let input = $(this).siblings('.qty-input');
        let current = parseInt(input.val()) || 1;
        input.val(current + 1);
        clearTimeout(cartUpdateTimer);
        cartUpdateTimer = setTimeout(triggerCartSync, 200);
    });

    $(document).on('click', '.qty-minus', function (e) {
        e.preventDefault();
        let input = $(this).siblings('.qty-input');
        let current = parseInt(input.val()) || 1;
        if (current > 1) {
            input.val(current - 1);
            clearTimeout(cartUpdateTimer);
            cartUpdateTimer = setTimeout(triggerCartSync, 200);
        }
    });

    // Shipping selection AJAX
    $(document).on('click', '.shipping-box', function () {
        let radio = $(this).find('input[name="shipping"]');
        let zone = radio.val();
        
        $('.shipping-box').removeClass('active-box');
        $(this).addClass('active-box');
        radio.prop('checked', true);

        $.ajax({
            url: "{{ url('/cart/update-shipping-zone') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                zone: zone
            },
            success: function (res) {
                if (res.success) {
                    $('.shipping-value').text('৳' + formatMoney(res.shipping));
                    $('.total-value').text('৳' + formatMoney(res.total));

                    window.dataLayer.push({
                        event: "cart_shipping_updated",
                        ecommerce: {
                            shipping_tier: zone,
                            value: res.total
                        }
                    });
                }
            },
            error: function (xhr) {
                console.log("Shipping AJAX Error: ", xhr.responseText);
            }
        });
    });
</script>
@endpush
