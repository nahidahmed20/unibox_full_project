@extends('backend.layouts.app')
@section('title', 'Coupons & Vouchers')

@section('content')
<style>
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.15); }
    .bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
    .coupon-code-badge {
        font-family: 'Courier New', Courier, monospace;
        letter-spacing: 1px;
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 6px;
        background: #f1f5f9;
        border: 1px dashed #cbd5e1;
        font-weight: 700;
        color: #1e293b;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    /* Modal & Live Coupon Ticket Styling */
    #couponModal .modal-dialog {
        max-width: 980px;
    }
    .coupon-ticket {
        background: linear-gradient(135deg, #091322 0%, #0f1e38 45%, #1d3557 100%);
        border-radius: 20px;
        padding: 24px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.45);
        border: 1px solid rgba(255, 255, 255, 0.12);
    }
    .coupon-ticket::before,
    .coupon-ticket::after {
        content: '';
        position: absolute;
        width: 26px;
        height: 26px;
        background: #ffffff;
        border-radius: 50%;
        top: 58%;
        transform: translateY(-50%);
        z-index: 4;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.18);
    }
    .coupon-ticket::before { left: -13px; }
    .coupon-ticket::after { right: -13px; }

    .coupon-ticket-glow {
        position: absolute;
        top: -40px;
        right: -40px;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.5) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .coupon-ticket-glow-bottom {
        position: absolute;
        bottom: -50px;
        left: -30px;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.4) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .coupon-ticket-dashed {
        border-top: 2px dashed rgba(255, 255, 255, 0.25);
        margin: 20px 0;
        position: relative;
    }
    .coupon-ticket-code-pill {
        background: rgba(255, 255, 255, 0.08);
        border: 1.5px dashed rgba(56, 189, 248, 0.7);
        border-radius: 12px;
        padding: 9px 20px;
        font-family: 'Courier New', Courier, monospace;
        font-size: 19px;
        font-weight: 800;
        letter-spacing: 3px;
        color: #38bdf8;
        text-shadow: 0 0 14px rgba(56, 189, 248, 0.5);
        display: inline-block;
        transition: all 0.2s ease;
    }
    .coupon-type-radio:checked + label {
        background-color: #eff6ff !important;
        border-color: #2563eb !important;
        color: #1d4ed8 !important;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2) !important;
    }
</style>

