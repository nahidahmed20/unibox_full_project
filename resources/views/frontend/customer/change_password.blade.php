@extends('frontend.layouts.app')
@section('title', 'Password & security')
@push('css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/account.css') }}?v={{ filemtime(public_path('frontend/assets/css/account.css')) }}">
@endpush
@section('content')
<section class="ub-account-page ub-account-detail">
    <div class="container">
        <div class="row g-4"><div class="col-lg-3">@include('frontend.customer.partials.sidebar')</div>
            <div class="col-lg-9" id="account-content">
                <!-- Header Card -->
                <div class="ub-account-panel mb-4">
                    <h3>Change Password</h3>
                    <p>Update your account password securely</p>
                </div>

                <!-- Form Card -->
                <div class="ub-account-panel">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('account.password.update') }}" method="POST">
                        @csrf

                        <div class="row">

                            <!-- Current Password -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control"
                                    placeholder="Enter current password">

                                @error('current_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Enter new password">

                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Confirm new password">
                            </div>

                            <!-- Submit Button -->
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    Update Password
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
