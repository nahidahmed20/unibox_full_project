@php
    $footerBrand = setting('website_title') ?: setting('company_name', 'Unibox');
    $footerLogo = setting('footer_logo', setting('header_logo', setting('logo')));
    $phone = setting('hotline', setting('phone', '01640914338'));
    $cleanPhone = preg_replace('/[^+0-9]/', '', $phone);
    $whatsapp = setting('whatsapp', $phone);
    $cleanWhatsapp = preg_replace('/[^0-9]/', '', $whatsapp);
    $address = setting('company_address', setting('address', '278/3/A, Sardar Villa, 5th Floor Kataban Dhal, Kataban'));
    $email = setting('email', 'support@unibox4u.com');
@endphp

{{-- =========================================================
     1. TRUST FEATURES STRIP (TOP-TIER E-COMMERCE)
     ========================================================= --}}
<div class="ub-footer-trust-strip">
    <div class="container">
        <div class="row g-3 g-lg-4 text-center text-sm-start">
            <div class="col-6 col-md-3">
                <div class="ub-trust-item d-flex align-items-center gap-3">
                    <div class="ub-trust-icon-box text-primary">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark fs-6">সারা দেশে ডেলিভারি</h6>
                        <small class="text-muted">ক্যাশ অন ডেলিভারি সুবিধা</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="ub-trust-item d-flex align-items-center gap-3">
                    <div class="ub-trust-icon-box text-success">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark fs-6">১০০% আসল পণ্য</h6>
                        <small class="text-muted">গুণগত মান নিশ্চিত</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="ub-trust-item d-flex align-items-center gap-3">
                    <div class="ub-trust-icon-box text-warning">
                        <i class="fa-solid fa-arrow-rotate-left"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark fs-6">সহজ রিটার্ন</h6>
                        <small class="text-muted">সমস্যা হলে দ্রুত রিপ্লেসমেন্ট</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="ub-trust-item d-flex align-items-center gap-3">
                    <div class="ub-trust-icon-box text-info">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark fs-6">কাস্টমার কেয়ার</h6>
                        <small class="text-muted">সরাসরি ফোন ও হোয়াটসঅ্যাপ</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =========================================================
     2. LUXURY NEWSLETTER & OFFERS SHOWCASE
     ========================================================= --}}
<section class="ub-newsletter-luxury py-4 py-md-5">
    <div class="container">
        <div class="ub-newsletter-card">
            <div class="row align-items-center g-4">
                {{-- LEFT COLUMN: OFFER HEADLINE & BENEFITS --}}
                <div class="col-lg-7 col-md-6 text-center text-md-start">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3 ub-offer-badge">
                        <i class="fa-solid fa-gift text-warning"></i>
                        <span class="fw-bold">NEWSLETTER & SPECIAL OFFERS</span>
                    </div>
                    <h2 class="ub-newsletter-title">
                        যুক্ত থাকুন আমাদের সাথে, পান এক্সক্লুসিভ অফার!
                    </h2>
                    <p class="ub-newsletter-subtitle">
                        {{ $footerBrand }}-এর স্পেশাল ডিসকাউন্ট, সিক্রেট ভাউচার এবং নতুন কালেকশনের আপডেট সবার আগে পেতে এখনই সাবস্ক্রাইব করুন।
                    </p>
                    
                    <div class="ub-newsletter-perks d-flex flex-wrap justify-content-center justify-content-md-start gap-3 mt-3">
                        <span class="perk-item"><i class="fa-solid fa-circle-check text-success"></i> স্পেশাল ভাউচার ও ডিসকাউন্ট</span>
                        <span class="perk-item"><i class="fa-solid fa-circle-check text-success"></i> সাপ্তাহিক ফ্ল্যাশ সেল আপডেট</span>
                        <span class="perk-item"><i class="fa-solid fa-circle-check text-success"></i> নো স্প্যাম গ্যারান্টি</span>
                    </div>
                </div>

                {{-- RIGHT COLUMN: MODERN INPUT FORM --}}
                <div class="col-lg-5 col-md-6">
                    <div class="ub-newsletter-form-box">
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="ub-luxury-subscribe-form">
                            @csrf
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control border-start-0 border-end-0 shadow-none ps-2" placeholder="আপনার ইমেইল অ্যাড্রেস লিখুন..." required autocomplete="email">
                                <button type="submit" class="btn btn-dark fw-bold px-3 px-sm-4 d-flex align-items-center gap-2">
                                    <span>সাবস্ক্রাইব</span>
                                    <i class="fa-solid fa-paper-plane small"></i>
                                </button>
                            </div>
                        </form>
                        <p class="small text-muted mt-2 mb-0 d-flex align-items-center justify-content-center justify-content-md-start gap-1" style="font-size: 11.5px;">
                            <i class="fa-solid fa-shield-halved text-success"></i> আপনার ইমেইল তথ্য সম্পূর্ণ সুরক্ষিত থাকবে।
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
     3. MASTER LUXURY FOOTER
     ========================================================= --}}
