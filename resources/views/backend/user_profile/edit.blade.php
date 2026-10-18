@extends('backend.layouts.app')
@section('title', 'Super Admin Profile')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --prof-bg: #f8fafc;
        --prof-card: #ffffff;
        --prof-border: #e2e8f0;
        --prof-text: #0f172a;
        --prof-muted: #64748b;
        --prof-primary: #2563eb;
    }

    body {
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        background-color: var(--prof-bg) !important;
    }

    .app-main {
        background-color: var(--prof-bg);
    }

    /* Executive Profile Cover Banner */
    .profile-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 16px;
        padding: 30px 30px 40px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: -50px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.2);
    }

    .profile-hero::after {
        content: '';
        position: absolute;
        right: -30px;
        top: -30px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.2) 0%, rgba(0,0,0,0) 70%);
        pointer-events: none;
    }

    .hero-top-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    /* Profile Header Box overlapping Banner */
    .profile-header-card {
        background: #ffffff;
        border: 1px solid var(--prof-border);
        border-radius: 16px;
        padding: 24px 28px;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.06);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        position: relative;
        z-index: 2;
    }

    .profile-avatar-wrap {
        position: relative;
        display: inline-block;
        flex-shrink: 0;
    }

    .profile-avatar-img {
        width: 100px;
        height: 100px;
        border-radius: 20px;
        object-fit: cover;
        border: 4px solid #ffffff;
        box-shadow: 0 4px 14px rgba(0,0,0,0.12);
        background: #f1f5f9;
    }

    .avatar-upload-trigger {
        position: absolute;
        bottom: -4px;
        right: -4px;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #0f172a;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 2px solid #ffffff;
        transition: all 0.2s ease;
    }

    .avatar-upload-trigger:hover {
        background: #2563eb;
        transform: scale(1.08);
    }

    .profile-info-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--prof-text);
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-meta-list {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        font-size: 13px;
        color: var(--prof-muted);
        margin-top: 6px;
    }

    .profile-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Cards */
    .prof-card {
        background: var(--prof-card);
        border: 1px solid var(--prof-border);
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        margin-bottom: 20px;
    }

    .prof-card-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--prof-text);
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-label {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 6px;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 500;
        color: var(--prof-text);
        transition: all 0.15s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .sticky-sidebar {
        position: sticky;
        top: 20px;
    }

    .btn-save-profile {
        background: #0f172a;
        color: #ffffff;
        font-weight: 700;
        font-size: 14px;
        padding: 12px 20px;
        border-radius: 10px;
        border: none;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }

    .btn-save-profile:hover {
        background: #1e293b;
        transform: translateY(-2px);
    }

    .select2-container--default .select2-selection--single {
        height: 42px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        display: flex !important;
        align-items: center !important;
    }

    .select2-container--default .select2-selection__rendered {
        line-height: 40px !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        color: var(--prof-text) !important;
    }

    .select2-container {
        width: 100% !important;
    }
</style>

<main class="app-main pt-3 pb-5">
    <div class="container-fluid px-4">

        {{-- ================= HERO COVER ================= --}}
        <div class="profile-hero">
            <div class="hero-top-nav">
                <div>
                    <h5 class="fw-bold mb-1">Super Admin Account Profile</h5>
                    <small class="text-light opacity-75">Manage your administrator credentials, personal information, and store settings</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-light rounded-3 px-3 py-1.5 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>

        {{-- ================= OVERLAPPING IDENTITY CARD ================= --}}
        <div class="profile-header-card">
            <div class="d-flex align-items-center gap-3">
                <div class="profile-avatar-wrap">
                    <img id="headerAvatarPreview"
                        src="{{ $user->image && file_exists(public_path($user->image)) ? asset($user->image) : asset('backend/assets/img/user_image.png') }}"
                        class="profile-avatar-img" alt="{{ $user->name }}">
                    <label for="image" class="avatar-upload-trigger" title="Upload New Avatar Photo">
                        <i class="bi bi-camera-fill"></i>
                    </label>
                </div>

                <div>
                    <div class="profile-info-title">
                        {{ $user->name }}
                        <span class="badge bg-primary-subtle text-primary border px-2 py-1" style="font-size: 11px;">
                            {{ $user->roles->pluck('name')->first() ?? (strtoupper($user->type) ?: 'SUPER ADMIN') }}
                        </span>
                    </div>
                    <div class="profile-meta-list">
                        <div class="profile-meta-item">
                            <i class="bi bi-envelope text-muted"></i>
                            <span>{{ $user->email ?? 'admin@unibox.com' }}</span>
                        </div>
                        <div class="profile-meta-item">
                            <i class="bi bi-telephone text-muted"></i>
                            <span>{{ $user->phone ?? 'Not set' }}</span>
                        </div>
                        <div class="profile-meta-item">
                            <i class="bi bi-shield-check text-success"></i>
                            <span class="text-success fw-bold">Active Administrator</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-none d-md-flex align-items-center gap-2">
                <a href="{{ route('sales.create') }}" class="btn btn-sm btn-dark rounded-pill px-3 py-2 fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-pc-display-horizontal text-success"></i>
                    <span>Open POS</span>
                </a>
            </div>
        </div>

        {{-- Success / Error Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 p-3 mb-4 rounded-3" role="alert">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <div class="fw-semibold">{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm p-3 mb-4 rounded-3" role="alert">
                <div class="fw-bold mb-1"><i class="bi bi-exclamation-octagon-fill me-1"></i> Please check the following errors:</div>
                <ul class="mb-0 ps-3" style="font-size: 13px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ================= PROFILE EDIT FORM ================= --}}
        <form action="{{ route('user-profiles.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- LEFT 8 COLS: FORM DETAILS --}}
                <div class="col-lg-8">

                    {{-- 1: PERSONAL & CONTACT INFORMATION --}}
                    <div class="prof-card">
                        <div class="prof-card-title">
                            <i class="bi bi-person-lines-fill text-primary"></i>
                            Personal & Contact Information
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required placeholder="e.g. John Doe">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" placeholder="e.g. admin">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required placeholder="admin@example.com">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Primary Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="01XXXXXXXXX">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Alternate Phone</label>
                                <input type="text" name="alternate_phone" class="form-control" value="{{ old('alternate_phone', $user->alternate_phone) }}" placeholder="Optional">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact</label>
                                <input type="text" name="emergency_contact" class="form-control" value="{{ old('emergency_contact', $user->emergency_contact) }}" placeholder="Emergency phone">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select select2">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $user->birth_date) }}">
                            </div>
                        </div>
                    </div>

                    {{-- 2: SECURITY & PASSWORD CHANGE --}}
                    <div class="prof-card">
                        <div class="prof-card-title">
                            <i class="bi bi-shield-lock-fill text-warning"></i>
                            Security & Password Update
                        </div>
                        <p class="text-muted small mb-3">
                            Leave password fields blank if you do not want to change your current password.
                        </p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="new_password" class="form-control" minlength="6" placeholder="Enter new password (min 6 chars)">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('new_password', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" minlength="6" placeholder="Repeat new password">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('password_confirmation', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3: ADDRESS & GEOGRAPHY --}}
                    <div class="prof-card">
                        <div class="prof-card-title">
                            <i class="bi bi-geo-alt-fill text-danger"></i>
                            Address & Geographical Details
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Residential Address</label>
                                <textarea name="address" rows="2" class="form-control" placeholder="House, Road, Area details...">{{ old('address', $user->address) }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Office / Store Address</label>
                                <textarea name="office_address" rows="2" class="form-control" placeholder="Company office location...">{{ old('office_address', $user->office_address) }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Division</label>
                                <select name="division_id" id="division_id" class="form-select select2">
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}" {{ old('division_id', $user->division_id) == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">District</label>
                                <select name="district_id" id="district_id" class="form-select select2">
                                    <option value="">Select District</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}" {{ old('district_id', $user->district_id) == $district->id ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Upazila / Thana</label>
                                <select name="upazila_id" id="upazila_id" class="form-select select2">
                                    <option value="">Select Upazila</option>
                                    @foreach ($upazilas as $upazila)
                                        <option value="{{ $upazila->id }}" {{ old('upazila_id', $user->upazila_id) == $upazila->id ? 'selected' : '' }}>
                                            {{ $upazila->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country', $user->country ?? 'Bangladesh') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $user->postal_code) }}" placeholder="e.g. 1207">
                            </div>
                        </div>
                    </div>

                </div>

                {{-- RIGHT 4 COLS: PHOTO UPLOAD & SUMMARY --}}
                <div class="col-lg-4">
                    <div class="sticky-sidebar">

                        {{-- AVATAR UPLOAD CARD --}}
                        <div class="prof-card text-center">
                            <div class="prof-card-title text-start">
                                <i class="bi bi-image text-primary"></i>
                                Profile Photo
                            </div>

                            <div class="mb-3 d-inline-block position-relative">
                                <img id="previewImage"
                                    src="{{ $user->image && file_exists(public_path($user->image)) ? asset($user->image) : asset('backend/assets/img/user_image.png') }}"
                                    class="rounded-4 border" width="130" height="130" style="object-fit: cover;">
                            </div>

                            <div class="mb-3">
                                <label for="image" class="btn btn-sm btn-outline-primary fw-semibold rounded-pill px-3 py-1.5 cursor-pointer">
                                    <i class="bi bi-upload me-1"></i> Choose New Photo
                                </label>
                                <input type="file" name="image" id="image" class="d-none" accept="image/png, image/jpeg, image/jpg, image/webp">
                                <div class="text-muted mt-2" style="font-size: 11px;">
                                    Max size: 2MB. Formats: JPG, PNG, WebP.
                                </div>
                            </div>
                        </div>

                        {{-- ADMIN ACCOUNT META --}}
                        <div class="prof-card">
                            <div class="prof-card-title">
                                <i class="bi bi-info-circle text-primary"></i>
                                Account Summary
                            </div>

                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="font-size: 13px;">
                                <span class="text-muted">Account Role:</span>
                                <span class="badge bg-primary-subtle text-primary fw-bold">
                                    {{ $user->roles->pluck('name')->first() ?? 'Super Admin' }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="font-size: 13px;">
                                <span class="text-muted">Employee Code:</span>
                                <span class="fw-bold text-dark">{{ $user->employee_code ?? 'EMP-001' }}</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="font-size: 13px;">
                                <span class="text-muted">Designation:</span>
                                <span class="fw-bold text-dark">{{ $user->designation ?? 'Store Administrator' }}</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="font-size: 13px;">
                                <span class="text-muted">Account Status:</span>
                                <span class="badge bg-success-subtle text-success fw-bold">Active</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-2" style="font-size: 13px;">
                                <span class="text-muted">Member Since:</span>
                                <span class="text-muted">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'Active' }}</span>
                            </div>
                        </div>

                        {{-- SUBMIT BUTTON --}}
                        <button type="submit" class="btn-save-profile">
                            <i class="bi bi-check2-circle fs-5"></i>
                            <span>SAVE PROFILE CHANGES</span>
                        </button>

                    </div>
                </div>

            </div>
        </form>

    </div>
</main>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            width: '100%'
        });

        // Live Image Preview
        $('#image').change(function() {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
                $('#headerAvatarPreview').attr('src', e.target.result);
            }
            if (this.files[0]) {
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Division Change -> Load Districts
        $('#division_id').change(function() {
            let id = $(this).val();
            if (!id) return;
            $('#district_id').html('<option>Loading districts...</option>');
            $.get('{{ url("admin/get-locations") }}/' + id, function(data) {
                let html = '<option value="">Select District</option>';
                $.each(data, function(index, row) {
                    html += `<option value="${row.id}">${row.name}</option>`;
                });
                $('#district_id').html(html);
                $('#upazila_id').html('<option value="">Select Upazila</option>');
            });
        });

        // District Change -> Load Upazilas
        $('#district_id').change(function() {
            let id = $(this).val();
            if (!id) return;
            $('#upazila_id').html('<option>Loading upazilas...</option>');
            $.get('{{ url("admin/get-locations") }}/' + id, function(data) {
                let html = '<option value="">Select Upazila</option>';
                $.each(data, function(index, row) {
                    html += `<option value="${row.id}">${row.name}</option>`;
                });
                $('#upazila_id').html(html);
            });
        });
    });

    // Toggle Password Visibility
    function togglePasswordVisibility(inputId, btn) {
        let input = document.getElementById(inputId);
        let icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
@endpush
