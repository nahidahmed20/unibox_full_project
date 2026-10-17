@extends('frontend.layouts.app')
@section('title', 'Thank You | Unibox')

@section('content')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/home-thank-you-1.css') }}">
@endpush
<main id="MainContent" class="content-for-layout">
    <div class="container d-flex justify-content-center" style="margin-top:80px">

        <div class="thankyou-card text-center">

            <h1 id="thankyouText" class="thankyou-title">
                ধন্যবাদ
            </h1>

            <p id="orderText" class="thankyou-desc">
                আপনার অর্ডারটি সফলভাবে গ্রহণ করা হয়েছে <br>
                <span class="order-no">
                    Order Number: {{ $order->order_number }}
                </span>
            </p>

            <a href="{{ route('home') }}" class="home-btn">
                হোমে ফিরে যান
            </a>

        </div>

    </div>
</main>
@endsection
@push('js')
    <script>
    $(document).ready(function () {

        $('.thankyou-card').fadeTo(800, 1, function () {
            $('#orderText').fadeTo(1200, 1);
        });

    });
    </script>
@endpush
