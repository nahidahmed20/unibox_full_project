@extends('frontend.layouts.app')
@section('title', 'Your account')
@push('css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/account.css') }}?v={{ filemtime(public_path('frontend/assets/css/account.css')) }}">
@endpush
@section('content')
<section class="ub-account-page">
 <div class="container"><div class="ub-login-layout">
  <div class="ub-login-story">
   <span class="ub-eyebrow">YOUR UNIBOX ACCOUNT</span>
   <h1>A little more<br>personal.</h1>
   <p>Your orders, your details, and everything you're making next. All in one place.</p>
   <div class="ub-login-benefits"><span><i class="fa-regular fa-bag-shopping" aria-hidden="true"></i> Keep track of every order</span><span><i class="fa-regular fa-user" aria-hidden="true"></i> Manage your personal details</span><span><i class="fa-regular fa-heart" aria-hidden="true"></i> Pick up where you left off</span></div>
  </div>
  <div class="ub-login-form">
   @if(session()->has('otp_login'))
    <span class="ub-eyebrow">ONE LAST STEP</span><h2>Check your phone</h2>
    <p>Enter the 4-digit code sent to <strong>{{ session('otp_login') }}</strong>.</p>
    <form method="POST" action="{{ route('account.otp.verify') }}" data-login-form>
     @csrf
     <label for="login-otp">Verification code</label>
     <input id="login-otp" class="ub-otp-input" type="text" name="otp" inputmode="numeric" pattern="[0-9]{4}" minlength="4" maxlength="4" autocomplete="one-time-code" required autofocus placeholder="0000">
     @error('otp')<p class="ub-login-error" role="alert">{{ $message }}</p>@enderror
     @if(session('error'))<p class="ub-login-error" role="alert">{{ session('error') }}</p>@endif
     <button type="submit" class="ub-button ub-button-primary">Verify & sign in <i class="fa-regular fa-arrow-right" aria-hidden="true"></i></button>
    </form>
    <div class="ub-otp-actions">
     <span id="otp-countdown" data-expires="{{ session('otp_expires_at', 0) }}" role="timer"></span>
     <form method="POST" action="{{ route('account.otp.send') }}" data-login-form>
      @csrf<input type="hidden" name="name" value="{{ session('otp_login') }}"><button id="otp-resend" type="submit" hidden>Resend code</button>
     </form>
     <a href="{{ route('account.otp.cancel') }}">Change number</a>
    </div>
   @else
    <span class="ub-eyebrow">WELCOME BACK</span><h2>Make yourself at home.</h2>
    <p>Sign in or create your account with your mobile number.</p>
    <form method="POST" action="{{ route('account.otp.send') }}" data-login-form>
     @csrf<label for="login-phone">Mobile number</label>
     <input id="login-phone" type="tel" name="name" value="{{ old('name') }}" inputmode="tel" autocomplete="tel-national" pattern="01[3-9][0-9]{8}" maxlength="11" placeholder="01XXXXXXXXX" required aria-describedby="phone-help">
     <p id="phone-help" class="ub-login-note">We'll send you a verification code by SMS.</p>
     @error('name')<p class="ub-login-error" role="alert">{{ $message }}</p>@enderror
     <button type="submit" class="ub-button ub-button-primary">Send verification code <i class="fa-regular fa-arrow-right" aria-hidden="true"></i></button>
    </form>
    @if(config('services.google.client_id') && config('services.google.client_secret'))
     <a class="ub-button ub-button-outline" href="{{ route('login.google') }}"><i class="fa-brands fa-google" aria-hidden="true"></i> Continue with Google</a>
    @endif
   @endif
   <p class="ub-login-note">Read our <a href="{{ route('privacy.policy') }}">privacy policy</a> and <a href="{{ route('terms.conditions') }}">terms & conditions</a>.</p>
  </div>
 </div></div>
</section>
@endsection
@push('javascript')
<script src="{{ asset('frontend/assets/js/account.js') }}?v={{ filemtime(public_path('frontend/assets/js/account.js')) }}" defer></script>
@endpush
