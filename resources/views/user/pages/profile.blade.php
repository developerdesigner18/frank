@extends('user.master')
@section('title', trans_message('dashboard'))
@section('style')
    <style>
        .el-input_inner {
            color: #a8abb2;
            -webkit-text-fill-color: #a8abb2;
            cursor: not-allowed;
        }
    </style>
@endsection
@section('main')
    <section class="pt-4 sm:pt-6">
        <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <form id="profileForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col items-center lg:items-start">

                    <div class="relative mb-4">
                        <div
                                class="w-24 h-24 rounded-2xl bg-gradient-to-br from-[#0073AF] to-blue-600 p-0.5 shadow-lg">
                            <div
                                    class="w-full h-full rounded-2xl bg-white flex items-center justify-center overflow-hidden">
                                <img id="profileImage"
                                     src="{{ auth('web')->user()->profile_image ?? asset('assets/user/image/user.png')}}"
                                     alt="Profile"
                                     class="w-full h-full object-cover">
                            </div>
                        </div>
                        <label for="imageUpload"
                               class="absolute -bottom-2 -right-2 w-8 h-8 bg-[#0073AF] rounded-full flex items-center justify-center cursor-pointer hover:bg-[#0068A0] transition-colors">
                            <svg class="size-[18px] text-white" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path
                                        d="M9 3H15L17 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V6C2 5.44772 2.44772 5 3 5H7L9 3ZM12 19C15.3137 19 18 16.3137 18 13C18 9.68629 15.3137 7 12 7C8.68629 7 6 9.68629 6 13C6 16.3137 8.68629 19 12 19ZM12 17C9.79086 17 8 15.2091 8 13C8 10.7909 9.79086 9 12 9C14.2091 9 16 10.7909 16 13C16 15.2091 14.2091 17 12 17Z">
                                </path>
                            </svg>
                        </label>
                        <input type="file" id="imageUpload" accept="image/*" class="hidden"
                               onchange="handleImageUpload(event)">
                    </div>
                    <p class="text-sm text-red-600 text-center lg:text-left text-sm" id="imageError">
                    </p>
                    <p class="text-red-600 text-sm" id="profile_image-error">
                    </p>
                    <p class="text-sm text-gray-600 text-center lg:text-left">{{ trans_message('profile_click_camera') }}</p>
                </div>
                <div class="grid grid-cols-2 gap-6 pt-6">
                    <!-- Email -->
                    <div class="w-full flex flex-col gap-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ trans_message('email') }}</label>
                        <input type="email" id="email" value="{{ auth('web')->user()->email ?? '' }}"
                               name="email"
                               class="el-input_inner w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               disabled>
                    </div>

                    <!-- Mobile Number -->
                    <div class="w-full flex flex-col gap-1">
                        <label for="phone" class="block text-sm font-medium text-gray-700">{{ trans_message('mobile_number') }}</label>
                        <input type="tel" id="phone" name="phone" value="{{ auth('web')->user()->mobile_number ?? '' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-red-600 text-sm" id="phone-error" style="display:none"></p>
                    </div>


                    <div class="w-full flex flex-col gap-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ trans_message('first_name') }}</label>
                        <input type="text" id="first_name" value="{{ auth('web')->user()->first_name ?? '' }}"
                               name="first_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-red-600 text-sm" id="first_name-error" style="display:none"></p>
                    </div>
                    <div class="w-full flex flex-col gap-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ trans_message('first_name') }}</label>
                        <input type="text" id="last_name" value="{{ auth('web')->user()->last_name ?? '' }}"
                               name="last_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-red-600 text-sm" id="last_name-error" style="display:none"></p>

                    </div>
                    <div class="w-full flex flex-col gap-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ trans_message('bank_account_code') }}</label>
                        <input type="text" id="bank_account_code" value="{{ auth('web')->user()->bank_account ?? '' }}"
                               name="bank_account_code"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-red-600 text-sm" id="bank_account_code-error" style="display:none"></p>

                    </div>
                    <div class="w-full flex flex-col gap-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ trans_message('remuneration_method') }}</label>
                        <div class="relative w-full">
                            <select id="remuneration" name="remuneration"
                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="INVOICING" {{ auth('web')->user()->remuneration_method->value == "INVOICING" ? 'selected' : '' }}>
                                    Invoicing
                                </option>
                                <option value="VERLONING.NL" {{ auth('web')->user()->remuneration_method->value == "VERLONING.NL" ? 'selected' : '' }}>
                                    Verloning.nl
                                </option>

                            </select>

                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                        d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-red-600 text-sm" id="remuneration-error" style="display:none"></p>
                    </div>

                    <!-- change password section -->
                    {{--<div class="w-full flex flex-col gap-1 pt-6 col-span-2">
                        <h6 class="text-base font-semibold text-gray-700 pb-4">Change Password</h6>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="w-full flex flex-col gap-1">
                                <label for="email" class="block text-sm font-medium text-gray-700">New
                                    Password</label>
                                <input type="password" id="last_name" value="Admin"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="New Password">
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <label for="email" class="block text-sm font-medium text-gray-700">Confirm
                                    Password</label>
                                <input type="password" id="bank_account_code" value=""
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Confirm Password">
                            </div>
                        </div>
                    </div>--}}
                    <!-- change password section end -->
                </div>
                <div>
                    <input class="form-check-input"
                           type="checkbox"
                           value="1"
                           name="receive_new_visit_emails"
                           id="receive-mail"
                        {{ auth('web')->user()->receive_visit_emails ? 'checked' : '' }}>

                    <label class="form-check-label" for="receive-mail">
                        I want to receive emails when new MysteryVisits are available.
                    </label>

                    <label id="receive-mail-error" class="text-[red] error" for="receive-mail" style="display: none"></label>
                </div>
                <div class="flex justify-end gap-3 pt-6">
                    <button type="submit" id="updateProfile"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                        <i class="bx bx-loader spinner me-2"
                           style="display: none" id="profileBtnSpinner"></i>{{ trans_message('save_changes') }}
                    </button>
                </div>


            </form>
        </div>
    </section>

    <!-- change password section -->
{{--    <section class="pt-4 sm:pt-6">--}}
{{--        <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">--}}
{{--            <form id="changePasswordForm" method="POST">--}}
{{--                @csrf--}}
{{--                <div class="flex flex-col items-center lg:items-start">--}}

{{--                    <div class="w-full flex flex-col gap-1 pt-6 col-span-2">--}}
{{--                        <h6 class="text-base font-semibold text-gray-700 pb-4">Change Password</h6>--}}
{{--                        <div class="flex flex-row gap-6">--}}
{{--                            <div class="w-1/2 flex flex-col gap-1">--}}
{{--                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current--}}
{{--                                    Password</label>--}}
{{--                                <input type="password" id="current_password" name="current_password"--}}
{{--                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"--}}
{{--                                       placeholder="Current password">--}}
{{--                            </div>--}}
{{--                            <div class="w-1/2 flex flex-col gap-1">--}}
{{--                                <label for="new_password" class="block text-sm font-medium text-gray-700">New--}}
{{--                                    Password</label>--}}
{{--                                <input type="password" id="new_password" name="new_password"--}}
{{--                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"--}}
{{--                                       placeholder="New Password">--}}
{{--                            </div>--}}
{{--                            <div class="w-1/2 flex flex-col gap-1">--}}
{{--                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm--}}
{{--                                    Password</label>--}}
{{--                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"--}}
{{--                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"--}}
{{--                                       placeholder="Confirm Password">--}}
{{--                                <p class="text-red-600 text-sm" id="new_password-error"></p>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="flex justify-end gap-3 pt-6">--}}
{{--                    <button type="submit" id="pwdUpdateProfile"--}}
{{--                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">--}}
{{--                        <i class="bx bx-loader spinner me-2"--}}
{{--                           style="display: none" id="pwdBtnSpinner"></i> Save Changes--}}
{{--                    </button>--}}
{{--                </div>--}}


{{--            </form>--}}
{{--        </div>--}}
{{--    </section>--}}
    <!-- end change password section -->

@endsection

@section('script')
    <script !src="">
        let selectedFile = null;

        function handleImageUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                $('#imageError').text('Only JPG, JPEG, PNG, and WEBP images are allowed.');
                selectedFile = null;
                event.target.value = '';
                return;
            }

            $('#imageError').text('');
            selectedFile = file;

            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("profileImage").src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        const input = document.querySelector("#phone");
        const iti = window.intlTelInput(input, {
            initialCountry: "nl",
            onlyCountries: ['nl'],
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input/build/js/utils.js",
        });

        $(document).ready(function () {

            $("#profileForm").validate({
                rules: {
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    }
                },
                messages: {
                    first_name: {
                        required: "The first name field is required."
                    },
                    last_name: {
                        required: "The last name field is required."
                    }
                },
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                errorClass: "text-red-600 text-sm",
                submitHandler: function (form, e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    if (selectedFile) {
                        formData.append('profile_image', selectedFile);
                    }

                    $.ajax({
                        url: "{{route('profile-update')}}",
                        method: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#updateProfile').attr('disabled', true);
                            $("#profileBtnSpinner").show();
                        },
                        success: function (result) {
                            sendSuccess(result.message);
                            setTimeout(function () {
                                window.location.reload(true);
                            }, 1000);
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                if (data.error.hasOwnProperty('first_name')) {
                                    $("#first_name-error").html(data.error.first_name).show();
                                }
                                if (data.error.hasOwnProperty('last_name')) {
                                    $("#last_name-error").html(data.error.first_name).show();
                                }
                                if (data.error.hasOwnProperty('profile_image')) {
                                    $("#profile_image-error").html(data.error.profile_image).show();
                                }
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message)
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            $('#updateProfile').attr('disabled', false);
                            $("#profileBtnSpinner").hide();
                        },
                    });
                }
            });

        });
    </script>
@endsection
