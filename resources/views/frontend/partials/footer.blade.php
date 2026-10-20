<section class="ub-newsletter">
    <div class="container ub-newsletter-inner">
        <div>
            <span class="ub-eyebrow">A LITTLE INSPIRATION</span>
            <h2>Good ideas. Straight to your inbox.</h2>
            <p>Discover new arrivals and what's happening at Unibox.</p>
        </div>
        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="ub-newsletter-form">
            @csrf
            <label class="visually-hidden" for="newsletter-email">Email address</label>
            <input id="newsletter-email" type="email" name="email" placeholder="Enter your email address" required
                autocomplete="email">
            <button type="submit" aria-label="Subscribe to newsletter">
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </button>
        </form>
    </div>
</section>

<footer class="ub-footer">
    <div class="container">
        <div class="ub-footer-grid">
            {{-- BRAND & ABOUT --}}
            <div class="ub-footer-about">
                <a class="ub-brand ub-footer-logo mb-3 d-inline-block" href="{{ route('home') }}" aria-label="Unibox home">
                    @if(setting('footer_logo') && file_exists(public_path(setting('footer_logo'))))
                        <img src="{{ asset(setting('footer_logo')) }}" alt="Unibox" width="180" height="60" style="max-height: 52px; object-fit: contain;" loading="lazy">
                    @else
                        <span class="fw-bold fs-3 text-white">unibox</span>
                    @endif
                </a>
                <p>{{ setting('footer_about', 'Products with purpose. Thoughtfully crafted details for your business, everyday, and celebrations.') }}</p>
                <a class="ub-footer-contact" href="{{ route('contact.us') }}">
                    Let's create something together <i class="fa-solid fa-arrow-up-right-from-square ms-1" aria-hidden="true"></i>
                </a>
            </div>

            {{-- EXPLORE --}}
            <div>
                <h3>Explore</h3>
                <a href="{{ route('search') }}">All Products</a>
                <a href="{{ route('shop.bestsellers') }}">Bestsellers</a>
                <a href="{{ route('about.us') }}">About Unibox</a>
                <a href="{{ route('our-blogs') }}">Our Journal</a>
            </div>

            {{-- HELP & POLICIES --}}
            <div>
                <h3>Here to Help</h3>
                <a href="{{ route('contact.us') }}">Contact Us</a>
                <a href="{{ route('track.order') }}">Track an Order</a>
                <a href="{{ route('shipping.policy') }}">Shipping & Delivery</a>
                <a href="{{ route('return.policy') }}">Returns Policy</a>
                <a href="{{ route('faq') }}">FAQs</a>
            </div>

            {{-- CONTACT & SOCIAL --}}
            <div>
                <h3>Get in Touch</h3>
                @if (setting('phone'))
                    <a href="tel:{{ preg_replace('/[^+0-9]/', '', setting('phone')) }}"><i class="fa-solid fa-phone me-1 small"></i> {{ setting('phone') }}</a>
                @endif
                @if (setting('email'))
                    <a href="mailto:{{ setting('email') }}"><i class="fa-solid fa-envelope me-1 small"></i> {{ setting('email') }}</a>
                @endif
                <p class="mb-2"><i class="fa-solid fa-location-dot me-1 small text-danger"></i> {{ setting('company_address', setting('address', '278/3/A, Sardar Villa, 5th Floor Kataban Dhal, Kataban')) }}</p>
                <span class="ub-payment-note mb-3 d-inline-block"><i class="fa-solid fa-hand-holding-dollar text-success me-1"></i> Cash on delivery available</span>

                {{-- SOCIAL MEDIA CHANNELS --}}
                <div class="d-flex align-items-center gap-2 mt-2 pt-2 border-top border-secondary border-opacity-25">
                    @if(setting('facebook'))
                        <a href="{{ setting('facebook') }}" target="_blank" class="text-light" title="Facebook" style="font-size: 16px;"><i class="fa-brands fa-facebook"></i></a>
                    @endif
                    @if(setting('instagram'))
                        <a href="{{ setting('instagram') }}" target="_blank" class="text-light" title="Instagram" style="font-size: 16px;"><i class="fa-brands fa-instagram"></i></a>
                    @endif
                    @if(setting('youtube'))
                        <a href="{{ setting('youtube') }}" target="_blank" class="text-light" title="YouTube" style="font-size: 16px;"><i class="fa-brands fa-youtube"></i></a>
                    @endif
                    @if(setting('whatsapp'))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp')) }}" target="_blank" class="text-success" title="WhatsApp" style="font-size: 16px;"><i class="fa-brands fa-whatsapp"></i></a>
                    @endif
                    @if(setting('twitter'))
                        <a href="{{ setting('twitter') }}" target="_blank" class="text-light" title="Twitter / X" style="font-size: 16px;"><i class="fa-brands fa-x-twitter"></i></a>
                    @endif
                    @if(setting('tiktok'))
                        <a href="{{ setting('tiktok') }}" target="_blank" class="text-light" title="TikTok" style="font-size: 16px;"><i class="fa-brands fa-tiktok"></i></a>
                    @endif
                </div>
            </div>
        </div>

        {{-- FOOTER BOTTOM --}}
        <div class="ub-footer-bottom">
            <span>{{ setting('copyright_text', '© ' . date('Y') . ' Unibox BD. All rights reserved.') }}</span>
            <div>
                <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                <a href="{{ route('terms.conditions') }}">Terms & Conditions</a>
                <a href="{{ route('shipping.policy') }}">Shipping Policy</a>
            </div>
            <span>Thoughtfully chosen. Simply yours.</span>
        </div>
    </div>
</footer>
