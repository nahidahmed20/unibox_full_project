@extends('frontend.layouts.app')
@section('title', 'আমাদের গল্প ও পথচলা | Our Story')

@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/info-pages.css') }}?v={{ filemtime(public_path('frontend/assets/css/info-pages.css')) }}">
@endpush

@section('content')
@php
    $brandName = setting('company_name', setting('website_title', 'Unibox'));
    $tagline = setting('website_tagline', 'Ideas, Delivered.');
    $isDummy = str_contains(strtolower($about_us?->title ?? ''), 'nulla') || str_contains(strtolower($about_us?->description ?? ''), 'voluptate');
    $storyTitle = (!$isDummy && $about_us?->title) ? $about_us->title : 'সৃজনশীল ভাবনা আর প্রিমিয়াম কোয়ালিটির মেলবন্ধন';
    $storySubtitle = (!$isDummy && $about_us?->subtitle) ? $about_us->subtitle : 'আমাদের গল্প ও দর্শন';
    $storyDesc = (!$isDummy && $about_us?->description) ? $about_us->description : $brandName . ' একটি আধুনিক ও প্রিমিয়াম লাইফস্টাইল ব্র্যান্ড। আমরা বিশ্বাস করি প্রতিটি উপহার ও প্রোডাক্টের পেছনে জড়িয়ে থাকে বিশেষ এক আবেগ ও স্মৃতি। ব্যক্তিগত উপহার, অফিস সামগ্রী, ক্রেস্ট, ট্রফি কিংবা ব্র্যান্ডিং আইটেম—প্রতিটি পণ্য তৈরিতে আমাদের নিবেদিত কারিগররা সর্বোচ্চ যত্ন ও গুণগত মান নিশ্চিত করেন। সারা দেশে দ্রুততম হোম ডেলিভারি এবং সহজ কেনাকাটার মাধ্যম হিসেবে আমরা সবসময় আপনার পাশে আছি।';
    $experienceYears = ($about_us?->experience_years && $about_us->experience_years < 100) ? $about_us->experience_years : '5';
    $storyImg = ($about_us?->image1 && file_exists(public_path($about_us->image1))) ? asset($about_us->image1) : null;
@endphp

