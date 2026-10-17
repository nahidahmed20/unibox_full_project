@php
    $stock = $product->total_quantity ?? ($product->stock ?? 0);
    $price = $product instanceof \App\Models\Product ? $product->final_price : $product->selling_price;
@endphp
<article class="ub-product-card">
    <a class="ub-product-image" href="{{ route('product.show', $product->slug) }}" aria-label="View {{ $product->name }}">
        <img src="{{ asset($product->image ?: 'frontend/assets/img/product-placeholder.svg') }}"
            alt="{{ $product->name }}" loading="lazy" decoding="async" width="400" height="400">
        @if ($stock <= 0)
            <span class="ub-product-tag ub-tag-muted">Sold out</span>
        @elseif($product->is_bestseller ?? false)
            <span class="ub-product-tag">Bestseller</span>
        @elseif($product->is_new ?? false)
            <span class="ub-product-tag">New arrival</span>
        @endif
        <span class="ub-product-arrow" aria-hidden="true"><i class="fa-regular fa-arrow-up-right"></i></span>
    </a>
    <div class="ub-product-info"><span
            class="ub-product-category">{{ $product->category->name ?? ($product->brand_name ?? 'THE UNIBOX COLLECTION') }}</span>
        <h3><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h3>
        <div class="ub-product-bottom">
            <div class="ub-product-price">৳{{ number_format($price, 2) }} @if (($product->main_price ?? 0) > $price)
                    <del>৳{{ number_format($product->main_price, 2) }}</del>
                @endif
            </div><span
                class="ub-stock {{ $stock <= 0 ? 'is-unavailable' : '' }}">{{ $stock > 0 ? 'In stock' : 'Unavailable' }}</span>
        </div>
    </div>
</article>
