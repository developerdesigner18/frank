@extends('admin.master')
@section('title','Available Visit')

@push('modal')
    <!-- Add Visit Modal -->
    <div class="modal fade" id="addVisitMD" tabindex="-1" aria-labelledby="addVisitMDLabel" aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Visit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="addVisitForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="branchId" class="form-label">Branch</label>
                                    <select class="form-control" id="branchId" name="branch_id">
                                        <option value="">Select Branch</option>
                                    </select>
                                    <label id="branch_id-error" class="text-danger error" for="branch_id"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="questionnaireId" class="form-label">Questionnaire</label>
                                    <select class="form-control" id="questionnaireId" name="questionnaire_id">
                                        <option value="">Select Questionnaire</option>
                                    </select>
                                    <label id="questionnaire_id-error" class="text-danger error" for="questionnaire_id"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="visitDateTime" class="form-label">Visit Date</label>
                                    <input type="text" class="form-control flatpickr" id="visitDateTime"
                                           name="visit_datetime"
                                           placeholder="Select date and time" data-mode="range">
                                    <label id="visit_datetime-error" class="text-danger error" for="visit_datetime"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="price" name="price"
                                           placeholder="Enter price" step="0.01">
                                    <label id="price-error" class="text-danger error" for="price"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expenseMin" class="form-label">Expense Estimation (Min)</label>
                                    <input type="number" class="form-control" id="expenseMin"
                                           name="expense_estimation_min"
                                           placeholder="Enter minimum expense" step="0.01">
                                    <label id="expense_estimation_min-error" class="text-danger error"
                                           for="expense_estimation_min"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expenseMax" class="form-label">Expense Estimation (Max)</label>
                                    <input type="number" class="form-control" id="expenseMax"
                                           name="expense_estimation_max"
                                           placeholder="Enter maximum expense" step="0.01">
                                    <label id="expense_estimation_max-error" class="text-danger error"
                                           for="expense_estimation_max"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4"
                                              placeholder="Enter description"></textarea>
                                    <label id="description-error" class="text-danger error" for="description"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="visitorId" class="form-label">Visitor</label>
                                    <select class="form-control" id="visitorId" name="visitor_id">
                                        <option value="">Select Visitor</option>
                                    </select>
                                    <label id="visitor_id-error" class="text-danger error" for="visitor_id"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        @foreach(\App\Enums\VisitStatus::cases() as $status)
                                            <option value="{{ $status->value }}"
                                                    @if($status->value == 'OPEN') selected @endif>{{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label id="status-error" class="text-danger error" for="status"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light btn-lg"
                                            data-bs-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg" id="addVisitBtn">
                                        <i class="bx bx-loader spinner me-2" style="display: none"
                                           id="addVisitBtnSpinner"></i>Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Visit Modal -->
    <div class="modal fade" id="editVisitMD" tabindex="-1" aria-labelledby="editVisitMDLabel" aria-modal="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Visit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="editVisitForm">
                        @csrf
                        <input type="hidden" name="id" id="edit_visit_id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editBranchId" class="form-label">Branch</label>
                                    <select class="form-control" id="editBranchId" name="branch_id">
                                        <option value="">Select Branch</option>
                                    </select>
                                    <label id="edit_branch_id-error" class="text-danger error" for="branch_id"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editQuestionnaireId" class="form-label">Questionnaire</label>
                                    <select class="form-control" id="editQuestionnaireId" name="questionnaire_id">
                                        <option value="">Select Questionnaire</option>
                                    </select>
                                    <label id="edit_questionnaire_id-error" class="text-danger error"
                                           for="questionnaire_id"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editVisitDateTime" class="form-label">Visit Date</label>
                                    <input type="text" class="form-control flatpickr" id="editVisitDateTime"
                                           name="visit_datetime" placeholder="Select date and time" data-mode="range">
                                    <label id="edit_visit_datetime-error" class="text-danger error" for="visit_datetime"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editPrice" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="editPrice" name="price"
                                           placeholder="Enter price" step="0.01">
                                    <label id="edit_price-error" class="text-danger error" for="price"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editExpenseMin" class="form-label">Expense Estimation (Min)</label>
                                    <input type="number" class="form-control" id="editExpenseMin"
                                           name="expense_estimation_min"
                                           placeholder="Enter minimum expense" step="0.01">
                                    <label id="edit_expense_estimation_min-error" class="text-danger error"
                                           for="expense_estimation_min" style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editExpenseMax" class="form-label">Expense Estimation (Max)</label>
                                    <input type="number" class="form-control" id="editExpenseMax"
                                           name="expense_estimation_max"
                                           placeholder="Enter maximum expense" step="0.01">
                                    <label id="edit_expense_estimation_max-error" class="text-danger error"
                                           for="expense_estimation_max"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="editDescription" name="description" rows="4"
                                              placeholder="Enter description"></textarea>
                                    <label id="edit_description-error" class="text-danger error" for="description"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editVisitorId" class="form-label">Visitor</label>
                                    <select class="form-control" id="editVisitorId" name="visitor_id">
                                        <option value="">Select Visitor</option>
                                    </select>
                                    <label id="edit_visitor_id-error" class="text-danger error" for="visitor_id"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editStatus" class="form-label">Status</label>
                                    <select class="form-control" id="editStatus" name="status">
                                        @foreach(\App\Enums\VisitStatus::cases() as $status)
                                            <option value="{{ $status->value }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    <label id="edit_status-error" class="text-danger error" for="status"
                                           style="display: none"></label>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light btn-lg"
                                            data-bs-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-warning btn-lg" id="editVisitBtn">
                                        <i class="bx bx-loader spinner me-2" style="display: none"
                                           id="editVisitBtnSpinner"></i>Save Changes
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
                <h4 class="mb-sm-0">Available Visit</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Available Visit</a></li>
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
                            <h5 class="card-title mb-0">Visit List</h5>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex gap-1 flex-wrap">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addVisitMD">
                                    <i class="ri-add-line align-bottom"></i>
                                    <span class="d-none d-sm-inline-block">Add Visit</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="visitDT"
                           class="listDatatable tableview table w-100 pt-2 datatable dataTable no-footer"></table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script !src="">
        $(document).ready(function () {
            function initSelect2Field(selector, parent, url, placeholder) {
                $(selector).select2({
                    dropdownParent: $(parent),
                    ajax: {
                        url: url,
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                search: params.term,
                                page: params.page || 1,
                                _token: '{{ csrf_token() }}'
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.data,
                                pagination: {
                                    more: data.current_page < data.last_page
                                }
                            };
                        },
                        cache: true
                    },
                    placeholder: placeholder,
                    minimumInputLength: 1,
                    templateResult: function (item) {
                        if (item.loading) return item.text;
                        return item.name;
                    },
                    templateSelection: function (item) {
                        return item.name || item.text;
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    }
                });
            }

// Status dropdowns (no AJAX)
            $('#status').select2({dropdownParent: $('#addVisitMD')});
            $('#editStatus').select2({dropdownParent: $('#editVisitMD')});

// Branch dropdowns
            initSelect2Field('#branchId', '#addVisitMD', '{{ route("admin.visit.branches.search") }}', 'Select a branch');
            initSelect2Field('#editBranchId', '#editVisitMD', '{{ route("admin.visit.branches.search") }}', 'Select a branch');

// Visitor dropdowns
            initSelect2Field('#visitorId', '#addVisitMD', '{{ route("admin.visit.visitor.search") }}', 'Select a visitor');
            initSelect2Field('#editVisitorId', '#editVisitMD', '{{ route("admin.visit.visitor.search") }}', 'Select a visitor');

// Questionnaire dropdowns
            initSelect2Field('#questionnaireId', '#addVisitMD', '{{ route("admin.visit.questionnaires.search") }}', 'Select a questionnaire');
            initSelect2Field('#editQuestionnaireId', '#editVisitMD', '{{ route("admin.visit.questionnaires.search") }}', 'Select a questionnaire');


            // Initialize flatpickr for date range
            $(".flatpickr").flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                mode: "range",
                // minDate: "today",
                time_24hr: true
            });

            // DataTable initialization
            var dataTable = $('#visitDT').DataTable({
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
                    zeroRecords: "No records found",
                    search: "",
                    searchPlaceholder: "Search Here",
                    processing: "Processing...",
                    emptyTable: "No data available in table",
                    paginate: {
                        next: '<i class="ri-arrow-right-s-line">',
                        previous: '<i class="ri-arrow-left-s-line">',
                    },
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'id', title: 'ID', class: 'text-center'},
                    {data: 'branch', name: 'branch.branch_name', title: 'Branch', class: 'text-center'},
                    {data: 'questionnaire', name: 'questionnaire.name', title: 'Questionnaire', class: 'text-center'},
                    {data: 'start_datetime', name: 'start_datetime', title: 'Start Date', class: 'text-center'},
                    {data: 'end_datetime', name: 'end_datetime', title: 'End Date', class: 'text-center'},
                    // {data: 'status', name: 'status', title: 'Status', class: 'text-center'},
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
                    url: '{{ route("admin.visit.available.list") }}',
                    type: "POST",
                    dataType: "JSON",
                    data: function (f) {
                        f._token = "{{csrf_token()}}";
                    },
                    error: function (xhr) {
                        dataTableError("visitDT", xhr.responseJSON.message);
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
            $(document).on('change', '.visit-status-select', function () {
                let id = $(this).data('id');
                let status = $(this).val();

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to change the visit status to " + status + "?",
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
                            url: "{{ route('admin.visit.update.status') }}",
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

            // Form submission
            $("#addVisitForm").validate({
                rules: {
                    branch_id: {required: true},
                    questionnaire_id: {required: true},
                    visit_datetime: {required: true},
                    price: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    expense_estimation_min: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    expense_estimation_max: {
                        required: true,
                        number: true,
                        min: function () {
                            return parseFloat($('#expenseMin').val()) || 0;
                        }
                    },
                    // visitor_id: {required: true},
                    status: {required: true}
                },
                messages: {
                    branch_id: {required: "Please select a branch"},
                    questionnaire_id: {required: "Please select a questionnaire"},
                    visit_datetime: {required: "Please select visit date and time"},
                    price: {
                        required: "Please enter the price",
                        number: "Please enter a valid number",
                        min: "Price cannot be negative"
                    },
                    expense_estimation_min: {
                        required: "Please enter minimum expense",
                        number: "Please enter a valid number",
                        min: "Expense cannot be negative"
                    },
                    expense_estimation_max: {
                        required: "Please enter maximum expense",
                        number: "Please enter a valid number",
                        min: "Maximum expense should be greater than or equal to minimum expense"
                    },
                    // visitor_id: {required: "Please select a visitor"},
                    status: {required: "Please select a status"}
                },
                errorClass: 'text-danger error',
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();

                    $.ajax({
                        url: "{{ route('admin.visit.save') }}",
                        method: "POST",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#addVisitBtn').attr('disabled', true);
                            $("#addVisitBtnSpinner").show();
                        },
                        success: function (result) {
                            sendToast(result.message)
                            $("#addVisitMD").modal('hide');
                            form.reset();
                            dataTable.ajax.reload();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('errors')) {
                                $.each(data.errors, function (key, value) {
                                    $("#" + key + "-error").html(value[0]).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                sendError(data.message);
                            } else {
                                sendError("An error occurred. Please try again.");
                            }
                        },
                        complete: function () {
                            $('#addVisitBtn').attr('disabled', false);
                            $("#addVisitBtnSpinner").hide();
                        }
                    });
                }
            });

            // Edit Visit Form validation
            $("#editVisitForm").validate({
                rules: {
                    branch_id: {required: true},
                    questionnaire_id: {required: true},
                    visit_datetime: {required: true},
                    price: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    expense_estimation_min: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    expense_estimation_max: {
                        required: true,
                        number: true,
                        min: function () {
                            return parseFloat($('#editExpenseMin').val()) || 0;
                        }
                    },
                    // visitor_id: {required: true},
                    status: {required: true}
                },
                messages: {
                    branch_id: {required: "Please select a branch"},
                    questionnaire_id: {required: "Please select a questionnaire"},
                    visit_datetime: {required: "Please select visit date and time"},
                    price: {
                        required: "Please enter the price",
                        number: "Please enter a valid number",
                        min: "Price cannot be negative"
                    },
                    expense_estimation_min: {
                        required: "Please enter minimum expense",
                        number: "Please enter a valid number",
                        min: "Expense cannot be negative"
                    },
                    expense_estimation_max: {
                        required: "Please enter maximum expense",
                        number: "Please enter a valid number",
                        min: "Maximum expense should be greater than or equal to minimum expense"
                    },
                    // visitor_id: {required: "Please select a visitor"},
                    status: {required: "Please select a status"}
                },
                errorClass: 'text-danger error',
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    let id = $('#edit_visit_id').val();

                    $.ajax({
                        url: "{{ route('admin.visit.update') }}",
                        method: "POST",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#editVisitBtn').attr('disabled', true);
                            $("#editVisitBtnSpinner").show();
                        },
                        success: function (result) {
                            sendToast(result.message)
                            $("#editVisitMD").modal('hide');
                            form.reset();
                            dataTable.ajax.reload();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('errors')) {
                                $.each(data.errors, function (key, value) {
                                    $("#edit_" + key + "-error").html(value[0]).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                sendError(data.message);
                            } else {
                                sendError("An error occurred. Please try again.");
                            }
                        },
                        complete: function () {
                            $('#editVisitBtn').attr('disabled', false);
                            $("#editVisitBtnSpinner").hide();
                        }
                    });
                }
            });

            // Custom validation for expense max >= expense min
            $.validator.addMethod("min", function (value, element, param) {
                return this.optional(element) || parseFloat(value) >= parseFloat(param);
            }, "Maximum expense must be greater than or equal to minimum expense");

            // Reset form when modal is closed
            $('#addVisitMD').on('hidden.bs.modal', function () {
                $('#addVisitForm')[0].reset();
                $('.error').hide();
                $('#branchId').val(null).trigger('change');
                $('#questionnaireId').val(null).trigger('change');
                $('#visitorId').val(null).trigger('change');
            });

            $('#editVisitMD').on('hidden.bs.modal', function () {
                $('#editVisitForm')[0].reset();
                $('.error').hide();
                $('#editBranchId').val(null).trigger('change');
                $('#editQuestionnaireId').val(null).trigger('change');
                $('#editVisitorId').val(null).trigger('change');
            });

            // Get visit data for edit
            function getVisit(id, element) {
                $.ajax({
                    url: "{{route('admin.visit.edit')}}",
                    dataType: "JSON",
                    data: {
                        id: id
                    },
                    method: "GET",
                    beforeSend: function () {
                        $(element).html('<i class="spinner-border fs-10 spinner-border-sm m-1 mx-0"></i>');
                        $(element).attr('disabled', true);
                    },
                    success: function (data) {
                        $('#edit_visit_id').val(data.data.id);

                        // Set branch
                        if (data.data.branch) {
                            var branchOption = new Option(data.data.branch.branch_name, data.data.branch_id, true, true);
                            $('#editBranchId').append(branchOption).trigger('change');
                        }

                        // Set questionnaire
                        if (data.data.questionnaire) {
                            var questionnaireOption = new Option(data.data.questionnaire.name, data.data.questionnaire_id, true, true);
                            $('#editQuestionnaireId').append(questionnaireOption).trigger('change');
                        }

                        // Set visitor
                        if (data.data.visitor) {
                            var visitorName = data.data.visitor.first_name + ' ' + data.data.visitor.last_name;
                            var visitorOption = new Option(visitorName, data.data.visitor_id, true, true);
                            $('#editVisitorId').append(visitorOption).trigger('change');
                        }

                        function formatUtcToLocal(dateTimeString) {
                            const date = dateTimeString.split('T')[0]; // "2025-06-16"
                            const time = dateTimeString.split('T')[1].substring(0, 5); // "12:00"
                            return `${date} ${time}`; // "2025-06-16 12:00"
                        }

                        const startDateStr = formatUtcToLocal(data.data.start_datetime);
                        const endDateStr = formatUtcToLocal(data.data.end_datetime);

                        $('#editVisitDateTime').flatpickr({
                            enableTime: false,
                            dateFormat: "Y-m-d",
                            mode: "range",
                            // minDate: "today",
                            time_24hr: true,
                            defaultDate: [startDateStr, endDateStr]
                        });

                        $('#editPrice').val(data.data.price);
                        $('#editExpenseMin').val(data.data.expense_estimation_min);
                        $('#editExpenseMax').val(data.data.expense_estimation_max);
                        $('#editDescription').val(data.data.description);
                        $('#editStatus').val(data.data.status).trigger('change');

                        $("#editVisitMD").modal('show');
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data.hasOwnProperty('message')) {
                            sendError(data.message);
                        } else {
                            sendError("An error occurred. Please try again.");
                        }
                    },
                    complete: function () {
                        $(element).attr('disabled', false);
                        $(element).html('<i class="ri-pencil-fill fs-16"></i>');
                    }
                });
            }

            // Remove visit
            function removeVisit(id, element) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to remove this visit?",
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
                            url: "{{route('admin.visit.delete')}}",
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
                                if (data.hasOwnProperty('message')) {
                                    sendError(data.message);
                                } else {
                                    sendError("An error occurred. Please try again.");
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

            // Make functions global
            window.getVisit = getVisit;
            window.removeVisit = removeVisit;
        });
    </script>
@endsection
