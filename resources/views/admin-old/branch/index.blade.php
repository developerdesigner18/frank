@extends('admin.master')
@section('title','Company Branches')

@push('modal')
    <!-- Add Company Modal -->
    <div class="modal fade" id="addCompanyBranchMD" tabindex="-1" aria-labelledby="addCompanyBranchMDLabel"
         aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="addCompanyBranchForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="branchImage" class="form-label">Branch Logo</label>
                                    <input type="file" class="form-control" id="branchImage" name="image">
                                    <label id="image-error" class="text-danger error" for="image"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="branchName" class="form-label">Branch Name</label>
                                    <input type="text" class="form-control" id="branchName" name="branch_name"
                                           placeholder="Enter branch name">
                                    <label id="branch_name-error" class="text-danger error" for="branch_name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="address1" class="form-label">Address Line 1</label>
                                    <input type="text" class="form-control" id="address1" name="address_1"
                                           placeholder="Enter address">
                                    <label id="address_1-error" class="text-danger error" for="address_1"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="locality" class="form-label">Locality</label>
                                    <input type="text" class="form-control" id="locality" name="locality"
                                           placeholder="Enter locality">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="postalCode" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" id="postalCode" name="postal_code"
                                           placeholder="Enter postal code">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="upsellingInputUrl" class="form-label">Upselling Input URL</label>
                                    <input type="text" class="form-control" id="upsellingInputUrl"
                                           name="upselling_input_url"
                                           placeholder="Enter upselling input URL">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="upsellingReportUrl" class="form-label">Upselling Report URL</label>
                                    <input type="text" class="form-control" id="upsellingReportUrl"
                                           name="upselling_report_url"
                                           placeholder="Enter upselling report URL">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="inputUrl46" class="form-label">Input URL 46</label>
                                    <input type="text" class="form-control" id="inputUrl46" name="input_url_46"
                                           placeholder="Enter input URL 46">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="reportUrl46" class="form-label">Report URL 46</label>
                                    <input type="text" class="form-control" id="reportUrl46" name="report_url_46"
                                           placeholder="Enter report URL 46">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="route" class="form-label">Route</label>
                                    <select class="form-select" id="route" name="route">
                                        <option value="">Enter route</option>
                                        @foreach(\App\Enums\BranchRoutes::cases() as $status)
                                            <option value="{{ $status->value }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
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
    <div class="modal fade" id="editCompanyBranchMD" tabindex="-1" aria-labelledby="editCompanyBranchMDLabel"
         aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="editCompanyBranchForm">
                        @csrf
                        <input type="hidden" name="id" id="branch_id">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editBranchImage" class="form-label">Branch Logo</label>
                                    <input type="file" class="form-control" id="editBranchImage" name="image">
                                    <div class="mt-2">
                                        <img id="currentBranchImage" src="" class="rounded avatar-md"
                                             alt="Current Logo" style="display: none;">
                                    </div>
                                    <label id="edit_image-error" class="text-danger error" for="image"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editBranchName" class="form-label">Branch Name</label>
                                    <input type="text" class="form-control" id="editBranchName" name="branch_name"
                                           placeholder="Enter branch name">
                                    <label id="edit_branch_name-error" class="text-danger error" for="branch_name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editAddress1" class="form-label">Address Line 1</label>
                                    <input type="text" class="form-control" id="editAddress1" name="address_1"
                                           placeholder="Enter address">
                                    <label id="edit_address_1-error" class="text-danger error" for="address_1"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editLocality" class="form-label">Locality</label>
                                    <input type="text" class="form-control" id="editLocality" name="locality"
                                           placeholder="Enter locality">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editPostalCode" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" id="editPostalCode" name="postal_code"
                                           placeholder="Enter postal code">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editUpsellingInputUrl" class="form-label">Upselling Input URL</label>
                                    <input type="text" class="form-control" id="editUpsellingInputUrl"
                                           name="upselling_input_url"
                                           placeholder="Enter upselling input URL">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editUpsellingReportUrl" class="form-label">Upselling Report URL</label>
                                    <input type="text" class="form-control" id="editUpsellingReportUrl"
                                           name="upselling_report_url"
                                           placeholder="Enter upselling report URL">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editInputUrl46" class="form-label">Input URL 46</label>
                                    <input type="text" class="form-control" id="editInputUrl46" name="input_url_46"
                                           placeholder="Enter input URL 46">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editReportUrl46" class="form-label">Report URL 46</label>
                                    <input type="text" class="form-control" id="editReportUrl46" name="report_url_46"
                                           placeholder="Enter report URL 46">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editRoute" class="form-label">Route</label>
                                    <select class="form-select" id="editRoute" name="route">
                                        <option value="">Enter route</option>
                                        @foreach(\App\Enums\BranchRoutes::cases() as $status)
                                            <option value="{{ $status->value }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
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

    <div class="modal fade" id="addBranchContactMD" tabindex="-1" aria-labelledby="addBranchContactMDLabel"
         aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Branch Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="addBranchContactForm">
                        @csrf
                        <input type="hidden" name="branch_id" id="branch_id_for_contact">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name"
                                           placeholder="Enter first name">
                                    <label id="first_name-error" class="text-danger error" for="first_name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name"
                                           placeholder="Enter last name">
                                    <label id="last_name-error" class="text-danger error" for="last_name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="contactEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="contactEmail" name="email"
                                           placeholder="Enter email">
                                    <label id="email-error" class="text-danger error" for="email"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="mobileNumber" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" id="mobileNumber" name="mobile_number"
                                           placeholder="Enter mobile number">
                                    <label id="mobile_number-error" class="text-danger error" for="mobile_number"
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

    <!-- Edit Company User Modal -->
    <div class="modal fade" id="editBranchContactMD" tabindex="-1" aria-labelledby="editBranchContactMDLabel"
         aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Branch Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="editBranchContactForm">
                        @csrf
                        <input type="hidden" name="id" id="edit_branch_contact_id">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editFirstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="editFirstName" name="first_name"
                                           placeholder="Enter first name">
                                    <label id="edit_first_name-error" class="text-danger error" for="first_name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editLastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="editLastName" name="last_name"
                                           placeholder="Enter last name">
                                    <label id="edit_last_name-error" class="text-danger error" for="last_name"
                                           style="display: none"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editContactEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="editContactEmail" name="email"
                                           placeholder="Enter email">
                                    <label id="edit_email-error" class="text-danger error" for="email"
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
                                    <label for="editBranchContactStatus" class="form-label">Status</label>
                                    <select class="form-select" id="editBranchContactStatus" name="status">
                                        @foreach(\App\Enums\BranchContactStatus::cases() as $status)
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

    <div class="offcanvas offcanvas-end" style="width: 60vw;" tabindex="-1" id="branchContactsOffcanvas"
         aria-labelledby="branchContactsOffcanvasLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="branchContactsOffcanvasLabel">Branch Contacts (<span
                        id="branchNameTitle"></span>)</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-flex justify-content-end align-items-center mb-3">
                <button type="button" class="btn btn-primary btn-sm" id="addBranchContactBtnOffcanvas">
                    <i class="ri-add-line align-bottom me-1"></i>Add Contact
                </button>
            </div>
            <table id="branchContactsDT" class="table table-hover datatable dataTable no-footer"
                   style="width:100%"></table>
        </div>
    </div>
