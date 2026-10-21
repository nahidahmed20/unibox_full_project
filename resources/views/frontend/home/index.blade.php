@extends('frontend.layouts.app')
@section('title', 'Thoughtful products. Big possibilities.')
@section('content')
    @include('frontend.home.partials.hero')
    <section class="container ub-trust-strip" aria-label="Shopping information">
        <div>
            <i class="fa-solid fa-truck-fast text-primary" aria-hidden="true"></i>
            <span><strong>সারা দেশে হোম ডেলিভারি</strong>ক্যাশ অন ডেলিভারি সুবিধা</span>
        </div>
        <div>
            <i class="fa-solid fa-sliders text-success" aria-hidden="true"></i>
            <span><strong>কাস্টমাইজড প্রডাক্টস</strong>আপনার পছন্দমতো তৈরি</span>
        </div>
        <div>
            <i class="fa-solid fa-wallet text-warning" aria-hidden="true"></i>
            <span><strong>ক্যাশ অন ডেলিভারি</strong>পণ্য হাতে পেয়ে পেমেন্ট</span>
        </div>
        <div>
            <i class="fa-solid fa-headset text-info" aria-hidden="true"></i>
            <span><strong>২৪/৭ কাস্টমার সাপোর্ট</strong>যেকোনো তথ্যে পাশে আছি</span>
        </div>
    </section>
    {{-- FEATURED CATEGORIES & COLLECTIONS --}}
    <section class="container ub-section ub-collections-premium" id="collections" aria-labelledby="collections-title">
        <div class="ub-section-header-modern d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
            <div>
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-primary bg-opacity-10 text-primary fw-bold text-uppercase mb-2" style="font-size: 11px; letter-spacing: 0.08em;">
                    <i class="fa-solid fa-shapes"></i> TOP COLLECTIONS & CATEGORIES
                </div>
                <h2 id="collections-title" class="fw-bolder text-dark mb-1" style="font-size: 30px; letter-spacing: -0.02em;">
                    জনপ্রিয় ক্যাটাগরি ও কালেকশন
                </h2>
                <p class="text-muted mb-0" style="font-size: 14.5px; max-width: 580px;">
                    কাস্টমাইজড উপহার, ক্রেস্ট, অ্যাওয়ার্ড, অফিস ব্যাগ ও ব্র্যান্ডিং আইটেম—আপনার পছন্দের ক্যাটাগরি এক্সপ্লোর করুন।
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="ub-collection-controls" data-collection-controls hidden>
                    <button type="button" class="btn-rail-ctrl" data-collection-prev aria-label="Previous collections">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button type="button" class="btn-rail-ctrl" data-collection-next aria-label="Next collections">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
                <a class="btn btn-sm btn-outline-dark rounded-pill px-3 py-2 fw-semibold d-none d-sm-inline-flex align-items-center gap-1" href="{{ route('search') }}" style="font-size: 13px;">
                    <span>সবগুলো দেখুন</span>
                    <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="ub-collection-rail" tabindex="0" aria-label="Browse all collections">
            @forelse($categories as $category)
                <a class="ub-collection-card" href="{{ route('category.show', $category->slug) }}">
                    <div class="ub-card-thumb-wrap">
                        @if($category->image)
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="ub-card-img" loading="lazy" decoding="async">
                        @else
                            <div class="ub-card-img-placeholder">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                        @endif

                        {{-- Floating badge --}}
                        <div class="ub-card-badge-top">
                            <span class="ub-card-badge">
                                @if(isset($category->products_count) && $category->products_count > 0)
                                    {{ $category->products_count }} {{ Str::plural('Product', $category->products_count) }}
                                @elseif($category->children && count($category->children) > 0)
                                    {{ count($category->children) }} Types
                                @else
                                    Exclusive
                                @endif
                            </span>
                        </div>

                        {{-- Hover Action Circle --}}
                        <div class="ub-card-hover-action">
                            <span class="ub-action-circle">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </span>
                        </div>
                    </div>

                    <div class="ub-card-content">
                        <h3 class="ub-card-title">{{ $category->name }}</h3>

                        @if($category->children && count($category->children) > 0)
                            <div class="ub-card-pills">
                                @foreach($category->children->take(2) as $sub)
                                    <span class="ub-sub-pill">{{ $sub->name }}</span>
                                @endforeach
                                @if(count($category->children) > 2)
                                    <span class="ub-sub-pill ub-sub-more">+{{ count($category->children) - 2 }} more</span>
                                @endif
                            </div>
                        @endif

                        <div class="ub-card-footer">
                            <span class="ub-explore-text">
                                Explore Collection <i class="fa-solid fa-arrow-right ms-1 ub-arrow-slide"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="ub-empty p-4 text-center w-100 bg-white rounded-4 border">
                    <i class="fa-solid fa-box-open text-muted fs-1 mb-2"></i>
                    <p class="text-muted mb-2">শীঘ্রই নতুন কালেকশন যুক্ত হচ্ছে।</p>
                    <a href="{{ route('contact.us') }}" class="btn btn-sm btn-primary rounded-pill px-4">যোগাযোগ করুন</a>
                </div>
            @endforelse
        </div>

        <div class="ub-collections-bottom-bar mt-4 p-3 rounded-4 bg-white border d-flex justify-content-between align-items-center flex-wrap gap-3 shadow-sm">
            <div class="d-flex align-items-center gap-2">
                <span class="rounded-circle bg-success bg-opacity-10 text-success p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="fa-solid fa-shield-halved" style="font-size: 15px;"></i>
                </span>
                <span class="fw-semibold text-dark" style="font-size: 13.5px;">কর্পোরেট গিফট ও বাল্ক অর্ডারের জন্য বিশেষ ডিসকাউন্ট এবং দ্রুত ডেলিভারি সুবিধা।</span>
            </div>
            <a class="ub-bulk-quote-btn" href="{{ route('contact.us') }}">
                <span>Get Bulk Quote</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </section>
    @if ($bestsellers->isNotEmpty())
        <section class="ub-bestseller-section py-4 py-md-5 my-2" style="background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2 bg-warning bg-opacity-10 text-dark fw-bold" style="font-size: 11.5px; letter-spacing: 0.06em;">
                            <i class="fa-solid fa-fire text-warning"></i> MOST LOVED & TRENDING
                        </div>
                        <h2 class="fw-bolder text-dark mb-1" style="font-size: clamp(24px, 3.2vw, 32px); letter-spacing: -0.02em;">
                            জনপ্রিয় বেস্ট সেলার্স
                        </h2>
                        <p class="text-muted small mb-0" style="font-size: 14.5px;">
                            গ্রাহকদের সর্বাধিক পছন্দের এবং সর্বোচ্চ রেটেড ট্রেন্ডিং প্রোডাক্টসমূহ।
                        </p>
                    </div>
                    <a class="btn btn-sm btn-outline-dark rounded-pill px-4 py-2 fw-bold d-inline-flex align-items-center gap-2" href="{{ route('shop.bestsellers') }}">
                        <span>সকল বেস্টসেলার দেখুন</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <div class="ub-product-grid">
                    @foreach ($bestsellers as $product)
                        @include('frontend.components.product-card', ['product' => $product])
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
                    class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        </div>
        <div class="ub-product-grid">
            @forelse($products->take(8) as $product)
                @include('frontend.components.product-card')@empty
                <div class="ub-empty"><i class="fa-solid fa-box-open" aria-hidden="true"></i>
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
            <a class="ub-button ub-button-primary" href="{{ route('contact.us') }}">Create something personal <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
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
                            <h3>{{ $service->title ?? $service->name }}</h3><i class="fa-solid fa-arrow-up-right-from-square"
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
