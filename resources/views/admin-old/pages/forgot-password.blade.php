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

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Forgot Password?</h5>
                                <p class="text-muted">Reset password with {{env('APP_NAME')}}</p>

                                <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop"
                                           colors="primary:#0ab39c" class="avatar-xl"></lord-icon>

                            </div>

                            <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                                Enter your email and instructions will be sent to you!
                            </div>
                            <div class="p-2">
                                <form id="loginForm">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                               placeholder="Enter Email">
                                        <label id="email-error" class="text-danger error" for="email"
                                               style="display: none"></label>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button class="btn btn-success w-100" type="submit" id="loginButton"><i
                                                    class="bx bx-loader spinner me-2"
                                                    style="display: none" id="loginBtnSpinner"></i> Send Reset
                                            Link
                                        </button>
                                    </div>
                                </form><!-- end form -->
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Wait, I remember my password... <a href="{{route('admin.login')}}"
                                                                           class="fw-semibold text-primary text-decoration-underline">Click
                                here </a></p>
                    </div>

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
<script !src="">
    $(document).ready(function () {
        $("#loginForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                }
            },
            messages: {
                email: {
                    required: "The email field is required.",
                    email: "The email must be a valid email address.",
                }
            },
            errorPlacement: function (error, element) {
                element.after(error);
            },
            errorClass: "text-danger",
            submitHandler: function (form, e) {
                e.preventDefault();
                $.ajax({
                    url: "{{route('admin.forget.password.post')}}",
                    method: "post",
                    dataType: "json",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        $('#loginButton').attr('disabled', true);
                        $("#loginBtnSpinner").show();
                    },
                    success: function (result) {
                        sendSuccess(result.message);
                        setTimeout(function () {
                            window.location.href = "{{route('admin.mail.sent.get')}}";
                        }, 1000);
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data.hasOwnProperty('error')) {
                            if (data.error.hasOwnProperty('password')) {
                                $("#password").html(data.error.password).show();
                            }
                        } else if (data.hasOwnProperty('message')) {
                            actionError(xhr, data.message)
                        } else {
                            actionError(xhr);
                        }
                    },
                    complete: function () {
                        $('#loginButton').attr('disabled', false);
                        $("#loginBtnSpinner").hide();
                    },
                });
            }
        });
    });
</script>
</body>
</html>
