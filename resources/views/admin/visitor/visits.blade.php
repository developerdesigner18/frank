@extends('admin.master')
@section('title',$user->first_name.' Visits')
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('admin.visitor.index') }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>Mystery Visitors</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-500">{{ $user->first_name }}</span>
    </div>
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">{{ $user->first_name }} Visits</span>
    </div>
@endpush
@push('modal')
    <!-- edit Visit Model -->
    <el-dialog>
        <dialog id="edit-visit-model" aria-labelledby="dialog-title"
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
                                <h3 id="add-visit-dialog-title" class="text-base font-semibold text-gray-800">
                                    Mystery Visit Event</h3>
                                <button type="button" command="close" commandfor="edit-visit-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-col gap-2 w-full">
                                <form class="flex flex-col gap-5 w-full" id="edit-visit-form" method="post">
                                    @csrf
                                    <input type="hidden" name="id">
                                    <!-- Branch Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="branch"
                                               class="block text-sm font-medium text-gray-700">Branch</label>
                                        <div class="relative">
                                            <select name="branch_id"
                                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">Select</option>
                                                @foreach($branch_list as $bVal)
                                                    <option value="{{ $bVal->id }}">{{ $bVal->branch_name }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Period Range Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Period Range (start -
                                            end)</label>
                                        <div class="flex gap-2 justify-between items-center w-full">
                                            <div class="w-[47%]">
                                                <input type="datetime-local" id="start-date" name="start_datetime"
                                                       value="2025-09-19T11:37"
                                                       class="px-3 w-full py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none focus:border-transparent">

                                            </div>
                                            <span class="text-gray-500">-</span>
                                            <div class="w-[47%]">
                                                <input type="datetime-local" id="end-date" name="end_datetime"
                                                       value="2025-09-19T11:37"
                                                       class=" px-3 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none focus:border-transparent">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Questionnaire Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="questionnaire"
                                               class="block text-sm font-medium text-gray-700">Questionnaire</label>
                                        <div class="relative w-full">
                                            <select id="questionnaire_id" name="questionnaire_id"
                                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">Select</option>
                                                @foreach($questionnaires_list as $qusVal)
                                                    <option value="{{ $qusVal->id }}">{{ $qusVal->name }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Price Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                        <div class="relative w-full">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">€</span>
                                            <input type="number" id="price" name="price" step="0.01" placeholder="0.00"
                                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                    </div>

                                    <!-- Expense Estimate Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Expense Estimate</label>
                                        <div class="flex items-center gap-2 w-full">
                                            <div class="relative flex-1">
                                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">€</span>
                                                <input type="number" id="expense-min" name="expense_estimation_min"
                                                       step="0.01"
                                                       placeholder="0.00"
                                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>
                                            <span class="text-gray-500">-</span>
                                            <div class="relative flex-1">
                                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">€</span>
                                                <input type="number" id="expense-max" name="expense_estimation_max"
                                                       step="0.01"
                                                       placeholder="0.00"
                                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="description"
                                               class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea id="description" name="description" rows="3"
                                                  placeholder="Enter description..."
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                                    </div>

                                    <!-- Visitor Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="visitor"
                                               class="block text-sm font-medium text-gray-700">Visitor</label>
                                        <div class="relative w-full">
                                            <select id="visitor_id" name="visitor_id"
                                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">Select</option>
                                                @foreach($visitors_list as $vVal)
                                                    <option value="{{ $vVal->id }}">{{ $vVal->first_name }} {{ $vVal->last_name??'' }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path
                                                        d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Status Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="status"
                                               class="block text-sm font-medium text-gray-700">Status</label>
                                        <div class="relative w-full">
                                            <select id="status" name="status"
                                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                @foreach(\App\Enums\VisitStatus::cases() as $status)
                                                    <option value="{{ $status->value }}">{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Form Buttons -->
                                    <div class="grid grid-cols-[1fr_1fr] gap-3 pt-4 w-full">
                                        <button type="button" command="close" commandfor="edit-visit-model"
                                                class="btn-secondary px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="editVisitBtn btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>

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
                                    Visit Note</h3>
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
                                <p id="visit-dialog-description"
                                   class="text-sm font-normal text-gray-800 model-data"></p>
                            </div>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>
@endpush
@section('main')
    <section class="pt-4 sm:pt-6">
        <div class="flex flex-col md:flex-row items-center justify-end pb-6 gap-4">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative w-full md:w-auto">
                    <select id="filter-sort_by"
                            class="filter-fields w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2 sm:py-2.5 pr-8 text-sm sm:text-base text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="desc">Visit (New-Old)</option>
                        <option value="asc">Visit (Old-New)</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px] pointer-events-none"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
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
    <script>
        var visitorId = "{{ $visitorId }}";

        function visitList() {
            var sort_by = $('#filter-sort_by').val();
            $.ajax({
                url: "{{ route("admin.visitor.visits.list",["visitorId" => $visitorId]) }}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "sort_by": sort_by,
                    "visitorId": visitorId,
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

        $(document).delegate('.visitNote', 'click', function (e) {
            var note = $(this).data('note');
            $('#visit-model')[0].showModal();
            $('#visit-model .model-data').html(note);
        })

        $(document).delegate('.visitPublished', 'click', function (e) {
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

        // Remove visit
        function removeVisit(id, element) {
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to remove this visit?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, remove",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
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
                            $(element).attr('disabled', true);
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
                                sendError("An error occurred. Please try again.");
                            }
                        },
                        complete: function () {
                            $(element).attr('disabled', false);
                        }
                    });
                }
            });
        }

        // Duplicate visit
        function duplicateVisit(id, element) {
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to duplicate this visit?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, duplicate",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
                buttonsStyling: !1,
            }).then(function (t) {
                if (t.value) {
                    $.ajax({
                        url: "{{route('admin.visit.duplicate')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendToast(data.message)
                            visitList();
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
                        }
                    });
                }
            });
        }

        $('.filter-fields').on('change', function (e) {
            visitList();
        });

        function getVisit(id, element) {
            $.ajax({
                url: "{{route('admin.visit.edit')}}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "id": id,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    console.log(data.data.start_datetime);
                    var start_datetime = new Date(data.data.start_datetime);
                    start_datetime = start_datetime.toISOString().slice(0, 16);
                    var end_datetime = new Date(data.data.end_datetime);
                    end_datetime = end_datetime.toISOString().slice(0, 16);

                    $("#edit-visit-form input[name=id]").val(id);
                    $('#edit-visit-form select[name=branch_id]').val(data.data.branch_id);
                    $('#edit-visit-form input[name=start_datetime]').val(start_datetime);
                    $('#edit-visit-form input[name=end_datetime]').val(end_datetime);
                    $('#edit-visit-form select[name=questionnaire_id]').val(data.data.questionnaire_id);
                    $('#edit-visit-form input[name=price]').val(data.data.price);
                    $('#edit-visit-form input[name=expense_estimation_min]').val(data.data.expense_estimation_min);
                    $('#edit-visit-form input[name=expense_estimation_max]').val(data.data.expense_estimation_max);
                    $('#edit-visit-form textarea[name=description]').html(data.data.description);
                    $('#edit-visit-form select[name=visitor_id]').val(data.data.visitor_id);
                    $('#edit-visit-form select[name=status]').val(data.data.status);

                    $('#edit-visit-model')[0].showModal();
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
                }
            });
        }

        $("#edit-visit-form").validate({
            rules: {
                branch_id: {required: true},
                questionnaire_id: {required: true},
                start_datetime: {required: true},
                end_datetime: {required: true},
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
                start_datetime: {required: "Please select visit start date and time"},
                end_datetime: {required: "Please select visit end date and time"},
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
                        $('#editVisitBtn').attr('disabled', true).html(`
                            <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        `);
                    },
                    success: function (result) {
                        $('#edit-visit-model')[0].close();
                        sendToast(result.message)
                        visitList();
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
                        $('#editVisitBtn').attr('disabled', false).html('save');
                    }
                });
            }
        });

    </script>
@endsection
