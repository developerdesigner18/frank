<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8"/>
    <title>Forgot Password | Mystery Visitor </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('company.layouts.header-links')

</head>

<body>
<div class="flex min-h-dvh h-full p-4 md:p-6">
    <div class="flex justify-center items-center w-full ">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-lg rounded-2xl p-4 md:p-8">
                <div class="flex flex-col items-center pb-4">
                    <img alt="CheckMyZaak logo" class=" h-10 sm:h-12 w-auto" src="{{ asset('assets/logo/logo.png') }}">
                    <h1 class="text-xl sm:text-2xl font-semibold pt-3 text-gray-600">Recover Account</h1>
                    <p class=" text-xs sm:text-sm text-center text-gray-500 pt-1">Enter your email or username to
                        regain access.</p>
                </div>
                <form class="flex flex-col gap-6" id="forgotForm">
                    @csrf
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-700" for="email">Email</label>
                        <input autocomplete="email"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="email" name="email" placeholder="you@example.com" type="email">
                        <p id="email-error" class="text-red-600 text-sm"></p>
                    </div>
                    <div>
                        <button
                                class="w-full py-2.5 text-xs sm:text-sm rounded-md btn-primary transition-all duration-300" id="resetButton"
                                type="submit"><i class="bx bx-loader spinner me-2" id="resetBtnSpinner" style="display: none;" ></i>
                            Send Password Reset link
                        </button>
                    </div>
                </form>
                <p class="pt-6 text-center text-xs sm:text-sm text-gray-500">
                    Wait, I remember my password...
                    <a class="font-semibold text-[#0073AF] hover:!underline" href="{{route('company.login')}}">
                        Sign In
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

@include('company.layouts.footer-links')
@include('company.layouts.common-js')
<script !src="">
    $(document).ready(function () {
        $("#forgotForm").validate({
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
            errorClass: "text-red-600 text-sm",
            submitHandler: function (form, e) {
                e.preventDefault();
                $.ajax({
                    url: "{{route('company.forget.password.post')}}",
                    method: "post",
                    dataType: "json",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        $('#resetButton').attr('disabled', true);
                        $("#resetBtnSpinner").show();
                    },
                    success: function (result) {
                        sendSuccess(result.message);
                        setTimeout(function () {
                            window.location.href = "{{route('company.mail.sent.get')}}";
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
                        $('#resetButton').attr('disabled', false);
                        $("#resetBtnSpinner").hide();
                    },
                });
            }
        });
    });
</script>
</body>
</html>
