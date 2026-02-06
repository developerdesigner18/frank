<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8"/>
    <title>Invitation | Visitor </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('admin.layouts.header-links')
</head>
<body>
<div class="flex min-h-dvh h-full p-4 md:p-6">
    <div class="flex justify-center items-center w-full ">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-lg rounded-2xl p-4 md:p-8">
                <div class="flex flex-col items-center pb-4">
                    <img alt="CheckMyZaak logo" class=" h-10 sm:h-12 w-auto" src="{{asset('assets/logo/logo.png')}}">
                    <h1 class="text-xl sm:text-2xl font-semibold pt-3 text-gray-600">Greetings !</h1>
                    <p class=" text-xs sm:text-sm text-center text-gray-500 pt-1">Sign up to continue
                        to {{env('APP_NAME')}}.</p>
                </div>
                <form class="flex flex-col gap-4" id="registerForm">
                    @csrf

                    <!-- Profile Picture Section -->
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <!-- Profile Image Preview Box -->
                            <div id="preview-container"
                                 class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-2 overflow-hidden">
                                <svg id="default-icon" class="w-12 h-12 text-gray-400"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                                    <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z"/>
                                </svg>
                                <img id="preview-image" src="" alt="Preview" class="hidden w-full h-full object-cover"/>
                            </div>

                            <!-- File Input (hidden) -->
                            <input type="file" id="file-input" accept="image/*" class="hidden" name="image"/>

                            <!-- Upload Button -->
                            <label for="file-input"
                                   class="absolute -bottom-0 -right-0 w-8 h-8 bg-[#0073AF] rounded-full flex items-center justify-center hover:bg-[#0068A0] transition-colors text-white cursor-pointer">
                                <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 3H15L17 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V6C2 5.44772 2.44772 5 3 5H7L9 3ZM12 19C15.3137 19 18 16.3137 18 13C18 9.68629 15.3137 7 12 7C8.68629 7 6 9.68629 6 13C6 16.3137 8.68629 19 12 19ZM12 17C9.79086 17 8 15.2091 8 13C8 10.7909 9.79086 9 12 9C14.2091 9 16 10.7909 16 13C16 15.2091 14.2091 17 12 17Z"></path>
                                </svg>
                            </label>
                        </div>
                    </div>

                    <!-- First Name -->
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-700" for="first_name">First Name</label>
                        <input autocomplete="first_name"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="first_name" name="first_name" placeholder="First Name" type="text">
                        <label id="first_name-error" class="text-[red] error" for="first_name"
                               style="display: none"></label>
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-700" for="last_name">Last Name</label>
                        <input autocomplete="last_name"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="last_name" name="last_name" placeholder="Last Name" type="text">
                        <label id="last_name-error" class="text-[red] error" for="last_name"
                               style="display: none"></label>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-700" for="email">Email</label>
                        <input autocomplete="email"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="email" name="email" value="{{$decrypt}}" placeholder="you@example.com" type="email"
                               readonly>
                        <label id="email-error" class="text-[red] error" for="email" style="display: none"></label>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between">
                            <label class="text-xs sm:text-sm font-medium text-gray-700" for="password">Password</label>
                        </div>
                        <input autocomplete="current-password"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="password" name="password" type="password">
                        <label id="password-error" class="text-[red] error" for="password"
                               style="display: none"></label>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <div class="flex items-center justify-between">
                            <label class="text-xs sm:text-sm font-medium text-gray-700" for="password_confirmation">Confirm
                                Password</label>
                        </div>
                        <input autocomplete="confirmation-password"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"
                               type="password">
                        <label id="password_confirmation-error" class="text-[red] error" for="password_confirmation"
                               style="display: none"></label>
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-700" for="mobile_number">Mobile
                            Number</label>
                        <input autocomplete="mobile_number"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="mobile_number" name="mobile_number" placeholder="Mobile Number" type="tel">
                        <label id="mobile_number-error" class="text-[red] error" for="mobile_number"
                               style="display: none"></label>
                    </div>

                    <!-- Remuneration Method -->
                    <div class="flex flex-col gap-1">
                        <label class="block text-sm font-medium text-gray-700" for="remuneration_method">Remuneration
                            Method</label>
                        <div class="relative">
                            <select name="remuneration_method"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                <option value="">Please Select</option>
                                @foreach(\App\Enums\RemunerationMethod::cases() as $method)
                                    <option value="{{$method->value}}">{{$method->label()}}</option>
                                @endforeach
                            </select>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px] pointer-events-none"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                 fill="currentColor">
                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                </path>
                            </svg>
                        </div>
                        <label id="remuneration_method-error" class="text-[red] error" for="remuneration_method"
                               style="display: none"></label>
                    </div>

                    <!-- terms and conditions -->
                    <div class="">
                        <input class="form-check-input" type="checkbox" value="1" name="terms_agreed"
                               id="terms-agreed-check" required>
                        <label class="form-check-label" for="terms-agreed-check">I agree to the terms and
                            conditions</label>
                        <label id="terms_agreed-error" class="text-[red] error" for="terms_agreed"
                               style="display: none"></label>
                    </div>

                    <!-- Button -->
                    <div>
                        <button class="w-full py-2.5 text-xs sm:text-sm rounded-md btn-primary transition-all duration-300 cursor-pointer flex justify-center"
                                type="submit" id="registerBtn">
                            Sign up
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- end auth-page-wrapper -->

@include('admin.layouts.footer-links')
@include('admin.layouts.common-js')
<script !src="">
    $(document).ready(function () {

        const fileInput = document.getElementById("file-input");
        const previewImage = document.getElementById("preview-image");
        const defaultIcon = document.getElementById("default-icon");

        fileInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove("hidden");
                    defaultIcon.classList.add("hidden");
                };
                reader.readAsDataURL(file);
            }
        });

        $("#registerForm").validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
                terms_agreed: {
                    required: true
                }
            },
            messages: {
                first_name: {
                    required: "The first name field is required."
                },
                last_name: {
                    required: "The last name field is required."
                },
                password: {
                    required: "The password field is required.",
                    minlength: "Password must be at least 8 characters."
                },
                password_confirmation: {
                    required: "Please confirm your password.",
                    equalTo: "Passwords do not match."
                },
                terms_agreed: {
                    required: "You must agree to the terms and conditions."
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "terms_agreed") {
                    error.insertAfter(element.parent());
                } else {
                    element.after(error);
                }
            },
            submitHandler: function (form, e) {

                let formData = new FormData(form);

                formData.append('cryptToken', "{{request()->route('cryptToken')}}")

                e.preventDefault();
                $.ajax({
                    url: "{{route('register')}}",
                    method: "post",
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        $('#registerBtn').attr('disabled', true).html(`
                                <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            `);
                    },
                    success: function (result) {
                        sendSuccess(result.message);
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data.hasOwnProperty('errors')) {
                            $.each(data.errors, function (key, value) {
                                $("#" + key + "-error").html(value[0]).show();
                            });
                        } else if (data.hasOwnProperty('message')) {
                            actionError(xhr, data.message)
                        } else {
                            actionError(xhr);
                        }
                    },
                    complete: function () {
                        $('#registerBtn').attr('disabled', false).html('Sign up');
                        setTimeout(function () {
                            window.location.href = "{{route('login')}}";
                        }, 1000);
                    },
                });
            }
        });
    });
</script>
</body>
</html>
