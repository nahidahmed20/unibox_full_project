@extends('frontend.layouts.app')
@section('title', 'ব্যক্তিগত তথ্য ও প্রোফাইল | Profile Settings')

@push('css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/account.css') }}?v={{ filemtime(public_path('frontend/assets/css/account.css')) }}">
@endpush

@section('content')
<section class="ub-account-page py-3 py-md-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                @include('frontend.customer.partials.sidebar')
            </div>

            {{-- Content --}}
            <div class="col-lg-9" id="account-content">

                {{-- Header Card --}}
                <div class="p-3.5 p-sm-4 rounded-4 bg-white border shadow-xs mb-4">
                    <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-0.5 rounded-pill mb-1 bg-primary bg-opacity-10 text-primary fw-bold" style="font-size: 11px;">
                        <i class="fa-solid fa-user-pen"></i> PROFILE SETTINGS
                    </div>
                    <h4 class="fw-bolder text-dark mb-1 fs-4">ব্যক্তিগত তথ্য ও ঠিকানা</h4>
                    <p class="text-muted small mb-0">আপনার নাম, মোবাইল নম্বর, ইমেইল ও ডেলিভারি ঠিকানা আপডেট করুন।</p>
                </div>
                
                {{-- Form Card --}}
                <div class="p-3.5 p-sm-4 rounded-4 bg-white border shadow-xs">
                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <ul class="mb-0 small ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form data-account-profile data-district-url="{{ route('get.districts') }}" data-upazila-url="{{ route('get.upazilas') }}" action="{{ route('account.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            {{-- Name --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small text-dark mb-1">পূর্ণ নাম (Full Name) <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control rounded-3 shadow-none" value="{{ old('name', $customer->name) }}" required>
                            </div>

                            {{-- Email --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small text-dark mb-1">ইমেইল অ্যাড্রেস</label>
                                <input type="email" name="email" class="form-control rounded-3 shadow-none" value="{{ old('email', $customer->email) }}">
                            </div>

                            {{-- Phone --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small text-dark mb-1">মোবাইল নম্বর</label>
                                <input type="text" name="phone" class="form-control rounded-3 shadow-none" value="{{ old('phone', $customer->phone) }}">
                            </div>

                            {{-- Birth Date --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small text-dark mb-1">জন্ম তারিখ</label>
                                <input type="date" name="birth_date" class="form-control rounded-3 shadow-none" value="{{ old('birth_date', $customer->birth_date) }}">
                            </div>
                            
                            {{-- Division --}}
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold small text-dark mb-1">বিভাগ (Division)</label>
                                <select name="division_id" id="division" class="form-select custom-select rounded-3 shadow-none">
                                    <option value="">Select Division</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}" {{ (string)old('division_id', $customer->division_id) === (string)$division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- District --}}
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold small text-dark mb-1">জেলা (District)</label>
                                <select name="district_id" id="district" class="form-select custom-select rounded-3 shadow-none">
                                    <option value="">Select District</option>
                                </select>
                            </div>

                            {{-- Upazila --}}
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold small text-dark mb-1">উপজেলা / থানা (Upazila)</label>
                                <select name="upazila_id" id="upazila" class="form-select custom-select rounded-3 shadow-none">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>

                            <input type="hidden" id="selected_district" value="{{ old('district_id', $customer->district_id) }}">
                            <input type="hidden" id="selected_upazila" value="{{ old('upazila_id', $customer->upazila_id) }}">
                            
                            {{-- Home Address --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-primary small mb-1">
                                    <i class="fa-solid fa-house me-1"></i> বাসার ডেলিভারি ঠিকানা (Home Address)
                                </label>
                                <textarea name="address" rows="2" class="form-control rounded-3 shadow-none" placeholder="বাসার নম্বর, রোড, এলাকা...">{{ old('address', $customer->address ?? '') }}</textarea>
                            </div>
                            
                            {{-- Office Address --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-info small mb-1">
                                    <i class="fa-solid fa-building me-1"></i> অফিস ডেলিভারি ঠিকানা (Office Address)
                                </label>
                                <textarea name="office_address" rows="2" class="form-control rounded-3 shadow-none" placeholder="প্রতিষ্ঠানের নাম, ফ্লোর, এলাকা...">{{ old('office_address', $customer->office_address ?? '') }}</textarea>
                            </div>

                            {{-- Image Upload --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold small text-dark mb-1">প্রোফাইল ছবি পরিবর্তন</label>
                                <input type="file" name="image" class="form-control rounded-3 shadow-none" accept="image/*">
                            </div>

                            {{-- Current Image Preview --}}
                            <div class="col-12 col-md-6 d-flex align-items-center gap-3 pt-2">
                                @if($customer->image && file_exists(public_path($customer->image)))
                                    <img src="{{ asset($customer->image) }}" width="56" height="56" class="rounded-circle border shadow-xs flex-shrink-0" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center text-muted fw-bold flex-shrink-0" style="width: 56px; height: 56px; font-size: 22px;">
                                        {{ mb_substr($customer->name ?: 'U', 0, 1) }}
                                    </div>
                                @endif
                                <small class="text-muted" style="font-size: 11.5px;">JPG, PNG বা WebP ফরম্যাট (সর্বোচ্চ 2MB)</small>
                            </div>

                            {{-- Submit --}}
                            <div class="col-12 mt-4 pt-3 border-top text-end">
                                <button type="submit" class="btn btn-dark rounded-pill px-5 py-2.5 fw-bold text-white shadow-xs w-100 w-md-auto" style="background: #0f172a;">
                                    <i class="fa-solid fa-check me-1"></i> সংরক্ষণ করুন (Save Changes)
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

@push('javascript')
<script src="{{ asset('frontend/assets/js/account.js') }}?v={{ filemtime(public_path('frontend/assets/js/account.js')) }}" defer></script>
@endpush