<footer class="ub-footer">
    <div class="container">
        <div class="ub-footer-grid">
            
            {{-- COLUMN 1: BRAND IDENTITY & ASSISTANCE --}}
            <div class="ub-footer-about">
                <a class="ub-brand ub-footer-logo mb-3 d-inline-block text-decoration-none" href="{{ route('home') }}" aria-label="{{ $footerBrand }} home">
                    @if($footerLogo && file_exists(public_path($footerLogo)))
                        <img src="{{ asset($footerLogo) }}" alt="{{ $footerBrand }}" width="180" height="60" style="max-height: 50px; object-fit: contain;" loading="lazy">
                    @else
                        <span class="fw-bold fs-3 text-white">{{ $footerBrand }}</span>
                    @endif
                </a>
                <p class="text-light opacity-75 small mb-3" style="line-height: 1.7;">
                    {{ setting('footer_about', 'প্রিমিয়াম কোয়ালিটি ও আধুনিক জীবনের প্রয়োজনীয় পণ্য নিয়ে আপনার আস্থার ঠিকানা। দ্রুত ডেলিভারি ও সেরা গ্রাহক সেবাই আমাদের প্রতিশ্রুতি।') }}
                </p>

                <div class="d-flex flex-wrap gap-2 mt-3">
                    @if($whatsapp)
                        <a href="https://wa.me/{{ $cleanWhatsapp }}" target="_blank" class="ub-footer-quick-badge">
                            <i class="fa-brands fa-whatsapp text-success fs-6"></i>
                            <span>WhatsApp Support</span>
                        </a>
                    @endif
                    @if($phone)
                        <a href="tel:{{ $cleanPhone }}" class="ub-footer-quick-badge">
                            <i class="fa-solid fa-phone text-info fs-6"></i>
                            <span>{{ $phone }}</span>
                        </a>
                    @endif
                </div>
            </div>

            {{-- COLUMN 2: QUICK LINKS / SHOP --}}
            <div>
                <h3>প্রয়োজনীয় লিংক</h3>
                <div class="ub-footer-links">
                    <a href="{{ route('search') }}"><i class="fa-solid fa-angle-right small opacity-50"></i> সকল প্রোডাক্ট (All Products)</a>
                    <a href="{{ route('shop.bestsellers') }}"><i class="fa-solid fa-angle-right small opacity-50"></i> বেস্ট সেলার্স (Bestsellers)</a>
                    <a href="{{ route('about.us') }}"><i class="fa-solid fa-angle-right small opacity-50"></i> আমাদের সম্পর্কে (About Us)</a>
                    <a href="{{ route('our-blogs') }}"><i class="fa-solid fa-angle-right small opacity-50"></i> ব্লগ ও আর্টিকেল (Our Journal)</a>
                    <a href="{{ route('contact.us') }}"><i class="fa-solid fa-angle-right small opacity-50"></i> যোগাযোগ করুন (Contact)</a>
                </div>
            </div>

            {{-- COLUMN 3: CUSTOMER CARE & POLICIES --}}
            <div>
                <h3>গ্রাহক সেবা ও পলিসি</h3>
                <div class="ub-footer-links">
                    <a href="{{ route('track.order') }}"><i class="fa-solid fa-truck-fast text-info small"></i> অর্ডার ট্র্যাক করুন (Track Order)</a>
                    <a href="{{ route('shipping.policy') }}"><i class="fa-solid fa-angle-right small opacity-50"></i> ডেলিভারি পলিসি (Shipping)</a>
                    <a href="{{ route('return.policy') }}"><i class="fa-solid fa-angle-right small opacity-50"></i> রিটার্ন ও রিফান্ড (Returns)</a>
                    <a href="{{ route('terms.conditions') }}"><i class="fa-solid fa-angle-right small opacity-50"></i> শর্তাবলী (Terms & Conditions)</a>
                    <a href="{{ route('privacy.policy') }}"><i class="fa-solid fa-angle-right small opacity-50"></i> গোপনীয়তা নীতি (Privacy Policy)</a>
                    <a href="{{ route('faq') }}"><i class="fa-solid fa-angle-right small opacity-50"></i> সাধারণ জিজ্ঞাসা (FAQs)</a>
                </div>
            </div>

            {{-- COLUMN 4: CONTACT & SOCIAL --}}
            <div>
                <h3>যোগাযোগ ও ঠিকানা</h3>
                <div class="d-flex flex-column gap-2 text-light opacity-80 small mb-3">
                    @if ($phone)
                        <div><i class="fa-solid fa-phone-volume me-2 text-primary"></i> <a href="tel:{{ $cleanPhone }}" class="text-light text-decoration-none fw-semibold">{{ $phone }}</a></div>
                    @endif
                    @if ($email)
                        <div><i class="fa-solid fa-envelope me-2 text-warning"></i> <a href="mailto:{{ $email }}" class="text-light text-decoration-none">{{ $email }}</a></div>
                    @endif
                    @if ($address)
                        <div class="d-flex align-items-start gap-2 mt-1">
                            <i class="fa-solid fa-location-dot text-danger mt-1"></i>
                            <span>{{ $address }}</span>
                        </div>
                    @endif
                    <div class="mt-1 text-success d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>ক্যাশ অন ডেলিভারি সারা দেশে সহজলভ্য</span>
                    </div>
                </div>

                {{-- SOCIAL MEDIA CHANNELS --}}
                <div class="d-flex align-items-center gap-2 mt-3 pt-3 border-top border-secondary border-opacity-25 flex-wrap">
                    @php
                        $fb = setting('facebook') ?: 'https://facebook.com';
                        $insta = setting('instagram') ?: 'https://instagram.com';
                        $yt = setting('youtube') ?: 'https://youtube.com';
                        $waUrl = $whatsapp ? 'https://wa.me/' . $cleanWhatsapp : ($phone ? 'https://wa.me/' . $cleanPhone : 'https://wa.me/8801640914338');
                        $tiktok = setting('tiktok');
                        $twitter = setting('twitter');
                    @endphp
                    @if($fb)
                        <a href="{{ $fb }}" target="_blank" rel="noopener" class="ub-footer-social-btn facebook" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    @endif
                    @if($insta)
                        <a href="{{ $insta }}" target="_blank" rel="noopener" class="ub-footer-social-btn instagram" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    @endif
                    @if($yt)
                        <a href="{{ $yt }}" target="_blank" rel="noopener" class="ub-footer-social-btn youtube" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    @endif
                    @if($waUrl)
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="ub-footer-social-btn whatsapp" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    @endif
                    @if($tiktok)
                        <a href="{{ $tiktok }}" target="_blank" rel="noopener" class="ub-footer-social-btn tiktok" title="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                    @endif
                    @if($twitter)
                        <a href="{{ $twitter }}" target="_blank" rel="noopener" class="ub-footer-social-btn twitter" title="Twitter / X"><i class="fa-brands fa-x-twitter"></i></a>
                    @endif
                </div>
            </div>

        </div>

        {{-- FOOTER BOTTOM ROW --}}
        <div class="ub-footer-bottom">
            <span>{{ setting('copyright_text', '© ' . date('Y') . ' ' . $footerBrand . '. All rights reserved.') }}</span>
            <div class="d-flex align-items-center flex-wrap gap-2 gap-md-3">
                <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                <span>•</span>
                <a href="{{ route('terms.conditions') }}">Terms & Conditions</a>
                <span>•</span>
                <a href="{{ route('shipping.policy') }}">Shipping Policy</a>
            </div>
            <div class="d-flex align-items-center gap-2 opacity-75">
                <i class="fa-solid fa-shield-halved text-success"></i>
                <small>100% Safe & Secure Shopping</small>
            </div>
        </div>
    </div>
</footer>
