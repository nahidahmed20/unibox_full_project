<script src="{{ asset('frontend/assets/js/vendor/jquary-3.6.0.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/bootstrap-bundle.js') }}"></script>
@hasSection('uses-swiper')
    <script src="{{ asset('frontend/assets/js/vendor/swiper.min.js') }}"></script>
@endif
@hasSection('uses-select2')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endif
<script src="{{ asset('frontend/assets/js/vendor/sweetalert2.all.min.js') }}?v={{ filemtime(public_path('frontend/assets/js/vendor/sweetalert2.all.min.js')) }}"></script>
@php
    $storeConfig = [
        'cartUpdate' => route('cart.update'),
        'cartRemove' => route('cart.remove', ['id' => '__id__']),
        'search' => route('search.suggestion'),
        'success' => session('success'),
        'error' => session('error'),
    ];
@endphp
<script id="unibox-config" type="application/json">@json($storeConfig)</script>
@stack('javascript')
