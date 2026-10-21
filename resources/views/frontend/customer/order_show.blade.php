@extends('frontend.layouts.app')
@section('title', 'অর্ডার বিবরণী | Order #' . $order->order_number)

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
            <div class="col-lg-9">
                {{-- Order Header Card --}}
                <div class="p-4 rounded-4 bg-white border shadow-xs mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-0.5 rounded-pill mb-1 bg-primary bg-opacity-10 text-primary fw-bold" style="font-size: 11px;">
                                <i class="fa-solid fa-receipt"></i> ORDER DETAILS
                            </div>
                            <h4 class="fw-bolder text-dark mb-0 fs-4">অর্ডার #{{ $order->order_number }}</h4>
                            <small class="text-muted">প্লেস করা হয়েছে: {{ $order->created_at->format('d M, Y (h:i A)') }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
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
                            <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 fw-bold" style="font-size: 13px;">
                                <i class="fa-solid fa-circle-dot me-1 small"></i> {{ ucfirst($order->status) }}
                            </span>
                            <a href="{{ route('account.orders.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1.5 fw-semibold" style="font-size: 12.5px;">
                                <i class="fa-solid fa-arrow-left me-1"></i> ফিরে যান
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Order Info Cards --}}
                <div class="row g-4 mb-4">
                    {{-- Delivery Information --}}
                    <div class="col-md-6">
                        <div class="p-4 rounded-4 bg-white border shadow-xs h-100">
                            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom text-primary">
                                <i class="fa-solid fa-location-dot"></i>
                                <h6 class="fw-bold text-dark mb-0">ডেলিভারি তথ্য</h6>
                            </div>
                            <div class="d-flex flex-column gap-1.5 small text-muted">
                                <div><strong class="text-dark">প্রাপকের নাম:</strong> {{ $order->full_name }}</div>
                                <div><strong class="text-dark">ফোন নম্বর:</strong> {{ $order->phone }}</div>
                                @if($order->email)
                                    <div><strong class="text-dark">ইমেইল:</strong> {{ $order->email }}</div>
                                @endif
                                <div><strong class="text-dark">ডেলিভারি ঠিকানা:</strong> {{ $order->address }}</div>
                                @if($order->note)
                                    <div class="mt-2 pt-2 border-top fst-italic">
                                        <strong class="text-dark">বিশেষ নোট:</strong> {{ $order->note }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Payment & Shipping Details --}}
                    <div class="col-md-6">
                        <div class="p-4 rounded-4 bg-white border shadow-xs h-100">
                            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom text-success">
                                <i class="fa-solid fa-credit-card"></i>
                                <h6 class="fw-bold text-dark mb-0">পেমেন্ট ও অর্ডার সারাংশ</h6>
                            </div>
                            <div class="d-flex flex-column gap-1.5 small text-muted">
                                <div><strong class="text-dark">পেমেন্ট পদ্ধতি:</strong> <span class="badge bg-light text-dark border text-uppercase">{{ $order->payment_method ?: 'ক্যাশ অন ডেলিভারি' }}</span></div>
                                <div><strong class="text-dark">পেমেন্ট স্ট্যাটাস:</strong> <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($order->payment_status ?: 'pending') }}</span></div>
                                <div><strong class="text-dark">অর্ডারের তারিখ:</strong> {{ $order->created_at->format('d M, Y (h:i A)') }}</div>
                                <div><strong class="text-dark">মোট প্রোডাক্ট সংখ্যা:</strong> {{ $order->items->count() }}টি আইটেম</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Items Table --}}
                <div class="p-4 rounded-4 bg-white border shadow-xs mb-4">
                    <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom fs-5">অর্ডারের আইটেমসমূহ</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-muted text-uppercase" style="font-size: 11px;">
                                    <th class="ps-3 py-2.5">প্রোডাক্ট</th>
                                    <th class="text-center py-2.5">একক মূল্য</th>
                                    <th class="text-center py-2.5">পরিমাণ</th>
                                    <th class="text-end pe-3 py-2.5">মোট মূল্য</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center gap-2.5">
                                                @if(optional($item->product)->image)
                                                    <img src="{{ asset($item->product->image) }}" class="rounded-3 border" width="44" height="44" style="object-fit: cover;">
                                                @else
                                                    <div class="rounded-3 border bg-light d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                                        <i class="fa-solid fa-box text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="fw-bold text-dark d-block fs-6" style="font-size: 13.5px;">{{ $item->product_name }}</span>
                                                    @if($item->variant_name)
                                                        <small class="badge bg-light text-muted border" style="font-size: 10.5px;">{{ $item->variant_name }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-medium text-dark">
                                            ৳{{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="text-center fw-bold text-dark">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="text-end pe-3 fw-bold text-dark">
                                            ৳{{ number_format($item->total, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Price Breakdown Summary --}}
                <div class="p-4 rounded-4 bg-white border shadow-xs">
                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between text-muted small">
                                    <span>সাবটোটাল (Subtotal):</span>
                                    <span class="fw-semibold text-dark">৳{{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between text-muted small">
                                    <span>ডেলিভারি চার্জ (Shipping):</span>
                                    <span class="fw-semibold text-dark">৳{{ number_format($order->shipping, 2) }}</span>
                                </div>
                                @if($order->discount && $order->discount > 0)
                                    <div class="d-flex justify-content-between text-success small">
                                        <span>ডিসকাউন্ট (Discount):</span>
                                        <span class="fw-semibold">-৳{{ number_format($order->discount, 2) }}</span>
                                    </div>
                                @endif
                                <div class="d-flex justify-content-between pt-2 border-top fs-5 fw-bold text-dark">
                                    <span>সর্বমোট প্রদেয়:</span>
                                    <span class="text-primary">৳{{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection