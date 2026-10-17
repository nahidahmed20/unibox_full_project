@extends('frontend.layouts.app')
@section('title', 'Let’s talk')
@push('css')
    <link rel="stylesheet"
        href="{{ asset('frontend/assets/css/info-pages.css') }}?v={{ filemtime(public_path('frontend/assets/css/info-pages.css')) }}">
@endpush
@section('content')

    @php
        $address = setting('address', '278/3/A, Sardar Villa, 5th Floor, Kataban Dhal, Kataban');
        $phone = setting('phone');
        $email = setting('email', 'uniboxbd4u@gmail.com');
    @endphp
    <section class="ub-info-intro container"><span class="ub-eyebrow">WE’RE HERE TO HELP</span>
        <h1>Good conversations.<span>Great possibilities.</span></h1>
        <p>A question about your order, a custom idea, or just getting started? Let’s talk.</p>
    </section>
    <section class="container ub-contact-layout">
        <aside class="ub-contact-details"><span class="ub-eyebrow">GET IN TOUCH</span>
            <h2>A real person. A helping hand.</h2>
            <p>Choose how you’d like to reach us, or leave a message using the form.</p>
            @if ($phone)
                <a class="ub-contact-method" href="tel:{{ preg_replace('/[^+0-9]/', '', $phone) }}"><i
                        class="fa-regular fa-phone" aria-hidden="true"></i><span><small>GIVE US A
                            CALL</small><strong>{{ $phone }}</strong></span><i class="fa-regular fa-arrow-up-right"
                        aria-hidden="true"></i></a>
            @endif
            @if ($email)
                <a class="ub-contact-method" href="mailto:{{ $email }}"><i class="fa-regular fa-envelope"
                        aria-hidden="true"></i><span><small>DROP US A
                            LINE</small><strong>{{ $email }}</strong></span><i class="fa-regular fa-arrow-up-right"
                        aria-hidden="true"></i></a>
            @endif
            @if ($address)
                <div class="ub-contact-method"><i class="fa-regular fa-location-dot"
                        aria-hidden="true"></i><span><small>FIND US</small><strong>{{ $address }}</strong><a
                            class="ub-text-link"
                            href="https://www.google.com/maps/search/?api=1&query={{ rawurlencode($address) }}"
                            target="_blank" rel="noopener noreferrer">Get directions ↗</a></span></div>
            @endif
            <div class="ub-contact-hours"><i class="fa-regular fa-clock" aria-hidden="true"></i>
                <div>
                    <h3>Opening hours</h3>
                    <p>{{ setting('opening_hours', 'Saturday–Thursday, 9:00 AM–8:00 PM. Friday closed.') }}</p>
                </div>
            </div>
        </aside>
        <div class="ub-contact-form"><span class="ub-eyebrow">START A CONVERSATION</span>
            <h2>How can we help?</h2>
            <p>Share a few details and your message with our team.</p>
            @if (session('success'))
                <div class="ub-form-success" role="status">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="ub-form-error" role="alert">Please check the highlighted fields below.</div>
            @endif
            <form action="{{ route('contact.store') }}" method="POST" data-contact-form>
                @csrf
                <div class="ub-contact-fields">
                    @foreach ([['name', 'Your name', 'text', 'name', true], ['email', 'Email address', 'email', 'email', true], ['phone', 'Phone number (optional)', 'tel', 'tel', false], ['subject', 'Subject', 'text', 'off', true]] as [$field, $label, $type, $autocomplete, $required])
                        <div><label for="contact-{{ $field }}">{{ $label }}@if ($required)
                                    <span aria-hidden="true"> *</span>
                                @endif
                            </label>
                            <input id="contact-{{ $field }}" name="{{ $field }}" type="{{ $type }}"
                                autocomplete="{{ $autocomplete }}" value="{{ old($field) }}"
                                maxlength="{{ $field === 'phone' ? 30 : 255 }}"
                                @if ($required) required @endif
                                @error($field) aria-invalid="true" aria-describedby="error-{{ $field }}" @enderror>
                            @error($field)
                                <p class="ub-form-error" id="error-{{ $field }}">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
                <label for="contact-message">Your message <span aria-hidden="true">*</span></label>
                <textarea id="contact-message" name="message" rows="6" maxlength="5000"
                    placeholder="Tell us about your order, your idea, or what you need help with…" required
                    @error('message') aria-invalid="true" aria-describedby="error-message" @enderror>{{ old('message') }}</textarea>
                @error('message')
                    <p class="ub-form-error" id="error-message">{{ $message }}</p>
                @enderror
                <div class="ub-contact-submit">
                    <p>Your details are used to respond to your enquiry. <a href="{{ route('privacy.policy') }}">Privacy
                            policy</a></p><button class="ub-button ub-button-primary" type="submit">Send message <i
                            class="fa-regular fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </form>
        </div>
    </section>
    <section class="container ub-contact-help">
        <div><span class="ub-eyebrow">LOOKING FOR A QUICK ANSWER?</span>
            <h2>A little help, right here.</h2>
        </div>
        <div class="ub-help-links"><a href="{{ route('track.order') }}"><i class="fa-regular fa-box"
                    aria-hidden="true"></i>Track your order <span>↗</span></a><a href="{{ route('shipping.policy') }}"><i
                    class="fa-regular fa-truck" aria-hidden="true"></i>Shipping & delivery <span>↗</span></a><a
                href="{{ route('faq') }}"><i class="fa-regular fa-circle-question" aria-hidden="true"></i>Common questions
                <span>↗</span></a></div>
    </section>
@endsection
@push('javascript')
    <script>
        document.querySelector('[data-contact-form]').addEventListener('submit', function(event) {
            if (this.dataset.busy) {
                event.preventDefault();
                return;
            }
            this.dataset.busy = 'true';
            const button = this.querySelector('button[type=submit]');
            button.disabled = true;
            button.textContent = 'Sending your message…';
        });
        window.addEventListener('pageshow', () => {
            const form = document.querySelector('[data-contact-form]');
            delete form.dataset.busy;
            const button = form.querySelector('button[type=submit]');
            button.disabled = false;
            button.textContent = 'Send message';
        });
    </script>
@endpush
