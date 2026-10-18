<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'Explore products for your business, your everyday, and your next idea. Shop the Unibox collection and discover custom options.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#202020">
    <title>@yield('title', 'Shop') | Unibox</title>
    @if (setting('nav_icon'))
        <link rel="icon" href="{{ asset(setting('nav_icon')) }}">
    @endif
    @include('frontend.partials.style')
    @include('frontend.partials.analytics')
</head>

<body class="ub-store">
    @include('frontend.partials.header')
    <main id="main-content">@yield('content')</main>
    @include('frontend.partials.footer')
    @include('frontend.partials.script')
    @if(setting('custom_footer_scripts'))
        {!! setting('custom_footer_scripts') !!}
    @endif
    <script
        src="{{ asset('frontend/assets/js/storefront.js') }}?v={{ filemtime(public_path('frontend/assets/js/storefront.js')) }}"
        defer></script>
</body>

</html>
