@extends('frontend.layouts.app')
@section('title', 'Shopping Cart | Unibox')

@section('content')

@php
    $cart = session('cart', []);
    $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
    $shippingCost = session('shipping_cost', 0);
@endphp

<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/checkout-cart-1.css') }}">

<section class="cart-page-wrapper">
    <div class="container">

        <div class="row">
            <div class="col-lg-8">
                <div class="modern-card">
                    <div class="table-responsive">
                        <table class="modern-cart-table">
                            <thead>
                                <tr>
                                    <th style="width: 50%;">Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody id="cart-table-wrapper">
                                @include('frontend.cart.partials.cart-table', ['cart' => session('cart')])
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap cart-actions">
                        <div class="mt-4 mt-lg-0">
                            <button class="btn-modern btn-outline-modern update-btn">
                                <i class="fa-solid fa-rotate-right me-2"></i> Update Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="modern-card">
                    <h4 class="summary-title">Order Summary</h4>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span class="fw-bold text-dark currency subtotal-value">৳{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <h5 class="shipping-title">Shipping Method</h5>
                    @php
                        $selectedZone = session('shipping_zone', 'inside_dhaka');
                    @endphp
                    
                    <label class="shipping-box {{ $selectedZone == 'inside_dhaka' ? 'active-box' : '' }}">
                        <input id="inside_dhaka" type="radio" name="shipping" value="inside_dhaka" {{ $selectedZone == 'inside_dhaka' ? 'checked' : '' }}>
                        <div class="shipping-content">
                            <span class="shipping-label">Inside Dhaka</span>
                            <span class="shipping-desc">Delivery within 24-48 hours</span>
                        </div>
                        <i class="fa-solid fa-circle-check check-icon"></i>
                    </label>

                    <label class="shipping-box {{ $selectedZone == 'near_dhaka' ? 'active-box' : '' }}">
                        <input id="near_dhaka" type="radio" name="shipping" value="near_dhaka" {{ $selectedZone == 'near_dhaka' ? 'checked' : '' }}>
                        <div class="shipping-content">
                            <span class="shipping-label">Near Dhaka</span>
                            <span class="shipping-desc">Delivery within 2-3 days</span>
                        </div>
                        <i class="fa-solid fa-circle-check check-icon"></i>
                    </label>

                    <label class="shipping-box {{ $selectedZone == 'outside_dhaka' ? 'active-box' : '' }}">
                        <input id="outside_dhaka" type="radio" name="shipping" value="outside_dhaka" {{ $selectedZone == 'outside_dhaka' ? 'checked' : '' }}>
                        <div class="shipping-content">
                            <span class="shipping-label">Outside Dhaka</span>
                            <span class="shipping-desc">Delivery via courier (3-5 days)</span>
                        </div>
                        <i class="fa-solid fa-circle-check check-icon"></i>
                    </label>

                    <div class="summary-row mt-4">
                        <span>Shipping Cost</span>
                        <span class="fw-bold text-dark currency shipping-value">৳{{ number_format($shippingCost ?? 0, 2) }}</span>
                    </div>

                    <div class="summary-row total">
                        <span>Total</span>
                        <span class="currency total-value">৳{{ number_format($subtotal + $shippingCost, 2) }}</span>
                    </div>

                    @if(auth('customer')->check())
                        <a href="{{ route('cart.checkout') }}" class="btn-modern btn-primary-custom mt-4">
                            Proceed to Checkout <i class="fa-solid fa-arrow-right ms-2 mt-1"></i>
                        </a>
                    @else
                        @php
                            session(['redirect_after_login' => route('cart.checkout')]);
                        @endphp
                        
                        <a href="{{ route('account.login') }}" class="btn-modern btn-primary-custom mt-4">
                            Proceed to Checkout <i class="fa-solid fa-arrow-right ms-2 mt-1"></i>
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('javascript')
<script>
    function formatMoney(amount) {
        return Number(amount).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

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

    $(document).on('change', 'input[name="shipping"]', function () {
        let zone = $(this).val();
        
        $('.shipping-box').removeClass('active-box');
        $(this).closest('.shipping-box').addClass('active-box');

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
                } else {
                    alert(res.message || 'Could not update shipping zone.');
                }
            },
            error: function (xhr) {
                console.log("Shipping AJAX Error: ", xhr.responseText);
            }
        });
    });
</script>
@endpush
