<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8"/>
    <title>@yield('title') | {{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('admin.layouts.header-links')
    @stack('style-link')
    @stack('style')
    @yield('style')

</head>

<body>

<!-- Begin page -->
<section class="el-container">

    @php
        $visitCounts = getVisitCounts();
    @endphp
    @include('admin.layouts.sidebar', ['visitCounts' => $visitCounts])
    <!-- Left Sidebar End -->

    <section class="el-content p-4 lg:p-6">

        @include('admin.layouts.header')

        <!-- removeNotificationModal -->
        @stack('modal')
        @stack('offcanvasa')

        <!-- ========== App Menu ========== -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <main class="el-main flex-1">
            @yield('main')
        </main>
        <!-- container-fluid -->

    </section>
    <!-- End Page-content -->

    @include('admin.layouts.footer')
    <!-- end main content-->

</section>
<!-- END layout-wrapper -->


<!--start back-to-top-->

<!--end back-to-top-->

<!--preloader-->


{{-- @include('admin.layouts.theme-setting') --}}

@include('admin.layouts.footer-links')
@include('admin.layouts.common-js')
@stack('script-link')
@stack('script')
@yield('script')
<script !src="">
    $(document).ready(function () {

    });
</script>
</body>
</html>
