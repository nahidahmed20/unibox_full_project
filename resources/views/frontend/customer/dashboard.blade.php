@extends('frontend.layouts.app')
@section('title', 'Your account')
@push('css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/account.css') }}?v={{ filemtime(public_path('frontend/assets/css/account.css')) }}">
@endpush
@section('content')
<section class="ub-account-page"><div class="container">
 <div class="ub-account-heading"><div><span class="ub-eyebrow">YOUR ACCOUNT</span><h1>Hello, {{ auth('customer')->user()->name ?: 'welcome back' }}.</h1><p>Everything you need, all in one place.</p></div><a class="ub-button ub-button-outline" href="{{ route('search') }}">Continue shopping <i class="fa-regular fa-arrow-right" aria-hidden="true"></i></a></div>
 <div class="ub-account-layout">
  @include('frontend.customer.partials.sidebar')
  <div>
   <div class="ub-account-stats">
    @foreach([['fa-bag-shopping', $totalOrders, 'Total orders'], ['fa-box', $processingOrders, 'In progress'], ['fa-check', $completedOrders, 'Delivered']] as [$icon, $value, $label])
     <div class="ub-account-stat"><i class="fa-regular {{ $icon }}" aria-hidden="true"></i><strong>{{ $value }}</strong><span>{{ $label }}</span></div>
    @endforeach
   </div>
   <div class="ub-account-panel">
    <div class="ub-account-heading"><h2>Recent orders</h2><a class="ub-text-link" href="{{ route('account.orders.index') }}">View all <i class="fa-regular fa-arrow-right" aria-hidden="true"></i></a></div>
    @if($orders->isEmpty())
     <div class="ub-account-empty"><i class="fa-regular fa-bag-shopping" aria-hidden="true"></i><h3>Your next favourite is waiting.</h3><p>When you place an order, you can follow its progress here.</p><a class="ub-button ub-button-primary" href="{{ route('search') }}">Explore the collection</a></div>
    @else
     <div class="table-responsive"><table class="ub-account-table"><thead><tr><th>Order</th><th>Date</th><th>Status</th><th>Total</th><th><span class="visually-hidden">Details</span></th></tr></thead><tbody>
     @foreach($orders as $order)<tr><td>{{ $order->order_number }}</td><td>{{ $order->created_at->format('d M Y') }}</td><td><span class="ub-account-status" data-status="{{ $order->status }}">{{ ucfirst($order->status) }}</span></td><td>৳{{ number_format($order->total, 2) }}</td><td><a href="{{ route('account.orders.show', $order->order_number) }}">View order →</a></td></tr>@endforeach
     </tbody></table></div>
     <div class="mt-4">{{ $orders->links() }}</div>
    @endif
   </div>
   <div class="ub-account-panel"><h2>A little help?</h2><p class="mt-3">Questions about a product or an order? We'd love to help.</p><a class="ub-text-link" href="{{ route('contact.us') }}">Contact our team <i class="fa-regular fa-arrow-right" aria-hidden="true"></i></a></div>
  </div>
 </div>
</div></section>
@endsection
