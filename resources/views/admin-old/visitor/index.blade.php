@extends('admin.master')
@section('title','Mystery Visitors')

@push('modal')
    <div class="modal fade" id="addVisitorMD" tabindex="-1" aria-labelledby="addVisitorMDLabel" aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Visitor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="addVisitorForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="visitorImage" class="form-label">Visitor Image</label>
                                    <input type="file" class="form-control" id="visitorImage" name="image">
                                    <label id="image-error" class="text-danger error" for="image"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="visitorName" class="form-label">Visitor First Name</label>
                                    <input type="text" class="form-control" id="visitorName" name="first_name"
                                           placeholder="Enter visitor name">
                                    <label id="first_name-error" class="text-danger error" for="first_name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="visitorLastName" class="form-label">Visitor Last Name</label>
                                    <input type="text" class="form-control" id="visitorLastName" name="last_name"
                                           placeholder="Enter visitor name">
                                    <label id="last_name-error" class="text-danger error" for="last_name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="visitorEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="visitorEmail" name="email"
                                           placeholder="Enter email">
                                    <label id="email-error" class="text-danger error" for="email"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="visitorPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="visitorPassword" name="password"
                                           placeholder="Enter password">
                                    <label id="password-error" class="text-danger error" for="password"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="mobile_number" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                                           placeholder="Enter mobile number">
                                    <label id="mobile_number-error" class="text-danger error" for="mobile_number"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="remuneration_method" class="form-label">Remuneration Method</label>
                                    <select name="remuneration_method" class="form-control" id="remuneration_method">
                                        <option value="">Please Select</option>
                                        @foreach(\App\Enums\RemunerationMethod::cases() as $method)
                                            <option value="{{$method->value}}">{{$method->label()}}</option>
                                        @endforeach
                                    </select>
                                    <label id="remuneration_method-error" class="text-danger error"
                                           for="remuneration_method"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="addVisitorBtn">
                                        <i class="bx bx-loader spinner me-2" style="display: none"
                                           id="addVisitorBtnSpinner"></i>Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="inviteVisitorMD" tabindex="-1" aria-labelledby="inviteVisitorMDLabel" aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Invite Visitor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="inviteVisitorForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="invitation_email" class="form-label">Visitor Email</label>
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

    <!-- Edit Visitor Modal -->
    <div class="modal fade" id="editVisitorMD" tabindex="-1" aria-labelledby="editVisitorMDLabel" aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Visitor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="editVisitorForm">
                        @csrf
                        <input type="hidden" name="id" id="visitor_id">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editVisitorImage" class="form-label">Visitor Image</label>
                                    <input type="file" class="form-control" id="editVisitorImage" name="image">
                                    <div class="mt-2">
                                        <img id="currentVisitorImage" src="" class="rounded avatar-md"
                                             alt="Current Logo" style="display: none;">
                                    </div>
                                    <label id="edit_image-error" class="text-danger error" for="image"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editVisitorName" class="form-label">Visitor First Name</label>
                                    <input type="text" class="form-control" id="editVisitorName" name="first_name"
                                           placeholder="Enter visitor name">
                                    <label id="edit_first_name-error" class="text-danger error" for="first_name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editVisitorLastName" class="form-label">Visitor Last Name</label>
                                    <input type="text" class="form-control" id="editVisitorLastName" name="last_name"
                                           placeholder="Enter visitor last name">
                                    <label id="edit_last_name-error" class="text-danger error" for="last_name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editVisitorEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="editVisitorEmail" name="email"
                                           placeholder="Enter email">
                                    <label id="edit_email-error" class="text-danger error" for="email"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editVisitorPassword" class="form-label">Password (Leave blank to keep
                                        current)</label>
                                    <input type="password" class="form-control" id="editVisitorPassword" name="password"
                                           placeholder="Enter new password">
                                    <label id="edit_password-error" class="text-danger error" for="password"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editMobileNumber" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" id="editMobileNumber" name="mobile_number"
                                           placeholder="Enter mobile number">
                                    <label id="edit_mobile_number-error" class="text-danger error" for="mobile_number"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editRemunerationMethod" class="form-label">Remuneration Method</label>
                                    <select name="remuneration_method" class="form-control" id="editRemunerationMethod">
                                        <option value="">Please Select</option>
                                        @foreach(\App\Enums\RemunerationMethod::cases() as $method)
                                            <option value="{{$method->value}}">{{$method->label()}}</option>
                                        @endforeach
                                    </select>
                                    <label id="edit_remuneration_method-error" class="text-danger error"
                                           for="remuneration_method"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-warning" id="editVisitorBtn">
                                        <i class="bx bx-loader spinner me-2" style="display: none"
                                           id="editVisitorBtnSpinner"></i>Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@section('main')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Mystery Visitors</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Mystery Visitors</a></li>
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
                            <h5 class="card-title mb-0">Visitor List</h5>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex gap-1 flex-wrap">
                                <button onclick="resetForm();" type="button" class="btn btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#addVisitorMD"
                                        aria-controls="addVisitorMD">
                                    <i class="ri-add-line align-bottom"></i>
                                    <span class="d-none d-sm-inline-block">Add Visitor</span>
                                </button>
                                <button onclick="resetForm();" type="button" class="btn btn-ghost-primary"
                                        data-bs-toggle="modal" data-bs-target="#inviteVisitorMD"
                                        aria-controls="addVisitorMD">
                                    <i class="ri-add-line align-bottom"></i>
                                    <span class="d-none d-sm-inline-block">Invite Visitor</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="visitorDT"
                           class="listDatatable tableview table w-100 pt-2 datatable dataTable no-footer"></table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var dataTable = $('#visitorDT').DataTable({
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
                {data: 'image', name: 'image', title: 'Image', class: 'text-center', orderable: false},
                {data: 'first_name', name: 'first_name', title: 'First Name', class: 'text-center'},
                {data: 'last_name', name: 'last_name', title: 'Last Name', class: 'text-center'},
                {data: 'email', name: 'email', title: 'Email', class: 'text-center'},
                {data: 'mobile_number', name: 'mobile_number', title: 'Mobile Number', class: 'text-center'},
                {data: 'bank_account', name: 'bank_account', title: 'Bank Account', class: 'text-center'},
                {data: 'remuneration_method', name: 'remuneration_method', title: 'Method', class: 'text-center'},
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
                url: '{{ route("admin.visitor.list") }}',
                type: "POST",
                dataType: "JSON",
                data: function (f) {
                    f._token = "{{csrf_token()}}";
                },
                error: function (xhr) {
                    dataTableError("visitorDT", xhr.responseJSON.message);
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
                text: "You want to change the visitor status to " + status + "?",
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
                        url: "{{ route('admin.visitor.update.status') }}",
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

        $(document).on('change', '.method-select', function () {
            let id = $(this).data('id');
            let status = $(this).val();

            Swal.fire({
                title: "Are you sure?",
                text: "You want to change the visitor method to " + status + "?",
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
                        url: "{{ route('admin.visitor.update.method') }}",
                        method: "POST",
                        data: {
                            id: id,
                            remuneration_method: status,
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
            $("#addVisitorForm").trigger('reset');
            $("#editVisitorForm").trigger('reset');
            $("#inviteVisitorForm").trigger('reset');
            $("label.error").hide();
            $("#currentVisitorImage").hide();
        }

        function removeVisitor(id, element) {
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to remove this visitor?",
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
                        url: "{{route('admin.visitor.delete')}}",
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

        function getVisitor(id, element) {
            $.ajax({
                url: "{{route('admin.visitor.edit')}}",
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
                    $("#visitor_id").val(id);
                    $('#editVisitorName').val(data.data.first_name);
                    $('#editVisitorLastName').val(data.data.last_name);
                    $('#editVisitorEmail').val(data.data.email);
                    $('#editMobileNumber').val(data.data.mobile_number);
                    $('#editRemunerationMethod').val(data.data.remuneration_method);

                    // Set image if exists
                    if (data.data.profile_image) {
                        $("#currentVisitorImage").attr('src', data.data.profile_image).show();
                    }

                    $("#editVisitorMD").modal('show');
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
            // Add Visitor Form
            $("#addVisitorForm").validate({
                rules: {
                    first_name: {required: true},
                    last_name: {required: true},
                    email: {required: true, email: true},
                    password: {required: true, minlength: 8},
                },
                messages: {
                    first_name: {required: "The first name field is required."},
                    last_name: {required: "The last name field is required."},
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
                        url: "{{route('admin.visitor.add')}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#addVisitorBtn').attr('disabled', true);
                            $("#addVisitorBtnSpinner").show();
                        },
                        success: function (result) {
                            sendSuccess(result.message);
                            dataTable.ajax.reload();
                            $("#addVisitorMD").modal('hide');
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
                            $('#addVisitorBtn').attr('disabled', false);
                            $("#addVisitorBtnSpinner").hide();
                        },
                    });
                }
            });

            $("#inviteVisitorForm").validate({
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
                        url: "{{route('admin.visitor.invite')}}",
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
                            dataTable.ajax.reload();
                            $("#inviteVisitorMD").modal('hide');
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
                            $('#inviteVisitorBtn').attr('disabled', false);
                            $("#inviteVisitorBtnSpinner").hide();
                        },
                    });
                }
            });

            // Update Visitor Form
            $("#editVisitorForm").validate({
                rules: {
                    first_name: {required: true},
                    last_name: {required: true},
                    email: {required: true, email: true},
                    password: {minlength: 8},
                },
                messages: {
                    first_name: {required: "The first name field is required."},
                    last_name: {required: "The last name field is required."},
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
                        url: "{{route('admin.visitor.update')}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#editVisitorBtn').attr('disabled', true);
                            $("#editVisitorBtnSpinner").show();
                        },
                        success: function (result) {
                            sendSuccess(result.message);
                            dataTable.ajax.reload();
                            $("#editVisitorMD").modal('hide');
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
                            $('#editVisitorBtn').attr('disabled', false);
                            $("#editVisitorBtnSpinner").hide();
                        },
                    });
                }
            });
        });
    </script>
@endsection
