<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8"/>
    <title>Reset Password | Mystery Visitor </title>
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
                                <h5 class="text-primary">Create new password</h5>
                                <p class="text-muted">Your new password must be different from previous used
                                    password.</p>
                            </div>

                            <div class="p-2">
                                <form id="loginForm">
                                    @csrf
                                    <input type="hidden" name="token" value="{{$token}}">
                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" name="password"
                                                   class="form-control pe-5 password-input"
                                                   onpaste="return false" placeholder="Enter password"
                                                   id="password-input" aria-describedby="passwordInput"
                                            >
                                            <label id="password-error" class="text-danger error" for="password"
                                                   style="display: none"></label>
                                            <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="confirm-password-input">Confirm Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" name="password_confirmation"
                                                   class="form-control pe-5 password-input"
                                                   onpaste="return false" placeholder="Confirm password"
                                                   id="password_confirmation-input">
                                            <label id="password_confirmation-error" class="text-danger error"
                                                   for="password"
                                                   style="display: none"></label>
                                            <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                                                    type="button" id="confirm-password-input"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>

                                    <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                        <h5 class="fs-13">Password must contain:</h5>
                                        <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                        <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)
                                        </p>
                                        <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter
                                            (A-Z)</p>
                                        <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit" id="loginButton"><i
                                                    class="bx bx-loader spinner me-2"
                                                    style="display: none" id="loginBtnSpinner"></i> Reset Password
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Wait, I remember my password... <a href="{{route('login')}}"
                                                                           class="fw-semibold text-primary text-decoration-underline">
                                Click here </a></p>
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
                password: {
                    required: true,
                },
                password_confirmation: {
                    required: true,
                },
            },
            messages: {
                password: {
                    required: "The password field is required.",
                },
                password_confirmation: {
                    required: "The password field is required.",
                }
            },
            errorPlacement: function (error, element) {
                element.after(error);
            },
            errorClass: "text-danger",
            submitHandler: function (form, e) {
                e.preventDefault();
                $.ajax({
                    url: "{{route('reset.password.post')}}",
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
                            window.location.href = "{{route('login')}}";
                        }, 1000);
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data.hasOwnProperty('error')) {
                            if (data.error.hasOwnProperty('email')) {
                                $("#email-error").html(data.error.email).show();
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
