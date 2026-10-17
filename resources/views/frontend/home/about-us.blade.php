@extends('frontend.layouts.app')
@section('title', 'Our story')
@push('css')
    <link rel="stylesheet"
        href="{{ asset('frontend/assets/css/info-pages.css') }}?v={{ filemtime(public_path('frontend/assets/css/info-pages.css')) }}">
@endpush
@section('content')

    <section class="ub-info-intro container">
        <span class="ub-eyebrow">THE STORY BEHIND UNIBOX</span>
        <h1>Small details.<span>Meaningful possibilities.</span></h1>
        <p>For the ideas you want to bring to life, and the details that make them yours.</p>
    </section>
    <section class="container ub-about-story">
        <div class="ub-about-photo">
            @if ($about_us?->image1)
                <img src="{{ asset($about_us->image1) }}" alt="{{ $about_us->title ?: 'Our story' }}" width="720"
                    height="800" fetchpriority="high">
            @else
                <div class="ub-about-wordmark" aria-hidden="true"><span>unibox.</span><small>YOUR IDEAS. YOUR WAY.</small>
                </div>
            @endif
            <span class="ub-about-photo-label">A LITTLE MORE PERSONAL.</span>
        </div>
        <div class="ub-about-copy">
            <span class="ub-eyebrow">{{ $about_us?->subtitle ?: 'MADE AROUND YOUR IDEAS' }}</span>
            <h2>{{ $about_us?->title ?: 'Good things begin with a personal touch.' }}</h2>
            <div class="ub-info-prose">
                {{ $about_us?->description ?: 'Explore products for your business, your everyday and your special occasions. Find a detail you love, discover the available custom options, and let us help you make it your own.' }}
            </div>
            @if ($about_us?->experience_years)
                <div class="ub-about-experience"><strong>{{ $about_us->experience_years }}+</strong><span>Years of
                        experience</span></div>
            @endif
            @php($storyLink = new \App\Models\Slider(['link' => $about_us?->btn_url]))
            <a class="ub-button ub-button-primary"
                href="{{ $about_us?->btn_url ? $storyLink->action_url : route('search') }}">{{ $about_us?->btn_text ?: 'Explore the collection' }}
                <i class="fa-regular fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </section>
    <section class="ub-info-band">
        <div class="container ub-info-values">
            @foreach ([['01', 'Find your starting point', 'Browse collections for your business, your space and your next occasion.'], ['02', 'Make it personal', 'Explore the sizes, finishes and custom options available for your product.'], ['03', 'Let’s work out the details', 'Have a question or a new idea? Talk to us before placing your order.']] as [$number, $title, $copy])
                <div><span class="ub-info-number">{{ $number }}</span>
                    <h3>{{ $title }}</h3>
                    <p>{{ $copy }}</p>
                </div>
            @endforeach
        </div>
    </section>
    @if ($services->isNotEmpty())
        <section class="container ub-info-section">
            <div class="ub-info-heading">
                <div><span class="ub-eyebrow">FROM IDEA TO SOMETHING REAL</span>
                    <h2>More ways to make it yours.</h2>
                </div>
            </div>
            <div class="ub-info-card-grid">
                @foreach ($services as $service)
                    <a class="ub-info-card" href="{{ route('service.details', $service->slug) }}">
                        @if ($service->image)
                            <img src="{{ asset($service->image) }}" alt="{{ $service->title }}" loading="lazy"
                                width="480" height="320">
                        @endif
                        <div>
                            <h3>{{ $service->title }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($service->short_description ?: $service->description), 160) }}
                            </p><span>Discover more →</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
    @if ($teams->isNotEmpty())
        <section class="container ub-info-section">
            <div class="ub-info-heading">
                <div><span class="ub-eyebrow">THE PEOPLE BEHIND THE DETAILS</span>
                    <h2>Meet our team.</h2>
                </div>
            </div>
            <div class="ub-team-grid">
                @foreach ($teams as $team)
                    <article class="ub-team-card">
                        @if ($team->image)
                            <img src="{{ asset($team->image) }}" alt="{{ $team->name }}" loading="lazy" width="400"
                                height="480">
                        @endif
                        <h3>
                            {{ $team->name }}</h3>
                        <p>{{ $team->designation }}</p>
                        <div class="ub-team-social">
                            @foreach (['facebook' => 'Facebook', 'twitter' => 'Twitter', 'instagram' => 'Instagram'] as $field => $label)
                                @if (filter_var($team->$field, FILTER_VALIDATE_URL) &&
                                        in_array(parse_url($team->$field, PHP_URL_SCHEME), ['http', 'https']))
                                    <a href="{{ $team->$field }}" target="_blank"
                                        rel="noopener noreferrer">{{ $label }}</a>
                                @endif
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
    @if ($testimonials->isNotEmpty())
        <section class="ub-info-band">
            <div class="container ub-info-section">
                <div class="ub-info-heading">
                    <div><span class="ub-eyebrow">IN THEIR WORDS</span>
                        <h2>Stories from our customers.</h2>
                    </div>
                </div>
                <div class="ub-testimonial-rail" tabindex="0" aria-label="Customer testimonials">
                    @foreach ($testimonials as $testimonial)
                        <figure class="ub-quote">
                            <div aria-label="{{ $testimonial->rating }} out of 5 stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $testimonial->rating ? 'fa-solid' : 'fa-regular' }} fa-star"
                                        aria-hidden="true"></i>
                                @endfor
                            </div>
                            <h3>{{ $testimonial->title }}</h3>
                            <blockquote>{{ $testimonial->review }}</blockquote>
                            <figcaption>
                                @if ($testimonial->image)
                                    <img src="{{ asset($testimonial->image) }}" alt="" loading="lazy"
                                        width="48" height="48">
                                @endif
                                <div>
                                    <strong>{{ $testimonial->name }}</strong><span>{{ $testimonial->designation }}</span>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @if ($clients->isNotEmpty())
        <section class="container ub-info-section"><span class="ub-eyebrow">PART OF OUR STORY</span>
            <div class="ub-client-grid">
                @foreach ($clients as $client)
                    @if ($client->logo)
                        <div>
                            @if (filter_var($client->url, FILTER_VALIDATE_URL) &&
                                    in_array(parse_url($client->url, PHP_URL_SCHEME), ['http', 'https']))
                                <a href="{{ $client->url }}" target="_blank" rel="noopener noreferrer">
                            @endif
                            <img src="{{ asset($client->logo) }}" alt="{{ $client->name ?: 'Client' }}" loading="lazy"
                                width="160" height="80">
                            @if (filter_var($client->url, FILTER_VALIDATE_URL) &&
                                    in_array(parse_url($client->url, PHP_URL_SCHEME), ['http', 'https']))
                                </a>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    @endif
    <section class="container ub-info-cta">
        <div><span class="ub-eyebrow">SOMETHING ON YOUR MIND?</span>
            <h2>Let’s make it happen.</h2>
            <p>Tell us what you have in mind. We’ll help you explore the possibilities.</p>
        </div><a class="ub-button ub-button-light" href="{{ route('contact.us') }}">Start a conversation <i
                class="fa-regular fa-arrow-right" aria-hidden="true"></i></a>
    </section>
@endsection
