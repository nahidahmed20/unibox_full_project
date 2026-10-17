@extends('frontend.layouts.app')
@section('title', 'Thoughtful products. Big possibilities.')
@section('content')
    @include('frontend.home.partials.hero')
    <section class="container ub-trust-strip" aria-label="Shopping information">
        <div><i class="fa-regular fa-truck-fast" aria-hidden="true"></i><span><strong>Delivered to your door</strong>Choose
                your delivery zone</span></div>
        <div><i class="fa-regular fa-sliders" aria-hidden="true"></i><span><strong>Details, your way</strong>Explore
                available custom options</span></div>
        <div><i class="fa-regular fa-wallet" aria-hidden="true"></i><span><strong>Cash on delivery</strong>Pay when your
                order arrives</span></div>
        <div><i class="fa-regular fa-comments" aria-hidden="true"></i><span><strong>A real helping hand</strong>Talk to us
                about your order</span></div>
    </section>
    <section class="container ub-section ub-collections" id="collections" aria-labelledby="collections-title">
        <div class="ub-section-heading">
            <div><span class="ub-eyebrow">CURATED FOR YOUR NEXT IDEA</span><h2 id="collections-title">Discover your kind of collection.</h2><p>Thoughtful details for your business, your everyday, and the moments worth celebrating.</p></div>
            <div class="ub-collection-controls" data-collection-controls hidden><button type="button" data-collection-prev aria-label="Previous collections"><i class="fa-regular fa-arrow-left" aria-hidden="true"></i></button><button type="button" data-collection-next aria-label="Next collections"><i class="fa-regular fa-arrow-right" aria-hidden="true"></i></button></div>
        </div>
        <div class="ub-collection-rail" tabindex="0" aria-label="Browse all collections">
            @forelse($categories as $category)
                <a class="ub-collection-link ub-category-tile" href="{{ route('category.show', $category->slug) }}">
                    <div class="ub-collection-image">
                        <span class="ub-collection-number" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        @if($category->image)<img src="{{ asset($category->image) }}" alt="" width="200" height="200" loading="lazy" decoding="async">@else<i class="fa-regular fa-shapes" aria-hidden="true"></i>@endif
                    </div>
                    <div class="ub-collection-caption"><h3>{{ $category->name }}</h3><span>Explore collection <i class="fa-regular fa-arrow-up-right" aria-hidden="true"></i></span></div>
                </a>
            @empty
                <div class="ub-empty"><p>New collections are on their way.</p><a href="{{ route('contact.us') }}">Tell us what you have in mind</a></div>
            @endforelse
        </div>
        <div class="ub-collection-bottom"><span>A collection for every possibility.</span><a class="ub-text-link" href="{{ route('search') }}">View all products <i class="fa-regular fa-arrow-right" aria-hidden="true"></i></a></div>
    </section>
    @if ($bestsellers->isNotEmpty())
        <section class="ub-bestseller-section">
            <div class="container ub-section">
                <div class="ub-section-heading">
                    <div><span class="ub-eyebrow">WORTH A CLOSER LOOK</span>
                        <h2>Bestsellers</h2>
                    </div><a class="ub-text-link" href="{{ route('shop.bestsellers') }}">Shop bestsellers <i
                            class="fa-regular fa-arrow-right" aria-hidden="true"></i></a>
                </div>
                <div class="ub-product-grid">
                    @foreach ($bestsellers as $product)
                        @include('frontend.components.product-card')
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <section class="container ub-section">
        <div class="ub-section-heading">
            <div><span class="ub-eyebrow">MEET YOUR NEXT FAVORITE</span>
                <h2>New in the shop</h2>
            </div><a class="ub-button ub-button-outline" href="{{ route('search') }}">Shop the collection <i
                    class="fa-regular fa-arrow-right" aria-hidden="true"></i></a>
        </div>
        <div class="ub-product-grid">
            @forelse($products->take(8) as $product)
                @include('frontend.components.product-card')@empty
                <div class="ub-empty"><i class="fa-regular fa-box-open" aria-hidden="true"></i>
                    <h3>Good things are coming.</h3>
                    <p>Our collection is getting ready. Contact us for a custom order.</p><a
                        class="ub-button ub-button-primary" href="{{ route('contact.us') }}">Start a conversation</a>
                </div>
            @endforelse
        </div>
    </section>
    <section class="ub-story">
        <div class="container ub-story-inner">
            <span class="ub-eyebrow">A PERSONAL TOUCH</span>
            <h2>Good things start<br>with your idea.</h2>
            <p>A name, a message, a detail that makes it yours. Explore our custom options and create something worth keeping.</p>
            <a class="ub-button ub-button-primary" href="{{ route('contact.us') }}">Create something personal <i class="fa-regular fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </section>
    @if (count($services))
        <section class="container ub-section">
            <div class="ub-section-heading">
                <div><span class="ub-eyebrow">A LITTLE EXTRA, FROM US</span>
                    <h2>More ways to bring it to life.</h2>
                </div>
            </div>
            <div class="ub-service-grid">
                @foreach (collect($services)->take(3) as $service)
                    <a class="ub-service-card" href="{{ route('service.details', $service->slug) }}">
                        @if ($service->image)
                            <img src="{{ asset($service->image) }}" alt="" loading="lazy" width="400"
                                height="260">
                        @endif
                        <div>
                            <h3>{{ $service->title ?? $service->name }}</h3><i class="fa-regular fa-arrow-up-right"
                                aria-hidden="true"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection

@push('javascript')
<script src="{{ asset('frontend/assets/js/home.js') }}?v={{ filemtime(public_path('frontend/assets/js/home.js')) }}" defer></script>
@endpush
