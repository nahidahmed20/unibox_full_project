@extends('frontend.layouts.app')
@section('title', 'Login / Sign Up')

@push('css')
<style>
    .rokomari-auth-wrapper {
        min-height: calc(100vh - 260px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 15px;
        background-color: #f8fafc;
    }
    .rokomari-auth-card {
        width: 100%;
        max-width: 440px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.06), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
        padding: 36px 32px;
        margin: 0 auto;
    }
    .rokomari-auth-logo {
        text-align: center;
        margin-bottom: 24px;
    }
    .rokomari-auth-logo img {
        max-height: 44px;
        object-fit: contain;
    }
    .rokomari-auth-title {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
        text-align: center;
    }
    .rokomari-auth-subtitle {
        font-size: 13.5px;
        color: #64748b;
        margin-bottom: 24px;
        text-align: center;
        line-height: 1.5;
    }
    .rokomari-phone-group .input-group-text {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
        font-weight: 600;
        color: #334155;
        font-size: 15px;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        padding-left: 14px;
        padding-right: 14px;
    }
    .rokomari-phone-group .form-control {
        border-color: #cbd5e1;
        font-size: 16px;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        height: 50px;
        padding-left: 14px;
    }
    .rokomari-phone-group .form-control:focus {
        border-color: #0f172a;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
    }
    .rokomari-auth-btn {
        width: 100%;
        height: 50px;
        background: #0f172a;
        color: #ffffff;
        font-size: 15px;
        font-weight: 600;
        border-radius: 10px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        margin-top: 18px;
    }
    .rokomari-auth-btn:hover {
        background: #1e293b;
        color: #ffffff;
        transform: translateY(-1px);
    }
    .rokomari-divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 22px 0;
        color: #94a3b8;
        font-size: 13px;
        font-weight: 500;
    }
    .rokomari-divider::before,
    .rokomari-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e2e8f0;
    }
    .rokomari-divider:not(:empty)::before {
        margin-right: .75em;
    }
    .rokomari-divider:not(:empty)::after {
        margin-left: .75em;
    }
    .rokomari-google-btn {
        width: 100%;
        height: 48px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .rokomari-google-btn:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }
    .rokomari-otp-input {
        height: 56px;
        font-size: 26px !important;
        letter-spacing: 14px;
        text-align: center;
        font-weight: 700;
        border: 2px solid #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        transition: all 0.2s ease;
    }
    .rokomari-otp-input:focus {
        border-color: #0f172a;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.08);
    }
    .rokomari-auth-footer {
        margin-top: 24px;
        font-size: 12px;
        color: #64748b;
        text-align: center;
        line-height: 1.6;
    }
    .rokomari-auth-footer a {
        color: #0f172a;
        font-weight: 600;
        text-decoration: underline;
    }
    @media (max-width: 480px) {
        .rokomari-auth-wrapper {
            padding: 24px 12px;
        }
        .rokomari-auth-card {
            padding: 28px 20px;
            border-radius: 14px;
        }
        .rokomari-auth-title {
            font-size: 20px;
        }
        .rokomari-otp-input {
            letter-spacing: 8px;
            font-size: 22px !important;
        }
    }
</style>
@endpush

@section('content')
@php
    $brandName = setting('website_title') ?: setting('company_name', 'Unibox');
    $brandLogo = setting('header_logo', setting('logo'));
@endphp

