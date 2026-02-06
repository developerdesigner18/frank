<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="enable">
<head>

    <meta charset="utf-8"/>
    <title>@yield('title') | {{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('admin-old.layouts.header-links')
    @stack('style-link')
    @stack('style')
    @yield('style')
</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">

    @include('user-old.layouts.header')

    <!-- removeNotificationModal -->
    @stack('modal')
    @stack('offcanvasa')
    <div class="offcanvas offcanvas-end" tabindex="-1" id="changeNameCanvas" aria-labelledby="changeNameCanvasLabel">
        <div class="offcanvas-header">
            <h5 id="changeNameCanvasLabel">Change Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="changeNameForm" action="javascript:void(0);">
                @csrf
                <div class="row g-3">
                    <!-- Profile Image -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="visitorImage" class="form-label">Profile Image</label>
                            <input type="file" class="dropify form-control-sm" id="visitorImage" name="image"
                                   data-height="180" data-default-file="{{ Auth::guard('web')->user()->profile_image ?? '' }}">
                            <label id="image-error" class="text-danger error" for="image" style="display: none"></label>
                        </div>
                    </div>

                    <!-- First Name -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="visitorName" class="form-label">First Name</label>
                            <input type="text" class="form-control form-control-sm" id="visitorName"
                                   name="first_name" placeholder="First name"
                                   value="{{ Auth::guard('web')->user()->first_name }}">
                            <label id="first_name-error" class="text-danger error"
                                   for="first_name" style="display: none"></label>
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="visitorLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control form-control-sm" id="visitorLastName"
                                   name="last_name" placeholder="Last name"
                                   value="{{ Auth::guard('web')->user()->last_name }}">
                            <label id="last_name-error" class="text-danger error"
                                   for="last_name" style="display: none"></label>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="visitorEmail" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" id="visitorEmail"
                                   name="email" value="{{ Auth::guard('web')->user()->email }}" placeholder="Email"
                                   disabled>
                            <label id="email-error" class="text-danger error"
                                   for="email" style="display: none"></label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="bank_account" class="form-label">Bank Account</label>
                            <input type="text" class="form-control form-control-sm" id="bank_account"
                                   name="bank_account" value="{{ Auth::guard('web')->user()->bank_account }}" placeholder="Back Account">
                            <label id="bank_account-error" class="text-danger error"
                                   for="bank_account" style="display: none"></label>
                        </div>
                    </div>

                    <!-- Mobile Number -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control form-control-sm" id="mobile_number"
                                   name="mobile_number" placeholder="Mobile number"
                                   value="{{ Auth::guard('web')->user()->mobile_number ?? '' }}">
                            <label id="mobile_number-error" class="text-danger error"
                                   for="mobile_number" style="display: none"></label>
                        </div>
                    </div>

                    <!-- Remuneration Method -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="remuneration_method" class="form-label">Remuneration Method</label>
                            <select name="remuneration_method" class="form-control form-control-sm"
                                    id="remuneration_method">
                                <option value="">Please Select</option>
                                @foreach(\App\Enums\RemunerationMethod::cases() as $method)
                                    <option value="{{ $method->value }}"
                                        {{ Auth::guard('web')->user()->remuneration_method?->value == $method->value ? 'selected' : '' }}>
                                        {{ $method->label() }}
                                    </option>
                                @endforeach
                            </select>
                            <label id="remuneration_method-error" class="text-danger error"
                                   for="remuneration_method" style="display: none"></label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary" id="registerBtn">
                            <i class="bx bx-loader spinner me-2" style="display: none"
                               id="registerBtnSpinner"></i>Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="changePasswordCanvas"
         aria-labelledby="changePasswordCanvasLabel">
        <div class="offcanvas-header">
            <h5 id="changePasswordCanvasLabel">Change Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="changePasswordForm">
                @csrf
                <div class="mb-3">
                    <label for="currentPassword" class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="currentPassword" name="current_password">
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="newPassword" name="password">
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="password_confirmation">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="NotificationModalbtn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                   colors="primary:#f7b84b,secondary:#f06548"
                                   style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!
                        </button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- ========== App Menu ========== -->
    @include('user-old.layouts.sidebar')
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid custom-container-fluid">
                @yield('main')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('user-old.layouts.footer')
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!--preloader-->
<div id="preloader">
    <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

@include('admin-old.layouts.theme-setting')

@include('admin-old.layouts.footer-links')
@include('admin-old.layouts.common-js')
@stack('script-link')
@stack('script')
@yield('script')
<script !src="">
    $(document).ready(function () {
        initDropify();
        $('#changeNameForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
            },
            messages: {
                name: {
                    required: "Please enter your new name.",
                    minlength: "Name must be at least 3 characters."
                },
            },
            errorClass: "text-danger error",
            errorPlacement: function (error, element) {
                element.after(error);
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "{{ route('update-name') }}",
                    method: "post",
                    dataType: "json",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {

                    },
                    success: function (result) {
                        sendSuccess(result.message);
                        var myOffcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('changeNameCanvas'));
                        myOffcanvas.hide();
                        window.location.reload();
                    },
                    error: function (xhr) {
                        actionError(xhr);
                    }
                });
            }
        });

        $('#changePasswordForm').validate({
            rules: {
                current_password: {
                    required: true,
                    minlength: 8
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo: "#newPassword"
                },
            },
            messages: {
                current_password: {
                    required: "Please enter your current password.",
                    minlength: "Password must be at least 8 characters."
                },
                password: {
                    required: "Please enter a new password.",
                    minlength: "Password must be at least 8 characters."
                },
                password_confirmation: {
                    required: "Please confirm your new password.",
                    minlength: "Password must be at least 8 characters.",
                    equalTo: "New password and confirm password must match."
                },
            },
            errorClass: "text-danger error",
            errorPlacement: function (error, element) {
                element.after(error);
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "{{ route('update-password') }}",
                    method: "post",
                    dataType: "json",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {

                    },
                    success: function (result) {
                        sendSuccess(result.message);
                        var myOffcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('changePasswordCanvas'));
                        myOffcanvas.hide();
                        window.location.reload();
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data.hasOwnProperty('message')) {
                            actionError(xhr, data.message);
                        } else {
                            actionError(xhr);
                        }
                    }
                });
            }
        });
    });
</script>
</body>
</html>