@endpush

@section('main')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Company Branches</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Companies</a></li>
                        <li class="breadcrumb-item active">Branches</li>
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
                            <h5 class="card-title mb-0">Branch List</h5>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex gap-1 flex-wrap">
                                <button onclick="resetForm();" type="button" class="btn btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#addCompanyBranchMD"
                                        aria-controls="addCompanyBranchMD">
                                    <i class="ri-add-line align-bottom"></i>
                                    <span class="d-none d-sm-inline-block">Add Branch</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="branchDT"
                           class="listDatatable tableview table w-100 pt-2 datatable dataTable no-footer"></table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var companyId = "{{ $companyId }}";
        var dataTable = $('#branchDT').DataTable({
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
                {
                    data: 'branch_name',
                    name: 'branch_name',
                    title: 'Branch Name',
                    class: 'text-center',
                },
                // {
                //     data: 'company_name',
                //     name: 'company_name',
                //     title: 'Company Name',
                //     class: 'text-center',
                //     searchable: false
                // },
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
                url: '{{ route("admin.company.branches.list",["companyId" => $companyId]) }}',
                type: "POST",
                dataType: "JSON",
                data: function (f) {
                    f._token = "{{csrf_token()}}";
                },
                error: function (xhr) {
                    dataTableError("branchDT", xhr.responseJSON.message);
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
                text: "You want to change the branch status to " + status + "?",
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
                        url: "{{ route('admin.company.branches.update.status',['companyId' => $companyId]) }}",
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
            $("#addCompanyBranchForm").trigger('reset');
            $("#editCompanyBranchForm").trigger('reset');
            $("#addBranchContactForm").trigger('reset');
            $("#editBranchContactForm").trigger('reset');
            $("label.error").hide();
            $("#currentBranchImage").hide();
        }

        function removeBranch(id, element) {
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to remove this branch?",
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
                        url: "{{route('admin.company.branches.delete',['companyId' => $companyId])}}",
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

        function getBranch(id, element) {
            $.ajax({
                url: "{{route('admin.company.branches.edit',['companyId' => $companyId])}}",
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
                    $("#branch_id").val(id);
                    $('#editBranchName').val(data.data.branch_name);
                    $('#editAddress1').val(data.data.address_1);
                    $('#editLocality').val(data.data.locality);
                    $('#editPostalCode').val(data.data.postal_code);
                    $('#editUpsellingInputUrl').val(data.data.upselling_input_url);
                    $('#editUpsellingReportUrl').val(data.data.upselling_report_url);
                    $('#editInputUrl46').val(data.data.input_url_46);
                    $('#editReportUrl46').val(data.data.report_url_46);
                    $('#editRoute').val(data.data.route);

                    // Set image if exists
                    if (data.data.image) {
                        $("#currentBranchImage").attr('src', data.data.image).show();
                    }


                    $("#editCompanyBranchMD").modal('show');
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
            $("#addCompanyBranchForm").validate({
                rules: {
                    branch_name: {required: true},
                },
                messages: {
                    branch_name: {required: "The branch field is required."},
                },
                errorClass: 'text-danger error',
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.branches.add',['companyId' => $companyId])}}",
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
                            $("#addCompanyBranchMD").modal('hide');
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
            $("#editCompanyBranchForm").validate({
                rules: {
                    branch_name: {required: true},
                },
                errorClass: 'text-danger error',
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.branches.update',['companyId' => $companyId])}}",
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
                            $("#editCompanyBranchMD").modal('hide');
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
        function initBranchContactsDT(branchId) {
            branchContactsDT = $('#branchContactsDT').DataTable({
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
                    {data: 'first_name', name: 'first_name', title: 'First Name', class: 'text-center'},
                    {data: 'last_name', name: 'last_name', title: 'Last Name', class: 'text-center'},
                    {data: 'email', name: 'email', title: 'Email', class: 'text-center'},
                    {data: 'mobile_number', name: 'mobile_number', title: 'Mobile', class: 'text-center'},
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
                    url: '{{ route("admin.company.branch.users.list",["companyId" => $companyId]) }}',
                    type: "POST",
                    dataType: "JSON",
                    data: function (f) {
                        f._token = "{{csrf_token()}}";
                        f.branch_id = branchId;
                        f.company_id = companyId;
                    },
                    error: function (xhr) {
                        dataTableError("branchContactsDT", xhr.responseJSON.message);
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
        // Handle status change for branch contacts
        $(document).on('change', '.company-user-status-select', function () {
            let id = $(this).data('id');
            let status = $(this).val();

            Swal.fire({
                title: "Are you sure?",
                text: "You want to change the contact status to " + status + "?",
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
                        url: "{{ route('admin.company.branch.users.update.status',['companyId' => $companyId]) }}",
                        method: "POST",
                        data: {
                            id: id,
                            status: status,
                            company_id: companyId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            sendSuccess(response.message);
                            branchContactsDT.ajax.reload();
                        },
                        error: function (xhr) {
                            actionError(xhr);
                            branchContactsDT.ajax.reload();
                        }
                    });
                } else {
                    // Revert the select to its previous value
                    branchContactsDT.ajax.reload();
                }
            });
        });

        // Show branch contacts offcanvas
        function showContacts(branchId, branchName) {
            $('#branchNameTitle').text(branchName);
            $('#branch_id_for_contact').val(branchId);
            initBranchContactsDT(branchId);
            $('#branchContactsOffcanvas').offcanvas('show');
        }

        // Add company user button click in offcanvas
        $(document).on('click', '#addBranchContactBtnOffcanvas', function () {
            resetBranchContactForm();
            $('#addBranchContactMD').modal('show');
        });

        // Reset company user form
        function resetBranchContactForm() {
            $("#addBranchContactForm").trigger('reset');
            $("#editBranchContactForm").trigger('reset');
            $("#inviteCompanyUserForm").trigger('reset');
            $("label.error").hide();
            $("#currentCompanyUserImage").hide();
        }

        // Get company user for edit
        function getBranchContact(id, element) {
            $.ajax({
                url: "{{route('admin.company.branch.users.edit',['companyId' => $companyId])}}",
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
                    resetBranchContactForm();

                    $("#edit_branch_contact_id").val(id);
                    $('#editFirstName').val(data.data.first_name);
                    $('#editLastName').val(data.data.last_name);
                    $('#editContactEmail').val(data.data.email);
                    $('#editMobileNumber').val(data.data.mobile_number);
                    $('#editBranchContactStatus').val(data.data.status);

                    $("#editBranchContactMD").modal('show');
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
        function removeBranchContact(id, element) {
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to remove this contact?",
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
                        url: "{{route('admin.company.branch.users.delete',['companyId' => $companyId])}}",
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
                            branchContactsDT.ajax.reload();
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
            $("#addBranchContactForm").validate({
                rules: {
                    first_name: {required: true},
                    last_name: {required: true},
                    email: {required: true, email: true},
                    mobile_number: {required: true},
                },
                messages: {
                    email: {required: "The email field is required.", email: "Please enter a valid email address."},
                },
                errorClass: 'text-danger error',
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.branch.users.add',['companyId' => $companyId])}}",
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
                            branchContactsDT.ajax.reload();
                            $("#addBranchContactMD").modal('hide');
                            resetBranchContactForm();
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
            $("#editBranchContactForm").validate({
                rules: {
                    first_name: {required: true},
                    last_name: {required: true},
                    email: {required: true, email: true},
                    mobile_number: {required: true},
                },
                messages: {
                    email: {required: "The email field is required.", email: "Please enter a valid email address."},
                },
                errorClass: 'text-danger error',
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.branch.users.update',['companyId' => $companyId])}}",
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
                            branchContactsDT.ajax.reload();
                            $("#editBranchContactMD").modal('hide');
                            resetBranchContactForm();
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
        });
    </script>
@endsection
