<div class="tab-content" id="nav-tabContent">
    @foreach (['nav-home' => 'grid', 'nav-profile' => 'list'] as $pane => $mode)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $pane }}" role="tabpanel">
            <div class="ub-product-grid {{ $mode === 'list' ? 'ub-product-list' : '' }}">
                @forelse($products as $product)
                    @include('frontend.components.product-card', ['product' => $product])
                @empty
                    <div class="ub-empty"><i class="fa-regular fa-box-open" aria-hidden="true"></i>
                        <h3>No products found</h3>
                        <p>Try another search or explore a different category.</p><a class="ub-button ub-button-outline"
                            href="{{ route('search') }}">Explore all products</a>
                    </div>
                @endforelse
            </div>
        </div>
    @endforeach
</div>
