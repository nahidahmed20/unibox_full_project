<section class="ub-newsletter">
    <div class="container ub-newsletter-inner">
        <div><span class="ub-eyebrow">A LITTLE INSPIRATION</span>
            <h2>Good ideas. Straight to your inbox.</h2>
            <p>Discover new arrivals and what's happening at Unibox.</p>
        </div>
        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="ub-newsletter-form">
            @csrf
            <label class="visually-hidden" for="newsletter-email">Email address</label>
            <input id="newsletter-email" type="email" name="email" placeholder="Enter your email address" required
                autocomplete="email">
            <button type="submit" aria-label="Subscribe to newsletter"><i class="fa-regular fa-arrow-right"
                    aria-hidden="true"></i></button>
        </form>
    </div>
</section>
<footer class="ub-footer">
    <div class="container">
        <div class="ub-footer-grid">
            <div class="ub-footer-about"><a class="ub-brand ub-footer-logo" href="{{ route('home') }}" aria-label="Unibox home">
                    @if(setting('footer_logo'))
                        <img src="{{ asset(setting('footer_logo')) }}" alt="Unibox" width="180" height="64" loading="lazy">
                    @else
                        <span>unibox</span>
                    @endif
                </a>
                <p>Products with purpose. Details that make a difference.</p><a class="ub-footer-contact"
                    href="{{ route('contact.us') }}">Let's create something together <i
                        class="fa-regular fa-arrow-up-right" aria-hidden="true"></i></a>
            </div>
            <div>
                <h3>Explore</h3><a href="{{ route('search') }}">All products</a><a
                    href="{{ route('shop.bestsellers') }}">Bestsellers</a><a href="{{ route('about.us') }}">About
                    Unibox</a><a href="{{ route('our-blogs') }}">Our journal</a>
            </div>
            <div>
                <h3>Here to help</h3><a href="{{ route('contact.us') }}">Contact us</a><a
                    href="{{ route('track.order') }}">Track an order</a><a
                    href="{{ route('shipping.policy') }}">Shipping & delivery</a><a
                    href="{{ route('return.policy') }}">Returns policy</a><a href="{{ route('faq') }}">FAQs</a>
            </div>
            <div>
                <h3>Get in touch</h3>
                @if (setting('phone'))
                    <a href="tel:{{ setting('phone') }}">{{ setting('phone') }}</a>
                    @endif @if (setting('email'))
                        <a href="mailto:{{ setting('email') }}">{{ setting('email') }}</a>
                    @endif
                    <p>{{ setting('address', 'Bangladesh') }}</p><span class="ub-payment-note"><i
                            class="fa-regular fa-wallet" aria-hidden="true"></i> Cash on delivery</span>
            </div>
        </div>
        <div class="ub-footer-bottom"><span>© {{ date('Y') }} Unibox. All rights reserved.</span>
            <div><a href="{{ route('privacy.policy') }}">Privacy policy</a><a
                    href="{{ route('terms.conditions') }}">Terms & conditions</a></div><span>Thoughtfully chosen.
                Simply yours.</span>
        </div>
    </div>
</footer>
