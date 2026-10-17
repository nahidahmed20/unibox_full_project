<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/home-search-suggestion-1.css') }}">
@if ($products->count() > 0)
    <ul class="search-suggestion-list">
        @foreach ($products as $product)
            <li>
                <a href="{{ route('product.show', $product->slug) }}" class="search-item">

                    <img src="{{ asset($product->image) }}"
                         width="50"
                         height="50"
                         alt="{{ $product->name }}">

                    <div class="search-content">
                        <h6>{{ $product->name }}</h6>
                    </div>

                    <div class="search-price">
                        ৳{{ $product->selling_price }}
                    </div>

                </a>
            </li>
        @endforeach
    </ul>
@else
    <div class="p-3 text-center">
        No products found.
    </div>
@endif