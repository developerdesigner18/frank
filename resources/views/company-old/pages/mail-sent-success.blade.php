<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8"/>
    <title>Forgot Password | Mystery Visitor </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('admin.layouts.header-links')
</head>

<body>
<div class="auth-page-wrapper pt-5 mt-5">
    <div class="auth-page-content">
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="#" class="d-inline-block auth-logo">
                                <img src="{{asset('assets/logo/logo.png')}}" alt="" height="100">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4 card-bg-fill">
                        <div class="card-body p-4 text-center">
                            <div class="avatar-lg mx-auto mt-2">
                                <div class="avatar-title bg-light text-success display-3 rounded-circle">
                                    <i class="ri-checkbox-circle-fill"></i>
                                </div>
                            </div>
                            <div class="mt-4 pt-2">
                                <h4>Delivered!</h4>
                                <p class="text-muted mx-4">A mail has been sent your mail.</p>
                                <div class="mt-4">
                                    <a href="{{route('company.login')}}" class="btn btn-success w-100">Back to Login</a>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">&copy;
                            <script>document.write(new Date().getFullYear())</script> {{env('APP_NAME')}}. Crafted with
                            <i class="mdi mdi-heart text-danger"></i> by TshrXD
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->

@include('admin.layouts.footer-links')
@include('admin.layouts.common-js')

</body>
</html>
