@extends('user.master')
@section('title','Scheduled Visit')

@push('modal')

@endpush

@section('main')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Scheduled Visit</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Scheduled Visit</a></li>
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
                    {data: 'branch', name: 'branch.branch_name', title: 'Branch', class: 'text-center'},
                    {data: 'questionnaire', name: 'questionnaire.name', title: 'Questionnaire', class: 'text-center'},
                    {data: 'start_datetime', name: 'start_datetime', title: 'Start Date', class: 'text-center'},
                    {data: 'end_datetime', name: 'end_datetime', title: 'End Date', class: 'text-center'},
                    {data: 'price', name: 'price', title: 'Fee', class: 'text-center'},
                    {data: 'expense_estimate', name: 'expense_estimate', title: 'Expense Estimate', class: 'text-center'},
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
                    url: '{{ route("visit.scheduled.list") }}',
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


        });
    </script>
@endsection
