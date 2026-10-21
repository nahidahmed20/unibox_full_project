@extends('frontend.layouts.app')
@section('title', 'Order Received')

@section('content')

@php
    $dataLayerItems = [];
    foreach($order->items as $item) {
        $variantParts = [];
        if(!empty($item->size->name)) $variantParts[] = $item->size->name;
        if(!empty($item->color->name)) $variantParts[] = $item->color->name;
        
        $itemAttributes = is_string($item->attributes) ? json_decode($item->attributes, true) : $item->attributes;
        if(!empty($itemAttributes) && is_array($itemAttributes)) {
            $variantParts[] = implode(', ', $itemAttributes);
        }
        
        $unitPrice = $item->price ?? ($item->quantity > 0 ? ($item->total / $item->quantity) : 0);

        $dataLayerItems[] = [
            'item_id' => (string) ($item->product_id ?? $item->product?->id ?? ''),
            'item_name' => $item->product_name ?? ($item->product->name ?? 'Unknown Product'),
            'price' => (float) $unitPrice,
            'quantity' => (int) $item->quantity,
            'item_variant' => implode(' - ', $variantParts)
        ];
    }
@endphp

@push('css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/checkout-success-1.css') }}">
<style>
    .success-wrapper {
        padding: 60px 0 100px 0;
        background: #f8fafc;
    }
    .success-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        overflow: hidden;
        max-width: 820px;
        margin: 0 auto;
    }
    .success-top {
        text-align: center;
        padding: 40px 30px 30px 30px;
        background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);
        border-bottom: 1px solid #edf2f7;
    }
    .success-check-badge {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin-bottom: 20px;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
    }
    .success-title {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
    }
    .order-badge {
        background: #0f172a;
        color: #ffffff;
        display: inline-block;
        padding: 6px 18px;
        border-radius: 9999px;
        font-weight: 700;
        font-size: 14px;
        margin-top: 10px;
        letter-spacing: 0.04em;
    }
    .success-details-card {
        padding: 30px;
    }
    .success-grid-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        height: 100%;
    }
    .success-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .success-item-row:last-child {
        border-bottom: none;
    }

    @media (max-width: 767px) {
        .success-wrapper {
            padding: 25px 0 60px 0;
        }
        .success-card {
            border-radius: 16px;
        }
        .success-top {
            padding: 28px 16px 20px 16px;
        }
        .success-check-badge {
            width: 58px;
            height: 58px;
            font-size: 26px;
            margin-bottom: 14px;
        }
        .success-title {
            font-size: 20px;
        }
        .order-badge {
            font-size: 13px;
            padding: 5px 14px;
        }
        .success-details-card {
            padding: 16px 14px;
        }
        .success-item-row img {
            width: 44px !important;
            height: 44px !important;
        }
        .success-item-row h6 {
            font-size: 13.5px !important;
        }
    }
</style>
@endpush

