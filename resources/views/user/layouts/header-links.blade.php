<!-- ================== Stylesheets ================== -->

<link rel="shortcut icon" href="{{ asset('assets/user/image/favicon.png') }}" type="image/x-icon">

@if(!request()->is('admin') && !request()->is('admin/*'))
<link rel="manifest" href="{{ asset('manifest.json') }}">
@endif



<!-- Main User Styles -->
<link rel="stylesheet" href="{{ asset('assets/user/css/style.css') }}">

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="{{asset('assets/admin_new/css/toastify.css')}}">
<link href="{{ asset('assets/admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
<!-- Icons Css -->
<link href="{{asset('assets/admin/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>

<!-- ================== Tailwind (via CDN) ================== -->
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

<link rel="stylesheet" href="{{asset('assets/admin/libs/flatpickr/flatpickr.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/raty/2.9.0/jquery.raty.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">