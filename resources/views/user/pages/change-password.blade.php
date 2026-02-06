@extends('user.master')
@section('title','Dashboard')

@section('main')

    <section class="pt-4 sm:pt-6">
        <!-- Settings Cards Grid -->
        <div class="grid grid-cols-1 gap-6">
            <!-- Account Settings Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <form id="changePasswordForm" method="POST">
                    @csrf
                <div class="p-4 sm:p-6">
                    <!-- Account Header -->
                    <h2 class="text-base leading-none font-semibold text-gray-800 pb-4">{{ trans_message('change_password') }}</h2>
                    <!-- change Password -->
                    <div class="space-y-1">

                                <div class="flex flex-row gap-6">
                                    <div class="w-1/2 flex flex-col gap-1">
                                        <label for="current_password" class="block text-sm font-medium text-gray-700">{{ trans_message('current_password') }}</label>
                                        <input type="password" id="current_password" name="current_password"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="{{ trans_message('current_password') }}">
                                    </div>
                                    <div class="w-1/2 flex flex-col gap-1">
                                        <label for="new_password" class="block text-sm font-medium text-gray-700">   {{ trans_message('new_password') }}</label>
                                        <input type="password" id="new_password" name="new_password"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="{{ trans_message('new_password') }}">
                                    </div>
                                    <div class="w-1/2 flex flex-col gap-1">
                                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">{{ trans_message('confirm_password') }}</label>
                                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="{{ trans_message('confirm_password') }}">
                                        <p class="text-red-600 text-sm" id="new_password-error"></p>
                                    </div>
                                </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-6">
                        <button type="submit" id="pwdUpdateProfile"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                            <i class="bx bx-loader spinner me-2"
                               style="display: none" id="pwdBtnSpinner"></i> {{ trans_message('save_changes') }}
                        </button>
                    </div>


                </div>
                </form>
            </div>

        </div>
    </section>
@endsection
@section('script')
    <script !src="">

        $(document).ready(function (){

            $("#changePasswordForm").validate({
                rules: {
                    current_password: {
                        required: true
                    },
                    new_password: {
                        required: true
                    },
                    new_password_confirmation: {
                        required: true,
                        equalTo: "#new_password"
                    }
                },
                messages: {
                    current_password: {
                        required: "Please enter your current password"
                    },
                    new_password: {
                        required: "Please enter a new password"
                    },
                    new_password_confirmation: {
                        required: "Please confirm your new password",
                        equalTo: "Passwords do not match"
                    }
                },
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                errorClass: "text-red-600 text-sm",
                submitHandler: function (form, e) {
                    e.preventDefault();

                    const formData = new FormData(form);

                    $.ajax({
                        url: "{{route('update-password')}}",
                        method: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#pwdUpdateProfile').attr('disabled', true);
                            $("#pwdBtnSpinner").show();
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
                                if (data.error.hasOwnProperty('password')) {
                                    $("#new_password-error").html(data.error.password.join('<br>')).show();
                                }
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message)
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            $('#pwdUpdateProfile').attr('disabled', false);
                            $("#pwdBtnSpinner").hide();
                        },
                    });
                }
            });

        });

    </script>
@endsection
