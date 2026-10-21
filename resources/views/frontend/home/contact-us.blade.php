@extends('frontend.layouts.app')
@section('title', 'যোগাযোগ করুন | Contact Us')

@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/info-pages.css') }}?v={{ filemtime(public_path('frontend/assets/css/info-pages.css')) }}">
@endpush

@section('content')
@php
    $brandName = setting('company_name', setting('website_title', 'Unibox'));
    $address = setting('company_address', setting('address', '278/3/A, Sardar Villa, 5th Floor, Kataban Dhal, Kataban, Dhaka'));
    $phone = setting('hotline', setting('phone', '01640914338'));
    $cleanPhone = preg_replace('/[^+0-9]/', '', $phone);
    $whatsapp = setting('whatsapp', $phone);
    $cleanWhatsapp = preg_replace('/[^0-9]/', '', $whatsapp);
    $email = setting('email', 'support@unibox4u.com');
    $openingHours = setting('opening_hours', 'শনিবার – বৃহস্পতিবার: সকাল ৯:০০ – রাত ৮:০০ (শুক্রবার সাপ্তাহিক বন্ধ)');
@endphp

<div class="ub-contact-page-wrapper py-4 py-md-5">
    <div class="container">

        {{-- 1. LUXURY HERO BANNER --}}
        <div class="p-4 p-md-5 mb-4 mb-md-5 rounded-4 position-relative overflow-hidden shadow-sm"
             style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #1e1b4b 100%); color: #ffffff;">
            <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb mb-0 small text-white-50">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none"><i class="fa-solid fa-house me-1"></i> Home</a></li>
                            <li class="breadcrumb-item active text-white fw-semibold" aria-current="page">Contact Us</li>
                        </ol>
                    </nav>

                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); font-size: 12px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                        <i class="fa-solid fa-headset text-warning"></i>
                        <span>24/7 CUSTOMER SUPPORT & ASSISTANCE</span>
                    </div>

                    <h1 class="fw-bolder mb-2 text-white" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.2;">
                        আমাদের সাথে যোগাযোগ করুন
                    </h1>
                    <p class="mb-0 text-white-50 fs-6" style="max-width: 620px; line-height: 1.6;">
                        কোনো পণ্য সম্পর্কে বিস্তারিত তথ্য, কাস্টমাইজড উপহার বা কর্পোরেট অর্ডারের বিষয়ে যেকোনো প্রশ্ন থাকলে নির্দ্বিধায় আমাদের মেসেজ দিন বা কল করুন। আমাদের টিম আপনাকে সর্বাত্মক সহায়তা করতে প্রস্তুত।
                    </p>
                </div>
                <div class="col-lg-4 text-center text-lg-end d-none d-lg-block">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 110px; height: 110px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);">
                        <i class="fa-solid fa-comments text-warning" style="font-size: 52px;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. FOUR QUICK ACTION CONTACT CARDS --}}
        <div class="row g-3 g-md-4 mb-4 mb-md-5">
            {{-- PHONE / HOTLINE --}}
            <div class="col-6 col-lg-3">
                <div class="h-100 p-3 p-md-4 rounded-4 bg-white border shadow-xs d-flex flex-column justify-content-between ub-contact-quick-card">
                    <div>
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 bg-primary bg-opacity-10 text-primary" style="width: 48px; height: 48px; font-size: 20px;">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <span class="d-block small text-muted text-uppercase fw-bold" style="letter-spacing: 0.05em; font-size: 11px;">হটলাইন / ফোন</span>
                        <h6 class="fw-bold text-dark mt-1 mb-1 fs-6">{{ $phone }}</h6>
                        <p class="text-muted small mb-3" style="font-size: 12px;">সরাসরি কথা বলুন আমাদের টিমের সাথে</p>
                    </div>
                    <a href="tel:{{ $cleanPhone }}" class="btn btn-sm btn-outline-primary rounded-pill w-100 fw-bold py-1.5" style="font-size: 12.5px;">
                        <i class="fa-solid fa-phone me-1"></i> কল করুন
                    </a>
                </div>
            </div>

            {{-- WHATSAPP --}}
            <div class="col-6 col-lg-3">
                <div class="h-100 p-3 p-md-4 rounded-4 bg-white border shadow-xs d-flex flex-column justify-content-between ub-contact-quick-card">
                    <div>
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 bg-success bg-opacity-10 text-success" style="width: 48px; height: 48px; font-size: 22px;">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <span class="d-block small text-muted text-uppercase fw-bold" style="letter-spacing: 0.05em; font-size: 11px;">হোয়াটসঅ্যাপ চ্যাট</span>
                        <h6 class="fw-bold text-dark mt-1 mb-1 fs-6">WhatsApp Support</h6>
                        <p class="text-muted small mb-3" style="font-size: 12px;">ইনস্ট্যান্ট মেসেজ ও ছবি আদান-প্রদান</p>
                    </div>
                    <a href="https://wa.me/{{ $cleanWhatsapp }}" target="_blank" rel="noopener" class="btn btn-sm btn-success rounded-pill w-100 fw-bold py-1.5" style="font-size: 12.5px;">
                        <i class="fa-brands fa-whatsapp me-1"></i> চ্যাট শুরু করুন
                    </a>
                </div>
            </div>

            {{-- EMAIL --}}
            <div class="col-6 col-lg-3">
                <div class="h-100 p-3 p-md-4 rounded-4 bg-white border shadow-xs d-flex flex-column justify-content-between ub-contact-quick-card">
                    <div>
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 bg-warning bg-opacity-10 text-warning" style="width: 48px; height: 48px; font-size: 20px;">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <span class="d-block small text-muted text-uppercase fw-bold" style="letter-spacing: 0.05em; font-size: 11px;">ইমেইল সাপোর্ট</span>
                        <h6 class="fw-bold text-dark mt-1 mb-1 text-truncate fs-6" title="{{ $email }}">{{ $email }}</h6>
                        <p class="text-muted small mb-3" style="font-size: 12px;">অফিসিয়াল ও কর্পোরেট যোগাযোগের জন্য</p>
                    </div>
                    <a href="mailto:{{ $email }}" class="btn btn-sm btn-outline-dark rounded-pill w-100 fw-bold py-1.5" style="font-size: 12.5px;">
                        <i class="fa-solid fa-paper-plane me-1"></i> মেইল পাঠান
                    </a>
                </div>
            </div>

            {{-- LOCATION --}}
            <div class="col-6 col-lg-3">
                <div class="h-100 p-3 p-md-4 rounded-4 bg-white border shadow-xs d-flex flex-column justify-content-between ub-contact-quick-card">
                    <div>
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 bg-danger bg-opacity-10 text-danger" style="width: 48px; height: 48px; font-size: 20px;">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <span class="d-block small text-muted text-uppercase fw-bold" style="letter-spacing: 0.05em; font-size: 11px;">অফিস ও শোরুম</span>
                        <h6 class="fw-bold text-dark mt-1 mb-1 fs-6" style="font-size: 13.5px; line-height: 1.3;">{{ Str::limit($address, 32) }}</h6>
                        <p class="text-muted small mb-3" style="font-size: 12px;">সরাসরি ভিজিট করতে পারেন</p>
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ rawurlencode($address) }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-danger rounded-pill w-100 fw-bold py-1.5" style="font-size: 12.5px;">
                        <i class="fa-solid fa-map-location-dot me-1"></i> ম্যাপে দেখুন
                    </a>
                </div>
            </div>
        </div>

        {{-- 3. MAIN SECTION: CONTACT FORM & STORE INFO --}}
        <div class="row g-4 mb-5">
            {{-- LEFT: CONTACT FORM --}}
            <div class="col-lg-7">
                <div class="p-4 p-md-5 rounded-4 bg-white border shadow-sm h-100">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2 bg-primary bg-opacity-10 text-primary fw-bold" style="font-size: 11px; letter-spacing: 0.06em;">
                        <i class="fa-solid fa-paper-plane"></i> SEND US A MESSAGE
                    </div>
                    <h3 class="fw-bold text-dark mb-1" style="font-size: 24px;">একটি বার্তা পাঠান</h3>
                    <p class="text-muted small mb-4">নিচের ফর্মটি পূরণ করে আপনার বার্তা বা প্রস্তাব পাঠান। আমাদের কাস্টমার কেয়ার প্রতিনিধি দ্রুততম সময়ে রিপ্লাই দেবেন।</p>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 d-flex align-items-center gap-2" role="alert">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                            <div class="fw-bold d-flex align-items-center gap-2 mb-1">
                                <i class="fa-solid fa-triangle-exclamation"></i> অনুগ্রহ করে নিচের ভুলগুলো সংশোধন করুন:
                            </div>
                            <ul class="mb-0 small ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" data-contact-form>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="contact-name" class="form-label fw-semibold small text-dark mb-1">আপনার নাম <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user small"></i></span>
                                    <input id="contact-name" name="name" type="text" class="form-control border-start-0 shadow-none @error('name') is-invalid @enderror" placeholder="যেমন: মো: হাসিবুর রহমান" value="{{ old('name') }}" required maxlength="255">
                                </div>
                                @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="contact-phone" class="form-label fw-semibold small text-dark mb-1">মোবাইল নম্বর (ঐচ্ছিক)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-phone small"></i></span>
                                    <input id="contact-phone" name="phone" type="tel" class="form-control border-start-0 shadow-none @error('phone') is-invalid @enderror" placeholder="01XXXXXXXXX" value="{{ old('phone') }}" maxlength="30">
                                </div>
                                @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="contact-email" class="form-label fw-semibold small text-dark mb-1">ইমেইল অ্যাড্রেস <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope small"></i></span>
                                    <input id="contact-email" name="email" type="email" class="form-control border-start-0 shadow-none @error('email') is-invalid @enderror" placeholder="example@gmail.com" value="{{ old('email') }}" required maxlength="255">
                                </div>
                                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="contact-subject" class="form-label fw-semibold small text-dark mb-1">বিষয় (Subject) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-tag small"></i></span>
                                    <input id="contact-subject" name="subject" type="text" class="form-control border-start-0 shadow-none @error('subject') is-invalid @enderror" placeholder="যেমন: কাস্টম অর্ডার বা ডেলিভারি তথ্য" value="{{ old('subject') }}" required maxlength="255">
                                </div>
                                @error('subject')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="contact-message" class="form-label fw-semibold small text-dark mb-1">আপনার বার্তা বা বিস্তারিত তথ্য <span class="text-danger">*</span></label>
                                <textarea id="contact-message" name="message" rows="5" class="form-control shadow-none @error('message') is-invalid @enderror" placeholder="আপনার পণ্যের ধরন, পরিমাণ বা যেকোনো প্রয়োজনীয় তথ্য বিস্তারিত লিখুন…" required maxlength="5000">{{ old('message') }}</textarea>
                                @error('message')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 pt-2">
                                <button class="btn btn-dark w-100 py-3 rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm text-white" type="submit" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); font-size: 15px;">
                                    <span>বার্তা পাঠান (Send Message)</span>
                                    <i class="fa-solid fa-paper-plane small"></i>
                                </button>
                                <p class="text-muted text-center small mt-2 mb-0" style="font-size: 12px;">
                                    <i class="fa-solid fa-shield-halved text-success me-1"></i> আপনার তথ্য সম্পূর্ণ সুরক্ষিত রাখা হয়। <a href="{{ route('privacy.policy') }}" class="text-decoration-underline text-muted">গোপনীয়তা নীতি</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- RIGHT: STORE HIGHLIGHTS & OPERATING DETAILS --}}
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-3 h-100">
                    {{-- OPERATING HOURS CARD --}}
                    <div class="p-4 rounded-4 bg-white border shadow-xs">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                                <i class="fa-solid fa-clock fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">অফিস ও শোরুমের সময়সূচি</h6>
                                <p class="text-muted small mb-0" style="line-height: 1.6;">{{ $openingHours }}</p>
                                <small class="text-success fw-semibold mt-1 d-block"><i class="fa-solid fa-circle-check me-1"></i> ওয়েবসাইট থেকে ২৪/৭ অর্ডার গ্রহণ চালু রয়েছে</small>
                            </div>
                        </div>
                    </div>

                    {{-- FAST DELIVERY COMMITMENT --}}
                    <div class="p-4 rounded-4 bg-white border shadow-xs">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                                <i class="fa-solid fa-truck-fast fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">ডেলিভারির সময়সীমা</h6>
                                <p class="text-muted small mb-0" style="line-height: 1.6;">
                                    • ঢাকা সিটির ভেতরে: <strong>২৪ থেকে ৪৮ ঘণ্টার</strong> মধ্যে ডেলিভারি<br>
                                    • ঢাকা সিটির বাইরে (সারা দেশ): <strong>২ থেকে ৪ কার্যদিবসের</strong> মধ্যে দ্রুততম ডেলিভারি
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- CORPORATE & BULK ORDERS CARD --}}
                    <div class="p-4 rounded-4 text-white border-0 shadow-xs position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11px;">
                                <i class="fa-solid fa-crown me-1"></i> BULK & CORPORATE
                            </span>
                        </div>
                        <h6 class="fw-bold text-white mb-2 fs-6">কর্পোরেট গিফট ও বাল্ক অর্ডার</h6>
                        <p class="text-white-50 small mb-3" style="line-height: 1.5; font-size: 12.5px;">
                            আপনার ব্র্যান্ডের লোগো প্রিন্ট, কাস্টম এমবসিং, এক্সক্লুসিভ প্যাকেজিং এবং পাইকারি মূল্যছাড়ের বিশেষ সুবিধা উপভোগ করুন।
                        </p>
                        <a href="https://wa.me/{{ $cleanWhatsapp }}?text=Hello,%20I%20am%20interested%20in%20a%20bulk/corporate%20order." target="_blank" class="btn btn-sm btn-light rounded-pill px-3 py-1.5 fw-bold" style="font-size: 12.5px;">
                            <i class="fa-brands fa-whatsapp text-success me-1"></i> বাল্ক কোটেশন চান?
                        </a>
                    </div>

                    {{-- PHYSICAL ADDRESS PREVIEW --}}
                    <div class="p-4 rounded-4 bg-white border shadow-xs">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                                <i class="fa-solid fa-building-flag fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ $brandName }} অফিস ঠিকানা</h6>
                                <p class="text-muted small mb-2">{{ $address }}</p>
                                <a href="https://www.google.com/maps/search/?api=1&query={{ rawurlencode($address) }}" target="_blank" rel="noopener noreferrer" class="text-primary small fw-semibold text-decoration-none">
                                    Google Maps-এ ডিরেকশন নিন <i class="fa-solid fa-arrow-up-right-from-square small ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. BOTTOM QUICK HELP / POLICY SHORTCUTS --}}
        <div class="p-4 rounded-4 bg-white border shadow-xs">
            <div class="row align-items-center g-3">
                <div class="col-md-4">
                    <span class="d-block small text-muted text-uppercase fw-bold" style="letter-spacing: 0.05em; font-size: 11px;">HELP & FAQs</span>
                    <h5 class="fw-bold text-dark mb-0">প্রয়োজনীয় লিংক ও তথ্য</h5>
                </div>
                <div class="col-md-8">
                    <div class="d-flex align-items-center flex-wrap gap-2 gap-md-3 justify-content-md-end">
                        <a href="{{ route('track.order') }}" class="btn btn-sm btn-light border rounded-pill px-3 py-2 fw-semibold text-dark text-decoration-none">
                            <i class="fa-solid fa-truck text-primary me-1"></i> অর্ডার ট্র্যাক করুন
                        </a>
                        <a href="{{ route('shipping.policy') }}" class="btn btn-sm btn-light border rounded-pill px-3 py-2 fw-semibold text-dark text-decoration-none">
                            <i class="fa-solid fa-box text-success me-1"></i> ডেলিভারি পলিসি
                        </a>
                        <a href="{{ route('return.policy') }}" class="btn btn-sm btn-light border rounded-pill px-3 py-2 fw-semibold text-dark text-decoration-none">
                            <i class="fa-solid fa-rotate-left text-warning me-1"></i> রিটার্ন পলিসি
                        </a>
                        <a href="{{ route('faq') }}" class="btn btn-sm btn-light border rounded-pill px-3 py-2 fw-semibold text-dark text-decoration-none">
                            <i class="fa-solid fa-circle-question text-info me-1"></i> সাধারণ জিজ্ঞাসা
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('[data-contact-form]');
        if (!form) return;

        form.addEventListener('submit', function(event) {
            if (this.dataset.busy) {
                event.preventDefault();
                return;
            }
            this.dataset.busy = 'true';
            const button = this.querySelector('button[type=submit]');
            if (button) {
                button.disabled = true;
                button.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> পাঠানো হচ্ছে…';
            }
        });

        window.addEventListener('pageshow', function() {
            delete form.dataset.busy;
            const button = form.querySelector('button[type=submit]');
            if (button) {
                button.disabled = false;
                button.innerHTML = '<span>বার্তা পাঠান (Send Message)</span> <i class="fa-solid fa-paper-plane small"></i>';
            }
        });
    });
</script>
@endpush
