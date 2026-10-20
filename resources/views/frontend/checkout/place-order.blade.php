@extends('frontend.layouts.app')
@section('uses-select2', '1')
@section('title', 'Checkout | Place Order')

@section('content')
@if($errors->any())
    <div class="container pt-3">
        <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
@if(session('error'))
    <div class="container pt-3">
        <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@push('css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/checkout-place-order-1.css') }}">
<style>
    .checkout-section {
        background-color: #f8fafc;
        padding: 50px 0 90px 0;
    }
    .checkout-card {
        background: #ffffff;
        padding: 35px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        margin-bottom: 25px;
    }
    .form-header {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-header i {
        color: #2563eb;
    }
    .modern-input {
        width: 100%;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 14.5px;
        color: #0f172a;
        transition: all 0.25s ease;
        outline: none;
    }
    .modern-input:focus {
        border-color: #0f172a;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
    }
    .address-type-box {
        display: flex;
        gap: 12px;
    }
    .radio-card {
        flex: 1;
        position: relative;
    }
    .radio-card input {
        position: absolute;
        opacity: 0;
    }
    .radio-card label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 16px;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        margin: 0;
        color: #334155;
    }
    .radio-card input:checked + label {
        border-color: #0f172a;
        background: #0f172a;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
    }
    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .order-item:last-child {
        border-bottom: none;
    }
    .order-img img {
        width: 52px;
        height: 52px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .totals-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        font-size: 14.5px;
        color: #475569;
    }
    .totals-row.grand-total {
        border-top: 2px dashed #e2e8f0;
        margin-top: 10px;
        padding-top: 14px;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }
    .payment-option-wrap {
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        padding: 16px;
        margin-top: 20px;
    }
    .order-btn {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
        border-radius: 9999px !important;
        padding: 16px 30px !important;
        font-weight: 800 !important;
        font-size: 16px !important;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.2) !important;
        transition: all 0.25s ease !important;
        width: 100%;
        border: none;
        margin-top: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .order-btn:hover {
        background: #334155 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.28) !important;
    }
</style>
@endpush

@php
    $cart = session('cart', []);
    $shippingCost = session('shipping_cost', 0);

    $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
    $total = $subtotal + $shippingCost;

    $dataLayerItems = [];
    foreach($cart as $item) {
        $variantParts = [];
        if(!empty($item['size'])) $variantParts[] = $item['size'];
        if(!empty($item['color'])) $variantParts[] = $item['color'];
        
        if(!empty($item['attributes']) && is_array($item['attributes'])) {
            $variantParts[] = implode(', ', $item['attributes']);
        }
        
        $dataLayerItems[] = [
            'item_id' => $item['product_id'] ?? '',
            'item_name' => $item['name'] ?? '',
            'price' => (float) ($item['price'] ?? 0),
            'quantity' => (int) ($item['quantity'] ?? 1),
            'item_variant' => implode(' - ', $variantParts)
        ];
    }
@endphp

