@extends('frontend.layouts.app')

@section('title', 'My Orders')

@push('css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/account.css') }}?v={{ filemtime(public_path('frontend/assets/css/account.css')) }}">
@endpush
@section('content')

<section class="ub-account-page ub-account-detail">
    <div class="container">

        <div class="row g-4"><div class="col-lg-3">@include('frontend.customer.partials.sidebar')</div>
            {{-- Content --}}
            <div class="col-lg-9" id="account-content">

                <div class="ub-account-panel mb-4">
                    <h3>My Orders</h3>
                    <p>All your order history is shown below.</p>
                </div>

                <div class="ub-account-panel">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Order No</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                {{ $order->order_number }}
                                            </td>
                                            <td>
                                                {{ $order->created_at->format('d M Y') }}
                                            </td>
                                            <td>
                                                @if($order->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($order->status == 'processing')
                                                    <span class="badge bg-info">Processing</span>
                                                @elseif($order->status == 'delivered')
                                                    <span class="badge bg-success">Delivered</span>
                                                @else
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @endif

                                            </td>
                                            <td>
                                                {{ ucfirst($order->payment_status) }}
                                            </td>
                                            <td>
                                                ৳ {{ number_format($order->total, 2) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('account.orders.show', $order->order_number) }}"
                                                   class="btn btn-sm btn-primary ">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $orders->links() }}
                        </div>
                    @else

                        <p class="text-center text-muted">
                            No orders found
                        </p>

                    @endif

                </div>

            </div>

        </div>

    </div>
</section>

@endsection