<div class="rokomari-auth-wrapper">
    <div class="rokomari-auth-card">
        
        {{-- BRAND LOGO --}}
        <div class="rokomari-auth-logo">
            <a href="{{ route('home') }}" class="text-decoration-none">
                @if($brandLogo && file_exists(public_path($brandLogo)))
                    <img src="{{ asset($brandLogo) }}" alt="{{ $brandName }}">
                @else
                    <span class="fs-4 fw-bold text-dark">{{ $brandName }}</span>
                @endif
            </a>
        </div>

        @if(session()->has('otp_login'))
            {{-- ========================================================
                 STEP 2: OTP VERIFICATION (ROKOMARI STYLE)
                 ======================================================== --}}
            <h1 class="rokomari-auth-title">ওটিপি কোডটি লিখুন</h1>
            <p class="rokomari-auth-subtitle">
                <strong>{{ session('otp_login') }}</strong> নম্বরে ৪ ডিজিটের ভেরিফিকেশন কোড পাঠানো হয়েছে।<br>
                <a href="{{ route('account.otp.cancel') }}" class="text-primary fw-semibold small text-decoration-none d-inline-flex align-items-center gap-1 mt-1">
                    <i class="fa-regular fa-pen-to-square"></i> নম্বর পরিবর্তন করুন
                </a>
            </p>

            @if(session('dev_otp_notice'))
                <div class="alert alert-warning py-2 px-3 small rounded-3 mb-3 text-start" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ session('dev_otp_notice') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3 text-start" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('account.otp.verify') }}" data-login-form>
                @csrf
                <div class="mb-3">
                    <label for="login-otp" class="form-label small fw-bold text-muted mb-2 text-center d-block">৪ ডিজিটের ওটিপি কোড</label>
                    <input id="login-otp" class="rokomari-otp-input form-control" type="text" name="otp" inputmode="numeric" pattern="[0-9]{4}" minlength="4" maxlength="4" autocomplete="one-time-code" required autofocus placeholder="••••">
                    @error('otp')
                        <div class="text-danger small mt-1 text-center"><i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="rokomari-auth-btn">
                    <span>লগইন সম্পন্ন করুন</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pt-3 mt-3 border-top">
                <span id="otp-countdown" data-expires="{{ session('otp_expires_at', 0) }}" class="small text-muted" role="timer"></span>
                <form method="POST" action="{{ route('account.otp.send') }}" data-login-form class="d-inline">
                    @csrf
                    <input type="hidden" name="name" value="{{ session('otp_login') }}">
                    <button id="otp-resend" type="submit" class="btn btn-link text-primary small p-0 fw-semibold text-decoration-none" hidden>
                        <i class="fa-solid fa-rotate-right me-1"></i> আবার কোড পাঠান
                    </button>
                </form>
            </div>

        @else
            {{-- ========================================================
                 STEP 1: PHONE NUMBER INPUT (ROKOMARI STYLE)
                 ======================================================== --}}
            <h1 class="rokomari-auth-title">লগইন বা সাইন আপ</h1>
            <p class="rokomari-auth-subtitle">আপনার মোবাইল নম্বর দিয়ে সহজেই প্রবেশ করুন।</p>

            @if(session('error'))
                <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3 text-start" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
                </div>
            @endif

            @error('name')
                <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3 text-start" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                </div>
            @enderror

            <form method="POST" action="{{ route('account.otp.send') }}" data-login-form>
                @csrf
                <div class="mb-3 text-start">
                    <label for="login-phone" class="form-label small fw-bold text-muted mb-2">মোবাইল নম্বর (১১ ডিজিট)</label>
                    <div class="input-group rokomari-phone-group">
                        <span class="input-group-text">
                            +88
                        </span>
                        <input id="login-phone" type="tel" name="name" value="{{ old('name') }}" inputmode="tel" autocomplete="tel-national" pattern="01[3-9][0-9]{8}" maxlength="11" placeholder="01XXXXXXXXX" required autofocus class="form-control">
                    </div>
                    <div class="form-text small text-muted mt-1">আমরা আপনার এই নম্বরে একটি ভেরিফিকেশন ওটিপি পাঠাবো।</div>
                </div>

                <button type="submit" class="rokomari-auth-btn">
                    <span>এগিয়ে যান</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            @if(config('services.google.client_id') && config('services.google.client_secret'))
                <div class="rokomari-divider">
                    <span>অথবা</span>
                </div>
                <a class="rokomari-google-btn" href="{{ route('login.google') }}">
                    <i class="fa-brands fa-google text-danger fs-6"></i>
                    <span>গুগল দিয়ে লগইন করুন</span>
                </a>
            @endif

            <div class="rokomari-auth-footer">
                এগিয়ে যাওয়ার মাধ্যমে আপনি আমাদের <a href="{{ route('terms.conditions') }}">শর্তাবলী</a> ও <a href="{{ route('privacy.policy') }}">গোপনীয়তা নীতি</a> মেনে নিচ্ছেন।
            </div>
        @endif

    </div>
</div>
@endsection

@push('javascript')
<script src="{{ asset('frontend/assets/js/account.js') }}?v={{ filemtime(public_path('frontend/assets/js/account.js')) }}" defer></script>
@endpush
