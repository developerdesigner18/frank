@extends('company.master')
@section('title','Branches')

@push('modal')
@endpush

@section('main')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Branches</h4>

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
                url: '{{ route("company.branches.list") }}',
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
    </script>
@endsection