<div class="success-wrapper">
    <div class="container">
        <div class="success-card">
            
            {{-- TOP HEADER SECTION --}}
            <div class="success-top">
                <div class="success-check-badge">
                    <i class="fa-solid fa-check"></i>
                </div>
                <h2 class="success-title">অর্ডার সফলভাবে সম্পন্ন হয়েছে!</h2>
                <p class="text-muted mb-2">
                    ধন্যবাদ! আপনার অর্ডারটি সফলভাবে গ্রহণ করা হয়েছে। খুব শীঘ্রই আমাদের কাস্টমার প্রতিনিধি আপনার সাথে যোগাযোগ করবেন।
                </p>
                <div class="order-badge">
                    Order No: #{{ $order->order_number }}
                </div>
            </div>

            {{-- BODY SECTION --}}
            <div class="success-details-card">
                {{-- INFO SUMMARY ROW --}}
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-md-3">
                        <div class="success-grid-box">
                            <label class="text-muted small text-uppercase fw-bold d-block mb-1" style="font-size: 11px;">অর্ডারের তারিখ</label>
                            <span class="fw-bold text-dark">{{ $order->created_at->format('d M, Y') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="success-grid-box">
                            <label class="text-muted small text-uppercase fw-bold d-block mb-1" style="font-size: 11px;">মোট টাকা</label>
                            <span class="fw-bold text-dark fs-6">৳{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="success-grid-box">
                            <label class="text-muted small text-uppercase fw-bold d-block mb-1" style="font-size: 11px;">পেমেন্ট মেথড</label>
                            <span class="fw-bold text-success">Cash on Delivery</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="success-grid-box">
                            <label class="text-muted small text-uppercase fw-bold d-block mb-1" style="font-size: 11px;">অর্ডার স্ট্যাটাস</label>
                            <span class="badge bg-warning-subtle text-warning-emphasis px-2 py-1 rounded-pill fw-bold">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- CUSTOMER & SHIPPING INFO --}}
                <div class="p-3 bg-light rounded-4 mb-4 border">
                    <h5 class="fw-bold text-dark mb-2" style="font-size: 15px;">
                        <i class="fa-solid fa-location-dot text-danger me-2"></i> ডেলিভারি ও কাস্টমার তথ্য
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <span class="text-muted small d-block">প্রাপকের নাম ও ফোন:</span>
                            <strong class="text-dark">{{ $order->name ?? $order->full_name }}</strong> &bull; <span class="text-dark">{{ $order->phone }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted small d-block">ডেলিভারি ঠিকানা:</span>
                            <span class="text-dark">{{ $order->address }}</span>
                        </div>
                    </div>
                </div>

                {{-- ITEMS PURCHASED --}}
                <div class="border rounded-4 p-3 mb-4">
                    <h5 class="fw-bold text-dark mb-3" style="font-size: 15px;">
                        <i class="fa-solid fa-bag-shopping text-primary me-2"></i> অর্ডারের পণ্যসমূহ
                    </h5>

                    @foreach($order->items as $item)
                        @php
                            $itemImage = $item->product?->image ?? $item->image ?? 'frontend/assets/img/product-placeholder.svg';
                            $itemPrice = $item->price ?? ($item->quantity > 0 ? ($item->total / $item->quantity) : 0);
                        @endphp
                        <div class="success-item-row">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset($itemImage) }}" class="rounded-3 border" style="width: 54px; height: 54px; object-fit: cover;">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 14.5px;">
                                        {{ $item->product_name ?? ($item->product->name ?? 'Product') }}
                                    </h6>
                                    <small class="text-muted">
                                        Qty: <strong>{{ $item->quantity }}</strong>
                                        @if(!empty($item->size->name)) | Size: {{ $item->size->name }} @endif
                                        @if(!empty($item->color->name)) | Color: {{ $item->color->name }} @endif
                                    </small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-dark">৳{{ number_format($item->total, 2) }}</span>
                                <small class="text-muted d-block" style="font-size: 12px;">৳{{ number_format($itemPrice, 2) }} each</small>
                            </div>
                        </div>
                    @endforeach

                    {{-- TOTALS BREAKDOWN --}}
                    <div class="border-top pt-3 mt-2">
                        <div class="d-flex justify-content-between text-muted mb-1 small">
                            <span>Subtotal:</span>
                            <span class="fw-semibold text-dark">৳{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-1 small">
                            <span>Shipping / Delivery:</span>
                            <span class="fw-semibold text-dark">৳{{ number_format($order->shipping, 2) }}</span>
                        </div>
                        @if(($order->discount ?? 0) > 0)
                        <div class="d-flex justify-content-between text-success mb-1 small">
                            <span>Discount:</span>
                            <span class="fw-semibold">-৳{{ number_format($order->discount, 2) }}</span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between fw-bold text-dark fs-5 border-top pt-2 mt-2">
                            <span>Total Amount:</span>
                            <span class="text-primary">৳{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">
                        <i class="fa-solid fa-arrow-left me-1"></i> Continue Shopping
                    </a>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light border rounded-pill px-3 fw-semibold" onclick="window.print();">
                            <i class="fa-solid fa-print me-1"></i> Print Invoice
                        </button>
                        <a href="{{ route('track.order', ['order_id' => $order->order_number, 'phone' => $order->phone]) }}" class="btn btn-dark rounded-pill px-4 fw-bold">
                            <i class="fa-solid fa-truck-fast me-1"></i> Track Order
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('javascript')
    {{-- DATA LAYER PURCHASE EVENT --}}
    <script>
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: "purchase",
            ecommerce: {
                transaction_id: "{{ $order->order_number }}",
                value: {{ (float) $order->total }},
                shipping: {{ (float) $order->shipping }},
                currency: "BDT",
                items: @json($dataLayerItems)
            }
        });
    </script>
@endpush