<div class="ub-about-page-wrapper py-4 py-md-5">
    <div class="container">

        {{-- 1. LUXURY HERO BANNER --}}
        <div class="p-4 p-md-5 mb-4 mb-md-5 rounded-4 position-relative overflow-hidden shadow-sm"
             style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #172554 100%); color: #ffffff;">
            <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb mb-0 small text-white-50">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none"><i class="fa-solid fa-house me-1"></i> Home</a></li>
                            <li class="breadcrumb-item active text-white fw-semibold" aria-current="page">Our Story</li>
                        </ol>
                    </nav>

                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); font-size: 12px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                        <i class="fa-solid fa-crown text-warning"></i>
                        <span>THE {{ strtoupper($brandName) }} STORY & PHILOSOPHY</span>
                    </div>

                    <h1 class="fw-bolder mb-2 text-white" style="font-size: clamp(28px, 4vw, 44px); line-height: 1.2;">
                        আমাদের গল্প ও পথচলা
                    </h1>
                    <p class="mb-0 text-white-50 fs-6" style="max-width: 620px; line-height: 1.6;">
                        {{ $tagline }} — আপনার ছোট-বড় ভাবনাগুলোকে অনন্য ও অর্থবহ প্রোডাক্টে রূপান্তর করার লক্ষ্যেই আমাদের নিরন্তর প্রচেষ্টা।
                    </p>
                </div>
                <div class="col-lg-4 text-center text-lg-end d-none d-lg-block">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 110px; height: 110px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);">
                        <i class="fa-solid fa-gem text-warning" style="font-size: 50px;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. BRAND STORY & CRAFTSMANSHIP SHOWCASE --}}
        <div class="row align-items-center g-4 g-lg-5 mb-5 pb-lg-3">
            {{-- LEFT: IMAGE / BRAND CARD --}}
            <div class="col-lg-6">
                <div class="position-relative">
                    @if ($storyImg)
                        <div class="rounded-4 overflow-hidden border shadow-sm position-relative" style="max-height: 480px;">
                            <img src="{{ $storyImg }}" alt="{{ $storyTitle }}" class="w-100 h-100 object-fit-cover rounded-4" style="min-height: 380px;">
                            <div class="position-absolute bottom-0 start-0 w-100 p-3 p-md-4 text-white" style="background: linear-gradient(180deg, transparent 0%, rgba(15,23,42,0.85) 100%);">
                                <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold mb-1" style="font-size: 11px;">
                                    <i class="fa-solid fa-award me-1"></i> CRAFTSMANSHIP
                                </span>
                                <h6 class="mb-0 text-white fw-bold">প্রিমিয়াম মান ও আস্থার প্রতীক</h6>
                            </div>
                        </div>
                    @else
                        <div class="p-5 rounded-4 text-center d-flex flex-column align-items-center justify-content-center border shadow-xs" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: 380px;">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white shadow-sm mb-3" style="width: 90px; height: 90px;">
                                <i class="fa-solid fa-shapes text-primary" style="font-size: 42px;"></i>
                            </div>
                            <h3 class="fw-bolder text-dark mb-1" style="font-size: 32px; letter-spacing: -0.02em;">{{ $brandName }}</h3>
                            <p class="text-muted small text-uppercase fw-bold mb-0" style="letter-spacing: 0.1em;">{{ $tagline }}</p>
                        </div>
                    @endif

                    {{-- FLOATING EXPERIENCE BADGE --}}
                    <div class="position-absolute d-none d-sm-flex align-items-center gap-3 p-3 bg-white rounded-4 border shadow-md" style="bottom: -20px; right: 20px; z-index: 3;">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="fa-solid fa-star fs-5 text-warning"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark fw-bold" style="font-size: 18px; line-height: 1.1;">{{ $experienceYears }}+ Years</strong>
                            <small class="text-muted" style="font-size: 12px;">অব্যাহত সেবা ও সুনাম</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: STORY NARRATIVE --}}
            <div class="col-lg-6">
                <div class="ps-lg-3">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3 bg-primary bg-opacity-10 text-primary fw-bold" style="font-size: 11.5px; letter-spacing: 0.06em;">
                        <i class="fa-solid fa-feather-pointed"></i> {{ $storySubtitle }}
                    </div>
                    <h2 class="fw-bolder text-dark mb-3" style="font-size: clamp(24px, 3.2vw, 36px); line-height: 1.3;">
                        {{ $storyTitle }}
                    </h2>
                    <div class="text-muted mb-4" style="font-size: 15.5px; line-height: 1.8;">
                        {{ $storyDesc }}
                    </div>

                    {{-- KEY HIGHLIGHT BULLETS --}}
                    <div class="d-flex flex-column gap-2.5 mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span class="text-dark fw-semibold" style="font-size: 14.5px;">১০০% অরিজিনাল ম্যাটেরিয়াল ও সূক্ষ্ম ফিনিশিং</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span class="text-dark fw-semibold" style="font-size: 14.5px;">সরাসরি কাস্টমাইজেশন ও লোগো এমবসিং সুবিধা</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span class="text-dark fw-semibold" style="font-size: 14.5px;">সারা দেশে হোম ডেলিভারি ও নিরাপদ ক্যাশ অন ডেলিভারি</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <a href="{{ route('search') }}" class="btn btn-dark rounded-pill px-4 py-2.5 fw-bold d-inline-flex align-items-center gap-2 shadow-sm text-white" style="background: #0f172a;">
                            <span>সকল কালেকশন দেখুন</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a href="{{ route('contact.us') }}" class="btn btn-outline-dark rounded-pill px-4 py-2.5 fw-bold d-inline-flex align-items-center gap-2">
                            <i class="fa-solid fa-envelope"></i>
                            <span>যোগাযোগ করুন</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. FOUR CORE VALUES (WHY CHOOSE US) --}}
        <div class="mb-5 pb-lg-3">
            <div class="text-center mb-4 pb-2">
                <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-muted fw-bold small text-uppercase mb-2" style="font-size: 11px;">
                    <i class="fa-solid fa-check-double text-primary"></i> OUR CORE VALUES
                </span>
                <h3 class="fw-bolder text-dark mb-1" style="font-size: 28px;">কেন আমরা অন্যদের চেয়ে আলাদা?</h3>
                <p class="text-muted small mx-auto mb-0" style="max-width: 500px;">আমাদের মূল লক্ষ্য আপনার প্রতিটি কেনাকাটায় সর্বোচ্চ সন্তুষ্টি ও প্রিমিয়াম অভিজ্ঞতা নিশ্চিত করা।</p>
            </div>

            <div class="row g-3 g-md-4">
                <div class="col-6 col-md-3">
                    <div class="p-4 rounded-4 bg-white border h-100 shadow-xs text-center text-sm-start">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px; font-size: 22px;">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1 fs-6">শ্রেষ্ঠ কোয়ালিটি</h6>
                        <p class="text-muted small mb-0" style="line-height: 1.6; font-size: 13px;">সেরা মানের উপকরণ ও প্রতিটি ডিটেইলে নিখুঁত হাতের কাজ।</p>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="p-4 rounded-4 bg-white border h-100 shadow-xs text-center text-sm-start">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px; font-size: 22px;">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1 fs-6">সারা দেশে ডেলিভারি</h6>
                        <p class="text-muted small mb-0" style="line-height: 1.6; font-size: 13px;">ঢাকা সিটিতে ২৪-৪৮ ঘণ্টা ও ঢাকার বাইরে ২-৪ দিনে ক্যাশ অন ডেলিভারি।</p>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="p-4 rounded-4 bg-white border h-100 shadow-xs text-center text-sm-start">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px; font-size: 22px;">
                            <i class="fa-solid fa-sliders"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1 fs-6">কাস্টমাইজেশন সুবিধা</h6>
                        <p class="text-muted small mb-0" style="line-height: 1.6; font-size: 13px;">আপনার পছন্দমাফিক নাম, ব্র্যান্ড লোগো বা মেসেজ খোদাই করার সুবিধা।</p>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="p-4 rounded-4 bg-white border h-100 shadow-xs text-center text-sm-start">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px; font-size: 22px;">
                            <i class="fa-solid fa-rotate-left"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1 fs-6">সহজ রিটার্ন ও সাপোর্ট</h6>
                        <p class="text-muted small mb-0" style="line-height: 1.6; font-size: 13px;">পণ্য জনিত যেকোনো সমস্যায় দ্রুত সমাধান ও মানিব্যাক নিশ্চয়তা।</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. STATS COUNTER STRIP (LUXURY DARK & GOLD) --}}
        <div class="p-4 p-md-5 mb-5 rounded-4 text-white shadow-sm" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <div class="row g-4 text-center">
                <div class="col-6 col-md-3">
                    <h3 class="fw-bolder text-warning mb-1" style="font-size: clamp(28px, 4vw, 42px);">10,000+</h3>
                    <p class="text-white-50 small mb-0">সুখী ও সন্তুষ্ট গ্রাহক</p>
                </div>
                <div class="col-6 col-md-3">
                    <h3 class="fw-bolder text-warning mb-1" style="font-size: clamp(28px, 4vw, 42px);">25,000+</h3>
                    <p class="text-white-50 small mb-0">সম্পন্ন ডেলিভারি</p>
                </div>
                <div class="col-6 col-md-3">
                    <h3 class="fw-bolder text-warning mb-1" style="font-size: clamp(28px, 4vw, 42px);">64</h3>
                    <p class="text-white-50 small mb-0">জেলায় সার্ভিস নেটওয়ার্ক</p>
                </div>
                <div class="col-6 col-md-3">
                    <h3 class="fw-bolder text-warning mb-1" style="font-size: clamp(28px, 4vw, 42px);">4.9 / 5</h3>
                    <p class="text-white-50 small mb-0">গ্রাহক সন্তুষ্টি রেটিং</p>
                </div>
            </div>
        </div>

        {{-- 5. SERVICES / CAPABILITIES (IF AVAILABLE) --}}
        @if ($services->isNotEmpty())
            <div class="mb-5 pb-lg-3">
                <div class="text-center mb-4 pb-2">
                    <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-muted fw-bold small text-uppercase mb-2" style="font-size: 11px;">
                        <i class="fa-solid fa-shapes text-primary"></i> SERVICES & CAPABILITIES
                    </span>
                    <h3 class="fw-bolder text-dark mb-1" style="font-size: 28px;">আমাদের বিশেষ সেবাসমূহ</h3>
                </div>
                <div class="row g-4">
                    @foreach ($services as $service)
                        <div class="col-md-4">
                            <div class="card h-100 border rounded-4 overflow-hidden shadow-xs hover-shadow transition-all">
                                @if ($service->image)
                                    <img src="{{ asset($service->image) }}" class="card-img-top object-fit-cover" alt="{{ $service->title }}" style="height: 200px;">
                                @endif
                                <div class="card-body p-4">
                                    <h5 class="fw-bold text-dark mb-2">{{ $service->title }}</h5>
                                    <p class="text-muted small mb-3" style="line-height: 1.6;">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($service->short_description ?: $service->description), 140) }}
                                    </p>
                                    <a href="{{ route('service.details', $service->slug) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1.5 fw-semibold" style="font-size: 12.5px;">
                                        বিস্তারিত দেখুন <i class="fa-solid fa-arrow-right small ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 6. TEAMS (IF AVAILABLE) --}}
        @if ($teams->isNotEmpty())
            <div class="mb-5 pb-lg-3">
                <div class="text-center mb-4 pb-2">
                    <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-muted fw-bold small text-uppercase mb-2" style="font-size: 11px;">
                        <i class="fa-solid fa-users text-primary"></i> THE PASSIONATE TEAM
                    </span>
                    <h3 class="fw-bolder text-dark mb-1" style="font-size: 28px;">আমাদের দক্ষ কারিগর ও টিম</h3>
                </div>
                <div class="row g-4 justify-content-center">
                    @foreach ($teams as $team)
                        <div class="col-6 col-md-3">
                            <div class="card h-100 border rounded-4 overflow-hidden text-center shadow-xs p-3">
                                @if ($team->image)
                                    <img src="{{ asset($team->image) }}" class="rounded-circle mx-auto mb-3 object-fit-cover border" alt="{{ $team->name }}" style="width: 100px; height: 100px;">
                                @else
                                    <div class="rounded-circle mx-auto mb-3 bg-light border d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                        <i class="fa-solid fa-user text-muted fs-3"></i>
                                    </div>
                                @endif
                                <h6 class="fw-bold text-dark mb-0">{{ $team->name }}</h6>
                                <small class="text-muted d-block mb-2">{{ $team->designation }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 7. TESTIMONIALS (IF AVAILABLE) --}}
        @if ($testimonials->isNotEmpty())
            <div class="mb-5 pb-lg-3">
                <div class="text-center mb-4 pb-2">
                    <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border text-muted fw-bold small text-uppercase mb-2" style="font-size: 11px;">
                        <i class="fa-solid fa-comments text-primary"></i> CUSTOMER REVIEWS
                    </span>
                    <h3 class="fw-bolder text-dark mb-1" style="font-size: 28px;">গ্রাহকদের সন্তুষ্টির রিভিউ</h3>
                </div>
                <div class="row g-4">
                    @foreach ($testimonials as $testimonial)
                        <div class="col-md-4">
                            <div class="p-4 rounded-4 bg-white border h-100 shadow-xs d-flex flex-column justify-content-between">
                                <div>
                                    <div class="text-warning small mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $testimonial->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <h6 class="fw-bold text-dark mb-2">{{ $testimonial->title }}</h6>
                                    <p class="text-muted small mb-3 fst-italic" style="line-height: 1.6;">"{{ $testimonial->review }}"</p>
                                </div>
                                <div class="d-flex align-items-center gap-2 pt-2 border-top">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 14px;">
                                        {{ mb_substr($testimonial->name ?: 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <strong class="d-block text-dark small">{{ $testimonial->name }}</strong>
                                        <small class="text-muted" style="font-size: 11px;">{{ $testimonial->designation ?: 'Verified Customer' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 8. CALL TO ACTION (CTA) --}}
        <div class="p-4 p-md-5 rounded-4 text-center text-white shadow-sm position-relative overflow-hidden"
             style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold mb-3" style="font-size: 12px;">
                <i class="fa-solid fa-sparkles me-1"></i> READY TO CREATE SOMETHING SPECIAL?
            </span>
            <h2 class="fw-bolder mb-2 text-white" style="font-size: clamp(24px, 3.5vw, 36px);">
                আপনার পছন্দের প্রোডাক্ট অর্ডার করতে আজই শুরু করুন
            </h2>
            <p class="text-white-50 mx-auto mb-4" style="max-width: 580px; font-size: 15px;">
                আমাদের প্রিমিয়াম কালেকশন থেকে পছন্দের সামগ্রী বেছে নিন অথবা আপনার কাস্টম ধারণার জন্য আমাদের সাথে কথা বলুন।
            </p>
            <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                <a href="{{ route('search') }}" class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-dark">
                    <span>শপিং শুরু করুন</span>
                    <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
                <a href="{{ route('contact.us') }}" class="btn btn-outline-light rounded-pill px-4 py-2.5 fw-bold">
                    <span>যোগাযোগ করুন</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
