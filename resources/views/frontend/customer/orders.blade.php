@extends('frontend.layouts.app')
@section('title', 'আমার অর্ডারসমূহ | My Orders')

@push('css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/account.css') }}?v={{ filemtime(public_path('frontend/assets/css/account.css')) }}">
@endpush

@section('content')
<section class="ub-account-page py-4 py-md-5">
    <div class="container">

        <div class="row g-4">
            {{-- Sidebar --}}
            <div class="col-lg-3">
                @include('frontend.customer.partials.sidebar')
            </div>

            {{-- Content --}}
            <div class="col-lg-9" id="account-content">

                {{-- Page Header --}}
                <div class="p-4 rounded-4 bg-white border shadow-xs mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-0.5 rounded-pill mb-1 bg-primary bg-opacity-10 text-primary fw-bold" style="font-size: 11px;">
                            <i class="fa-solid fa-bag-shopping"></i> ORDER HISTORY
                        </div>
                        <h4 class="fw-bolder text-dark mb-0 fs-4">আমার অর্ডারসমূহ (My Orders)</h4>
                        <small class="text-muted">আপনার পূর্বের সকল অর্ডারের তালিকা ও বর্তমান ডেলিভারি স্ট্যাটাস</small>
                    </div>
                    <a href="{{ route('search') }}" class="btn btn-sm btn-dark rounded-pill px-3 py-2 fw-semibold text-white shadow-xs" style="background: #0f172a; font-size: 12.5px;">
                        <i class="fa-solid fa-cart-shopping me-1"></i> নতুন অর্ডার করুন
                    </a>
                </div>

                {{-- Orders Table Card --}}
                <div class="p-4 rounded-4 bg-white border shadow-xs">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="small text-muted text-uppercase" style="font-size: 11px;">
                                        <th class="ps-3 py-2.5">অর্ডার নম্বর</th>
                                        <th class="py-2.5">তারিখ</th>
                                        <th class="py-2.5">স্ট্যাটাস</th>
                                        <th class="py-2.5">পেমেন্ট</th>
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
                                                <a href="{{ route('account.orders.show', $order->order_number) }}" class="text-dark text-decoration-none">
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
                                            <td>
                                                <span class="badge bg-light text-dark border text-uppercase" style="font-size: 10.5px;">
                                                    {{ $order->payment_method ?: 'COD' }} ({{ ucfirst($order->payment_status ?: 'pending') }})
                                                </span>
                                            </td>
                                            <td class="fw-bold text-dark">
                                                ৳{{ number_format($order->total, 2) }}
                                            </td>
                                            <td class="text-end pe-3">
                                                <a href="{{ route('account.orders.show', $order->order_number) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-semibold" style="font-size: 12px;">
                                                    ডিটেইলস <i class="fa-solid fa-arrow-right small ms-1"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="p-5 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 70px; height: 70px;">
                                <i class="fa-solid fa-box-open text-muted fs-3"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">কোনো অর্ডার রেকর্ড পাওয়া যায়নি</h5>
                            <p class="text-muted small mb-3">আপনি এখনো কোনো অর্ডার প্লেস করেননি। আপনার পছন্দের পণ্যগুলো আজই অর্ডার করুন।</p>
                            <a href="{{ route('search') }}" class="btn btn-sm btn-dark rounded-pill px-4 py-2.5 fw-bold text-white shadow-xs" style="background: #0f172a;">
                                <i class="fa-solid fa-cart-shopping me-1"></i> সকল প্রোডাক্ট দেখুন
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</section>
@endsection