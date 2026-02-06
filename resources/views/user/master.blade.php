<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/user/image/favicon.png') }}" type="image/x-icon">

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- iOS PWA Support -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Mystery Visits">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo/bar_logo.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input/build/css/intlTelInput.css">

    @include('user.layouts.header-links')
    @stack('style-link')
    @stack('style')
    @yield('style')

</head>

<body>

<section class="el-container">

    @include('user.layouts.sidebar')

    <section class="el-content p-4 lg:p-6">

        @include('user.layouts.header')

        @stack('modal')

        <main class="el-main flex-1">
            @yield('main')
        </main>

    </section>

</section>

<!-- iOS Install Prompt (Bubble) -->
@include('user.layouts.ios-install-prompt')

</body>

<!-- JS Plugins -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input/build/js/intlTelInput.min.js"></script>

@include('user.layouts.footer-links')
@include('user.layouts.common-js')
@stack('script-link')
@stack('script')
@yield('script')

<!-- Service Worker Registration -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/service-worker.js')
                .then(function (reg) {
                    console.log('Service worker registered.', reg);
                })
                .catch(function (err) {
                    console.warn('Service worker registration failed:', err);
                });
        });
    }
</script>

</html>
