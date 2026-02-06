@extends('admin.master')
@section('title',trans_message("questionnaires"))
@push('navbar')
    <div class="pt-6 justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">Questionnaires</span>
        <div class="relative w-auto">
            <button command="show-modal" commandfor="add-questionnaire-model" onclick="resetForm();"
                    class="btn-primary w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2.5 text-gray-700 cursor-pointer transition-all duration-300">
                <span>{{ trans_message("add_questionnaire") }}</span>
            </button>
        </div>
    </div>
@endpush
@push('modal')
    <!-- Visit Model -->
    <el-dialog>
        <dialog id="settings-model" aria-labelledby="dialog-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0"
                 class="flex min-h-full justify-center p-4 text-center focus:outline-none items-center sm:p-0">
                <el-dialog-panel
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 w-full max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-white relative px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex flex-col sm:items-start">
                            <div class="flex pb-4 justify-center w-full items-center">
                                <h3 id="settings-dialog-title"
                                    class="capitalize text-xl text-center font-semibold text-gray-800">
                                    {{ trans_message('copy_locked_title') }}
                                </h3>
                                <button type="button" command="close" commandfor="settings-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path
                                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-col gap-2">
                                <p class="text-sm text-gray-800 text-center">
                                    {{ trans_message('copy_locked_message') }}
                                </p>
                                <div class="grid grid-cols-[1fr_1fr] gap-3 pt-4 w-full">
                                    <button type="button" command="close" commandfor="settings-model"
                                            class="btn-secondary px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300"
                                            aria-expanded="true">
                                        {{ trans_message('cancel') }}
                                    </button>
                                    <button type="submit"
                                            class="btn-primary flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                                        {{ trans_message('duplicate') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>

    <!-- Duplicate Model -->
    <el-dialog>
        <dialog id="duplicate-model" aria-labelledby="dialog-title"
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
                                <h3 id="duplicate-dialog-title" class="text-base font-semibold text-gray-800">
                                    {{ trans_message('duplicate_questionnaire_title') }}
                                </h3>
                                <button type="button" command="close" commandfor="duplicate-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path
                                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path>
                                    </svg>
                                </button>
                            </div>
                            <form class="flex flex-col gap-2 w-full" id="duplicateQuestionnaireForm">
                                @csrf
                                <input type="hidden" name="id">
                                <div class="w-full flex flex-col gap-1">
                                    <label for="branch" class="block text-sm font-medium text-gray-700">
                                        {{ trans_message('questionnaire_name') }}
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="name" name="name" value=""
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <label id="name-error" class="text-[red] error" for="name"></label>
                                    </div>
                                </div>
                                <div class="grid gap-3 pt-4 w-full">
                                    <button type="submit"
                                            class="btn-primary px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300 flex justify-center"
                                            aria-expanded="true" id="duplicateQuestionnaireBtn">
                                        {{ trans_message('save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>


    <!-- Add Questionnaire Model -->
    <el-dialog>
        <dialog id="add-questionnaire-model" aria-labelledby="dialog-title"
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
                                <h3 id="add-questionnaire-dialog-title" class="text-base font-semibold text-gray-800">
                                    {{ trans_message('add_questionnaire') }}
                                </h3>
                                <button type="button" command="close" commandfor="add-questionnaire-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path
                                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path>
                                    </svg>
                                </button>
                            </div>
                            <form id="addQuestionnaireForm" class="flex flex-col gap-2 w-full">
                                @csrf
                                <div class="w-full flex flex-col gap-1">
                                    <label for="branch" class="block text-sm font-medium text-gray-700">
                                        {{ trans_message('placeholder_questionnaire_name') }}
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="name" name="name" value=""
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <label id="name-error" class="text-[red] error" for="name"></label>
                                    </div>
                                </div>
                                <div class="grid gap-3 pt-4 w-full">
                                    <button type="submit"
                                            class="btn-primary px-4 py-2 flex justify-center items-center gap-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300"
                                            aria-expanded="true" id="addQuestionnaireBtn">
                                        {{ trans_message('save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>

    <!-- Delete / Close Model -->
    <el-dialog>
        <dialog id="close-model" aria-labelledby="dialog-title"
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
                                <button type="button" command="close" commandfor="close-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path
                                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-col gap-2 w-full">
                                <p class="text-sm text-gray-800 text-center sm:px-4">
                                    {{ trans_message('cannot_edit_questionnaire') }}
                                </p>
                                <div class="grid gap-3 pt-4 w-full">
                                    <button type="button" command="close" commandfor="close-model"
                                            class="btn-primary px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300"
                                            aria-expanded="true">
                                        {{ trans_message('close') }}
                                    </button>
                                </div>
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
                    <select id="filter-status"
                            class="filter-fields w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2 sm:py-2.5 pr-8 text-sm sm:text-base text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All</option>
                        @foreach(\App\Enums\QuestionnaireStatus::cases() as $status)
                            <option value="{{ $status->value }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                    <svg
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px] pointer-events-none"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                        </path>
                    </svg>
                </div>
                <div class="relative w-full md:w-auto">
                    <select id="filter-sort_by"
                            class="filter-fields w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2 sm:py-2.5 pr-8 text-sm sm:text-base text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="desc">{{ trans_message('most_recent') }}</option>
                        <option value="asc">{{ trans_message('oldest') }}</option>
                    </select>
                    <svg
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px] pointer-events-none"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                        </path>
                    </svg>
                </div>
                <div class="relative w-full hidden lg:flex md:w-auto">
                    <button command="show-modal" commandfor="add-questionnaire-model"
                            class="btn-primary w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2.5 text-gray-700 cursor-pointer transition-all duration-300"
                            aria-expanded="false">
                        <span>{{ trans_message('add_questionnaire') }}</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-4 questionnaireList">
            <!-- Questionnaire Card -->
        </div>
    </section>

@endsection
@section('script')
    <script>

        function questionnaireList() {
    var status = $('#filter-status').val();
    var sort_by = $('#filter-sort_by').val();

    $.ajax({
        url: "{{ route('admin.questionnaire.list') }}",
        dataType: "JSON",
        method: "POST",
        data: {
            status: status,
            sort_by: sort_by, // ✅ FIX
            _token: "{{csrf_token()}}",
        },
        success: function (data) {
            $('.questionnaireList').html(data.message);
        },
        error: function (xhr) {
            let data = xhr.responseJSON;
            if (data?.message) {
                actionError(xhr, data.message);
            } else {
                actionError(xhr);
            }
        }
    });
}
        questionnaireList();

        $('.filter-fields').on('change', function (e) {
            questionnaireList();
        });

        function resetForm() {
            $("#duplicateQuestionnaireForm").trigger('reset');
            $("#addQuestionnaireForm").trigger('reset');
            $("label.error").hide();
        }

        function duplicateQuestionnaire(id, name, element) {
            $('#duplicateQuestionnaireForm input[name=id]').val(id);
            $('#duplicateQuestionnaireForm input[name=name]').val(name + ' Copy');
            $('#duplicate-model')[0].showModal();
        }

        $(document).delegate('.statusUpdate', 'click', function (e) {
            var id = $(this).attr('data-id');
            var status = 'DRAFT';
            if ($(this).is(":checked")) {
                status = 'ACTIVE';
            }
            $.ajax({
                url: "{{ route("admin.questionnaire.status.update") }}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "id": id,
                    "status": status,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    sendToast(data.message);
                    questionnaireList();
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

        $(document).ready(function () {
            // Update Company Person Form
            $("#duplicateQuestionnaireForm").validate({
                rules: {
                    name: {required: true},
                },
                messages: {
                    name: {required: "{{ trans_message('name_required') }}"},
                },
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.questionnaire.duplicate')}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#duplicateQuestionnaireBtn').attr('disabled', true).html(`
                                    <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
    {{ trans_message('processing') }}
                            `);
                        },
                        success: function (result) {
                            $('#duplicate-model')[0].close();
                            sendToast(result.message);
                            resetForm();
                            questionnaireList();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#duplicateQuestionnaireForm #" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message);
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            $('#duplicateQuestionnaireBtn').attr('disabled', false).html('save');
                        },
                    });
                }
            });

            // Add Questionnaire Form
            $("#addQuestionnaireForm").validate({
                rules: {
                    name: {required: true},
                },
                messages: {
                    name: {required: "{{ trans_message('name_required') }}"},
                },
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.questionnaire.add.form')}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#addQuestionnaireBtn').attr('disabled', true).html(`
                                    <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
{{ trans_message('processing') }}
                            `);
                        },
                        success: function (result) {
                            $('#add-questionnaire-model')[0].close();
                            sendSuccess(result.message);
                            var quid = result.data;
                            var redirectUrl = "{{ route('admin.questionnaire.form', ['quid' => ':quid']) }}";
                            redirectUrl = redirectUrl.replace(':quid', quid);
                            setTimeout(function () {
                                window.location.href = redirectUrl;
                            }, 1000);
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#addQuestionnaireForm #" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message);
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            $('#addQuestionnaireBtn').attr('disabled', false).html('save');
                        },
                    });
                }
            });
        });

        function removeQuestionnaire(id, element) {
            Swal.fire({
                title: "{{ trans_message('are_you_sure') }}",
                text: "{{ trans_message('remove_questionnaire_confirm') }}",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "{{ trans_message('yes_remove') }}",
                cancelButtonText: "{{ trans_message('no_cancel') }}",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
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
                            $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendToast(data.message);
                            questionnaireList();
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
                        }
                    });
                }
            });
        }

    </script>
@endsection