<section class="checkout-section">
    <div class="container">
        <form method="POST" action="{{ route('checkout.placeOrder') }}" id="mainCheckoutForm">
            @csrf
            <div class="row g-4">
                
                {{-- LEFT SIDE - BILLING & DELIVERY DETAILS --}}
                <div class="col-lg-7 col-md-12">
                    <div class="checkout-card">
                        <h3 class="form-header">
                            <i class="fa-solid fa-location-dot"></i> Billing & Delivery Details
                        </h3>
                        
                        <div class="row">
                            {{-- FULL NAME --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold text-dark">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" 
                                    value="{{ old('name', auth('customer')->user()?->name ?? '') }}" 
                                    class="modern-input" placeholder="আপনার সম্পূর্ণ নাম লিখুন" required>
                                @error('name') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            {{-- PHONE NUMBER --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold text-dark">Mobile Phone Number <span class="text-danger">*</span></label>
                                <input type="text" id="phone" name="phone" 
                                    value="{{ old('phone', auth('customer')->user()?->phone ?? '') }}" 
                                    class="modern-input" placeholder="01XXXXXXXXX" required>
                                @error('phone') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            {{-- ADDRESS TYPE --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold text-dark">Address Type</label>
                                <div class="address-type-box">
                                    <div class="radio-card">
                                        <input class="address-type-radio" type="radio" name="address_type" id="home_address" value="home" checked>
                                        <label for="home_address"><i class="fa-solid fa-house"></i> Home Delivery</label>
                                    </div>
                                    <div class="radio-card">
                                        <input class="address-type-radio" type="radio" name="address_type" id="office_address" value="office">
                                        <label for="office_address"><i class="fa-solid fa-briefcase"></i> Office Delivery</label>
                                    </div>
                                </div>
                            </div>

                            {{-- FULL ADDRESS --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold text-dark">Delivery Address <span class="text-danger">*</span></label>
                                <input type="text" id="address" name="address" 
                                    value="{{ old('address', auth('customer')->user()?->address ?? '') }}" 
                                    class="modern-input" placeholder="বাসা/হোল্ডিং নম্বর, রোড, এলাকা, জেলা" required>
                                @error('address') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            {{-- LOCATION SELECTORS --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-dark">Division</label>
                                <select name="division_id" id="division" class="modern-input select2-location">
                                    <option value="">Select Division</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}" {{ auth('customer')->user()?->division_id == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-dark">District</label>
                                <select name="district_id" id="district" class="modern-input select2-location">
                                    <option value="">Select District</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-dark">Upazila / Thana</label>
                                <select name="upazila_id" id="upazila" class="modern-input select2-location">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>

                            {{-- ORDER NOTES --}}
                            <div class="col-md-12 mb-2">
                                <label class="form-label fw-bold text-dark">Order Notes (Optional)</label>
                                <textarea id="message" name="message" rows="2" class="modern-input" placeholder="ডেলিভারি সম্পর্কিত বিশেষ কোনো নির্দেশনা থাকলে এখানে লিখুন...">{{ old('message') }}</textarea>
                                @error('message') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT SIDE - ORDER SUMMARY & CONFIRMATION --}}
                <div class="col-lg-5 col-md-12">
                    <div class="checkout-card">
                        <h3 class="form-header">
                            <i class="fa-solid fa-bag-shopping"></i> Order Summary
                        </h3>
                        
                        <div class="order-summary-wrapper">
                            @forelse($cart as $item)
                                <div class="order-item">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="order-img">
                                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">{{ Str::limit($item['name'], 28) }}</h6>
                                            <small class="text-muted d-block" style="font-size: 12px;">
                                                Qty: <strong>{{ $item['quantity'] }}</strong> 
                                                @if(!empty($item['size'])) | Size: {{ $item['size'] }} @endif
                                                @if(!empty($item['color'])) | Color: {{ $item['color'] }} @endif
                                                
                                                @if(!empty($item['attributes']) && is_array($item['attributes'])) 
                                                    <br><span class="text-primary fw-semibold">Spec: {{ implode(', ', $item['attributes']) }}</span> 
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    <span class="fw-bold text-dark" style="font-size: 14.5px;">৳{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-muted mb-0">Your shopping bag is empty</p>
                                </div>
                            @endforelse
                        </div>

                        {{-- COUPON VOUCHER INPUT BOX --}}
                        <div class="coupon-box mt-3 mb-2">
                            @if(!empty($appliedCoupon))
                                <div class="p-2 d-flex justify-content-between align-items-center rounded-3" style="background: #ecfdf5; border: 1px dashed #10b981;">
                                    <div>
                                        <span class="badge bg-success" style="letter-spacing: 1px;">{{ $appliedCoupon['code'] }}</span>
                                        <small class="text-success ms-1 fw-bold">-৳{{ number_format($discount ?? $appliedCoupon['discount'], 2) }} OFF</small>
                                    </div>
                                    <button type="submit" form="removeCouponForm" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 11px;">Remove</button>
                                </div>
                            @else
                                <div class="input-group">
                                    <input type="text" name="coupon_code" form="applyCouponForm" class="form-control form-control-sm text-uppercase rounded-start-pill ps-3" placeholder="কুপন কোড (যেমন: EID50)" required>
                                    <button type="submit" form="applyCouponForm" class="btn btn-dark btn-sm px-3 rounded-end-pill" style="font-size: 12px; font-weight: 700;">Apply</button>
                                </div>
                            @endif
                        </div>

                        {{-- TOTALS CALCULATION --}}
                        <div class="mt-3">
                            <div class="totals-row">
                                <span>Subtotal</span>
                                <span class="fw-bold text-dark">৳{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="totals-row">
                                <span>Shipping / Delivery</span>
                                <span class="fw-bold text-dark">
                                    @if($shippingCost == 0)
                                        <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill">FREE</span>
                                    @else
                                        ৳{{ number_format($shippingCost, 2) }}
                                    @endif
                                </span>
                            </div>
                            @if(!empty($discount) && $discount > 0)
                            <div class="totals-row text-success">
                                <span>Coupon Discount ({{ $appliedCoupon['code'] ?? '' }})</span>
                                <span class="fw-bold">-৳{{ number_format($discount, 2) }}</span>
                            </div>
                            @endif
                            <div class="totals-row grand-total">
                                <span>Total Payable</span>
                                <span class="text-primary">৳{{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        {{-- PAYMENT METHOD --}}
                        <div class="payment-option-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <input type="radio" name="payment_method" value="cod" id="cod" checked style="width: 18px; height: 18px; accent-color: #0f172a;">
                                <label for="cod" class="fw-bold text-dark mb-0" style="cursor: pointer;">
                                    <i class="fa-solid fa-hand-holding-dollar text-success me-1"></i> Cash On Delivery (COD)
                                </label>
                            </div>
                            <small class="text-muted mt-1 d-block ps-4">
                                পণ্য হাতে পেয়ে ডেলিভারিম্যানকে মূল্য পরিশোধ করুন। সম্পূর্ণ নিশ্চিন্ত কেনাকাটা।
                            </small>
                        </div>

                        {{-- TERMS & CONDITIONS --}}
                        <div class="terms-condition-wrap mt-3">
                            <div class="d-flex align-items-start gap-2">
                                <input type="checkbox" name="terms_agreed" id="terms" required style="margin-top: 4px; width: 16px; height: 16px; accent-color: #0f172a; cursor: pointer;">
                                <label for="terms" class="small text-muted mb-0" style="cursor: pointer;">
                                    আমি ওয়েবসাইটের <a href="{{ route('terms.conditions') }}" target="_blank" class="text-dark fw-bold text-decoration-underline">শর্তাবলী ও নিয়মাবলী</a> পড়ে সম্মতি জানাচ্ছি। <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>

                        {{-- PLACE ORDER BUTTON --}}
                        <button type="submit" class="order-btn" id="btnPlaceOrder">
                            <span>অর্ডার কনফার্ম করুন (Place Order)</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        <small class="text-center d-block text-muted mt-2">
                            <i class="fa-solid fa-lock text-success me-1"></i> 256-Bit SSL Encrypted & Secure Checkout
                        </small>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>

{{-- AUXILIARY COUPON ACTION FORMS --}}
<form id="applyCouponForm" action="{{ route('coupon.apply') }}" method="POST" class="d-none">
    @csrf
</form>
<form id="removeCouponForm" action="{{ route('coupon.remove') }}" method="POST" class="d-none">
    @csrf
</form>

@endsection

@push('javascript')
    {{-- DATA LAYER INTEGRATION --}}
    <script>
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: "begin_checkout",
            ecommerce: {
                currency: "BDT",
                value: {{ (float) $total }},
                items: @json($dataLayerItems)
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            
            // ADDRESS TYPE TOGGLE LOGIC
            let isCustomer = {{ auth('customer')->check() ? 'true' : 'false' }};
            let savedHome = "{!! addslashes(auth('customer')->user()?->address ?? '') !!}";
            let savedOffice = "{!! addslashes(auth('customer')->user()?->office_address ?? '') !!}";

            $('.address-type-radio').on('change', function() {
                let type = $(this).val();

                if(isCustomer) {
                    if(type === 'home') {
                        $('#address').val(savedHome);
                    } else {
                        $('#address').val(savedOffice);
                    }
                }
                
                if(type === 'home') {
                    $('#address').attr('placeholder', 'বাসা/হোল্ডিং নম্বর, রোড, এলাকা, জেলা');
                } else {
                    $('#address').attr('placeholder', 'অফিসের নাম, ফ্লোর, রোড, এলাকা, জেলা');
                }
            });

            // LOCATION SELECT LOGIC
            $('.select2-location').select2({
                width: '100%'
            });

            let selectedDivision = "{{ auth('customer')->user()?->division_id }}";
            let selectedDistrict = "{{ auth('customer')->user()?->district_id }}";
            let selectedUpazila = "{{ auth('customer')->user()?->upazila_id }}";

            $('#division').on('change', function () {
                let division_id = $(this).val();

                $('#district').html('<option value="">Loading...</option>').trigger('change');
                $('#upazila').html('<option value="">Select Upazila</option>').trigger('change');

                if (!division_id) return;

                $.ajax({
                    url: '/get-districts/' + division_id,
                    type: 'GET',
                    success: function (data) {
                        let html = '<option value="">Select District</option>';
                        $.each(data, function (key, value) {
                            html += `<option value="${value.id}">${value.name}</option>`;
                        });
                        $('#district').html(html).trigger('change.select2');
                    }
                });
            });

            $('#district').on('change', function () {
                let district_id = $(this).val();

                $('#upazila').html('<option value="">Loading...</option>').trigger('change');

                if (!district_id) return;

                $.ajax({
                    url: '/get-upazilas/' + district_id,
                    type: 'GET',
                    success: function (data) {
                        let html = '<option value="">Select Upazila</option>';
                        $.each(data, function (key, value) {
                            html += `<option value="${value.id}">${value.name}</option>`;
                        });
                        $('#upazila').html(html).trigger('change.select2');
                    }
                });
            });

            // AUTO LOAD USER DATA
            if (selectedDivision) {
                $('#division').val(selectedDivision).trigger('change');

                $.ajax({
                    url: '/get-districts/' + selectedDivision,
                    type: 'GET',
                    success: function (data) {
                        let html = '<option value="">Select District</option>';
                        $.each(data, function (key, value) {
                            let selected = (value.id == selectedDistrict) ? 'selected' : '';
                            html += `<option value="${value.id}" ${selected}>${value.name}</option>`;
                        });
                        $('#district').html(html).trigger('change.select2');
                        
                        if (selectedDistrict) {
                            $.ajax({
                                url: '/get-upazilas/' + selectedDistrict,
                                type: 'GET',
                                success: function (data) {
                                    let html = '<option value="">Select Upazila</option>';
                                    $.each(data, function (key, value) {
                                        let selected = (value.id == selectedUpazila) ? 'selected' : '';
                                        html += `<option value="${value.id}" ${selected}>${value.name}</option>`;
                                    });
                                    $('#upazila').html(html).trigger('change.select2');
                                }
                            });
                        }
                    }
                });
            }

            // Prevent double submits
            $('#mainCheckoutForm').on('submit', function() {
                $('#btnPlaceOrder').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> অর্ডার প্রসেস হচ্ছে...');
            });
        });
    </script>
@endpush
