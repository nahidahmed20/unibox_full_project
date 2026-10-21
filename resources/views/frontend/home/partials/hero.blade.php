@php
    $heroSlides = $sliders->isNotEmpty() ? $sliders : collect([new \App\Models\Slider([
        'title' => 'Made for you. Made to stand out.',
        'short_description' => 'Discover thoughtful products and personal touches for your business and every occasion.',
        'image' => $products->first()?->image,
    ])]);
@endphp
<section class="ub-hero-slider" data-hero-slider aria-label="Featured collections" aria-roledescription="carousel">
    {{-- SLIDES --}}
    @foreach($heroSlides as $slide)
        <article class="ub-hero-slide {{ $loop->first ? 'is-current' : '' }}" data-slide
            role="group" aria-roledescription="slide" aria-label="{{ $loop->iteration }} of {{ $loop->count }}"
            @if(!$loop->first) hidden @endif>
            
            {{-- SLIDE PICTURE BACKGROUND (CLICKABLE) --}}
            @if($slide->image)
                <a href="{{ $slide->action_url }}" class="ub-slide-picture-link" aria-label="{{ $slide->title ?: 'Explore collection' }}">
                    <picture class="ub-slide-picture">
                        @if($slide->mobile_image)<source media="(max-width: 767px)" srcset="{{ asset($slide->mobile_image) }}">@endif
                        <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}" width="1600" height="800"
                            loading="{{ $loop->first ? 'eager' : 'lazy' }}" fetchpriority="{{ $loop->first ? 'high' : 'low' }}" decoding="async">
                    </picture>
                </a>
            @endif

            {{-- LUXURY GLASS HERO CONTENT CARD --}}
            <div class="container ub-slide-container">
                <div class="ub-hero-glass-card">
                    <div class="ub-hero-eyebrow-pill">
                        <i class="fa-solid fa-crown text-warning"></i>
                        <span>{{ setting('website_tagline') ?: 'PREMIUM COLLECTION' }}</span>
                    </div>

                    @if($loop->first)
                        <h1 class="ub-hero-title">{{ $slide->title ?: 'Made for you. Made to stand out.' }}</h1>
                    @else
                        <h2 class="ub-hero-title">{{ $slide->title ?: 'Made for you. Made to stand out.' }}</h2>
                    @endif

                    @if($slide->short_description)
                        <p class="ub-hero-desc">{{ $slide->short_description }}</p>
                    @else
                        <p class="ub-hero-desc">আপনার পছন্দের সব সেরা প্রিমিয়াম কালেকশন, প্রিমিয়াম কোয়ালিটি ও দ্রুত হোম ডেলিভারির নিশ্চয়তা।</p>
                    @endif

                    <div class="ub-hero-btn-group">
                        <a class="ub-hero-action-btn" href="{{ $slide->action_url }}">
                            <span>Explore Collection</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a class="ub-hero-secondary-btn" href="{{ route('shop.bestsellers') }}">
                            <i class="fa-solid fa-fire text-warning"></i>
                            <span>Bestsellers</span>
                        </a>
                    </div>
                </div>
            </div>
        </article>
    @endforeach

    @if($heroSlides->count() > 1)
        {{-- FLOATING SIDE ARROWS (DESKTOP & TABLET) --}}
        <button type="button" class="ub-hero-nav-arrow prev" data-slide-prev aria-label="Previous slide">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button type="button" class="ub-hero-nav-arrow next" data-slide-next aria-label="Next slide">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        {{-- BOTTOM GLASS CAPSULE CONTROLS --}}
        <div class="ub-slider-controls-wrap" data-slide-controls hidden>
            <div class="ub-slider-capsule">
                <div class="ub-slider-dots" aria-label="Choose a slide">
                    @foreach($heroSlides as $slide)
                        <button type="button" data-slide-to="{{ $loop->index }}" aria-label="Show slide {{ $loop->iteration }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">
                            <span></span>
                        </button>
                    @endforeach
                </div>
                <div class="ub-slider-meta">
                    <span data-slide-counter aria-live="off">1 / {{ $heroSlides->count() }}</span>
                    <button type="button" data-slide-pause class="ub-slider-pause" aria-label="Pause slideshow">
                        <i class="fa-solid fa-pause" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
        <span class="visually-hidden" data-slide-status aria-live="polite"></span>
    @endif
</section>
