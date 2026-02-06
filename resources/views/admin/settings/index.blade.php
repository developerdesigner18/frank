@extends('admin.master')
@section('title', trans_message('settings'))
@push('navbar')
    <div class="pt-6 flex lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">{{ trans_message('settings') }}</span>
    </div>
@endpush
@push('modal')
@endpush
@section('main')
    <section class="pt-4 sm:pt-6">
        <!-- Account Settings Section -->
        <form id="accountSettingsForm">
            @csrf
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow duration-200 mb-6">
                <h2 class="text-base leading-none font-semibold text-gray-800">
                    {{ trans_message('account_settings') }}
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-6">
                    <!-- Profile Image Section -->
                    <div class="flex flex-col items-center justify-start lg:items-start gap-4">
                        <div class="w-full flex flex-col gap-4 lg:sticky top-0">
                            <div class="flex flex-col items-center lg:items-start">
                                <div class="relative mb-4">
                                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-[#0073AF] to-blue-600 p-0.5 shadow-lg">
                                        <div class="w-full h-full rounded-2xl bg-white flex items-center justify-center overflow-hidden">
                                            <img id="profileImage" src="{{ $rowData->profile_img }}"
                                                 alt="Profile" class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                    <label for="imageUpload"
                                           class="absolute -bottom-2 -right-2 w-8 h-8 bg-[#0073AF] rounded-full flex items-center justify-center cursor-pointer hover:bg-[#0068A0] transition-colors">
                                        <svg class="size-[18px] text-white" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M9 3H15L17 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V6C2 5.44772 2.44772 5 3 5H7L9 3ZM12 19C15.3137 19 18 16.3137 18 13C18 9.68629 15.3137 7 12 7C8.68629 7 6 9.68629 6 13C6 16.3137 8.68629 19 12 19ZM12 17C9.79086 17 8 15.2091 8 13C8 10.7909 9.79086 9 12 9C14.2091 9 16 10.7909 16 13C16 15.2091 14.2091 17 12 17Z">
                                            </path>
                                        </svg>
                                    </label>
                                    <input type="file" id="imageUpload" accept="image/*" name="profile_img"
                                           class="hidden"
                                           onchange="handleImageUpload(event)">
                                </div>
                                <p class="text-sm text-gray-600 text-center lg:text-left">{{ trans_message('click_to_upload') }}</p>
                            </div>
                            <!-- Language Selection -->
                            <div class="w-full flex flex-col gap-2">
                                <label class="block text-sm font-medium text-gray-700">{{ trans_message('language') }}</label>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.lang.switch', 'en') }}"
                                       class="cursor-pointer px-4 py-2 rounded-lg font-medium transition-colors
       {{ get_current_locale() === 'en'
            ? 'bg-[#0073AF] text-white'
            : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                        EN
                                    </a>

                                    <a href="{{ route('admin.lang.switch', 'nl') }}"
                                       class="cursor-pointer px-4 py-2 rounded-lg font-medium transition-colcolors
       {{ get_current_locale() === 'nl'
            ? 'bg-[#0073AF] text-white'
            : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                        NL
                                    </a>
                                </div>                            </div>
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="space-y-6">


                        <!-- Email Field -->
                        <div class="w-full flex flex-col gap-1">
                            <label for="email"
                                   class="block text-sm font-medium text-gray-700">{{ trans_message('email') }}</label>
                            <input type="email" id="email" value="{{ $rowData->email }}" disabled
                                   class="w-full px-3 py-2 bg-[#F5F7FA] border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Display Name Field -->
                        <div class="w-full flex flex-col gap-1">
                            <label for="name"
                                   class="block text-sm font-medium text-gray-700">{{ trans_message('display_name') }}</label>
                            <input type="text" id="name" name="name" value="{{ $rowData->name }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <label id="name-error" class="error text-[red]" for="name" style="display: none;"></label>
                        </div>

                        <!-- Password Change Section -->
                        <div class="w-full flex flex-col gap-1">
                            <h3 class="text-base leading-none font-semibold text-gray-800 pb-3 pt-1">{{ trans_message('change_password') }}</h3>
                            <div class="w-full flex flex-col gap-6">
                                <div class="w-full flex flex-col gap-1">
                                    <label for="password"
                                           class="block text-sm font-medium text-gray-700">{{ trans_message('new_password') }}</label>
                                    <input type="password" id="password" name="password"
                                           placeholder="{{ trans_message('new_password') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="w-full flex flex-col gap-1">
                                    <label for="password_confirmation"
                                           class="block text-sm font-medium text-gray-700">{{ trans_message('confirm_password') }}</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           placeholder="{{ trans_message('confirm_password') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <label id="password_confirmation-error" class="error text-[red]"
                                           for="password_confirmation" style="display: none;"></label>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="button"
                                    class="btn-secondary px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300">
                                {{ trans_message('cancel') }}
                            </button>
                            <button type="submit"
                                    class="accountSettingsBtn flex justify-center btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2">
                                {{ trans_message('save_changes') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Modify Section -->
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow duration-200 mb-6">
            <h2 class="text-base leading-none pb-4 font-semibold text-gray-800">
                {{ trans_message('modify') }}
            </h2>
            <div class="w-full flex flex-col gap-4">
                <a href="{{ route('admin.settings.faq') }}"
                   class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group">
                    <div class="flex items-center gap-3">
                        <svg class="size-[20px] text-gray-400" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 9.5C12.8284 9.5 13.5 8.82843 13.5 8C13.5 7.17157 12.8284 6.5 12 6.5C11.1716 6.5 10.5 7.17157 10.5 8C10.5 8.82843 11.1716 9.5 12 9.5ZM14 15H13V10.5H10V12.5H11V15H10V17H14V15Z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">{{ trans_message('edit_faq') }}</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12L8.59 7.41L10 6L16 12L10 18L8.59 16.59Z"/>
                    </svg>
                </a>
                <a href="{{ route('admin.settings.guides') }}"
                   class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group">
                    <div class="flex items-center gap-3">
                        <svg class="size-[20px] text-gray-400" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 9.2L22.2133 5.55071C22.4395 5.39235 22.7513 5.44737 22.9096 5.6736C22.9684 5.75764 23 5.85774 23 5.96033V18.0397C23 18.3158 22.7761 18.5397 22.5 18.5397C22.3974 18.5397 22.2973 18.5081 22.2133 18.4493L17 14.8V19C17 19.5523 16.5523 20 16 20H2C1.44772 20 1 19.5523 1 19V5C1 4.44772 1.44772 4 2 4H16C16.5523 4 17 4.44772 17 5V9.2Z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">{{ trans_message('edit_guides') }}</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12L8.59 7.41L10 6L16 12L10 18L8.59 16.59Z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Email Attachment Section -->
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow duration-200 mb-6">
            <h2 class="text-base leading-none pb-4 font-semibold text-gray-800">
                {{ trans_message('email_attachment') }}
            </h2>
            <form id="emailAttachmentForm">
                @csrf
                <div class="space-y-4">
                    <div class="flex md:items-center justify-between md:flex-row flex-col gap-5 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <svg class="size-[20px] text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 8L9.00319 2H19.9978C20.5513 2 21 2.45531 21 2.9918V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5501 3 20.9932V8ZM10 4V9H5V20H19V4H10Z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ trans_message('successful_visitor_registration') }}</span>
                        </div>

                        <!-- Upload button with file input -->
                        <label class="relative btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2">
                            <span class="emailAttachmentBtn flex justify-center">{{ trans_message('upload_file') }}</span>
                            <input type="file"
                                   name="image"
                                   class="absolute inset-0 opacity-0 cursor-pointer"/>
                        </label>
                    </div>
                    <div class="flex items-center flex-wrap gap-4 fileData">
                        @if(isset($email_attachment_file->value))
                            <div class="flex items-center gap-2 bg-[#0073AF]/10 px-3 py-2 rounded-full">
                                <a href="{{asset(SETTING_PATH. $email_attachment_file->value)}}" target="_blank"
                                   class="text-[#0073AF] text-sm font-medium">{{ $email_attachment_file->value }}</a>
                                <button type="button"
                                        class="cursor-pointer text-[#0073AF] hover:text-[#0073AF]/80 removeImage"
                                        data-id="{{ $email_attachment_file->id }}">
                                    <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Visitor Announcement Section -->
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
            <h2 class="text-base leading-none pb-4 font-semibold text-gray-800">
                {{ trans_message('visitor_announcement') }}
            </h2>
            <form id="announcementForm">
                @csrf
                <div class="flex flex-col items-end gap-1">
                    <textarea id="announcement" name="announcement" rows="6"
                              placeholder="{{ trans_message('enter_announcement') }}"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0073AF] focus:border-transparent transition-colors resize-none">{{ $announcement->value }}</textarea>
                    <label id="announcement-error" class="error text-[red]" for="announcement"
                           style="display: none;"></label>
                    <button type="submit"
                            class="announcementBtn flex justify-center btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2">
                        {{ trans_message('save') }}
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            // Account Settings Form
            $("#accountSettingsForm").validate({
                rules: {
                    dataType: "json",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        $('.accountSettingsBtn').attr('disabled', true).html(`
                                <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            `);
                    },
                    success: function (result) {
                        sendSuccess(result.message);
                        $('.account_name').html(result.data.name);
                        $('.account_image').attr('src', result.data.image);
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data.hasOwnProperty('error')) {
                            $.each(data.error, function (key, value) {
                                $("#" + key + "-error").html(value).show();
                            });
                        } else if (data.hasOwnProperty('message')) {
                            actionError(xhr, data.message);
                        } else {
                            actionError(xhr);
                        }
                    },
                    complete: function () {
                        $('.accountSettingsBtn').attr('disabled', false).html('save');
                    },
                });
        }
        });

        // Announcement Form
        $("#announcementForm").validate({
            rules: {
                announcement: {required: true}
            },
            messages: {
                announcement: {required: "The announcement field is required."}
            },
            errorPlacement: function (error, element) {
                element.after(error);
            },
            submitHandler: function (form, e) {
                e.preventDefault();
                $.ajax({
                    url: "{{route('admin.announcement.update')}}",
                    method: "post",
                    dataType: "json",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        $('.announcementBtn').attr('disabled', true).html(`
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
                        if (data.hasOwnProperty('error')) {
                            $.each(data.error, function (key, value) {
                                $("#" + key + "-error").html(value).show();
                            });
                        } else if (data.hasOwnProperty('message')) {
                            actionError(xhr, data.message);
                        } else {
                            actionError(xhr);
                        }
                    },
                    complete: function () {
                        $('.announcementBtn').attr('disabled', false).html('save');
                    },
                });
            }
        });

        // Email Attachment Form
        $(document).on('change', '#emailAttachmentForm input[name="image"]', function (e) {
            e.preventDefault();
            let form = $("#emailAttachmentForm")[0];
            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('admin.email.attachment.update') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $('.emailAttachmentBtn').attr('disabled', true).html(`
                        <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Uploading...
                    `);
                },
                success: function (result) {
                    sendSuccess(result.message);
                    // Optional: reset input field
                    $('#emailAttachmentForm input[name="image"]').val('');
                    $('.fileData').html(`
                        <div class="flex items-center gap-2 bg-[#0073AF]/10 px-3 py-2 rounded-full">
                            <a href="${result.data.image_path}" target="_blank" class="text-[#0073AF] text-sm font-medium">${result.data.image}</a>
                            <button type="button" class="cursor-pointer text-[#0073AF] hover:text-[#0073AF]/80 removeImage" data-id="${result.data.id}">
                                <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    `);
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data?.error) {
                        $.each(data.error, function (key, value) {
                            $("#" + key + "-error").html(value).show();
                        });
                    } else if (data?.message) {
                        actionError(xhr, data.message);
                    } else {
                        actionError(xhr);
                    }
                },
                complete: function () {
                    $('.emailAttachmentBtn').attr('disabled', false).html('Upload File');
                },
            });
        });

        $(document).delegate('.removeImage', 'click', function (e) {
            e.preventDefault();
            var el = $(this);
            var id = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to remove this file?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, remove",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
                buttonsStyling: !1,
            }).then(function (t) {
                if (t.value) {
                    $.ajax({
                        url: "{{route('admin.email.attachment.delete')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            el.attr('disabled', true);
                        },
                        success: function (data) {
                            sendSuccess(data.message);
                            el.closest('div').remove();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message)
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            el.attr('disabled', false);
                        }
                    });
                }
            });
        });

        })
        ;
    </script>
@endsection
