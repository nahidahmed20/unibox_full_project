@php
    $heroSlides = $sliders->isNotEmpty() ? $sliders : collect([new \App\Models\Slider([
        'title' => 'Made for you. Made to stand out.',
        'short_description' => 'Discover thoughtful products and personal touches for your business and every occasion.',
        'image' => $products->first()?->image,
    ])]);
@endphp
<section class="ub-hero-slider" data-hero-slider aria-label="Featured collections" aria-roledescription="carousel">
    @foreach($heroSlides as $slide)
        <article class="ub-hero-slide {{ $loop->first ? 'is-current' : '' }}" data-slide
            role="group" aria-roledescription="slide" aria-label="{{ $loop->iteration }} of {{ $loop->count }}"
            @if(!$loop->first) hidden @endif>
            @if($slide->image)
                <picture class="ub-slide-picture">
                    @if($slide->mobile_image)<source media="(max-width: 767px)" srcset="{{ asset($slide->mobile_image) }}">@endif
                    <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}" width="1600" height="800"
                        loading="{{ $loop->first ? 'eager' : 'lazy' }}" fetchpriority="{{ $loop->first ? 'high' : 'low' }}" decoding="async">
                </picture>
            @endif
            <div class="container ub-slide-copy">
                <span class="ub-eyebrow">THE UNIBOX COLLECTION</span>
                @if($loop->first)<h1>{{ $slide->title ?: 'Something made for you.' }}</h1>@else<h2>{{ $slide->title ?: 'Something made for you.' }}</h2>@endif
                @if($slide->short_description)<p>{{ $slide->short_description }}</p>@endif
                <a class="ub-button ub-button-light" href="{{ $slide->action_url }}">Explore the collection <i class="fa-regular fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </article>
    @endforeach
    @if($heroSlides->count() > 1)
        <div class="ub-slider-controls container" data-slide-controls hidden>
            <div class="ub-slider-dots" aria-label="Choose a slide">
                @foreach($heroSlides as $slide)<button type="button" data-slide-to="{{ $loop->index }}" aria-label="Show slide {{ $loop->iteration }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}"><span></span></button>@endforeach
            </div>
            <div class="ub-slider-actions">
                <button type="button" data-slide-prev aria-label="Previous slide"><i class="fa-regular fa-arrow-left" aria-hidden="true"></i></button>
                <span data-slide-counter aria-live="off">1 / {{ $heroSlides->count() }}</span>
                <button type="button" data-slide-next aria-label="Next slide"><i class="fa-regular fa-arrow-right" aria-hidden="true"></i></button>
                <button type="button" data-slide-pause aria-label="Pause slideshow"><i class="fa-solid fa-pause" aria-hidden="true"></i></button>
            </div>
        </div>
        <span class="visually-hidden" data-slide-status aria-live="polite"></span>
    @endif
</section>