<div class="app-content-wrapper pt-3">
    <div class="container-fluid px-4">

        {{-- PAGE HEADER & BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1 fw-bold text-dark"><i class="bi bi-ticket-perforated-fill me-2 text-primary"></i> Coupons & Discounts</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0" style="font-size: 14px;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark">Coupons</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-primary shadow-sm" id="btnOpenAddModal"><i class="bi bi-plus-lg me-2"></i> Create Coupon</button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- KPI STATS CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-ticket-detailed fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Coupons</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalCoupons }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success-light text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-check-circle fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Active Coupons</h6>
                            <h4 class="mb-0 fw-bold">{{ $activeCoupons }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning-light text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-hourglass-bottom fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Expired Coupons</h6>
                            <h4 class="mb-0 fw-bold">{{ $expiredCoupons }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info-light text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-receipt fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Times Used</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalUsedCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th class="ps-4">Code</th>
                                <th>Title / Details</th>
                                <th>Discount</th>
                                <th>Min. Order</th>
                                <th>Validity Period</th>
                                <th>Usage / Limit</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coupons as $coupon)
                                @php
                                    $isExpired = $coupon->end_date && now()->startOfDay()->gt($coupon->end_date);
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="coupon-code-badge">
                                            <span>{{ $coupon->code }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $coupon->title ?? 'Promo Discount' }}</div>
                                        @if($coupon->type === 'percent' && $coupon->max_discount)
                                            <small class="text-muted">Max discount: ৳{{ number_format($coupon->max_discount, 2) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($coupon->type === 'percent')
                                            <span class="badge bg-primary fs-6">{{ $coupon->value }}% OFF</span>
                                        @else
                                            <span class="badge bg-success fs-6">৳{{ number_format($coupon->value, 2) }} OFF</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($coupon->min_order_amount > 0)
                                            <span>৳{{ number_format($coupon->min_order_amount, 2) }}</span>
                                        @else
                                            <span class="text-muted">No Minimum</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($coupon->start_date || $coupon->end_date)
                                            <small class="d-block text-secondary">
                                                {{ $coupon->start_date ? $coupon->start_date->format('d M, Y') : 'Immediate' }}
                                                to
                                                {{ $coupon->end_date ? $coupon->end_date->format('d M, Y') : 'Lifetime' }}
                                            </small>
                                            @if($isExpired)
                                                <span class="badge bg-danger mt-1">Expired</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Always Valid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $coupon->used_count }}</span>
                                        <span class="text-muted">/ {{ $coupon->usage_limit ? $coupon->usage_limit : '∞' }}</span>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-status-btn" type="checkbox" role="switch"
                                                data-id="{{ $coupon->id }}" {{ $coupon->status ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-light text-primary me-1 edit-coupon-btn" data-id="{{ $coupon->id }}" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="d-inline coupon-delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-light text-danger btn-delete-coupon" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-ticket-perforated fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                        No coupons created yet. Click "Create Coupon" above to add your first promotion.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ================= LUXURY LIVE COUPON MODAL ================= --}}
<div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <form id="couponForm" method="POST" action="{{ route('coupons.store') }}">
                @csrf
                <div id="methodSpoofing"></div>

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="bi bi-ticket-perforated-fill text-primary"></i>
                        <span id="modalTitleText">Create Promotional Coupon</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-4">
                        {{-- Left Column: Form Controls (7 cols) --}}
                        <div class="col-lg-7">

                            {{-- SECTION 1: COUPON IDENTITY --}}
                            <div class="p-3 bg-light rounded-3 border mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="coupon_code" class="form-label fw-bold text-dark small text-uppercase mb-0">
                                        Coupon Code <span class="text-danger">*</span>
                                    </label>
                                    <button type="button" class="btn btn-sm btn-link text-primary text-decoration-none p-0 fw-semibold" id="btnAutoGenerateCode" style="font-size: 12px;">
                                        <i class="bi bi-magic me-1"></i> Auto-Generate
                                    </button>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-white text-primary border-end-0"><i class="bi bi-tag-fill"></i></span>
                                    <input type="text" name="code" id="coupon_code" class="form-control text-uppercase fw-bold font-monospace border-start-0" placeholder="e.g. EID50 or SPECIAL10" required style="letter-spacing: 1.5px; font-size: 15px;">
                                </div>

                                <label for="coupon_title" class="form-label fw-bold text-dark small text-uppercase mb-1">Campaign Title / Description</label>
                                <input type="text" name="title" id="coupon_title" class="form-control" placeholder="e.g. Eid Mega Discount Campaign">
                            </div>

                            {{-- SECTION 2: DISCOUNT CONFIGURATION --}}
                            <div class="p-3 bg-light rounded-3 border mb-3">
                                <label class="form-label fw-bold text-dark small text-uppercase mb-2">Discount Type & Amount <span class="text-danger">*</span></label>
                                
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check coupon-type-radio" name="type" id="type_fixed" value="fixed" checked autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2 rounded-3 fw-semibold" for="type_fixed">
                                            <i class="bi bi-cash-stack"></i>
                                            <span>Fixed Amount (৳)</span>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" class="btn-check coupon-type-radio" name="type" id="type_percent" value="percent" autocomplete="off">
                                        <label class="btn btn-outline-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2 rounded-3 fw-semibold" for="type_percent">
                                            <i class="bi bi-percent"></i>
                                            <span>Percentage (%)</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="coupon_value" class="form-label fw-bold text-dark small text-uppercase mb-1">
                                            Discount Value <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white fw-bold text-primary" id="discountValueAdornment">৳</span>
                                            <input type="number" step="0.01" min="0" name="value" id="coupon_value" class="form-control fw-bold" placeholder="50" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="maxDiscountWrapper">
                                        <label for="coupon_max_discount" class="form-label fw-bold text-dark small text-uppercase mb-1">
                                            Max Discount Cap <span class="badge bg-white text-muted border ms-1 fw-normal" style="font-size: 10px;">For %</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white text-muted">৳</span>
                                            <input type="number" step="0.01" min="0" name="max_discount" id="coupon_max_discount" class="form-control" placeholder="Optional">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 3: SPEND & USAGE RESTRICTIONS --}}
                            <div class="p-3 bg-light rounded-3 border mb-3">
                                <label class="form-label fw-bold text-dark small text-uppercase mb-2">Usage Limits & Restrictions</label>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="coupon_min_order" class="form-label fw-semibold text-muted small mb-1">Min. Order Spend</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white text-muted">৳</span>
                                            <input type="number" step="0.01" min="0" name="min_order_amount" id="coupon_min_order" class="form-control" placeholder="0 = No Min.">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="coupon_usage_limit" class="form-label fw-semibold text-muted small mb-1">Total Usage Limit</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white text-muted"><i class="bi bi-people"></i></span>
                                            <input type="number" min="1" name="usage_limit" id="coupon_usage_limit" class="form-control" placeholder="Unlimited">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="coupon_start_date" class="form-label fw-semibold text-muted small mb-1">Start Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white text-muted"><i class="bi bi-calendar3"></i></span>
                                            <input type="date" name="start_date" id="coupon_start_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="coupon_end_date" class="form-label fw-semibold text-muted small mb-1">Expiry Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white text-muted"><i class="bi bi-calendar-check"></i></span>
                                            <input type="date" name="end_date" id="coupon_end_date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 4: IMMEDIATE STATUS TOGGLE --}}
                            <div class="p-3 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-check-label fw-bold text-dark d-block mb-0" for="coupon_status">Activate Immediately</label>
                                    <small class="text-muted" style="font-size: 11px;">Customers can apply this voucher at checkout right away.</small>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" name="status" value="1" id="coupon_status" checked style="width: 2.4em; height: 1.25em;">
                                </div>
                            </div>

                        </div>

                        {{-- Right Column: Live Voucher Card Preview (5 cols) --}}
                        <div class="col-lg-5">
                            <div class="sticky-top" style="top: 10px;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-uppercase fw-bold text-muted small" style="font-size: 11px; letter-spacing: 0.5px;">Live Voucher Preview</span>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1" style="font-size: 11px;">
                                        <i class="bi bi-eye me-1"></i> Interactive
                                    </span>
                                </div>

                                {{-- Luxury Voucher Ticket --}}
                                <div class="coupon-ticket">
                                    <div class="coupon-ticket-glow"></div>
                                    <div class="coupon-ticket-glow-bottom"></div>

                                    {{-- Ticket Header --}}
                                    <div class="d-flex justify-content-between align-items-center mb-3 position-relative" style="z-index: 2;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 32px; height: 32px; font-size: 14px;">
                                                <i class="bi bi-ticket-perforated-fill"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-white small" style="letter-spacing: 0.5px;">UNIBOX PROMO</div>
                                                <small class="text-white-50" style="font-size: 10px;">Official Store Voucher</small>
                                            </div>
                                        </div>
                                        <span id="previewStatusBadge" class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 11px;">
                                            <i class="bi bi-check-circle-fill me-1"></i> Active
                                        </span>
                                    </div>

                                    {{-- Ticket Value & Title --}}
                                    <div class="text-center my-3 position-relative" style="z-index: 2;">
                                        <div class="text-white-50 text-uppercase small fw-semibold mb-1" id="previewTitleText">Promotional Discount</div>
                                        <h1 class="display-6 fw-bolder text-white mb-0" id="previewDiscountText" style="letter-spacing: -0.5px;">
                                            ৳50 OFF
                                        </h1>
                                        <div id="previewMaxCap" class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 mt-2 d-none" style="font-size: 11px;">
                                            Max ৳0
                                        </div>
                                    </div>

                                    {{-- Perforated Dashed Line --}}
                                    <div class="coupon-ticket-dashed"></div>

                                    {{-- Ticket Code Box --}}
                                    <div class="text-center position-relative mb-3" style="z-index: 2;">
                                        <div class="small text-white-50 mb-1" style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Coupon Code</div>
                                        <div class="coupon-ticket-code-pill shadow-sm" id="previewCodeText">
                                            COUPONCODE
                                        </div>
                                    </div>

                                    {{-- Ticket Conditions Footer --}}
                                    <div class="row g-2 text-white-50 pt-2 border-top border-white border-opacity-10 position-relative" style="font-size: 11px; z-index: 2;">
                                        <div class="col-6">
                                            <span class="d-block text-white-50" style="font-size: 10px;">MIN. SPEND:</span>
                                            <span class="fw-semibold text-white" id="previewMinSpend">No Minimum</span>
                                        </div>
                                        <div class="col-6 text-end">
                                            <span class="d-block text-white-50" style="font-size: 10px;">VALIDITY:</span>
                                            <span class="fw-semibold text-white" id="previewValidity">Lifetime / Always</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Merchant Guidelines Under Voucher --}}
                                <div class="card border border-light-subtle rounded-3 mt-3 shadow-none bg-light p-3">
                                    <h6 class="fw-bold text-dark small mb-2 d-flex align-items-center gap-1">
                                        <i class="bi bi-lightbulb-fill text-warning"></i> Merchant Tips:
                                    </h6>
                                    <ul class="mb-0 ps-3 text-muted small" style="font-size: 12px; line-height: 1.6;">
                                        <li>Promo codes are auto-formatted into uppercase for easy checkout entry.</li>
                                        <li>For percentage discounts, set a <strong>Max Cap</strong> to control store liability.</li>
                                        <li>Leave dates blank for indefinite evergreen coupons.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="bi bi-check2-circle me-1"></i> Save Coupon
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('couponModal'));
        const form = document.getElementById('couponForm');
        const modalTitleText = document.getElementById('modalTitleText');
        const methodSpoofing = document.getElementById('methodSpoofing');

        function formatDate(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
        }

        // LIVE TICKET PREVIEW UPDATER
        function updateCouponPreview() {
            const code = document.getElementById('coupon_code').value.trim() || 'COUPONCODE';
            const title = document.getElementById('coupon_title').value.trim() || 'Promotional Campaign';
            const type = document.querySelector('input[name="type"]:checked')?.value || 'fixed';
            const value = parseFloat(document.getElementById('coupon_value').value) || 0;
            const minOrder = parseFloat(document.getElementById('coupon_min_order').value) || 0;
            const maxDiscount = parseFloat(document.getElementById('coupon_max_discount').value) || 0;
            const startDate = document.getElementById('coupon_start_date').value;
            const endDate = document.getElementById('coupon_end_date').value;
            const status = document.getElementById('coupon_status').checked;

            document.getElementById('previewCodeText').textContent = code.toUpperCase();
            document.getElementById('previewTitleText').textContent = title;

            if (type === 'percent') {
                document.getElementById('previewDiscountText').textContent = value > 0 ? `${value}% OFF` : '0% OFF';
                document.getElementById('discountValueAdornment').textContent = '%';
                document.getElementById('maxDiscountWrapper').style.opacity = '1';
                if (maxDiscount > 0) {
                    document.getElementById('previewMaxCap').textContent = `Max ৳${maxDiscount.toLocaleString()}`;
                    document.getElementById('previewMaxCap').classList.remove('d-none');
                } else {
                    document.getElementById('previewMaxCap').classList.add('d-none');
                }
            } else {
                document.getElementById('previewDiscountText').textContent = value > 0 ? `৳${value.toLocaleString()} OFF` : '৳0 OFF';
                document.getElementById('discountValueAdornment').textContent = '৳';
                document.getElementById('maxDiscountWrapper').style.opacity = '0.5';
                document.getElementById('previewMaxCap').classList.add('d-none');
            }

            document.getElementById('previewMinSpend').textContent = minOrder > 0 ? `৳${minOrder.toLocaleString()}` : 'No Minimum';

            if (startDate || endDate) {
                let validityText = '';
                if (startDate && endDate) validityText = `${formatDate(startDate)} - ${formatDate(endDate)}`;
                else if (endDate) validityText = `Until ${formatDate(endDate)}`;
                else validityText = `From ${formatDate(startDate)}`;
                document.getElementById('previewValidity').textContent = validityText;
            } else {
                document.getElementById('previewValidity').textContent = 'Lifetime / Always';
            }

            const statusBadge = document.getElementById('previewStatusBadge');
            if (status) {
                statusBadge.className = 'badge bg-success-subtle text-success border border-success-subtle px-2 py-1';
                statusBadge.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Active';
            } else {
                statusBadge.className = 'badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1';
                statusBadge.innerHTML = '<i class="bi bi-pause-circle-fill me-1"></i> Paused';
            }
        }

        // EVENT LISTENERS FOR LIVE PREVIEW
        ['input', 'change'].forEach(evt => {
            ['coupon_code', 'coupon_title', 'coupon_value', 'coupon_min_order', 'coupon_max_discount', 'coupon_start_date', 'coupon_end_date', 'coupon_status'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.addEventListener(evt, updateCouponPreview);
            });
        });

        document.querySelectorAll('input[name="type"]').forEach(radio => {
            radio.addEventListener('change', updateCouponPreview);
        });

        // AUTO-GENERATE CODE
        document.getElementById('btnAutoGenerateCode').addEventListener('click', function () {
            const prefixes = ['SAVE', 'MEGA', 'FLASH', 'SUPER', 'SPECIAL', 'PROMO', 'OFF', 'EID', 'DEAL'];
            const prefix = prefixes[Math.floor(Math.random() * prefixes.length)];
            const randNum = Math.floor(10 + Math.random() * 89);
            const codeInput = document.getElementById('coupon_code');
            codeInput.value = prefix + randNum;
            updateCouponPreview();
        });

        // OPEN ADD MODAL
        document.getElementById('btnOpenAddModal').addEventListener('click', function () {
            form.reset();
            form.action = "{{ route('coupons.store') }}";
            methodSpoofing.innerHTML = '';
            modalTitleText.textContent = 'Create Promotional Coupon';
            document.getElementById('type_fixed').checked = true;
            document.getElementById('coupon_status').checked = true;
            updateCouponPreview();
            modal.show();
        });

        // OPEN EDIT MODAL
        document.querySelectorAll('.edit-coupon-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                fetch(`/admin/coupons/${id}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        form.action = `/admin/coupons/${id}`;
                        methodSpoofing.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                        modalTitleText.textContent = 'Edit Coupon: ' + data.code;

                        document.getElementById('coupon_code').value = data.code;
                        document.getElementById('coupon_title').value = data.title || '';
                        if (data.type === 'percent') {
                            document.getElementById('type_percent').checked = true;
                        } else {
                            document.getElementById('type_fixed').checked = true;
                        }
                        document.getElementById('coupon_value').value = data.value;
                        document.getElementById('coupon_min_order').value = data.min_order_amount || '';
                        document.getElementById('coupon_max_discount').value = data.max_discount || '';
                        document.getElementById('coupon_start_date').value = data.start_date ? data.start_date.split('T')[0] : '';
                        document.getElementById('coupon_end_date').value = data.end_date ? data.end_date.split('T')[0] : '';
                        document.getElementById('coupon_usage_limit').value = data.usage_limit || '';
                        document.getElementById('coupon_status').checked = data.status == 1;

                        updateCouponPreview();
                        modal.show();
                    });
            });
        });

        // AJAX STATUS TOGGLE
        document.querySelectorAll('.toggle-status-btn').forEach(toggle => {
            toggle.addEventListener('change', function () {
                const id = this.getAttribute('data-id');
                fetch(`/admin/coupons/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message || 'Status updated');
                    } else {
                        toastr.error('Could not update status');
                    }
                })
                .catch(() => toastr.error('Network error'));
            });
        });

        // SWEETALERT DELETE
        document.querySelectorAll('.btn-delete-coupon').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Delete this coupon?',
                    text: "Customers will no longer be able to use this promotional code.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection

