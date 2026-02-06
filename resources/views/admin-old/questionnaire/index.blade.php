@extends('admin.master')
@section('title','Questionnaire')

@push('modal')

@endpush

@section('main')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Questionnaire</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Questionnaire</a></li>
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
                            <h5 class="card-title mb-0">Questionnaire List</h5>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{route('admin.questionnaire.create')}}" class="btn btn-primary">
                                    <i class="ri-add-line align-bottom"></i>
                                    <span class="d-none d-sm-inline-block">Add Questionnaire</span>
                                </a>
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
    <script !src="">
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
                {data: 'name', name: 'name', title: 'Name', class: 'text-center'},
                {data: 'status', name: 'status', title: 'Status', class: 'text-center', orderable: false},
                {data: 'published', name: 'published', title: 'Published', class: 'text-center', orderable: false},
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
                url: '{{ route("admin.questionnaire.list") }}',
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

        $(document).on('change', '.status-select', function () {
            let id = $(this).data('id');
            let status = $(this).val();

            Swal.fire({
                title: "Are you sure?",
                text: "You want to change the status to " + status + "?",
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
                        url: "{{ route('admin.questionnaire.update.status') }}",
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

        function changePublish(id, element) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to change?",
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
                        url: "{{ route('admin.questionnaire.update.publish') }}",
                        method: "POST",
                        data: {
                            id: id,
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
        }

        function removeQue(id, element) {
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to remove this questionnaire?",
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
                        url: "{{route('admin.questionnaire.delete')}}",
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

        function cloneQue(id, title, element) {
            Swal.fire({
                title: "Clone Questionnaire",
                html: `
            <div class="text-center">
                <p>Please enter a title for the cloned questionnaire:</p>
                <input id="clone-title" class="form-control" placeholder="Questionnaire title" value="${title} (Copy)">
            </div>
        `,
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Clone",
                cancelButtonText: "Cancel",
                confirmButtonClass: "btn btn-primary mt-2 text-white rounded px-4 fs-16",
                cancelButtonClass: "btn btn-light ms-2 mt-2 border rounded px-4 fs-16",
                buttonsStyling: false,
                focusConfirm: false,
                preConfirm: () => {
                    const cloneTitle = Swal.getPopup().querySelector('#clone-title').value;
                    if (!cloneTitle) {
                        Swal.showValidationMessage('Please enter a title');
                        return false;
                    }
                    return cloneTitle;
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const cloneTitle = result.value;
                    $.ajax({
                        url: "{{route('admin.questionnaire.clone')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "title": cloneTitle,
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
                            $(element).html('<i class="ri-file-copy-fill fs-16"></i>');
                        }
                    });
                }
            });
        }

    </script>
@endsection
