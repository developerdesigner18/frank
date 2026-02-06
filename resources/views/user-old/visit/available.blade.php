@extends('user.master')
@section('title','Available Visit')

@push('modal')
    <!-- Add Company Modal -->
    <div class="modal fade" id="visitNoteModal" tabindex="-1" aria-labelledby="visitNoteModalLabel"
         aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Visit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="route" class="form-label">Sort by</label>
            <select class="form-select" id="sort_by">
                <option value="">-- Sort By --</option>
                <option value="name_asc">Name A-Z</option>
                <option value="name_desc">Name Z-A</option>
                <option value="start_old">Start of Visit (Old-New)</option>
                <option value="start_new">Start of Visit (New-Old)</option>
            </select>
        </div>
    </div>
    <div id="visitResults">
        @if($results)
            <div class="row">
                @foreach($results as $rowData)
                    @php
                        // Set locale to Dutch
                        \Carbon\Carbon::setLocale('nl');

                        $startDate =  \Carbon\Carbon::parse($rowData->start_datetime);
                        $endDate   =  \Carbon\Carbon::parse($rowData->end_datetime);
                    @endphp
                    <div class="col-md-6 col-lg-4 col-div">
                        <div class="card border-2 border-d4dedc rounded-4">
                            <div class="card-body px-2 py-3">
                                <div class="align-items-center d-flex mb-1">
                                    <div style="width: 60px;">
                                        <img src="{{ $rowData->branch->image }}" class="w-100" style="clip-path: circle(33%);">
                                    </div>
                                    <div>
                                        {{ $startDate->format('d/m/Y (D)') }} - {{ $endDate->format('d/m/Y (D)') }}
                                    </div>
                                </div>
                                <div>
                                    <h5>{{ $rowData->questionnaire->name }}</h5>
                                    <div class="rounded-5 p-2 mb-2" style="background: #f9f9f9;">
                                        {{ $rowData->branch->address_1??'' }} {{ $rowData->branch->postal_code??'' }} {{ $rowData->branch->locality??'' }}
                                    </div>
                                    <div class="rounded-3 p-2 mb-2 align-items-center d-flex justify-content-between visitNote h-55px" style="background: #faf7fe;" data-note="{{ $rowData->description }}">
                                        <span class="short_desc">{{ $rowData->description }}</span>
                                        <i class='bx bx-expand-alt ml-1'></i>
                                    </div>
                                    <div class="pt-2 pb-2">
                                        <span class="rounded-5 p-2 bg-ebf5ff border-d4dedc fw-medium border-2">
                                            <span class="text-2c6e88">Fee €</span>{{ $rowData->price }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="rounded-5 p-2 bg-ebf5ff border-d4dedc text-2c6e88 h-100 fw-medium border-2">
                                            Expense Estimate
                                            €<span class="text-black">{{ $rowData->price }}</span> - €<span class="text-black">{{ $rowData->price }}</span>
                                        </span>
                                        <button type="button" class="btn bx bx-heart fs-1 text-2c6e88" onclick="requestVisit({{ $rowData->id }},this)"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

{{--    <div class="card">--}}
{{--        <div class="card-body">--}}
{{--            <table id="visitDT" class="listDatatable tableview table w-100 pt-2 datatable dataTable no-footer"></table>--}}
{{--        </div>--}}
{{--    </div>--}}

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
                    url: '{{ route("visit.available.list") }}',
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

            $(document).delegate('.visitNote','click', function (e){
                var note = $(this).data('note');
                $("#visitNoteModal").modal('show');
                $('#visitNoteModal .modal-body').html(note);
            })

            // Request visit
            function requestVisit(id, element) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to Request this visit?",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, Request",
                    cancelButtonText: "No, cancel!",
                    confirmButtonClass: "btn btn-danger mt-2 text-white rounded px-4 fs-16",
                    cancelButtonClass: "btn btn-light ms-2 mt-2 border rounded px-4 fs-16",
                    buttonsStyling: !1,
                }).then(function (t) {
                    if (t.value) {
                        $.ajax({
                            url: "{{route('visit.request')}}",
                            dataType: "JSON",
                            method: "POST",
                            data: {
                                "id": id,
                                "_token": "{{csrf_token()}}",
                            },
                            beforeSend: function () {
                                // $(element).addClass('<i class="spinner-border fs-10 spinner-border-sm m-1 mx-0"></i>');
                                // $(element).attr('disabled', true);
                            },
                            success: function (data) {
                                sendSuccess(data.message);
                                // dataTable.ajax.reload();

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
                                // $(element).attr('disabled', false);
                                // $(element).html('<i class="ri-delete-bin-5-fill fs-16"></i>');
                                $(element).closest('.col-div').remove();
                            }
                        });
                    }
                });
            }
            window.requestVisit = requestVisit;

            $('#sort_by').on('change', function () {
                let sort = $(this).val();

                $.ajax({
                    url: "{{ route('visit.available.list.filter') }}",
                    type: "POST",
                    data: {
                        sort_by: sort,
                        "_token": "{{csrf_token()}}"
                    },
                    dataType: "JSON",
                    success: function (data) {
                        $('#visitResults').html(data.message); // replace cards
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data.hasOwnProperty('message')) {
                            sendError(data.message);
                        } else {
                            sendError("An error occurred. Please try again.");
                        }
                    },
                });
            });
        });
    </script>
@endsection
