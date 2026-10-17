<link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.min.css') }}">
@hasSection('uses-swiper')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/swiper.min.css') }}">
@endif
<link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}?v={{ filemtime(public_path('frontend/assets/css/main.css')) }}">
@hasSection('uses-select2')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
@endif
@stack('css')
<link rel="stylesheet"
    href="{{ asset('frontend/assets/css/storefront.css') }}?v={{ filemtime(public_path('frontend/assets/css/storefront.css')) }}">
