<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MV | CheckMijnZaak.nl</title>
    @include('admin.layouts.header-links')
</head>

<body>
<div class="flex min-h-dvh h-full p-4 md:p-6">
    <div class="flex justify-center items-center w-full ">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-lg rounded-2xl p-4 md:p-8">
                <div class="flex flex-col items-center pb-4">
                    <img alt="CheckMyZaak logo" class="h-17 w-auto" src="{{asset('assets/logo/logo.png')}}">
                    <h1 class="text-xl sm:text-2xl font-semibold pt-3 text-gray-600">Login</h1>
                    <p class=" text-xs sm:text-sm text-center text-gray-500 pt-1">Welcome back! Please enter your
                        details.</p>
                </div>
                <form class="flex flex-col gap-6" id="loginForm">
                    @csrf
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-700" for="email">Email</label>
                        <input autocomplete="email"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="email" name="email" placeholder="you@example.com" required="" type="email">
                        <label id="email-error" class="text-[red] error" for="email" style="display: none"></label>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <label class="text-xs sm:text-sm font-medium text-gray-700"
                                   for="password">Password</label>
                            <a class="text-sm text-blue-600 hover:underline"
                               href="{{route('admin.forget.password.get')}}">Forgot password?</a>
                        </div>
                        <input autocomplete="current-password"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="password" name="password" required="" placeholder="password" type="password">
                        <label id="password-error" class="text-[red] error" for="password"
                               style="display: none"></label>
                    </div>
                    <div>
                        <button
                                class="w-full py-2.5 text-xs sm:text-sm rounded-md btn-primary transition-all duration-300 cursor-pointer flex justify-center"
                                type="submit" id="loginButton">
                            Sign in
                        </button>
                    </div>
                </form>
                {{--                <div class="mt-6">--}}
                {{--                    <div class="grid grid-cols-[1fr_auto_1fr] items-center gap-2">--}}
                {{--                        <span class="h-[1px] bg-gray-300"></span>--}}
                {{--                        <span class="text-gray-500 text-xs sm:text-sm uppercase text-center">--}}
                {{--                                Or continue with--}}
                {{--                            </span>--}}
                {{--                        <span class="h-[1px] bg-gray-300"></span>--}}
                {{--                    </div>--}}
                {{--                    <div class="mt-6 grid grid-cols-2 gap-3">--}}
                {{--                        <div>--}}
                {{--                            <a class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-xs sm:text-sm font-medium text-gray-500 hover:bg-gray-50"--}}
                {{--                               href="#">--}}
                {{--                                <span class="sr-only">Sign in with Google</span>--}}
                {{--                                <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"--}}
                {{--                                     fill="currentColor">--}}
                {{--                                    <path--}}
                {{--                                            d="M3.06364 7.50914C4.70909 4.24092 8.09084 2 12 2C14.6954 2 16.959 2.99095 18.6909 4.60455L15.8227 7.47274C14.7864 6.48185 13.4681 5.97727 12 5.97727C9.39542 5.97727 7.19084 7.73637 6.40455 10.1C6.2045 10.7 6.09086 11.3409 6.09086 12C6.09086 12.6591 6.2045 13.3 6.40455 13.9C7.19084 16.2636 9.39542 18.0227 12 18.0227C13.3454 18.0227 14.4909 17.6682 15.3864 17.0682C16.4454 16.3591 17.15 15.3 17.3818 14.05H12V10.1818H21.4181C21.5364 10.8363 21.6 11.5182 21.6 12.2273C21.6 15.2727 20.5091 17.8363 18.6181 19.5773C16.9636 21.1046 14.7 22 12 22C8.09084 22 4.70909 19.7591 3.06364 16.4909C2.38638 15.1409 2 13.6136 2 12C2 10.3864 2.38638 8.85911 3.06364 7.50914Z">--}}
                {{--                                    </path>--}}
                {{--                                </svg>--}}
                {{--                            </a>--}}
                {{--                        </div>--}}
                {{--                        <div>--}}
                {{--                            <a class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-xs sm:text-sm font-medium text-gray-500 hover:bg-gray-50"--}}
                {{--                               href="#">--}}
                {{--                                <span class="sr-only">Sign in with Facebook</span>--}}
                {{--                                <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"--}}
                {{--                                     fill="currentColor">--}}
                {{--                                    <path--}}
                {{--                                            d="M12.001 2C6.47813 2 2.00098 6.47715 2.00098 12C2.00098 16.9913 5.65783 21.1283 10.4385 21.8785V14.8906H7.89941V12H10.4385V9.79688C10.4385 7.29063 11.9314 5.90625 14.2156 5.90625C15.3097 5.90625 16.4541 6.10156 16.4541 6.10156V8.5625H15.1931C13.9509 8.5625 13.5635 9.33334 13.5635 10.1242V12H16.3369L15.8936 14.8906H13.5635V21.8785C18.3441 21.1283 22.001 16.9913 22.001 12C22.001 6.47715 17.5238 2 12.001 2Z">--}}
                {{--                                    </path>--}}
                {{--                                </svg>--}}
                {{--                            </a>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <p class="pt-6 text-center text-xs sm:text-sm text-gray-500">--}}
                {{--                    Not a member?--}}
                {{--                    <a class="font-semibold text-[#0073AF] hover:!underline" href="#">--}}
                {{--                        Sign up--}}
                {{--                    </a>--}}
                {{--                </p>--}}
            </div>
        </div>
    </div>
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
                },
                password: {
                    required: true,
                }
            },
            messages: {
                email: {
                    required: "The email field is required.",
                    email: "The email must be a valid email address.",
                },
                password: {
                    required: "The password field is required.",
                }
            },
            errorPlacement: function (error, element) {
                element.after(error);
            },
            // errorClass: "text-[red]",
            submitHandler: function (form, e) {
                e.preventDefault();
                $.ajax({
                    url: "{{route('admin.login-action')}}",
                    method: "post",
                    dataType: "json",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        $('#loginButton').attr('disabled', true).html(`
                                <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            `);
                    },
                    success: function (result) {
                        sendSuccess(result.message);
                        setTimeout(function () {
                            window.location.href = "{{route('admin.dashboard')}}";
                        }, 1000);
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data.hasOwnProperty('error')) {
                            if (data.error.hasOwnProperty('email')) {
                                $("#email-error").html(data.error.email).show();
                            }
                            if (data.error.hasOwnProperty('password')) {
                                $("#password-error").html(data.error.password).show();
                            }
                        } else if (data.hasOwnProperty('message')) {
                            actionError(xhr, data.message)
                        } else {
                            actionError(xhr);
                        }
                    },
                    complete: function () {
                        $('#loginButton').attr('disabled', false).html('Sign in');
                    },
                });
            }
        });
    });
</script>
</body>
</html>
