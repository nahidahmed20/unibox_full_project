@extends('backend.layouts.app')
@section('title', 'Settings')

@section('content')
    <div class="app-content-header mb-4 mt-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold" style="color:#212b36;">
                        Settings
                    </h3>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">
                                Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active fw-bold text-dark">
                            Settings
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="app-content">
        <div class="container-fluid">
            <div class="card modern-card shadow-sm">
                {{-- HEADER (same card style) --}}
                <div class="modern-card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title mb-0">
                        <i class="fa-solid fa-gear text-muted me-2"></i>
                        Manage Settings
                    </h4>
                    <button type="submit" form="settingsForm" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm">
                        Save Settings
                    </button>
                </div>

                <div class="card-body">
                    <form id="settingsForm" action="{{ route('settings.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- LOGO SECTION --}}
                            <div class="col-12 mb-3">
                                <h5 class="fw-bold text-muted">Branding</h5>
                                <hr>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Header Logo</label>
                                <input type="file" name="header_logo" class="form-control">
                                @if (isset($settings['header_logo']))
                                    <img src="{{ asset($settings['header_logo']) }}" width="120"
                                        class="mt-2 rounded border">
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Footer Logo</label>
                                <input type="file" name="footer_logo" class="form-control">

                                @if (isset($settings['footer_logo']))
                                    <img src="{{ asset($settings['footer_logo']) }}" width="120"
                                        class="mt-2 rounded border">
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Favicon</label>
                                <input type="file" name="favicon" class="form-control">

                                @if (isset($settings['favicon']))
                                    <img src="{{ asset($settings['favicon']) }}" width="60" class="mt-2 rounded border">
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Nav Icon</label>
                                <input type="file" name="nav_icon" class="form-control">

                                @if (isset($settings['nav_icon']))
                                    <img src="{{ asset($settings['nav_icon']) }}" width="80"
                                        class="mt-2 rounded border">
                                @endif
                            </div>

                            {{-- WEBSITE INFO --}}
                            <div class="col-12 mt-4 mb-3">
                                <h5 class="fw-bold text-muted">Website Info</h5>
                                <hr>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Website Title</label>
                                <input type="text" name="website_title" class="form-control"
                                    value="{{ $settings['website_title'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Tagline</label>
                                <input type="text" name="website_tagline" class="form-control"
                                    value="{{ $settings['website_tagline'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Company Name</label>
                                <input type="text" name="company_name" class="form-control"
                                    value="{{ $settings['company_name'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Company Address</label>
                                <input type="text" name="company_address" class="form-control"
                                    value="{{ $settings['company_address'] ?? '' }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Company Description</label>
                                <textarea name="company_description" class="form-control" rows="3">{{ $settings['company_description'] ?? '' }}</textarea>
                            </div>

                            {{-- CONTACT --}}
                            <div class="col-12 mt-4 mb-3">
                                <h5 class="fw-bold text-muted">Contact</h5>
                                <hr>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ $settings['phone'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ $settings['email'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Hotline</label>
                                <input type="text" name="hotline" class="form-control"
                                    value="{{ $settings['hotline'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>WhatsApp</label>
                                <input type="text" name="whatsapp" class="form-control"
                                    value="{{ $settings['whatsapp'] ?? '' }}">
                            </div>

                            {{-- SOCIAL --}}
                            <div class="col-12 mt-4 mb-3">
                                <h5 class="fw-bold text-muted">Social Links</h5>
                                <hr>
                            </div>

                            @php
                                $socialKeys = [
                                    'facebook',
                                    'instagram',
                                    'youtube',
                                    'twitter',
                                    'tiktok',
                                    'linkedin',
                                    'telegram',
                                    'pinterest',
                                ];
                            @endphp

                            @foreach ($socialKeys as $social)
                                <div class="col-md-6 mb-3">
                                    <label>{{ ucfirst($social) }}</label>
                                    <input type="text" name="{{ $social }}" class="form-control"
                                        value="{{ $settings[$social] ?? '' }}">
                                </div>
                            @endforeach

                            {{-- SEO --}}
                            <div class="col-12 mt-4 mb-3">
                                <h5 class="fw-bold text-muted">SEO</h5>
                                <hr>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Meta Title</label>
                                <input type="text" name="meta_title" class="form-control"
                                    value="{{ $settings['meta_title'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control"
                                    value="{{ $settings['meta_keywords'] ?? '' }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3">{{ $settings['meta_description'] ?? '' }}</textarea>
                            </div>

                            {{-- FOOTER --}}
                            <div class="col-12 mt-4 mb-3">
                                <h5 class="fw-bold text-muted">Footer</h5>
                                <hr>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Footer About</label>
                                <textarea name="footer_about" class="form-control" rows="3">{{ $settings['footer_about'] ?? '' }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Copyright Text</label>
                                <input type="text" name="copyright_text" class="form-control"
                                    value="{{ $settings['copyright_text'] ?? '' }}">
                            </div>

                            {{-- DIGITAL MARKETING & TRACKING PIXELS --}}
                            <div class="col-12 mt-4 mb-3">
                                <h5 class="fw-bold text-muted"><i class="fa-solid fa-chart-line text-primary me-2"></i> Digital Marketing & Tracking Pixels</h5>
                                <hr>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Facebook Pixel ID</label>
                                <input type="text" name="fb_pixel_id" class="form-control" placeholder="e.g. 123456789012345"
                                    value="{{ $settings['fb_pixel_id'] ?? '' }}">
                                <small class="text-muted">Enter your Meta Pixel ID to track page views and purchases.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Facebook CAPI Access Token</label>
                                <input type="text" name="fb_capi_token" class="form-control" placeholder="Optional Conversions API Token"
                                    value="{{ $settings['fb_capi_token'] ?? '' }}">
                                <small class="text-muted">For server-side tracking (Conversions API).</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Google Analytics (GA4) Measurement ID</label>
                                <input type="text" name="ga_measurement_id" class="form-control" placeholder="e.g. G-XXXXXXXXXX"
                                    value="{{ $settings['ga_measurement_id'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Google Tag Manager (GTM) Container ID</label>
                                <input type="text" name="gtm_id" class="form-control" placeholder="e.g. GTM-XXXXXXX"
                                    value="{{ $settings['gtm_id'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Custom Header Scripts (&lt;head&gt;)</label>
                                <textarea name="custom_header_scripts" class="form-control font-monospace" rows="3" placeholder="Additional meta tags or scripts to inject into header">{{ $settings['custom_header_scripts'] ?? '' }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Custom Footer Scripts (&lt;/body&gt;)</label>
                                <textarea name="custom_footer_scripts" class="form-control font-monospace" rows="3" placeholder="Chat widget scripts, live support, or tracking tags">{{ $settings['custom_footer_scripts'] ?? '' }}</textarea>
                            </div>

                            {{-- COURIER API CONFIGURATION --}}
                            <div class="col-12 mt-4 mb-3">
                                <h5 class="fw-bold text-muted"><i class="fa-solid fa-truck-fast text-success me-2"></i> Courier API Integrations</h5>
                                <hr>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Steadfast API Key</label>
                                <input type="text" name="steadfast_api_key" class="form-control" placeholder="Steadfast API Key"
                                    value="{{ $settings['steadfast_api_key'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Steadfast Secret Key</label>
                                <input type="text" name="steadfast_secret_key" class="form-control" placeholder="Steadfast Secret Key"
                                    value="{{ $settings['steadfast_secret_key'] ?? '' }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Pathao Client ID</label>
                                <input type="text" name="pathao_client_id" class="form-control" placeholder="Pathao Client ID"
                                    value="{{ $settings['pathao_client_id'] ?? '' }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Pathao Client Secret</label>
                                <input type="text" name="pathao_client_secret" class="form-control" placeholder="Pathao Client Secret"
                                    value="{{ $settings['pathao_client_secret'] ?? '' }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Pathao Store ID</label>
                                <input type="text" name="pathao_store_id" class="form-control" placeholder="Pathao Store ID"
                                    value="{{ $settings['pathao_store_id'] ?? '' }}">
                            </div>

                            {{-- AUTOMATED SMS & ECOMMERCE RULES --}}
                            <div class="col-12 mt-4 mb-3">
                                <h5 class="fw-bold text-muted"><i class="fa-solid fa-bell text-warning me-2"></i> Automated SMS & E-Commerce Rules</h5>
                                <hr>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Order Confirmation SMS</label>
                                <select name="order_sms_enabled" class="form-select">
                                    <option value="1" {{ ($settings['order_sms_enabled'] ?? '') == '1' ? 'selected' : '' }}>Enabled (Send SMS on new order)</option>
                                    <option value="0" {{ ($settings['order_sms_enabled'] ?? '') == '0' ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Order Status Update SMS</label>
                                <select name="status_sms_enabled" class="form-select">
                                    <option value="1" {{ ($settings['status_sms_enabled'] ?? '') == '1' ? 'selected' : '' }}>Enabled (Send SMS on status change)</option>
                                    <option value="0" {{ ($settings['status_sms_enabled'] ?? '') == '0' ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Free Shipping Minimum Threshold (৳)</label>
                                <input type="number" step="0.01" name="free_shipping_threshold" class="form-control" placeholder="0 = Disabled"
                                    value="{{ $settings['free_shipping_threshold'] ?? '' }}">
                                <small class="text-muted">Auto free delivery if subtotal exceeds this amount.</small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
