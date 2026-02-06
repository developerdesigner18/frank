@extends('admin.master')
@section('title','Interested Visit')

@push('modal')

@endpush

@section('main')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Interested Visit</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Interested Visit</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="card">
        <div class="card-body">
            <table id="visitDT" class="listDatatable tableview table w-100 pt-2 datatable dataTable no-footer"></table>
        </div>
    </div>

@endsection

@section('script')
    <script !src="">
        $(document).ready(function () {

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
                    {data: 'visitorName', name: 'visitorName', title: 'visitor Name', class: 'text-center'},
                    {data: 'branch', name: 'branch.branch_name', title: 'Branch', class: 'text-center'},
                    {data: 'questionnaire', name: 'questionnaire.name', title: 'Questionnaire', class: 'text-center'},
                    {data: 'start_datetime', name: 'start_datetime', title: 'Start Date', class: 'text-center'},
                    {data: 'end_datetime', name: 'end_datetime', title: 'End Date', class: 'text-center'},
                    {data: 'price', name: 'price', title: 'Fee', class: 'text-center'},
                    {
                        data: 'expense_estimate',
                        name: 'expense_estimate',
                        title: 'Expense Estimate',
                        class: 'text-center'
                    },
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
                    url: '{{ route("admin.visit.interested.list") }}',
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


            // Request visit
            function assignedVisit(id, element) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to Assigned this visit?",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, Assigned",
                    cancelButtonText: "No, cancel!",
                    confirmButtonClass: "btn btn-danger mt-2 text-white rounded px-4 fs-16",
                    cancelButtonClass: "btn btn-light ms-2 mt-2 border rounded px-4 fs-16",
                    buttonsStyling: !1,
                }).then(function (t) {
                    if (t.value) {
                        $.ajax({
                            url: "{{route('admin.visit.update.status')}}",
                            dataType: "JSON",
                            method: "POST",
                            data: {
                                "id": id,
                                status: 'ASSIGNED',
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

            // Reject visit
            function rejectVisit(id, element) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to Reject this visit?",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, Rejected",
                    cancelButtonText: "No, cancel!",
                    confirmButtonClass: "btn btn-danger mt-2 text-white rounded px-4 fs-16",
                    cancelButtonClass: "btn btn-light ms-2 mt-2 border rounded px-4 fs-16",
                    buttonsStyling: !1,
                }).then(function (t) {
                    if (t.value) {
                        $.ajax({
                            url: "{{route('admin.visit.reject')}}",
                            dataType: "JSON",
                            method: "POST",
                            data: {
                                "id": id,
                                status: 'OPEN',
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

            window.assignedVisit = assignedVisit;
            window.rejectVisit = rejectVisit;
        });
    </script>
@endsection
