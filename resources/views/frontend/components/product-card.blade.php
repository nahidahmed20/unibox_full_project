@php
    $stock = $product->total_quantity ?? ($product->stock ?? 0);
    $price = $product instanceof \App\Models\Product ? $product->final_price : $product->selling_price;
    $mainPrice = $product->main_price ?? 0;
    $hasDiscount = $mainPrice > $price;
    $discountPercent = $hasDiscount && $mainPrice > 0 ? round((($mainPrice - $price) / $mainPrice) * 100) : 0;
@endphp
<article class="ub-product-card">
    <a class="ub-product-image" href="{{ route('product.show', $product->slug) }}" aria-label="View {{ $product->name }}">
        <img src="{{ asset($product->image ?: 'frontend/assets/img/product-placeholder.svg') }}"
            alt="{{ $product->name }}" loading="lazy" decoding="async" width="400" height="400">
        
        {{-- BADGES --}}
        @if ($stock <= 0)
            <span class="ub-product-tag ub-tag-muted">Sold out</span>
        @elseif($product->is_bestseller ?? false)
            <span class="ub-product-tag"><i class="fa-solid fa-fire me-1 text-warning"></i> Bestseller</span>
        @elseif($product->is_new ?? false)
            <span class="ub-product-tag">New arrival</span>
        @endif

        {{-- DISCOUNT BADGE --}}
        @if ($hasDiscount && $discountPercent > 0)
            <span class="ub-discount-badge">-{{ $discountPercent }}%</span>
        @endif
    </a>

    <div class="ub-product-info">
        <div>
            <span class="ub-product-category">
                {{ $product->category->name ?? ($product->brand_name ?? 'THE UNIBOX COLLECTION') }}
            </span>
            <h3>
                <a href="{{ route('product.show', $product->slug) }}" title="{{ $product->name }}">
                    {{ $product->name }}
                </a>
            </h3>
        </div>

        <div>
            <div class="ub-product-bottom">
                <div class="ub-product-price">
                    <span>৳{{ number_format($price) }}</span>
                    @if ($hasDiscount)
                        <del>৳{{ number_format($mainPrice) }}</del>
                    @endif
                </div>
                <span class="ub-stock {{ $stock <= 0 ? 'is-unavailable' : '' }}">
                    {{ $stock > 0 ? 'In stock' : 'Stock out' }}
                </span>
            </div>

            <a href="{{ route('product.show', $product->slug) }}" class="ub-card-action-btn">
                <i class="fa-solid fa-cart-shopping me-1"></i> অর্ডার করুন
            </a>
        </div>
    </div>
</article>
