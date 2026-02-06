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
        <section class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg">
            <div class="flex flex-col md:flex-row items-center justify-between pb-6 gap-4">
                <form method="post" id="Form" enctype="multipart/form-data">
                    @csrf

                    <div class="w-full">
                                <input type="hidden" name="category[{{ $category['id'] }}]" value="{{ $category['name'] }}">
                                <!-- Niho! View 1 -->
                                <div class="view-content {{ $cat_k>0?'hidden':'' }}" id="niho-view-{{$cat_k}}">
                                    <div class="text-center mb-6 relative">
                                        <div class="flex items-center justify-center gap-2 mb-4">
                                            @if($cat_k>0)
                                                <!-- Arrow prevView -->
                                                <button type="button" onclick="showPrevView()"
                                                        class="cursor-pointer absolute left-0 bg-gray-100 hover:bg-gray-200 rounded-lg p-2 transition-colors">
                                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                              clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                            <span class="flex text-2xl font-semibold text-gray-800">

                                    </span>
                                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                          clip-rule="evenodd"></path>
                                                </svg>
                                            </div>

                                        </div>
                                        <div class="w-full h-1 bg-green-400 rounded-full mb-6"></div>
                                    </div>

                                </div>
                            @endforeach
                        @endif
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
