@extends('frontend.layouts.app')
@section('title', 'Order Success | Unibox')

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

<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/checkout-success-1.css') }}">

<div class="success-wrapper">
    <div class="container">
        <div class="success-card">
            
            {{-- TOP SECTION --}}
            <div class="success-top">
                <div class="success-check">
                    <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2>অর্ডার সফলভাবে সম্পন্ন হয়েছে</h2>
                <p>ধন্যবাদ! আপনার অর্ডারটি সফলভাবে করা হয়েছে। খুব শীঘ্রই আমাদের টিম আপনার সাথে যোগাযোগ করবে।</p>
                <div class="order-number-badge">
                    Order No: <strong>{{ $order->order_number }}</strong>
                </div>
            </div>

            {{-- BODY SECTION --}}
            <div class="success-body">
                
                {{-- INFO GRID --}}
                <div class="info-grid">
                    <div class="info-box">
                        <label>Date</label>
                        <span>{{ $order->created_at->format('d M, Y') }}</span>
                    </div>
                    <div class="info-box">
                        <label>Total Amount</label>
                        <span>৳{{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="info-box">
                        <label>Payment Method</label>
                        <span>{{ strtolower($order->payment_method) == 'cod' ? 'Cash on Delivery' : 'Online Payment' }}</span>
                    </div>
                    <div class="info-box">
                        <label>Order Status</label>
                        <span style="color: #f59e0b;">● {{ ucfirst($order->status) }}</span>
                    </div>
                </div>

                {{-- ORDER ITEMS --}}
                <h4 class="section-title">Order Items</h4>
                <div class="product-list">
                    @foreach($order->items as $item)
                        <div class="product-item">
                            <div class="product-info-wrapper">
                                <img src="{{ asset($item->product->image ?? 'default.png') }}" class="product-img" alt="Product">
                                <div>
                                    <div class="product-name">{{ $item->product_name ?? ($item->product->name ?? 'Unknown Product') }}</div>
                                    <div>
                                        @if(!empty($item->color->name))
                                            <span class="variation-tag">Color: {{ $item->color->name }}</span>
                                        @endif
                                        @if(!empty($item->size->name))
                                            <span class="variation-tag">Size: {{ $item->size->name }}</span>
                                        @endif
                                        
                                        @php
                                            $itemAttributes = is_string($item->attributes) ? json_decode($item->attributes, true) : $item->attributes;
                                        @endphp
                                        @if(!empty($itemAttributes) && is_array($itemAttributes))
                                            @foreach($itemAttributes as $attr)
                                                <span class="variation-tag">{{ $attr }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="product-price-wrapper">
                                <div class="product-qty">Qty: {{ $item->quantity }}</div>
                                <div class="product-price">৳{{ number_format($item->total, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- SUMMARY --}}
                <div class="summary-card">
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span>৳{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping Cost</span>
                        <span>৳{{ number_format($order->shipping, 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Payment Status</span>
                        <span>{{ ucfirst($order->payment_status) }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Grand Total</span>
                        <span>৳{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="success-actions">
                    <a href="{{ url('/') }}" class="success-btn btn-primary-custom">
                        <i class="fa-solid fa-cart-shopping"></i> Continue Shopping
                    </a>
                    <a href="{{ url('/shop') }}" class="success-btn btn-outline-custom">
                        Explore More Products
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('javascript')
    <script>
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: "purchase",
            ecommerce: {
                transaction_id: "{{ $order->order_number }}",
                value: {{ (float) $order->total }},
                tax: 0.00,
                shipping: {{ (float) ($order->shipping ?? 0) }},
                currency: "BDT",
                items: @json($dataLayerItems)
            }
        });
    </script>
@endpush