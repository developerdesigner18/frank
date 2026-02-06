@extends('admin.master')
@section('title','Companies')

@push('modal')
    <!-- Add Company Modal -->
    <div class="modal fade" id="addCompanyMD" tabindex="-1" aria-labelledby="addCompanyMDLabel" aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="addCompanyForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="companyImage" class="form-label">Company Logo</label>
                                    <input type="file" class="form-control" id="companyImage" name="image">
                                    <label id="image-error" class="text-danger error" for="image"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="companyName" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="companyName" name="company_name"
                                           placeholder="Enter company name">
                                    <label id="company_name-error" class="text-danger error" for="company_name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="addCompanyBtn">
                                        <i class="bx bx-loader spinner me-2" style="display: none"
                                           id="addCompanyBtnSpinner"></i>Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Company Modal -->
    <div class="modal fade" id="editCompanyMD" tabindex="-1" aria-labelledby="editCompanyMDLabel" aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="editCompanyForm">
                        @csrf
                        <input type="hidden" name="id" id="company_id">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editCompanyImage" class="form-label">Company Logo</label>
                                    <input type="file" class="form-control" id="editCompanyImage" name="image">
                                    <div class="mt-2">
                                        <img id="currentCompanyImage" src="" class="rounded avatar-md"
                                             alt="Current Logo" style="display: none;">
                                    </div>
                                    <label id="edit_image-error" class="text-danger error" for="image"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editCompanyName" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="editCompanyName" name="company_name"
                                           placeholder="Enter company name">
                                    <label id="edit_company_name-error" class="text-danger error" for="company_name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-warning" id="editCompanyBtn">
                                        <i class="bx bx-loader spinner me-2" style="display: none"
                                           id="editCompanyBtnSpinner"></i>Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCompanyUserMD" tabindex="-1" aria-labelledby="addCompanyUserMDLabel"
         aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Company User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="addCompanyUserForm">
                        @csrf
                        <input type="hidden" name="company_id" id="company_id_for_user">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="companyUserImage" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="companyUserImage" name="image">
                                    <label id="company_user_image-error" class="text-danger error" for="image"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="companyUserName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="companyUserName" name="name"
                                           placeholder="Enter full name">
                                    <label id="name-error" class="text-danger error" for="name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="companyUserEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="companyUserEmail" name="email"
                                           placeholder="Enter email">
                                    <label id="email-error" class="text-danger error" for="email"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="companyUserPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="companyUserPassword" name="password"
                                           placeholder="Enter password">
                                    <label id="password-error" class="text-danger error" for="password"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="addCompanyUserBtn">
                                        <i class="bx bx-loader spinner me-2" style="display: none"
                                           id="addCompanyUserBtnSpinner"></i>Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="inviteCompanyUserMD" tabindex="-1" aria-labelledby="inviteCompanyUserMD"
         aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Invite Company User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="inviteCompanyUserForm">
                        @csrf
                        <input type="hidden" name="company_id" id="company_id_for_user_invite">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="invitation_email" class="form-label">User Email</label>
                                    <input type="text" class="form-control" id="invitation_email"
                                           name="invitation_email" placeholder="Invitation Email">
                                    <label id="invitation_email-error" class="text-danger error" for="invitation_email"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="inviteVisitorBtn">
                                        <i class="bx bx-loader spinner me-2" style="display: none"
                                           id="inviteVisitorBtnSpinner"></i>Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Company User Modal -->
    <div class="modal fade" id="editCompanyUserMD" tabindex="-1" aria-labelledby="editCompanyUserMDLabel"
         aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Company User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="editCompanyUserForm">
                        @csrf
                        <input type="hidden" name="id" id="edit_company_user_id">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editCompanyUserImage" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="editCompanyUserImage" name="image">
                                    <div class="mt-2">
                                        <img id="currentCompanyUserImage" src="" class="rounded avatar-md"
                                             alt="Current Image" style="display: none;">
                                    </div>
                                    <label id="edit_image-error" class="text-danger error" for="image"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editCompanyUserName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="editCompanyUserName" name="name"
                                           placeholder="Enter full name">
                                    <label id="edit_name-error" class="text-danger error" for="name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editCompanyUserEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="editCompanyUserEmail" name="email"
                                           placeholder="Enter email">
                                    <label id="edit_email-error" class="text-danger error" for="email"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editCompanyUserPassword" class="form-label">Password (Leave blank to
                                        keep unchanged)</label>
                                    <input type="password" class="form-control" id="editCompanyUserPassword"
                                           name="password"
                                           placeholder="Enter new password">
                                    <label id="edit_password-error" class="text-danger error" for="password"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editCompanyUserStatus" class="form-label">Status</label>
                                    <select class="form-select" id="editCompanyUserStatus" name="status">
                                        @foreach(\App\Enums\CompanyUserStatus::cases() as $status)
                                            <option value="{{ $status->value }}">{{ $status->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-warning" id="editCompanyUserBtn">
                                        <i class="bx bx-loader spinner me-2" style="display: none"
                                           id="editCompanyUserBtnSpinner"></i>Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" style="width: 60vw;" tabindex="-1" id="companyUsersOffcanvas"
         aria-labelledby="companyUsersOffcanvasLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="companyUsersOffcanvasLabel">Company Users (<span
                        id="companyNameTitle"></span>)</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

            <div class="d-flex justify-content-end align-items-center mb-3">
                <button type="button" class="btn btn-primary btn-sm" id="addCompanyUserBtnOffcanvas">
                    <i class="ri-add-line align-bottom me-1"></i>Add User
                </button>
                <button type="button" class="btn btn-ghost-primary btn-sm" id="inviteCompanyUserBtnOffcanvas">
                    <i class="ri-add-line align-bottom me-1"></i>Invite User
                </button>
            </div>
            <table id="companyUsersDT" class="table table-hover datatable dataTable no-footer"
                   style="width:100%"></table>
        </div>
    </div>
@endpush

@section('main')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Companies</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Companies</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header rounded-0">
                    <div class="row align-items-center gy-3">
                        <div class="col-sm">
                            <h5 class="card-title mb-0">Company List</h5>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex gap-1 flex-wrap">
                                <button onclick="resetForm();" type="button" class="btn btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#addCompanyMD"
                                        aria-controls="addCompanyMD">
                                    <i class="ri-add-line align-bottom"></i>
                                    <span class="d-none d-sm-inline-block">Add Company</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="companyDT"
                           class="listDatatable tableview table w-100 pt-2 datatable dataTable no-footer"></table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        var dataTable = $('#companyDT').DataTable({
            processing: true,
            serverSide: true,
            info: true,
            select: false,
            dom: "Bfrtip",
            lengthMenu: [
                [10, 25, 50, 75],
                ["10 rows", "25 rows", "50 rows", "75 rows"],
            ],
            buttons: ["pageLength"],
            language: {
                zeroRecords: zeroRecords,
                search: "",
                searchPlaceholder: "Search Here",
                processing: processing,
                emptyTable: emptyTable,
                paginate: {
                    next: '<i class="ri-arrow-right-s-line">',
                    previous: '<i class="ri-arrow-left-s-line">',
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id', title: 'ID', class: 'text-center'},
                {data: 'image', name: 'image', title: 'Logo', class: 'text-center', orderable: false},
                {data: 'company_name', name: 'company_name', title: 'Company Name', class: 'text-center'},
                {data: 'status', name: 'status', title: 'Status', class: 'text-center', orderable: false},
                {data: 'created_at', name: 'created_at', title: 'Created At', class: 'text-center'},
                {
                    data: 'action',
                    name: 'action',
                    title: 'Action',
                    class: 'text-center',
                    searching: false,
                    orderable: false
                },
            ],
            ajax: {
                url: '{{ route("admin.company.list") }}',
                type: "POST",
                dataType: "JSON",
                data: function (f) {
                    f._token = "{{csrf_token()}}";
                },
                error: function (xhr) {
                    dataTableError("companyDT", xhr.responseJSON.message);
                    actionError(xhr);
                },
            },
            responsive: {
                breakpoints: [
                    {name: "desktop", width: Infinity},
                    {name: "tablet", width: 1024},
                    {name: "fablet", width: 768},
                    {name: "phone", width: 480},
                ],
            },
        });

        // Handle status change
        $(document).on('change', '.status-select', function () {
            let id = $(this).data('id');
            let status = $(this).val();

            Swal.fire({
                title: "Are you sure?",
                text: "You want to change the company status to " + status + "?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, change it!",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ms-2 mt-2",
                buttonsStyling: false
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('admin.company.update.status') }}",
                        method: "POST",
                        data: {
                            id: id,
                            status: status,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            sendSuccess(response.message);
                            dataTable.ajax.reload();
                        },
                        error: function (xhr) {
                            actionError(xhr);
                            dataTable.ajax.reload();
                        }
                    });
                } else {
                    // Revert the select to its previous value
                    dataTable.ajax.reload();
                }
            });
        });

        function resetForm() {
            $("#addCompanyForm").trigger('reset');
            $("#editCompanyForm").trigger('reset');
            $("label.error").hide();
            $("#currentCompanyImage").hide();
        }

        function removeCompany(id, element) {
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to remove this company?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, remove",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn btn-danger mt-2 text-white rounded px-4 fs-16",
                cancelButtonClass: "btn btn-light ms-2 mt-2 border rounded px-4 fs-16",
                buttonsStyling: !1,
            }).then(function (t) {
                if (t.value) {
                    $.ajax({
                        url: "{{route('admin.company.delete')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            $(element).html('<i class="spinner-border fs-10 spinner-border-sm m-1 mx-0"></i>');
                            $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendSuccess(data.message);
                            dataTable.ajax.reload();
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
                            $(element).attr('disabled', false);
                            $(element).html('<i class="ri-delete-bin-5-fill fs-16"></i>');
                        }
                    });
                }
            });
        }

        function getCompany(id, element) {
            $.ajax({
                url: "{{route('admin.company.edit')}}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "id": id,
                    "_token": "{{csrf_token()}}",
                },
                beforeSend: function () {
                    $(element).html('<i class="spinner-border fs-10 spinner-border-sm m-1 mx-0"></i>');
                    $(element).attr('disabled', true);
                },
                success: function (data) {
                    resetForm();
                    $("#company_id").val(id);
                    $('#editCompanyName').val(data.data.company_name);
                    $('#editCompanyEmail').val(data.data.email);

                    // Set image if exists
                    if (data.data.image) {
                        $("#currentCompanyImage").attr('src', data.data.image).show();
                    }

                    $("#editCompanyMD").modal('show');
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data.hasOwnProperty('error')) {
                        if (data.error.hasOwnProperty('id')) {
                            sendError(data.error.id);
                        }
                    } else if (data.hasOwnProperty('message')) {
                        actionError(xhr, data.message)
                    } else {
                        actionError(xhr);
                    }
                },
                complete: function () {
                    $(element).attr('disabled', false);
                    $(element).html('<i class="ri-pencil-fill fs-16"></i>');
                }
            });
        }

        $(document).ready(function () {
            // Add Company Form
            $("#addCompanyForm").validate({
                rules: {
                    company_name: {required: true},
                    email: {required: true, email: true},
                    password: {required: true, minlength: 8},
                },
                messages: {
                    company_name: {required: "The company name field is required."},
                    email: {required: "The email field is required.", email: "Please enter a valid email address."},
                    password: {
                        required: "The password field is required.",
                        minlength: "Password must be at least 8 characters."
                    },
                },
                errorClass: 'text-danger error',
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.add')}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#addCompanyBtn').attr('disabled', true);
                            $("#addCompanyBtnSpinner").show();
                        },
                        success: function (result) {
                            sendSuccess(result.message);
                            dataTable.ajax.reload();
                            $("#addCompanyMD").modal('hide');
                            resetForm();
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
                            $('#addCompanyBtn').attr('disabled', false);
                            $("#addCompanyBtnSpinner").hide();
                        },
                    });
                }
            });

            // Update Company Form
            $("#editCompanyForm").validate({
                rules: {
                    company_name: {required: true},
                    email: {required: true, email: true},
                    password: {minlength: 8},
                },
                messages: {
                    company_name: {required: "The company name field is required."},
                    email: {required: "The email field is required.", email: "Please enter a valid email address."},
                    password: {minlength: "Password must be at least 8 characters."},
                },
                errorClass: 'text-danger error',
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.update')}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#editCompanyBtn').attr('disabled', true);
                            $("#editCompanyBtnSpinner").show();
                        },
                        success: function (result) {
                            sendSuccess(result.message);
                            dataTable.ajax.reload();
                            $("#editCompanyMD").modal('hide');
                            resetForm();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#edit_" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message);
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            $('#editCompanyBtn').attr('disabled', false);
                            $("#editCompanyBtnSpinner").hide();
                        },
                    });
                }
            });
        });


        // Initialize company users datatable
        function initCompanyUsersDT(companyId) {
            companyUsersDT = $('#companyUsersDT').DataTable({
                processing: true,
                serverSide: true,
                destroy: true, // Destroy previous instance if exists
                info: true,
                select: false,
                dom: "Bfrtip",
                lengthMenu: [
                    [10, 25, 50, 75],
                    ["10 rows", "25 rows", "50 rows", "75 rows"],
                ],
                buttons: ["pageLength"],
                language: {
                    zeroRecords: zeroRecords,
                    search: "",
                    searchPlaceholder: "Search Here",
                    processing: processing,
                    emptyTable: emptyTable,
                    paginate: {
                        next: '<i class="ri-arrow-right-s-line">',
                        previous: '<i class="ri-arrow-left-s-line">',
                    },
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'id', title: 'ID', class: 'text-center'},
                    {data: 'image', name: 'image', title: 'Image', class: 'text-center', orderable: false},
                    {data: 'name', name: 'name', title: 'Name', class: 'text-center'},
                    {data: 'email', name: 'email', title: 'Email', class: 'text-center'},
                    {data: 'status', name: 'status', title: 'Status', class: 'text-center', orderable: false},
                    {data: 'created_at', name: 'created_at', title: 'Created At', class: 'text-center'},
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Action',
                        class: 'text-center',
                        searching: false,
                        orderable: false
                    },
                ],
                ajax: {
                    url: '{{ route("admin.company.users.list") }}',
                    type: "POST",
                    dataType: "JSON",
                    data: function (f) {
                        f._token = "{{csrf_token()}}";
                        f.company_id = companyId;
                    },
                    error: function (xhr) {
                        dataTableError("companyUsersDT", xhr.responseJSON.message);
                        actionError(xhr);
                    },
                },
                responsive: {
                    breakpoints: [
                        {name: "desktop", width: Infinity},
                        {name: "tablet", width: 1024},
                        {name: "fablet", width: 768},
                        {name: "phone", width: 480},
                    ],
                },
            });
        }

        // Handle status change for company users
        $(document).on('change', '.company-user-status-select', function () {
            let id = $(this).data('id');
            let status = $(this).val();

            Swal.fire({
                title: "Are you sure?",
                text: "You want to change the user status to " + status + "?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, change it!",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ms-2 mt-2",
                buttonsStyling: false
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('admin.company.users.update.status') }}",
                        method: "POST",
                        data: {
                            id: id,
                            status: status,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            sendSuccess(response.message);
                            companyUsersDT.ajax.reload();
                        },
                        error: function (xhr) {
                            actionError(xhr);
                            companyUsersDT.ajax.reload();
                        }
                    });
                } else {
                    // Revert the select to its previous value
                    companyUsersDT.ajax.reload();
                }
            });
        });

        // Show company users offcanvas
        function showCompanyUsers(companyId, companyName) {
            currentCompanyId = companyId;
            $('#companyNameTitle').text(companyName);
            $('#company_id_for_user').val(companyId);
            $('#company_id_for_user_invite').val(companyId);
            initCompanyUsersDT(companyId);
            $('#companyUsersOffcanvas').offcanvas('show');
        }

        // Add company user button click in offcanvas
        $(document).on('click', '#addCompanyUserBtnOffcanvas', function () {
            resetCompanyUserForm();
            $('#addCompanyUserMD').modal('show');
        });

        $(document).on('click', '#inviteCompanyUserBtnOffcanvas', function () {
            resetCompanyUserForm();
            $('#inviteCompanyUserMD').modal('show');
        });

        // Reset company user form
        function resetCompanyUserForm() {
            $("#addCompanyUserForm").trigger('reset');
            $("#editCompanyUserForm").trigger('reset');
            $("#inviteCompanyUserForm").trigger('reset');
            $("label.error").hide();
            $("#currentCompanyUserImage").hide();
        }

        // Get company user for edit
        function getCompanyUser(id, element) {
            $.ajax({
                url: "{{route('admin.company.users.edit')}}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "id": id,
                    "_token": "{{csrf_token()}}",
                },
                beforeSend: function () {
                    $(element).html('<i class="spinner-border fs-10 spinner-border-sm m-1 mx-0"></i>');
                    $(element).attr('disabled', true);
                },
                success: function (data) {
                    resetCompanyUserForm();
                    $("#edit_company_user_id").val(id);
                    $('#editCompanyUserName').val(data.data.name);
                    $('#editCompanyUserEmail').val(data.data.email);
                    $('#editCompanyUserStatus').val(data.data.status);

                    // Set image if exists
                    if (data.data.image) {
                        $("#currentCompanyUserImage").attr('src', data.data.image).show();
                    }

                    $("#editCompanyUserMD").modal('show');
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data.hasOwnProperty('error')) {
                        if (data.error.hasOwnProperty('id')) {
                            sendError(data.error.id);
                        }
                    } else if (data.hasOwnProperty('message')) {
                        actionError(xhr, data.message)
                    } else {
                        actionError(xhr);
                    }
                },
                complete: function () {
                    $(element).attr('disabled', false);
                    $(element).html('<i class="ri-pencil-fill fs-16"></i>');
                }
            });
        }

        // Remove company user
        function removeCompanyUser(id, element) {
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to remove this user?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, remove",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn btn-danger mt-2 text-white rounded px-4 fs-16",
                cancelButtonClass: "btn btn-light ms-2 mt-2 border rounded px-4 fs-16",
                buttonsStyling: !1,
            }).then(function (t) {
                if (t.value) {
                    $.ajax({
                        url: "{{route('admin.company.users.delete')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            $(element).html('<i class="spinner-border fs-10 spinner-border-sm m-1 mx-0"></i>');
                            $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendSuccess(data.message);
                            companyUsersDT.ajax.reload();
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
                            $(element).attr('disabled', false);
                            $(element).html('<i class="ri-delete-bin-5-fill fs-16"></i>');
                        }
                    });
                }
            });
        }

        $(document).ready(function () {
            $("#addCompanyUserForm").validate({
                rules: {
                    name: {required: true},
                    email: {required: true, email: true},
                    password: {required: true, minlength: 8},
                },
                messages: {
                    name: {required: "The name field is required."},
                    email: {required: "The email field is required.", email: "Please enter a valid email address."},
                    password: {
                        required: "The password field is required.",
                        minlength: "Password must be at least 8 characters."
                    },
                },
                errorClass: 'text-danger error',
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.users.add')}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#addCompanyUserBtn').attr('disabled', true);
                            $("#addCompanyUserBtnSpinner").show();
                        },
                        success: function (result) {
                            sendSuccess(result.message);
                            companyUsersDT.ajax.reload();
                            $("#addCompanyUserMD").modal('hide');
                            resetCompanyUserForm();
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
                            $('#addCompanyUserBtn').attr('disabled', false);
                            $("#addCompanyUserBtnSpinner").hide();
                        },
                    });
                }
            });

            // Update Company User Form
            $("#editCompanyUserForm").validate({
                rules: {
                    name: {required: true},
                    email: {required: true, email: true},
                    password: {minlength: 8},
                },
                messages: {
                    name: {required: "The name field is required."},
                    email: {required: "The email field is required.", email: "Please enter a valid email address."},
                    password: {minlength: "Password must be at least 8 characters."},
                },
                errorClass: 'text-danger error',
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.users.update')}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#editCompanyUserBtn').attr('disabled', true);
                            $("#editCompanyUserBtnSpinner").show();
                        },
                        success: function (result) {
                            sendSuccess(result.message);
                            companyUsersDT.ajax.reload();
                            $("#editCompanyUserMD").modal('hide');
                            resetCompanyUserForm();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#edit_" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message);
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            $('#editCompanyUserBtn').attr('disabled', false);
                            $("#editCompanyUserBtnSpinner").hide();
                        },
                    });
                }
            });

            $("#inviteCompanyUserForm").validate({
                rules: {
                    invitation_email: {required: true, email: true},
                },
                messages: {
                    invitation_email: {
                        required: "The email field is required.",
                        email: "Please enter a valid email address."
                    },
                },
                errorClass: 'text-danger error',
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.users.invite')}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#inviteVisitorBtn').attr('disabled', true);
                            $("#inviteVisitorBtnSpinner").show();
                        },
                        success: function (result) {
                            sendSuccess(result.message);
                            companyUsersDT.ajax.reload();
                            $("#inviteCompanyUserMD").modal('hide');
                            resetCompanyUserForm();
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
                            $('#inviteVisitorBtn').attr('disabled', false);
                            $("#inviteVisitorBtnSpinner").hide();
                        },
                    });
                }
            });
        });
    </script>
@endsection
