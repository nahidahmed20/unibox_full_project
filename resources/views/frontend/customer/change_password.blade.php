@extends('frontend.layouts.app')
@section('title', 'পাসওয়ার্ড পরিবর্তন | Password & Security')

@push('css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/account.css') }}?v={{ filemtime(public_path('frontend/assets/css/account.css')) }}">
@endpush

@section('content')
<section class="ub-account-page py-3 py-md-5">
    <div class="container">
        <div class="row g-4">
            {{-- Sidebar --}}
            <div class="col-lg-3">
                @include('frontend.customer.partials.sidebar')
            </div>

            {{-- Content --}}
            <div class="col-lg-9" id="account-content">

                {{-- Header Card --}}
                <div class="p-3 p-sm-4 rounded-4 bg-white border shadow-xs mb-4">
                    <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill mb-1 bg-warning bg-opacity-10 text-warning-emphasis fw-bold" style="font-size: 11px;">
                        <i class="fa-solid fa-shield-halved text-warning"></i> PASSWORD & SECURITY
                    </div>
                    <h4 class="fw-bolder text-dark mb-1 fs-5 fs-sm-4">পাসওয়ার্ড পরিবর্তন (Change Password)</h4>
                    <p class="text-muted small mb-0" style="font-size: 13.5px; line-height: 1.5;">আপনার অ্যাকাউন্টের নিরাপত্তা নিশ্চিত করতে একটি শক্তিশালী পাসওয়ার্ড ব্যবহার করুন।</p>
                </div>

                {{-- Form Card --}}
                <div class="p-3 p-sm-4 rounded-4 bg-white border shadow-xs">
                    <!-- Success Alert -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Error Alert -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <ul class="mb-0 small ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Password Update Form -->
                    <form action="{{ route('account.password.update') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            {{-- Current Password --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold small text-dark mb-1">বর্তমান পাসওয়ার্ড (Current Password) <span class="text-danger">*</span></label>
                                <input type="password" name="current_password" class="form-control rounded-pill px-3 py-2 shadow-none @error('current_password') is-invalid @enderror" placeholder="আপনার বর্তমান পাসওয়ার্ড দিন" required style="font-size: 14px;">
                                @error('current_password')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small text-dark mb-1">নতুন পাসওয়ার্ড (New Password) <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control rounded-pill px-3 py-2 shadow-none @error('password') is-invalid @enderror" placeholder="কমপক্ষে ৬টি অক্ষরের নতুন পাসওয়ার্ড" required style="font-size: 14px;">
                                @error('password')
                                    <div class="invalid-feedback small">{{ $message++ ?? $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small text-dark mb-1">কনফার্ম পাসওয়ার্ড (Confirm Password) <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control rounded-pill px-3 py-2 shadow-none" placeholder="পুনরায় নতুন পাসওয়ার্ড লিখুন" required style="font-size: 14px;">
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12 mt-4 pt-3 border-top text-center text-md-end">
                                <button type="submit" class="btn btn-dark rounded-pill px-4 py-2.5 fw-bold text-white shadow-xs w-100 w-md-auto" style="background: #0f172a; font-size: 14px;">
                                    <i class="fa-solid fa-lock me-1"></i> পাসওয়ার্ড আপডেট করুন
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
