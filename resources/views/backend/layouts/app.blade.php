<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ setting('website_title') ?: setting('company_name', 'Unibox') }} | Admin | @yield('title')</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="{{ setting('website_title', 'Unibox Admin') }}" />
    <meta name="author" content="{{ setting('company_name', 'Unibox') }}" />
    <meta name="description" content="{{ setting('meta_description', 'Unibox Management System') }}" />
    <meta name="supported-color-schemes" content="light dark" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $backendFav = setting('favicon') ?: setting('nav_icon');
    @endphp
    @if($backendFav && file_exists(public_path($backendFav)))
        <link rel="shortcut icon" href="{{ asset($backendFav) }}" type="image/x-icon">
    @elseif(file_exists(public_path('favicon.ico')))
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif
    @include('backend.partials.style')
 
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg {{ request()->routeIs('sales.create') ? 'sidebar-collapse' : 'sidebar-open' }} bg-body-tertiary">
    <audio id="order-sound" src="{{ asset('backend/sounds/notification.wav') }}" preload="auto"></audio>
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        
        <!--begin::Header-->
        @include('backend.layouts.navbar')
        <!--end::Header-->
        <!--begin::Sidebar-->
        @include('backend.layouts.sidebar')
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">
            @yield('content')
        </main>
        <!--end::App Main-->
        @unless(request()->routeIs('sales.create'))
        <!--begin::Footer-->
        <footer class="app-footer">
            <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline">Anything you want</div>
            <!--end::To the end-->
            <strong>
                Copyright &copy; {{ date('Y') }}&nbsp;
                <a href="{{ route('dashboard') }}" class="text-decoration-none">{{ setting('company_name', 'Unibox') }}</a>.
            </strong>
            {{ setting('copyright_text', 'All rights reserved.') }}
        </footer>
        <!--end::Footer-->
        @endunless
    </div>

    @include('backend.partials.js')

</body>
<!--end::Body-->

</html>
