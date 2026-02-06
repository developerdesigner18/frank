
@extends('user.master')
@section('title', $page.' visits')
@push('navbar')
    <div class="pt-6 flex justify-between items-center lg:hidden capitalize">
        <span class="text-2xl font-semibold text-gray-800">{{ $page.' ' .'visits' }}
</span>
    </div>
@endpush
@push('modal')
    <!-- Visit Model -->
    <el-dialog>
        <dialog id="visit-model" aria-labelledby="dialog-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0"
                 class="flex min-h-full justify-center p-4 text-center focus:outline-none items-center sm:p-0">
                <el-dialog-panel
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 w-full max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-white relative px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex flex-col sm:items-start">
                            <div class="flex pb-4 justify-between w-full items-center">
                                <h3 id="visit-dialog-title" class="text-base font-semibold text-gray-800">
                                    {{ trans_message('visit_note') }}</h3>
                                <button type="button" command="close" commandfor="visit-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-col gap-2">
                                <p id="visit-dialog-description" class="text-sm font-normal text-gray-800 model-data"></p>
                            </div>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>
@endpush
@section('main')
    <section class="bg-white p-2 sm:p-6 rounded-2xl shadow-lg">
        <div class="flex flex-col md:flex-row items-center justify-between pb-6 gap-4">
            <div class="relative w-full md:w-auto flex-grow">
                <input type="text"
                       class="sm:pl-10 pl-8 py-2 sm:py-2.5 border border-[#e5e7eb] rounded-full w-full text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 filter-search"
                       placeholder="{{ trans_message('search') }}">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px]"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z">
                    </path>
                </svg>
            </div>
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative w-full md:w-auto">
                    <select id="filter-sort_by" class="filter-fields w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2 sm:py-2.5 pr-8 text-sm sm:text-base text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="id_desc">{{ trans_message('most_recent') }}</option>

                        <option value="id_asc">{{ trans_message('oldest') }}</option>
                        <option value="branch_asc">{{ trans_message('branch_name_asc') }}</option>
                        <option value="branch_desc">{{ trans_message('branch_name_desc') }}</option>

                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px] pointer-events-none"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                                d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4 visitListData">

        </div>
    </section>
@endsection
@section('script')
    <script !src="">

        function visitList(){
            var sort_by = $('#filter-sort_by').val();
            var search = $('.filter-search').val();
            var type = $('.filter-type:checked').map(function () {
                return $(this).val();
            }).get();
            var page = '{{ $page }}';

            let url = "{{ route("visit.list",["page" => $page]) }}";
            if (page==='completed'){
                url = "{{ route("visit.completed.list",["page" => $page]) }}";
            }
            $.ajax({
                url: url,
                dataType: "JSON",
                method: "POST",
                data: {
                    "sort_by": sort_by,
                    "search": search,
                    "type": type,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    $('.visitListData').html(data.message)
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data.hasOwnProperty('message')) {
                        actionError(xhr, data.message)
                    } else {
                        actionError(xhr);
                    }
                }
            });
        }
        visitList();


        $(document).delegate('.visitNote','click', function (e){
            var note = $(this).data('note');
            $('#visit-model')[0].showModal();
            $('#visit-model .model-data').html(note);
        })

        $(document).delegate('.filter-type','change', function (e){
            var type = $(this).val();
            if(type==='all'){
                $('.filter-type').prop('checked', false);
                $(this).prop('checked', true);
            }else{
                $('#filter-all').prop('checked', false);
            }
            visitList();
        })

        $(document).delegate('.visitPublished','click', function (e){
            var id = $(this).attr('data-id');
            var status = 0;
            if ($(this).is(":checked")) {
                status = 1;
            }
            $.ajax({
                url: "{{ route("admin.visit.published") }}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "id": id,
                    "status": status,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    sendToast(data.message);
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data.hasOwnProperty('message')) {
                        actionError(xhr, data.message)
                    } else {
                        actionError(xhr);
                    }
                }
            });
        });

        $('.filter-fields').on('change', function (e){
            visitList();
        });
        $('.filter-search').on('keyup', function (e){
            visitList();
        });

        // Request visit
        function visitReportStatus(id, type, element) {
            var msg = "";
            if (type==='reject'){
                msg = "This action will put back this event to In Progress status.";
            }
            Swal.fire({
                title: "{{ trans_message('swal_are_you_sure') }}",
                text: "{{ trans_message('swal_confirm_action') }}" + type + "{{ trans_message('swal_this_visit') }} " + msg,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "{{ trans_message('swal_yes') }} " + type,
                cancelButtonText: "{{ trans_message('swal_no_cancel') }}",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
                buttonsStyling: !1,
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('admin.visit.visitReportStatus')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "type": type,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            // $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendToast(data.message);
                            visitList();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('message')) {
                                sendError(data.message);
                            } else {
                                sendError("{{ trans_message('swal_error') }}");
                            }
                        },
                        complete: function () {
                            $(element).attr('disabled', false);
                        }
                    });
                }
            });
        }

        // Request visit
        function requestVisit(id, element) {
            var available_count = parseInt($('.available_count').html());
            var interested_count = parseInt($('.interested_count').html());
            Swal.fire({
                title: "{{ trans_message('swal_are_you_sure') }}",
                text: "{{ trans_message('swal_request_confirm') }}",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "{{ trans_message('swal_yes_request') }}",
                cancelButtonText: "{{ trans_message('swal_no_cancel') }}",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
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
                            available_count = available_count-1;
                            interested_count = interested_count+1;
                            $('.available_count').html(available_count);
                            $('.interested_count').html(interested_count);
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
                            visitList();
                        }
                    });
                }
            });
        }

    </script>
@endsection
