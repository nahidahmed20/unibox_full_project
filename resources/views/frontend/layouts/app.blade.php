<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('meta_description', 'Explore premium products for your business, your everyday, and your next idea. Shop the Unibox collection and discover custom options.'))">
    <meta name="keywords" content="@yield('keywords', setting('meta_keywords', 'ecommerce, online shop, bangladesh, unibox, fashion, lifestyle'))">
    <meta name="author" content="{{ setting('company_name', 'Unibox') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#202020">

    @php
        $siteTitle = setting('meta_title') ?: setting('website_title') ?: setting('company_name', 'Unibox');
    @endphp
    <title>@hasSection('title')@yield('title') | {{ $siteTitle }}@else{{ $siteTitle }} - {{ setting('company_tagline', 'Best Online Shopping in Bangladesh') }}@endif</title>

    {{-- Open Graph / Social Media Sharing --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', $siteTitle)">
    <meta property="og:description" content="@yield('description', setting('meta_description', 'Explore premium products with fast delivery across Bangladesh.'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ setting('company_name', 'Unibox') }}">
    @if(setting('header_logo', setting('logo')))
        <meta property="og:image" content="{{ asset(setting('header_logo', setting('logo'))) }}">
    @endif

    {{-- Favicon & Web App Icons --}}
    @php
        $fav = setting('favicon') ?: setting('nav_icon');
    @endphp
    @if ($fav && file_exists(public_path($fav)))
        <link rel="icon" href="{{ asset($fav) }}">
        <link rel="apple-touch-icon" href="{{ asset($fav) }}">
    @elseif (file_exists(public_path('favicon.ico')))
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif

    @include('frontend.partials.style')
    @include('frontend.partials.analytics')
</head>

<body class="ub-store">
    {{-- Google Tag Manager (noscript fallback) --}}
    @if(setting('gtm_id'))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ setting('gtm_id') }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    @include('frontend.partials.header')
    <main id="main-content">@yield('content')</main>
    @include('frontend.partials.footer')
    @include('frontend.partials.script')

    {{-- Custom Footer Tracking Scripts --}}
    @if(setting('custom_footer_scripts'))
        {!! setting('custom_footer_scripts') !!}
    @endif
    <script
        src="{{ asset('frontend/assets/js/storefront.js') }}?v={{ filemtime(public_path('frontend/assets/js/storefront.js')) }}"
        defer></script>
</body>

</html>
