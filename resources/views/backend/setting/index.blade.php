@extends('backend.layouts.app')
@section('title', 'Global Settings')

@section('content')
<style>
    /* =========================================================
       GLOBAL SETTINGS LUXURY WORKSPACE
       ========================================================= */
    .settings-wrapper {
        padding-bottom: 90px;
    }

    /* Left Navigation Tabs */
    .settings-nav-card {
        background: #ffffff;
        border: 1px solid var(--ub-border, #e2e8f0);
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        position: sticky;
        top: 80px;
        z-index: 10;
        max-height: calc(100vh - 105px);
        display: flex;
        flex-direction: column;
    }

    .settings-nav-header {
        padding: 1.15rem 1.25rem;
        background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        border-bottom: 1px solid #edf2f7;
        flex-shrink: 0;
    }

    .settings-nav-pills {
        padding: 0.65rem 0.65rem;
        display: flex;
        flex-direction: column;
        gap: 4px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Tab Pane Visibility: Guaranteed Display */
    .tab-content > .tab-pane {
        display: none !important;
        opacity: 0;
        visibility: hidden;
    }

    .tab-content > .tab-pane.active,
    .tab-content > .tab-pane.show.active {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
        animation: ubTabFadeIn 0.15s ease-out forwards;
    }

    @keyframes ubTabFadeIn {
        from {
            opacity: 0;
            transform: translateY(3px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .settings-nav-pills .nav-link {
        color: #475569;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease-in-out;
        border: 1px solid transparent;
        text-align: left;
    }

    .settings-nav-pills .nav-link:hover {
        color: #0f172a;
        background: #f1f5f9;
    }

    .settings-nav-pills .nav-link.active {
        color: #ffffff !important;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.18);
        border-color: #0f172a;
    }

    .settings-nav-pills .nav-link .icon-box {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        font-size: 0.95rem;
        background: #f1f5f9;
        color: #334155;
        transition: all 0.2s;
    }

    .settings-nav-pills .nav-link.active .icon-box {
        background: rgba(255, 255, 255, 0.18);
        color: #ffffff;
    }

    /* Content Cards */
    .settings-content-card {
        background: #ffffff;
        border: 1px solid var(--ub-border, #e2e8f0);
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .settings-content-header {
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid #edf2f7;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .settings-content-body {
        padding: 1.75rem;
    }

    /* Checkerboard background for transparent PNG logos */
    .checkerboard-bg {
        background-color: #f8fafc;
        background-image: linear-gradient(45deg, #e2e8f0 25%, transparent 25%),
                          linear-gradient(-45deg, #e2e8f0 25%, transparent 25%),
                          linear-gradient(45deg, transparent 75%, #e2e8f0 75%),
                          linear-gradient(-45deg, transparent 75%, #e2e8f0 75%);
        background-size: 16px 16px;
        background-position: 0 0, 0 8px, 8px -8px, -8px 0px;
    }

    .dark-preview-bg {
        background: #0f172a;
        background-image: radial-gradient(#1e293b 1px, transparent 1px);
        background-size: 16px 16px;
    }

    /* Media Upload Box */
    .logo-upload-box {
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        padding: 1.25rem;
        text-align: center;
        background: #f8fafc;
        transition: all 0.25s ease;
        position: relative;
    }

    .logo-upload-box:hover {
        border-color: #2563eb;
        background: #eff6ff;
    }

    .logo-preview-canvas {
        min-height: 110px;
        max-height: 130px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        margin-bottom: 0.85rem;
        padding: 12px;
        position: relative;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .logo-preview-canvas img {
        max-height: 90px;
        max-width: 100%;
        object-fit: contain;
        transition: transform 0.2s ease;
    }

    /* Simulated Chrome Tab Preview for Favicon */
    .mock-browser-tab {
        background: #e2e8f0;
        border-radius: 12px 12px 0 0;
        padding: 8px 12px 0 12px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: -1px;
    }

    .mock-tab-pill {
        background: #ffffff;
        padding: 6px 14px;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #334155;
        box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.05);
    }

    /* Google SERP Preview */
    .google-serp-preview {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .google-serp-domain {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.78rem;
        color: #202124;
    }

    .google-serp-title {
        color: #1a0dab;
        font-size: 1.15rem;
        line-height: 1.35;
        font-weight: 500;
        cursor: pointer;
        margin-top: 4px;
        margin-bottom: 4px;
        text-decoration: none;
        display: block;
    }

    .google-serp-title:hover {
        text-decoration: underline;
    }

    .google-serp-desc {
        color: #4d5156;
        font-size: 0.86rem;
        line-height: 1.45;
        margin-bottom: 0;
    }

    /* Form Control Tweaks */
    .settings-input-group .input-group-text {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .settings-input-group .form-control {
        border-color: #cbd5e1;
    }

    .settings-input-group .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .password-toggle-btn {
        cursor: pointer;
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #64748b;
    }

    .password-toggle-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Social Card Pill */
    .social-input-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.95rem;
        transition: all 0.2s;
        background: #ffffff;
    }

    .social-input-card:focus-within {
        border-color: #0f172a;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
    }

    /* Code Editor Style Textarea */
    .code-textarea {
        background: #0f172a !important;
        color: #38bdf8 !important;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important;
        font-size: 0.82rem !important;
        line-height: 1.5 !important;
        border: 1px solid #334155 !important;
        border-radius: 10px !important;
    }

    .code-textarea:focus {
        border-color: #38bdf8 !important;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2) !important;
    }

    /* Sticky Bottom Action Bar */
    .settings-bottom-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-top: 1px solid #e2e8f0;
        padding: 0.85rem 1.5rem;
        z-index: 1040;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.06);
    }

    @media (max-width: 991.98px) {
        .settings-nav-card {
            position: static;
            margin-bottom: 1.5rem;
        }

        .settings-nav-pills {
            flex-direction: row;
            overflow-x: auto;
            flex-wrap: nowrap;
            padding-bottom: 8px;
        }

        .settings-nav-pills .nav-link {
            white-space: nowrap;
        }
    }
</style>

<div class="settings-wrapper">
    {{-- PAGE HEADER --}}
    <div class="app-content-header mb-4 mt-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-dark text-white rounded-3 p-2 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
                            <i class="fa-solid fa-sliders fs-5"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold" style="color:#0f172a; letter-spacing: -0.02em;">
                                Global Settings
                            </h3>
                            <p class="text-muted small mb-0">Centralized configuration for branding, couriers, marketing pixels, and SEO</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 text-md-end mt-3 mt-md-0 d-flex align-items-center justify-content-md-end gap-2">
                    <ol class="breadcrumb mb-0 bg-transparent p-0 d-none d-sm-flex me-2">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active fw-bold text-dark">Settings</li>
                    </ol>

                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3 fw-semibold btn-sm" onclick="location.reload();">
                        <i class="fa-solid fa-rotate me-1"></i> Discard
                    </button>
                    <button type="submit" form="settingsForm" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm btn-save-action">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save All Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN FORM & TAB WORKSPACE --}}
    <div class="app-content">
        <div class="container-fluid">
            <form id="settingsForm" action="{{ route('settings.save') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    {{-- LEFT COLUMN: VERTICAL NAVIGATION PILLS --}}
                    <div class="col-lg-3 col-xl-3">
                        <div class="settings-nav-card">
                            <div class="settings-nav-header">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-uppercase fw-bold text-muted small" style="letter-spacing: 0.08em; font-size: 0.72rem;">Settings Menu</span>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-2" style="font-size: 0.72rem;">10 Sections</span>
                                </div>
                                <div class="position-relative">
                                    <input type="text" id="settingSearch" autocomplete="off" name="search_settings_filter" class="form-control form-control-sm rounded-pill ps-4" placeholder="Filter settings...">
                                    <i class="fa-solid fa-magnifying-glass position-absolute top-50 translate-middle-y text-muted" style="left: 12px; font-size: 0.75rem;"></i>
                                </div>
                            </div>

                            <div class="nav settings-nav-pills" id="settingsTabList" role="tablist">
                                <button type="button" class="nav-link active" data-setting-tab="true" data-bs-target="#tab-branding" role="tab" data-search="brand logo favicon nav icon">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-box"><i class="fa-solid fa-palette text-primary"></i></span>
                                        <span>Branding & Assets</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-muted small opacity-50"></i>
                                </button>

                                <button type="button" class="nav-link" data-setting-tab="true" data-bs-target="#tab-general" role="tab" data-search="store identity company title tagline address bio google map">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-box"><i class="fa-solid fa-store text-indigo"></i></span>
                                        <span>Store Identity</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-muted small opacity-50"></i>
                                </button>

                                <button type="button" class="nav-link" data-setting-tab="true" data-bs-target="#tab-contact" role="tab" data-search="phone email hotline whatsapp contact support">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-box"><i class="fa-solid fa-headset text-success"></i></span>
                                        <span>Contact & Support</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-muted small opacity-50"></i>
                                </button>

                                <button type="button" class="nav-link" data-setting-tab="true" data-bs-target="#tab-couriers" role="tab" data-search="courier steadfast pathao shipping free threshold delivery logistics">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-box"><i class="fa-solid fa-truck-fast text-warning"></i></span>
                                        <span>Courier Logistics</span>
                                    </div>
                                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill" style="font-size: 0.7rem;">Couriers</span>
                                </button>

                                <button type="button" class="nav-link" data-setting-tab="true" data-bs-target="#tab-tracking" role="tab" data-search="meta pixel facebook capi google analytics ga4 gtm tag manager tracking">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-box"><i class="fa-solid fa-chart-line text-info"></i></span>
                                        <span>Tracking & Pixels</span>
                                    </div>
                                    <span class="badge bg-info-subtle text-info-emphasis rounded-pill" style="font-size: 0.7rem;">Marketing</span>
                                </button>

                                <button type="button" class="nav-link" data-setting-tab="true" data-bs-target="#tab-seo" role="tab" data-search="seo meta title keywords description google snippet search">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-box"><i class="fa-solid fa-magnifying-glass-chart text-danger"></i></span>
                                        <span>SEO & Snippet</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-muted small opacity-50"></i>
                                </button>

                                <button type="button" class="nav-link" data-setting-tab="true" data-bs-target="#tab-social" role="tab" data-search="facebook instagram youtube twitter x tiktok linkedin telegram pinterest social">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-box"><i class="fa-solid fa-share-nodes text-primary"></i></span>
                                        <span>Social Channels</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-muted small opacity-50"></i>
                                </button>

                                <button type="button" class="nav-link" data-setting-tab="true" data-bs-target="#tab-sms" role="tab" data-search="sms message order status notification automated">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-box"><i class="fa-solid fa-comment-sms text-secondary"></i></span>
                                        <span>SMS & Alerts</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-muted small opacity-50"></i>
                                </button>

                                <button type="button" class="nav-link" data-setting-tab="true" data-bs-target="#tab-footer" role="tab" data-search="footer copyright about story legal">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-box"><i class="fa-solid fa-file-shield text-dark"></i></span>
                                        <span>Footer & Legal</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-muted small opacity-50"></i>
                                </button>

                                <button type="button" class="nav-link" data-setting-tab="true" data-bs-target="#tab-scripts" role="tab" data-search="custom header footer script code head body inject">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-box"><i class="fa-solid fa-code text-purple"></i></span>
                                        <span>Custom Scripts</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-muted small opacity-50"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: TAB PANES --}}
                    <div class="col-lg-9 col-xl-9">
                        <div class="tab-content" id="settingsTabContent">

                            {{-- ========================================================
                                 TAB 1: BRANDING & ASSETS
                                 ======================================================== --}}
                            <div class="tab-pane fade show active" id="tab-branding" role="tabpanel">
                                <div class="settings-content-card">
                                    <div class="settings-content-header">
                                        <div>
                                            <h5 class="fw-bold mb-1 text-dark">
                                                <i class="fa-solid fa-palette text-primary me-2"></i> Brand Logos & Visual Identity
                                            </h5>
                                            <p class="text-muted small mb-0">Upload your store logos, browser favicons, and web app launcher icons.</p>
                                        </div>
                                        <span class="badge bg-light text-muted border px-3 py-2 rounded-pill small">
                                            PNG, SVG, WEBP or JPG
                                        </span>
                                    </div>

                                    <div class="settings-content-body">
                                        <div class="row g-4">
                                            {{-- Header Logo --}}
                                            <div class="col-md-6">
                                                <div class="logo-upload-box h-100 d-flex flex-column justify-content-between">
                                                    <div>
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <label class="fw-bold text-dark mb-0">Header Logo</label>
                                                            <span class="badge bg-light text-muted border small">Main Navbar</span>
                                                        </div>
                                                        <p class="text-muted small mb-2 text-start">Appears in desktop and mobile top headers. Transparent PNG is recommended.</p>

                                                        <div class="logo-preview-canvas checkerboard-bg" id="canvas-header-logo">
                                                            @if (!empty($settings['header_logo']) && file_exists(public_path($settings['header_logo'])))
                                                                <img src="{{ asset($settings['header_logo']) }}" id="preview-header_logo" alt="Header Logo">
                                                            @else
                                                                <div class="text-muted text-center py-3" id="placeholder-header_logo">
                                                                    <i class="fa-regular fa-image fs-2 mb-1 opacity-40"></i>
                                                                    <div class="small fw-semibold">No logo uploaded</div>
                                                                </div>
                                                                <img src="" id="preview-header_logo" class="d-none" alt="Header Logo">
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <input type="file" name="header_logo" id="input-header_logo" class="form-control form-control-sm file-preview-trigger" data-target="header_logo" accept="image/*">
                                                        <div class="d-flex justify-content-between align-items-center mt-2 small text-muted">
                                                            <span><i class="fa-solid fa-arrows-left-right me-1"></i> Recommended: 240 × 60 px</span>
                                                            <span class="fw-semibold">Max 2MB</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Footer Logo --}}
                                            <div class="col-md-6">
                                                <div class="logo-upload-box h-100 d-flex flex-column justify-content-between">
                                                    <div>
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <label class="fw-bold text-dark mb-0">Footer Logo</label>
                                                            <span class="badge bg-dark text-white border small">Dark / Footer</span>
                                                        </div>
                                                        <p class="text-muted small mb-2 text-start">Appears inside footer columns. Tested on dark backgrounds.</p>

                                                        <div class="logo-preview-canvas dark-preview-bg" id="canvas-footer-logo">
                                                            @if (!empty($settings['footer_logo']) && file_exists(public_path($settings['footer_logo'])))
                                                                <img src="{{ asset($settings['footer_logo']) }}" id="preview-footer_logo" alt="Footer Logo">
                                                            @else
                                                                <div class="text-light text-center py-3 opacity-75" id="placeholder-footer_logo">
                                                                    <i class="fa-regular fa-image fs-2 mb-1"></i>
                                                                    <div class="small fw-semibold">No logo uploaded</div>
                                                                </div>
                                                                <img src="" id="preview-footer_logo" class="d-none" alt="Footer Logo">
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <input type="file" name="footer_logo" id="input-footer_logo" class="form-control form-control-sm file-preview-trigger" data-target="footer_logo" accept="image/*">
                                                        <div class="d-flex justify-content-between align-items-center mt-2 small text-muted">
                                                            <span><i class="fa-solid fa-arrows-left-right me-1"></i> Recommended: 240 × 60 px</span>
                                                            <span class="fw-semibold">Max 2MB</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Favicon --}}
                                            <div class="col-md-6">
                                                <div class="logo-upload-box h-100 d-flex flex-column justify-content-between">
                                                    <div>
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <label class="fw-bold text-dark mb-0">Browser Favicon</label>
                                                            <span class="badge bg-light text-muted border small">Browser Tab</span>
                                                        </div>
                                                        <p class="text-muted small mb-2 text-start">Displayed in browser tabs and bookmark bars.</p>

                                                        <div class="text-start mb-2">
                                                            <div class="mock-browser-tab">
                                                                <div class="mock-tab-pill">
                                                                    <span id="tab-favicon-preview">
                                                                        @if (!empty($settings['favicon']) && file_exists(public_path($settings['favicon'])))
                                                                            <img src="{{ asset($settings['favicon']) }}" width="16" height="16" class="rounded-circle" id="preview-favicon-tab">
                                                                        @else
                                                                            <i class="fa-solid fa-globe text-primary" style="font-size: 14px;"></i>
                                                                        @endif
                                                                    </span>
                                                                    <span class="text-truncate" style="max-width: 140px;">{{ $settings['website_title'] ?? 'Store Homepage' }}</span>
                                                                    <i class="fa-solid fa-xmark text-muted ms-1" style="font-size: 11px;"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="logo-preview-canvas checkerboard-bg" style="min-height: 80px; max-height: 85px;">
                                                            @if (!empty($settings['favicon']) && file_exists(public_path($settings['favicon'])))
                                                                <img src="{{ asset($settings['favicon']) }}" id="preview-favicon" style="width: 42px; height: 42px; object-fit: contain;" alt="Favicon">
                                                            @else
                                                                <div class="text-muted text-center py-2" id="placeholder-favicon">
                                                                    <i class="fa-regular fa-circle-dot fs-4 opacity-40"></i>
                                                                    <div class="small fw-semibold">No favicon uploaded</div>
                                                                </div>
                                                                <img src="" id="preview-favicon" class="d-none" style="width: 42px; height: 42px; object-fit: contain;" alt="Favicon">
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <input type="file" name="favicon" id="input-favicon" class="form-control form-control-sm file-preview-trigger" data-target="favicon" accept="image/*">
                                                        <div class="d-flex justify-content-between align-items-center mt-2 small text-muted">
                                                            <span><i class="fa-solid fa-crop-simple me-1"></i> 32 × 32 px or 64 × 64 px (.ico / .png)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Nav Icon / App Icon --}}
                                            <div class="col-md-6">
                                                <div class="logo-upload-box h-100 d-flex flex-column justify-content-between">
                                                    <div>
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <label class="fw-bold text-dark mb-0">Nav Icon / App Icon</label>
                                                            <span class="badge bg-light text-muted border small">Sidebar & PWA</span>
                                                        </div>
                                                        <p class="text-muted small mb-2 text-start">Compact square symbol used in collapsed sidebars and mobile icons.</p>

                                                        <div class="logo-preview-canvas checkerboard-bg" style="min-height: 105px; max-height: 110px;">
                                                            @if (!empty($settings['nav_icon']) && file_exists(public_path($settings['nav_icon'])))
                                                                <img src="{{ asset($settings['nav_icon']) }}" id="preview-nav_icon" style="max-height: 60px; max-width: 60px;" class="rounded-3 shadow-xs" alt="Nav Icon">
                                                            @else
                                                                <div class="text-muted text-center py-2" id="placeholder-nav_icon">
                                                                    <i class="fa-solid fa-shapes fs-2 mb-1 opacity-40"></i>
                                                                    <div class="small fw-semibold">No icon uploaded</div>
                                                                </div>
                                                                <img src="" id="preview-nav_icon" class="d-none" style="max-height: 60px; max-width: 60px;" alt="Nav Icon">
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <input type="file" name="nav_icon" id="input-nav_icon" class="form-control form-control-sm file-preview-trigger" data-target="nav_icon" accept="image/*">
                                                        <div class="d-flex justify-content-between align-items-center mt-2 small text-muted">
                                                            <span><i class="fa-solid fa-vector-square me-1"></i> Recommended: 192 × 192 px (.png)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ========================================================
                                 TAB 2: STORE IDENTITY & GENERAL
                                 ======================================================== --}}
                            <div class="tab-pane fade" id="tab-general" role="tabpanel">
                                <div class="settings-content-card">
                                    <div class="settings-content-header">
                                        <div>
                                            <h5 class="fw-bold mb-1 text-dark">
                                                <i class="fa-solid fa-store text-indigo me-2"></i> Store Identity & Corporate Profile
                                            </h5>
                                            <p class="text-muted small mb-0">Legal business information, store title, slogans, and physical address.</p>
                                        </div>
                                    </div>

                                    <div class="settings-content-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark">Store / Website Title <span class="text-danger">*</span></label>
                                                <div class="input-group settings-input-group">
                                                    <span class="input-group-text"><i class="fa-solid fa-globe"></i></span>
                                                    <input type="text" name="website_title" id="input_website_title" class="form-control" placeholder="e.g. Unibox Online Store" value="{{ $settings['website_title'] ?? '' }}">
                                                </div>
                                                <small class="text-muted">Displayed in header title tags and browser windows.</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark">Store Tagline / Slogan</label>
                                                <div class="input-group settings-input-group">
                                                    <span class="input-group-text"><i class="fa-solid fa-quote-left"></i></span>
                                                    <input type="text" name="website_tagline" class="form-control" placeholder="e.g. Your One-Stop E-Commerce Solution" value="{{ $settings['website_tagline'] ?? '' }}">
                                                </div>
                                                <small class="text-muted">A short catchphrase summarizing your value proposition.</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark">Registered Company / Trade Name</label>
                                                <div class="input-group settings-input-group">
                                                    <span class="input-group-text"><i class="fa-solid fa-building"></i></span>
                                                    <input type="text" name="company_name" class="form-control" placeholder="e.g. Unibox Enterprise Ltd." value="{{ $settings['company_name'] ?? '' }}">
                                                </div>
                                                <small class="text-muted">Used for invoicing, receipts, and order invoices.</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark">Physical Store / Office Address</label>
                                                <div class="input-group settings-input-group">
                                                    <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                                                    <input type="text" name="company_address" class="form-control" placeholder="House, Road, Area, City" value="{{ $settings['company_address'] ?? '' }}">
                                                </div>
                                                <small class="text-muted">Printed on invoice header and Contact Us page.</small>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-bold text-dark">Company Description / About Story</label>
                                                <textarea name="company_description" class="form-control" rows="3" placeholder="Brief paragraph highlighting your company history, mission, or customer commitment...">{{ $settings['company_description'] ?? '' }}</textarea>
                                                <small class="text-muted">Used for the About Us snippet in widgets and brand bio.</small>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-bold text-dark">Google Maps Location Link / Embed Iframe</label>
                                                <div class="input-group settings-input-group">
                                                    <span class="input-group-text"><i class="fa-solid fa-map-location-dot text-danger"></i></span>
                                                    <input type="text" name="google_map" class="form-control" placeholder="https://maps.google.com/... or iframe src" value="{{ $settings['google_map'] ?? '' }}">
                                                </div>
                                                <small class="text-muted">Optional: Google Map embed URL to display interactive store location on Contact page.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ========================================================
                                 TAB 3: CONTACT & SUPPORT
                                 ======================================================== --}}
                            <div class="tab-pane fade" id="tab-contact" role="tabpanel">
                                <div class="settings-content-card">
                                    <div class="settings-content-header">
                                        <div>
                                            <h5 class="fw-bold mb-1 text-dark">
                                                <i class="fa-solid fa-headset text-success me-2"></i> Official Contact & Support Lines
                                            </h5>
                                            <p class="text-muted small mb-0">Help customers reach your sales team and customer care representatives.</p>
                                        </div>
                                    </div>

                                    <div class="settings-content-body">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="card h-100 border p-3 rounded-4 bg-light-subtle">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="bg-primary text-white rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                                            <i class="fa-solid fa-phone"></i>
                                                        </div>
                                                        <label class="form-label fw-bold text-dark mb-0">Primary Contact Phone</label>
                                                    </div>
                                                    <div class="input-group settings-input-group">
                                                        <input type="text" name="phone" class="form-control" placeholder="01XXXXXXXXX" value="{{ $settings['phone'] ?? '' }}">
                                                    </div>
                                                    <small class="text-muted mt-2">Main customer service line displayed on the top bar.</small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card h-100 border p-3 rounded-4 bg-light-subtle">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="bg-danger text-white rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                                            <i class="fa-solid fa-envelope"></i>
                                                        </div>
                                                        <label class="form-label fw-bold text-dark mb-0">Official Support Email</label>
                                                    </div>
                                                    <div class="input-group settings-input-group">
                                                        <input type="email" name="email" class="form-control" placeholder="support@yourdomain.com" value="{{ $settings['email'] ?? '' }}">
                                                    </div>
                                                    <small class="text-muted mt-2">Email address receiving order inquiries and contact forms.</small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card h-100 border p-3 rounded-4 bg-light-subtle">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="bg-warning text-dark rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                                            <i class="fa-solid fa-phone-volume"></i>
                                                        </div>
                                                        <label class="form-label fw-bold text-dark mb-0">Customer Hotline (Toll-Free / Short code)</label>
                                                    </div>
                                                    <div class="input-group settings-input-group">
                                                        <input type="text" name="hotline" class="form-control" placeholder="e.g. 16XXX or 096XXXXXXXX" value="{{ $settings['hotline'] ?? '' }}">
                                                    </div>
                                                    <small class="text-muted mt-2">Optional hotline badge featured in top header.</small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card h-100 border p-3 rounded-4 bg-light-subtle">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-success text-white rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                                                <i class="fa-brands fa-whatsapp fs-5"></i>
                                                            </div>
                                                            <label class="form-label fw-bold text-dark mb-0">Direct WhatsApp Number</label>
                                                        </div>
                                                        @if(!empty($settings['whatsapp']))
                                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp']) }}" target="_blank" class="badge bg-success text-white text-decoration-none py-1 px-2 rounded-pill small">
                                                                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Test Chat
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="input-group settings-input-group">
                                                        <span class="input-group-text"><i class="fa-solid fa-plus"></i>880</span>
                                                        <input type="text" name="whatsapp" class="form-control" placeholder="1XXXXXXXXX" value="{{ $settings['whatsapp'] ?? '' }}">
                                                    </div>
                                                    <small class="text-muted mt-2">Powers floating WhatsApp live chat buttons across frontend store.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ========================================================
                                 TAB 4: COURIERS & LOGISTICS
                                 ======================================================== --}}
                            <div class="tab-pane fade" id="tab-couriers" role="tabpanel">
                                {{-- Free Shipping Card --}}
                                <div class="settings-content-card">
                                    <div class="settings-content-header bg-success-subtle">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-success text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                <i class="fa-solid fa-gift"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-0 text-success-emphasis">Free Shipping Delivery Promotion</h5>
                                                <p class="text-muted small mb-0">Reward customers with automatic 0 delivery fee above a cart subtotal.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="settings-content-body">
                                        <div class="row align-items-center g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark">Free Delivery Subtotal Threshold (৳)</label>
                                                <div class="input-group settings-input-group">
                                                    <span class="input-group-text fw-bold">৳ BDT</span>
                                                    <input type="number" step="0.01" name="free_shipping_threshold" class="form-control form-control-lg fw-bold text-success" placeholder="0 = Promotion Disabled" value="{{ $settings['free_shipping_threshold'] ?? '' }}">
                                                </div>
                                                <small class="text-muted">Enter e.g. <code>1500</code> for free delivery when cart reaches ৳1500. Set <code>0</code> to disable.</small>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 bg-light rounded-3 border">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <i class="fa-solid fa-circle-info text-primary"></i>
                                                        <span class="fw-bold small text-dark">How Checkout Calculates Free Delivery</span>
                                                    </div>
                                                    <p class="small text-muted mb-0">When customer orders equal or exceed this threshold, delivery fee automatically waives to ৳0 on invoice & checkout.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Steadfast Logistics --}}
                                <div class="settings-content-card">
                                    <div class="settings-content-header">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-dark text-warning rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                <i class="fa-solid fa-bolt"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-0 text-dark">Steadfast Courier API Integration</h5>
                                                <p class="text-muted small mb-0">Automatic parcel creation, real-time tracking, and consignment booking.</p>
                                            </div>
                                        </div>
                                        <a href="https://steadfast.com.bd" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Steadfast Portal
                                        </a>
                                    </div>

                                    <div class="settings-content-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark">Steadfast API Key</label>
                                                <div class="input-group settings-input-group">
                                                    <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                                    <input type="password" name="steadfast_api_key" id="steadfast_api_key" class="form-control font-monospace" placeholder="Enter Steadfast API Key" value="{{ $settings['steadfast_api_key'] ?? '' }}">
                                                    <button class="btn btn-outline-secondary password-toggle-btn" type="button" data-target="steadfast_api_key">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </button>
                                                </div>
                                                <small class="text-muted">Obtained from Steadfast Dashboard &gt; API Credentials.</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark">Steadfast Secret Key</label>
                                                <div class="input-group settings-input-group">
                                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                                    <input type="password" name="steadfast_secret_key" id="steadfast_secret_key" class="form-control font-monospace" placeholder="Enter Steadfast Secret Key" value="{{ $settings['steadfast_secret_key'] ?? '' }}">
                                                    <button class="btn btn-outline-secondary password-toggle-btn" type="button" data-target="steadfast_secret_key">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </button>
                                                </div>
                                                <small class="text-muted">Secret key for authenticating booking requests.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Pathao Logistics --}}
                                <div class="settings-content-card">
                                    <div class="settings-content-header">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-danger text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                <i class="fa-solid fa-motorcycle"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-0 text-dark">Pathao Courier API Integration</h5>
                                                <p class="text-muted small mb-0">Nationwide doorstep delivery via Pathao Merchant API v2.</p>
                                            </div>
                                        </div>
                                        <a href="https://merchant.pathao.com" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Pathao Portal
                                        </a>
                                    </div>

                                    <div class="settings-content-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold text-dark">Pathao Client ID</label>
                                                <div class="input-group settings-input-group">
                                                    <span class="input-group-text"><i class="fa-solid fa-id-badge"></i></span>
                                                    <input type="text" name="pathao_client_id" class="form-control font-monospace" placeholder="Client ID" value="{{ $settings['pathao_client_id'] ?? '' }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bold text-dark">Pathao Client Secret</label>
                                                <div class="input-group settings-input-group">
                                                    <span class="input-group-text"><i class="fa-solid fa-shield-halved"></i></span>
                                                    <input type="password" name="pathao_client_secret" id="pathao_client_secret" class="form-control font-monospace" placeholder="Client Secret" value="{{ $settings['pathao_client_secret'] ?? '' }}">
                                                    <button class="btn btn-outline-secondary password-toggle-btn" type="button" data-target="pathao_client_secret">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bold text-dark">Pathao Store ID</label>
                                                <div class="input-group settings-input-group">
                                                    <span class="input-group-text"><i class="fa-solid fa-shop"></i></span>
                                                    <input type="text" name="pathao_store_id" class="form-control font-monospace" placeholder="Store ID (Numeric)" value="{{ $settings['pathao_store_id'] ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ========================================================
                                 TAB 5: TRACKING & PIXELS
                                 ======================================================== --}}
                            <div class="tab-pane fade" id="tab-tracking" role="tabpanel">
                                <div class="settings-content-card">
                                    <div class="settings-content-header">
                                        <div>
                                            <h5 class="fw-bold mb-1 text-dark">
                                                <i class="fa-solid fa-chart-line text-info me-2"></i> Ad Pixels & Conversion Tracking
                                            </h5>
                                            <p class="text-muted small mb-0">Track purchase conversions, add-to-cart events, and optimize ad spend across Meta & Google.</p>
                                        </div>
                                    </div>

                                    <div class="settings-content-body">
                                        {{-- Meta (Facebook) Card --}}
                                        <div class="p-4 rounded-4 mb-4 border" style="background: linear-gradient(180deg, #f0f7ff 0%, #ffffff 100%);">
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <div class="bg-primary text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                                    <i class="fa-brands fa-meta fs-5"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-0 text-dark">Meta Pixel & Conversions API (CAPI)</h6>
                                                    <small class="text-muted">Accurate purchase event tracking with iOS 14.5+ ad-blocker circumvention.</small>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md-5">
                                                    <label class="form-label fw-bold text-dark">Facebook Pixel ID</label>
                                                    <div class="input-group settings-input-group">
                                                        <span class="input-group-text"><i class="fa-brands fa-facebook"></i></span>
                                                        <input type="text" name="fb_pixel_id" class="form-control font-monospace" placeholder="e.g. 123456789012345" value="{{ $settings['fb_pixel_id'] ?? '' }}">
                                                    </div>
                                                    <small class="text-muted">Found in Meta Events Manager &gt; Data Sources.</small>
                                                </div>

                                                <div class="col-md-7">
                                                    <label class="form-label fw-bold text-dark">Facebook CAPI Access Token (Server-Side)</label>
                                                    <div class="input-group settings-input-group">
                                                        <span class="input-group-text"><i class="fa-solid fa-server"></i></span>
                                                        <input type="password" name="fb_capi_token" id="fb_capi_token" class="form-control font-monospace" placeholder="EAAB..." value="{{ $settings['fb_capi_token'] ?? '' }}">
                                                        <button class="btn btn-outline-secondary password-toggle-btn" type="button" data-target="fb_capi_token">
                                                            <i class="fa-regular fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    <small class="text-muted">Optional: Server-Side Conversions API System User token.</small>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Google Analytics & GTM Card --}}
                                        <div class="p-4 rounded-4 border" style="background: linear-gradient(180deg, #fffbeb 0%, #ffffff 100%);">
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <div class="bg-warning text-dark rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                                    <i class="fa-brands fa-google fs-5"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-0 text-dark">Google Analytics 4 & Tag Manager</h6>
                                                    <small class="text-muted">Visitor demographics, bounce rates, traffic sources, and event tracking.</small>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold text-dark">Google Analytics 4 (GA4) Measurement ID</label>
                                                    <div class="input-group settings-input-group">
                                                        <span class="input-group-text fw-bold">GA4</span>
                                                        <input type="text" name="ga_measurement_id" class="form-control font-monospace" placeholder="e.g. G-XXXXXXXXXX" value="{{ $settings['ga_measurement_id'] ?? '' }}">
                                                    </div>
                                                    <small class="text-muted">Web stream measurement ID from Google Analytics admin.</small>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold text-dark">Google Tag Manager (GTM) Container ID</label>
                                                    <div class="input-group settings-input-group">
                                                        <span class="input-group-text fw-bold">GTM</span>
                                                        <input type="text" name="gtm_id" class="form-control font-monospace" placeholder="e.g. GTM-XXXXXXX" value="{{ $settings['gtm_id'] ?? '' }}">
                                                    </div>
                                                    <small class="text-muted">Container ID to manage all third-party marketing tags.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ========================================================
                                 TAB 6: SEO & GOOGLE SNIPPET
                                 ======================================================== --}}
                            <div class="tab-pane fade" id="tab-seo" role="tabpanel">
                                <div class="settings-content-card">
                                    <div class="settings-content-header">
                                        <div>
                                            <h5 class="fw-bold mb-1 text-dark">
                                                <i class="fa-solid fa-magnifying-glass-chart text-danger me-2"></i> Search Engine Optimization (SEO)
                                            </h5>
                                            <p class="text-muted small mb-0">Configure title tags, search descriptions, and preview how your site looks on Google Search.</p>
                                        </div>
                                    </div>

                                    <div class="settings-content-body">
                                        <div class="row g-4">
                                            <div class="col-12">
                                                {{-- Live Google Search Simulator --}}
                                                <label class="fw-bold text-muted small text-uppercase mb-2" style="letter-spacing: 0.05em;">
                                                    <i class="fa-brands fa-google text-danger me-1"></i> Live Google Search Result Preview
                                                </label>
                                                <div class="google-serp-preview mb-4">
                                                    <div class="google-serp-domain">
                                                        <span class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 24px; height: 24px;">
                                                            <i class="fa-solid fa-globe text-primary" style="font-size: 11px;"></i>
                                                        </span>
                                                        <div>
                                                            <span class="fw-bold">{{ url('/') }}</span>
                                                            <span class="text-muted"> &gt; home</span>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:void(0)" class="google-serp-title" id="serp-live-title">
                                                        {{ !empty($settings['meta_title']) ? $settings['meta_title'] : ($settings['website_title'] ?? 'Store Homepage | Best Online Shopping in Bangladesh') }}
                                                    </a>
                                                    <p class="google-serp-desc" id="serp-live-desc">
                                                        {{ !empty($settings['meta_description']) ? $settings['meta_description'] : ($settings['company_description'] ?? 'Discover premium products with fast delivery, authentic guarantee, and cash on delivery across Bangladesh.') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold text-dark mb-0">Meta Title Tag</label>
                                                    <span class="small text-muted" id="char-meta_title">0 / 60 chars</span>
                                                </div>
                                                <input type="text" name="meta_title" id="input_meta_title" class="form-control" placeholder="e.g. Unibox BD - Premium Online Shopping Store" value="{{ $settings['meta_title'] ?? '' }}">
                                                <small class="text-muted">Recommended: 50-60 characters for optimal Google SERP ranking.</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark mb-1">Meta Keywords</label>
                                                <input type="text" name="meta_keywords" class="form-control" placeholder="e.g. ecommerce, shopping, online store, bangladesh" value="{{ $settings['meta_keywords'] ?? '' }}">
                                                <small class="text-muted">Comma-separated keywords defining your store catalog.</small>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label fw-bold text-dark mb-0">Meta Description</label>
                                                    <span class="small text-muted" id="char-meta_desc">0 / 160 chars</span>
                                                </div>
                                                <textarea name="meta_description" id="input_meta_desc" class="form-control" rows="3" placeholder="Write an engaging 1-2 sentence description enticing search engine users to click on your website...">{{ $settings['meta_description'] ?? '' }}</textarea>
                                                <small class="text-muted">Recommended: 120-160 characters. Appears as the snippet beneath search titles.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ========================================================
                                 TAB 7: SOCIAL CHANNELS
                                 ======================================================== --}}
                            <div class="tab-pane fade" id="tab-social" role="tabpanel">
                                <div class="settings-content-card">
                                    <div class="settings-content-header">
                                        <div>
                                            <h5 class="fw-bold mb-1 text-dark">
                                                <i class="fa-solid fa-share-nodes text-primary me-2"></i> Official Social Media Channels
                                            </h5>
                                            <p class="text-muted small mb-0">Link your brand social profiles to appear in top headers, footers, and live share widgets.</p>
                                        </div>
                                    </div>

                                    <div class="settings-content-body">
                                        <div class="row g-3">
                                            @php
                                                $socialChannels = [
                                                    ['key' => 'facebook', 'label' => 'Facebook Page', 'icon' => 'fa-brands fa-facebook-f', 'color' => '#1877f2', 'placeholder' => 'https://facebook.com/yourbrand'],
                                                    ['key' => 'instagram', 'label' => 'Instagram Profile', 'icon' => 'fa-brands fa-instagram', 'color' => '#e4405f', 'placeholder' => 'https://instagram.com/yourbrand'],
                                                    ['key' => 'youtube', 'label' => 'YouTube Channel', 'icon' => 'fa-brands fa-youtube', 'color' => '#ff0000', 'placeholder' => 'https://youtube.com/@yourbrand'],
                                                    ['key' => 'twitter', 'label' => 'Twitter / X Profile', 'icon' => 'fa-brands fa-x-twitter', 'color' => '#0f172a', 'placeholder' => 'https://x.com/yourbrand'],
                                                    ['key' => 'tiktok', 'label' => 'TikTok Account', 'icon' => 'fa-brands fa-tiktok', 'color' => '#000000', 'placeholder' => 'https://tiktok.com/@yourbrand'],
                                                    ['key' => 'linkedin', 'label' => 'LinkedIn Company', 'icon' => 'fa-brands fa-linkedin-in', 'color' => '#0a66c2', 'placeholder' => 'https://linkedin.com/company/yourbrand'],
                                                    ['key' => 'telegram', 'label' => 'Telegram Channel / Group', 'icon' => 'fa-brands fa-telegram', 'color' => '#229ed9', 'placeholder' => 'https://t.me/yourbrand'],
                                                    ['key' => 'pinterest', 'label' => 'Pinterest Board', 'icon' => 'fa-brands fa-pinterest-p', 'color' => '#bd081c', 'placeholder' => 'https://pinterest.com/yourbrand'],
                                                ];
                                            @endphp

                                            @foreach ($socialChannels as $chan)
                                                <div class="col-md-6">
                                                    <div class="social-input-card">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white shadow-xs" style="width: 28px; height: 28px; background-color: {{ $chan['color'] }};">
                                                                    <i class="{{ $chan['icon'] }}" style="font-size: 0.85rem;"></i>
                                                                </span>
                                                                <span class="fw-bold small text-dark">{{ $chan['label'] }}</span>
                                                            </div>
                                                            @if(!empty($settings[$chan['key']]))
                                                                <a href="{{ $settings[$chan['key']] }}" target="_blank" class="text-muted small text-decoration-none">
                                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <input type="text" name="{{ $chan['key'] }}" class="form-control form-control-sm" placeholder="{{ $chan['placeholder'] }}" value="{{ $settings[$chan['key']] ?? '' }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ========================================================
                                 TAB 8: SMS & NOTIFICATIONS
                                 ======================================================== --}}
                            <div class="tab-pane fade" id="tab-sms" role="tabpanel">
                                <div class="settings-content-card">
                                    <div class="settings-content-header">
                                        <div>
                                            <h5 class="fw-bold mb-1 text-dark">
                                                <i class="fa-solid fa-comment-sms text-secondary me-2"></i> Automated SMS & Customer Notifications
                                            </h5>
                                            <p class="text-muted small mb-0">Control transactional SMS notifications triggered by order status changes.</p>
                                        </div>
                                    </div>

                                    <div class="settings-content-body">
                                        {{-- SMS Gateway API Credentials --}}
                                        <div class="p-4 rounded-4 mb-4 border bg-white shadow-xs">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-dark text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                        <i class="fa-solid fa-server fs-6"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-0 text-dark">SMS Gateway Configuration (BD Providers)</h6>
                                                        <small class="text-muted">Compatible with BulkSMSBD, Alpha SMS, Greenweb, Reve SMS or custom HTTP API</small>
                                                    </div>
                                                </div>
                                                <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-1 small">
                                                    HTTP GET / POST API
                                                </span>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md-5">
                                                    <label class="form-label fw-bold text-dark">SMS Gateway API URL</label>
                                                    <div class="input-group settings-input-group">
                                                        <span class="input-group-text"><i class="fa-solid fa-link"></i></span>
                                                        <input type="text" name="sms_url" class="form-control font-monospace" placeholder="http://bulksmsbd.net/api/smsapi" value="{{ $settings['sms_url'] ?? 'http://bulksmsbd.net/api/smsapi' }}">
                                                    </div>
                                                    <small class="text-muted">Base URL endpoint provided by your SMS aggregator.</small>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold text-dark">SMS API Key / Token</label>
                                                    <div class="input-group settings-input-group">
                                                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                                        <input type="password" name="sms_api_key" id="sms_api_key" class="form-control font-monospace" placeholder="Enter API Key" value="{{ $settings['sms_api_key'] ?? '' }}">
                                                        <button class="btn btn-outline-secondary password-toggle-btn" type="button" data-target="sms_api_key">
                                                            <i class="fa-regular fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    <small class="text-muted">Secret API Key from your SMS dashboard.</small>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold text-dark">Sender ID / Masking</label>
                                                    <div class="input-group settings-input-group">
                                                        <span class="input-group-text"><i class="fa-solid fa-signature"></i></span>
                                                        <input type="text" name="sms_sender_id" class="form-control font-monospace" placeholder="e.g. 8809612... or UNIBOX" value="{{ $settings['sms_sender_id'] ?? '' }}">
                                                    </div>
                                                    <small class="text-muted">Approved masking name or number.</small>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Automated Notification Triggers --}}
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="card p-4 rounded-4 border h-100 bg-light-subtle">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <div class="bg-primary text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                                            <i class="fa-solid fa-receipt fs-5"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="fw-bold text-dark mb-0">Order Confirmation SMS</h6>
                                                            <small class="text-muted">Sends immediate SMS with Order ID after checkout.</small>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <select name="order_sms_enabled" class="form-select form-select-lg fw-bold">
                                                            <option value="1" {{ ($settings['order_sms_enabled'] ?? '') == '1' ? 'selected' : '' }}>
                                                                ✅ Enabled (Send SMS on new order)
                                                            </option>
                                                            <option value="0" {{ ($settings['order_sms_enabled'] ?? '') == '0' ? 'selected' : '' }}>
                                                                ❌ Disabled (No SMS)
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="p-3 bg-white rounded-3 border small text-muted">
                                                        <strong class="text-dark d-block mb-1"><i class="fa-regular fa-comment-dots me-1"></i> Preview:</strong>
                                                        "Dear Customer, your order #{order_id} of ৳{total} has been confirmed. Thank you for shopping with Unibox!"
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card p-4 rounded-4 border h-100 bg-light-subtle">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <div class="bg-success text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                                            <i class="fa-solid fa-truck-ramp-box fs-5"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="fw-bold text-dark mb-0">Order Status Update SMS</h6>
                                                            <small class="text-muted">Notifies customer when order is Shipped or Delivered.</small>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <select name="status_sms_enabled" class="form-select form-select-lg fw-bold">
                                                            <option value="1" {{ ($settings['status_sms_enabled'] ?? '') == '1' ? 'selected' : '' }}>
                                                                ✅ Enabled (Send SMS on status change)
                                                            </option>
                                                            <option value="0" {{ ($settings['status_sms_enabled'] ?? '') == '0' ? 'selected' : '' }}>
                                                                ❌ Disabled (No SMS)
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="p-3 bg-white rounded-3 border small text-muted">
                                                        <strong class="text-dark d-block mb-1"><i class="fa-regular fa-comment-dots me-1"></i> Preview:</strong>
                                                        "Your order #{order_id} is now on the way with {courier}. Tracking code: {tracking_code}."
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ========================================================
                                 TAB 9: FOOTER & LEGAL
                                 ======================================================== --}}
                            <div class="tab-pane fade" id="tab-footer" role="tabpanel">
                                <div class="settings-content-card">
                                    <div class="settings-content-header">
                                        <div>
                                            <h5 class="fw-bold mb-1 text-dark">
                                                <i class="fa-solid fa-file-shield text-dark me-2"></i> Footer Content & Copyright
                                            </h5>
                                            <p class="text-muted small mb-0">Information presented in website bottom footers, badges, and copyright statements.</p>
                                        </div>
                                    </div>

                                    <div class="settings-content-body">
                                        <div class="row g-4">
                                            <div class="col-12">
                                                <label class="form-label fw-bold text-dark">Footer About Synopsis</label>
                                                <textarea name="footer_about" class="form-control" rows="4" placeholder="Brief 2-3 sentence overview of your brand displayed directly under the footer logo...">{{ $settings['footer_about'] ?? '' }}</textarea>
                                                <small class="text-muted">Appears in footer Column 1 under the company logo.</small>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-bold text-dark">Copyright Statement</label>
                                                <div class="input-group settings-input-group">
                                                    <span class="input-group-text"><i class="fa-regular fa-copyright"></i></span>
                                                    <input type="text" name="copyright_text" class="form-control" placeholder="e.g. 2025 Unibox BD. All rights reserved." value="{{ $settings['copyright_text'] ?? '' }}">
                                                </div>
                                                <small class="text-muted">Displayed at the bottom-most bar across all frontend pages.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ========================================================
                                 TAB 10: CUSTOM SCRIPTS
                                 ======================================================== --}}
                            <div class="tab-pane fade" id="tab-scripts" role="tabpanel">
                                <div class="settings-content-card">
                                    <div class="settings-content-header">
                                        <div>
                                            <h5 class="fw-bold mb-1 text-dark">
                                                <i class="fa-solid fa-code text-purple me-2"></i> Custom Script Injections
                                            </h5>
                                            <p class="text-muted small mb-0">Inject custom JavaScript, CSS, live chat widgets (Tawk.to, Crisp), or verification meta tags.</p>
                                        </div>
                                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-2 small">
                                            <i class="fa-solid fa-triangle-exclamation me-1"></i> For Developers
                                        </span>
                                    </div>

                                    <div class="settings-content-body">
                                        <div class="row g-4">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label class="form-label fw-bold text-dark mb-0">
                                                        <i class="fa-solid fa-code me-1 text-primary"></i> Header Scripts Injected inside <code>&lt;head&gt; ... &lt;/head&gt;</code>
                                                    </label>
                                                    <span class="badge bg-dark text-white font-monospace small">&lt;head&gt;</span>
                                                </div>
                                                <textarea name="custom_header_scripts" class="form-control code-textarea" rows="5" placeholder="<!-- Paste verification meta tags, custom fonts, or head script tags here -->">{{ $settings['custom_header_scripts'] ?? '' }}</textarea>
                                                <small class="text-muted">Scripts will be rendered directly inside the HTML <code>&lt;head&gt;</code> tag.</small>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label class="form-label fw-bold text-dark mb-0">
                                                        <i class="fa-solid fa-code me-1 text-success"></i> Footer Scripts Injected before <code>&lt;/body&gt;</code>
                                                    </label>
                                                    <span class="badge bg-dark text-white font-monospace small">&lt;/body&gt;</span>
                                                </div>
                                                <textarea name="custom_footer_scripts" class="form-control code-textarea" rows="5" placeholder="<!-- Paste Live Chat widget codes, affiliate trackers, or body scripts here -->">{{ $settings['custom_footer_scripts'] ?? '' }}</textarea>
                                                <small class="text-muted">Scripts will be rendered right before the closing <code>&lt;/body&gt;</code> tag.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- FLOATING STICKY ACTION BAR --}}
    <div class="settings-bottom-bar d-flex align-items-center justify-content-between">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 small fw-semibold" id="save-status-indicator">
                    <i class="fa-solid fa-circle-check me-1"></i> All settings up to date
                </span>
                <span class="text-muted small d-none d-md-inline">Make sure to click save after updating any settings.</span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-light border rounded-pill px-3 fw-semibold btn-sm" onclick="location.reload();">
                    <i class="fa-solid fa-rotate-left me-1"></i> Reset
                </button>
                <button type="submit" form="settingsForm" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm btn-save-action">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Save All Settings
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // =========================================================
        // 1. BULLETPROOF TAB SWITCHING (NO SIDEBAR HIDING)
        // =========================================================
        $(document).on('click', '#settingsTabList .nav-link', function(e) {
            e.preventDefault();
            e.stopPropagation();

            let $btn = $(this);
            let targetSelector = $btn.attr('data-bs-target');
            if (!targetSelector) return;

            // 1. Update tab button active states
            $('#settingsTabList .nav-link').removeClass('active').attr('aria-selected', 'false');
            $btn.addClass('active').attr('aria-selected', 'true');

            // 2. Direct, flicker-free pane switching
            $('.tab-content > .tab-pane').removeClass('show active');
            $(targetSelector).addClass('show active');

            // 3. Persist in URL hash & localStorage
            try {
                history.replaceState(null, null, targetSelector);
                localStorage.setItem('unibox_active_setting_tab', targetSelector);
            } catch (err) {}
        });

        function activateTab(tabId) {
            if (!tabId) return;
            tabId = tabId.replace('#', '');
            let $btn = $(`#settingsTabList [data-bs-target="#${tabId}"]`);
            if ($btn.length) {
                // Direct activation without triggering form effects
                $('#settingsTabList .nav-link').removeClass('active').attr('aria-selected', 'false');
                $btn.addClass('active').attr('aria-selected', 'true');

                $('.tab-content > .tab-pane').removeClass('show active');
                $(`#${tabId}`).addClass('show active');
            }
        }

        // On page load: restore previous tab or URL hash
        let initialTab = window.location.hash || localStorage.getItem('unibox_active_setting_tab');
        if (initialTab) {
            activateTab(initialTab);
        } else {
            activateTab('tab-branding');
        }

        // =========================================================
        // 2. LIVE IMAGE UPLOAD PREVIEW
        // =========================================================
        $('.file-preview-trigger').on('change', function() {
            let file = this.files[0];
            let target = $(this).data('target');
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $(`#preview-${target}`).attr('src', e.target.result).removeClass('d-none');
                    $(`#placeholder-${target}`).addClass('d-none');

                    // If favicon, also update browser mock tab
                    if (target === 'favicon') {
                        $('#tab-favicon-preview').html(`<img src="${e.target.result}" width="16" height="16" class="rounded-circle">`);
                    }
                };
                reader.readAsDataURL(file);
                markUnsaved();
            }
        });

        // =========================================================
        // 3. LIVE GOOGLE SERP PREVIEW & CHARACTER COUNTERS
        // =========================================================
        function updateSerp() {
            let title = $('#input_meta_title').val() || $('#input_website_title').val() || 'Store Homepage | Best Online Shopping in Bangladesh';
            let desc = $('#input_meta_desc').val() || 'Discover premium products with fast delivery, authentic guarantee, and cash on delivery across Bangladesh.';

            $('#serp-live-title').text(title);
            $('#serp-live-desc').text(desc);

            let titleLen = ($('#input_meta_title').val() || '').length;
            let descLen = ($('#input_meta_desc').val() || '').length;

            $('#char-meta_title').text(`${titleLen} / 60 chars`).toggleClass('text-warning', titleLen > 60);
            $('#char-meta_desc').text(`${descLen} / 160 chars`).toggleClass('text-warning', descLen > 160);
        }

        $('#input_meta_title, #input_meta_desc, #input_website_title').on('input', updateSerp);
        updateSerp(); // initialize count

        // =========================================================
        // 4. PASSWORD & SECRET VISIBILITY TOGGLE
        // =========================================================
        $('.password-toggle-btn').on('click', function() {
            let targetId = $(this).data('target');
            let input = $('#' + targetId);
            let icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash text-danger');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash text-danger').addClass('fa-eye');
            }
        });

        // =========================================================
        // 5. SETTINGS SEARCH / FILTER (SAFE - NEVER BLANK)
        // =========================================================
        $('#settingSearch').on('input keyup search blur', function() {
            let val = $(this).val().toLowerCase().trim();
            if (!val) {
                $('#settingsTabList .nav-link').removeClass('d-none').show();
                return;
            }

            let matchCount = 0;
            $('#settingsTabList .nav-link').each(function() {
                let searchData = ($(this).data('search') || '') + ' ' + $(this).text().toLowerCase();
                if (searchData.indexOf(val) > -1) {
                    $(this).removeClass('d-none').show();
                    matchCount++;
                } else {
                    $(this).addClass('d-none').hide();
                }
            });

            // Prevent blank sidebar if user types random key
            if (matchCount === 0) {
                $('#settingsTabList .nav-link').removeClass('d-none').show();
            }
        });

        // =========================================================
        // 6. UNSAVED CHANGES INDICATOR
        // =========================================================
        let isDirty = false;
        function markUnsaved() {
            if (!isDirty) {
                isDirty = true;
                $('#save-status-indicator')
                    .removeClass('bg-success-subtle text-success border-success-subtle')
                    .addClass('bg-warning-subtle text-warning-emphasis border-warning-subtle')
                    .html('<i class="fa-solid fa-pen-to-square me-1"></i> You have unsaved changes');
            }
        }

        $('#settingsForm input, #settingsForm textarea, #settingsForm select').on('input change', function() {
            markUnsaved();
        });

        // Form submit spinner & feedback
        $('#settingsForm').on('submit', function() {
            $('.btn-save-action')
                .prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...');
        });
    });
</script>
@endpush
