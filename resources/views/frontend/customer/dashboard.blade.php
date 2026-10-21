@extends('frontend.layouts.app')
@section('title', 'গ্রাহক ড্যাশবোর্ড | Customer Account')

@push('css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/account.css') }}?v={{ filemtime(public_path('frontend/assets/css/account.css')) }}">
@endpush

@section('content')
@php
    $customer = auth('customer')->user();
    $customerName = $customer->name ?: 'Customer';
@endphp

<section class="ub-account-page py-4 py-md-5">
    <div class="container">

        {{-- EXECUTIVE WELCOME HERO CARD --}}
        <div class="p-4 p-md-5 mb-4 rounded-4 position-relative overflow-hidden shadow-sm"
             style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #1e1b4b 100%); color: #ffffff;">
            <div class="row align-items-center g-3 position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2"
                         style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); font-size: 11.5px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                        <i class="fa-solid fa-crown text-warning"></i>
                        <span>CUSTOMER PORTAL OVERVIEW</span>
                    </div>
                    <h1 class="fw-bolder mb-1 text-white" style="font-size: clamp(24px, 3.5vw, 36px); line-height: 1.2;">
                        স্বাগতম, {{ $customerName }}! 👋
                    </h1>
                    <p class="mb-0 text-white-50 small" style="max-width: 580px; font-size: 14px;">
                        আপনার অ্যাকাউন্টের সাম্প্রতিক অর্ডার, ডেলিভারি ট্র্যাকিং এবং প্রোফাইল তথ্য এক নজরে দেখে নিন।
                    </p>
                </div>
                <div class="col-lg-4 text-start text-lg-end">
                    <div class="d-flex align-items-center gap-2 justify-content-lg-end flex-wrap">
                        <a class="btn btn-sm btn-light rounded-pill px-3 py-2 fw-bold text-dark d-inline-flex align-items-center gap-2 shadow-xs" href="{{ route('search') }}">
                            <i class="fa-solid fa-cart-shopping text-primary"></i>
                            <span>শপিং করুন</span>
                        </a>
                        <a class="btn btn-sm btn-outline-light rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2" href="{{ route('track.order') }}">
                            <i class="fa-solid fa-truck-fast"></i>
                            <span>ট্র্যাক অর্ডার</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- SIDEBAR --}}
            <div class="col-lg-3">
                @include('frontend.customer.partials.sidebar')
            </div>

            {{-- MAIN DASHBOARD CONTENT --}}
            <div class="col-lg-9">
                {{-- 1. 4 STAT CARDS --}}
                <div class="row g-3 mb-4">
                    {{-- TOTAL ORDERS --}}
                    <div class="col-6 col-md-3">
                        <div class="p-3.5 p-md-4 rounded-4 bg-white border shadow-xs h-100 ub-account-kpi-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small text-muted fw-bold text-uppercase" style="font-size: 11px;">মোট অর্ডার</span>
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 16px;">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                </div>
                            </div>
                            <h3 class="fw-bolder text-dark mb-0 fs-3">{{ $totalOrders }}</h3>
                            <small class="text-muted" style="font-size: 11.5px;">সর্বমোট প্লেসকৃত অর্ডার</small>
                        </div>
                    </div>

                    {{-- IN PROGRESS --}}
                    <div class="col-6 col-md-3">
                        <div class="p-3.5 p-md-4 rounded-4 bg-white border shadow-xs h-100 ub-account-kpi-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small text-muted fw-bold text-uppercase" style="font-size: 11px;">প্রসেসিং হচ্ছে</span>
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 16px;">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </div>
                            </div>
                            <h3 class="fw-bolder text-dark mb-0 fs-3">{{ $processingOrders }}</h3>
                            <small class="text-muted" style="font-size: 11.5px;">পেন্ডিং ও প্রসেসিং</small>
                        </div>
                    </div>

                    {{-- DELIVERED --}}
                    <div class="col-6 col-md-3">
                        <div class="p-3.5 p-md-4 rounded-4 bg-white border shadow-xs h-100 ub-account-kpi-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small text-muted fw-bold text-uppercase" style="font-size: 11px;">সফল ডেলিভারি</span>
                                <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 16px;">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <h3 class="fw-bolder text-dark mb-0 fs-3">{{ $completedOrders }}</h3>
                            <small class="text-muted" style="font-size: 11.5px;">সম্পূর্ণ ডেলিভারকৃত</small>
                        </div>
                    </div>

                    {{-- TOTAL SPENT --}}
                    <div class="col-6 col-md-3">
                        <div class="p-3.5 p-md-4 rounded-4 bg-white border shadow-xs h-100 ub-account-kpi-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small text-muted fw-bold text-uppercase" style="font-size: 11px;">মোট কেনাকাটা</span>
                                <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 16px;">
                                    <i class="fa-solid fa-wallet"></i>
                                </div>
                            </div>
                            <h3 class="fw-bolder text-dark mb-0 fs-4">৳{{ number_format($totalSpent ?? 0) }}</h3>
                            <small class="text-muted" style="font-size: 11.5px;">মোট পেমেন্ট ভ্যালু</small>
                        </div>
                    </div>
                </div>

                {{-- 2. QUICK ACTION SHORTCUTS --}}
                <div class="p-3 mb-4 rounded-4 bg-white border shadow-xs d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="small text-muted fw-bold text-uppercase" style="font-size: 11px;">QUICK LINKS:</span>
                        <a href="{{ route('track.order') }}" class="badge bg-light text-dark border px-3 py-2 rounded-pill text-decoration-none fw-semibold">
                            <i class="fa-solid fa-truck-fast text-primary me-1"></i> ট্র্যাক অর্ডার
                        </a>
                        <a href="{{ route('account.profile.edit') }}" class="badge bg-light text-dark border px-3 py-2 rounded-pill text-decoration-none fw-semibold">
                            <i class="fa-solid fa-location-dot text-danger me-1"></i> ডেলিভারি ঠিকানা
                        </a>
                        <a href="{{ route('account.password.edit') }}" class="badge bg-light text-dark border px-3 py-2 rounded-pill text-decoration-none fw-semibold">
                            <i class="fa-solid fa-lock text-warning me-1"></i> পাসওয়ার্ড
                        </a>
                    </div>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp', '01640914338')) }}" target="_blank" class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill text-decoration-none fw-bold">
                        <i class="fa-brands fa-whatsapp me-1"></i> হেল্পলাইন সাপোর্ট
                    </a>
                </div>

                {{-- 3. RECENT ORDERS PANEL --}}
                <div class="p-4 rounded-4 bg-white border shadow-xs mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom flex-wrap gap-2">
                        <div>
                            <h5 class="fw-bold text-dark mb-0">সাম্প্রতিক অর্ডারসমূহ (Recent Orders)</h5>
                            <small class="text-muted">আপনার সর্বশেষ ৫টি অর্ডারের রিয়েল-টাইম স্ট্যাটাস</small>
                        </div>
                        <a class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1" href="{{ route('account.orders.index') }}" style="font-size: 12px;">
                            <span>সবগুলো দেখুন</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    @if($orders->isEmpty())
                        <div class="p-4 p-md-5 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 70px; height: 70px;">
                                <i class="fa-solid fa-bag-shopping text-muted fs-3"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">এখনো কোনো অর্ডার প্লেস করেননি</h5>
                            <p class="text-muted small mb-3">আপনার পছন্দের সেরা কালেকশনটি এখনই খুঁজে নিন।</p>
                            <a class="btn btn-sm btn-dark rounded-pill px-4 py-2 fw-bold text-white shadow-xs" href="{{ route('search') }}" style="background: #0f172a;">
                                <i class="fa-solid fa-cart-shopping me-1"></i> শপিং শুরু করুন
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="small text-muted text-uppercase" style="font-size: 11px;">
                                        <th class="ps-3 py-2.5">অর্ডার নম্বর</th>
                                        <th class="py-2.5">তারিখ</th>
                                        <th class="py-2.5">স্ট্যাটাস</th>
                                        <th class="py-2.5">মোট মূল্য</th>
                                        <th class="text-end pe-3 py-2.5">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-warning text-dark',
                                                'processing' => 'bg-info text-dark',
                                                'shipped' => 'bg-primary text-white',
                                                'delivered' => 'bg-success text-white',
                                                'cancelled' => 'bg-danger text-white',
                                                'return' => 'bg-secondary text-white',
                                            ];
                                            $badgeClass = $statusColors[strtolower($order->status)] ?? 'bg-secondary text-white';
                                        @endphp
                                        <tr>
                                            <td class="ps-3 fw-bold text-dark">
                                                <a href="{{ route('account.orders.show', $order->order_number) }}" class="text-dark text-decoration-none hover-primary">
                                                    #{{ $order->order_number }}
                                                </a>
                                            </td>
                                            <td class="small text-muted">
                                                {{ $order->created_at->format('d M, Y') }}
                                            </td>
                                            <td>
                                                <span class="badge {{ $badgeClass }} rounded-pill px-2.5 py-1 small fw-semibold" style="font-size: 11px;">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="fw-bold text-dark">
                                                ৳{{ number_format($order->total, 2) }}
                                            </td>
                                            <td class="text-end pe-3">
                                                <a href="{{ route('account.orders.show', $order->order_number) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-semibold" style="font-size: 11.5px;">
                                                    ডিটেইলস <i class="fa-solid fa-arrow-right small ms-1"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- 4. SAVED ADDRESS PREVIEW & SUPPORT CARD --}}
                <div class="row g-4">
                    {{-- SAVED ADDRESS PREVIEW --}}
                    <div class="col-md-7">
                        <div class="p-4 rounded-4 bg-white border shadow-xs h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-location-dot text-danger"></i>
                                        <h6 class="fw-bold text-dark mb-0">ডিফল্ট ডেলিভারি ঠিকানা</h6>
                                    </div>
                                    <a href="{{ route('account.profile.edit') }}" class="small text-primary text-decoration-none fw-semibold">
                                        পরিবর্তন করুন <i class="fa-solid fa-pen small ms-1"></i>
                                    </a>
                                </div>

                                <div class="mb-3">
                                    <span class="d-block small text-muted text-uppercase fw-bold mb-1" style="font-size: 11px;">বাসার ঠিকানা (Home Address):</span>
                                    <p class="text-dark small mb-0 fw-medium" style="line-height: 1.5;">
                                        {{ $customer->address ?: 'কোনো বাসার ঠিকানা এখনো যুক্ত করা হয়নি।' }}
                                    </p>
                                </div>

                                @if($customer->office_address)
                                    <div>
                                        <span class="d-block small text-muted text-uppercase fw-bold mb-1" style="font-size: 11px;">অফিস ঠিকানা (Office Address):</span>
                                        <p class="text-dark small mb-0 fw-medium" style="line-height: 1.5;">
                                            {{ $customer->office_address }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="pt-3 border-top mt-3 text-muted small" style="font-size: 11.5px;">
                                <i class="fa-solid fa-shield-halved text-success me-1"></i> অর্ডার প্লেস করার সময় এই ঠিকানা স্বয়ংক্রিয়ভাবে ব্যবহার হবে।
                            </div>
                        </div>
                    </div>

                    {{-- NEED HELP CARD --}}
                    <div class="col-md-5">
                        <div class="p-4 rounded-4 bg-white border shadow-xs h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-2 text-primary">
                                    <i class="fa-solid fa-headset fs-5"></i>
                                    <h6 class="fw-bold text-dark mb-0">যেকোনো সহায়তায় পাশে আছি</h6>
                                </div>
                                <p class="text-muted small mb-3" style="line-height: 1.6; font-size: 12.5px;">
                                    অর্ডার স্ট্যাটাস, পণ্য পরিবর্তন বা যেকোনো সমস্যায় আমাদের কাস্টমার কেয়ারে কল দিন।
                                </p>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <a href="tel:{{ preg_replace('/[^+0-9]/', '', setting('hotline', setting('phone', '01640914338'))) }}" class="btn btn-sm btn-outline-dark rounded-pill py-2 fw-semibold w-100 d-flex align-items-center justify-content-center gap-2" style="font-size: 12.5px;">
                                    <i class="fa-solid fa-phone"></i>
                                    <span>হটলাইন: {{ setting('hotline', setting('phone', '01640914338')) }}</span>
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp', '01640914338')) }}" target="_blank" class="btn btn-sm btn-success rounded-pill py-2 fw-semibold w-100 d-flex align-items-center justify-content-center gap-2" style="font-size: 12.5px;">
                                    <i class="fa-brands fa-whatsapp fs-6"></i>
                                    <span>WhatsApp সাপোর্ট</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
