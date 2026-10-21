@php
    $subtotal = 0;
@endphp

@if($cart && count($cart) > 0)
    @foreach($cart as $id => $item)
        @php
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
        @endphp
        <tr class="cart-row-item align-middle" data-id="{{ $id }}">
            <td class="cart-td-product py-3">
                <div class="cart-product-info d-flex align-items-center gap-3">
                    <div class="cart-img-wrap flex-shrink-0">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" loading="lazy" class="rounded-3 border" style="width: 70px; height: 70px; object-fit: cover;">
                    </div>
                    <div class="cart-product-meta flex-grow-1">
                        <h4 class="cart-product-title fw-bold text-dark mb-1" style="font-size: 15px; line-height: 1.4;">{{ $item['name'] }}</h4>
                        
                        {{-- Color & Size --}}
                        @if(!empty($item['color']) || !empty($item['size']))
                            <div class="d-flex gap-2 flex-wrap mb-1">
                                @if(!empty($item['color'])) 
                                    <span class="var-badge badge bg-light text-dark border fw-medium" style="font-size: 11px;">Color: {{ $item['color'] }}</span> 
                                @endif
                                @if(!empty($item['size'])) 
                                    <span class="var-badge badge bg-light text-dark border fw-medium" style="font-size: 11px;">Size: {{ $item['size'] }}</span> 
                                @endif
                            </div>
                        @endif

                        {{-- Custom Attributes & Dimensions --}}
                        @if(!empty($item['attributes']))
                            <div class="d-flex gap-1 flex-wrap mt-1">
                                @foreach($item['attributes'] as $attrValue)
                                    <span class="var-badge badge text-primary fw-normal border" style="background: #eff6ff; font-size: 11px;">
                                        {{ $attrValue }}
                                    </span> 
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </td>

            <td class="text-center fw-semibold text-muted currency cart-td-price" style="font-size: 15px;">
                ৳{{ number_format($item['price'], 2) }}
            </td>

            <td class="text-center cart-td-qty">
                <div class="luxury-qty-stepper d-inline-flex align-items-center">
                    <button type="button" class="stepper-btn qty-minus" data-id="{{ $id }}" aria-label="Decrease quantity">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <input type="number" class="qty-input" data-id="{{ $id }}"
                           name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" max="99" readonly>
                    <button type="button" class="stepper-btn qty-plus" data-id="{{ $id }}" aria-label="Increase quantity">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </td>

            <td class="text-end fw-bold currency line-total cart-td-total" style="color: #008a7a; font-size: 16px;">
                ৳{{ number_format($itemTotal, 2) }}
            </td>

            <td class="text-center cart-td-action">
                <button type="button" class="btn-remove remove-item" data-id="{{ $id }}" title="Remove item" aria-label="Remove item">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="5" class="text-center py-5">
            <div class="py-4 text-center">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 80px; height: 80px; border: 1px solid #e2e8f0;">
                    <i class="fa-solid fa-cart-arrow-down" style="font-size: 32px; color: #94a3b8;"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">আপনার শপিং ব্যাগটি খালি</h5>
                <p class="text-muted small mb-3">আপনার পছন্দের প্রোডাক্টগুলো যুক্ত করুন এবং দ্রুত অর্ডার সম্পন্ন করুন।</p>
                <a href="{{ route('search') }}" class="btn-modern btn-primary-custom d-inline-flex align-items-center gap-2 px-4 py-2" style="border-radius: 9999px;">
                    <i class="fa-solid fa-arrow-left"></i> কেনাকাটা শুরু করুন
                </a>
            </div>
        </td>
    </tr>
@endif
