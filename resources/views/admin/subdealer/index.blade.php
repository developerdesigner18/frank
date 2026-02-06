@extends('admin.master')
@section('title', trans_message('subdealers'))

@push('navbar')
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">{{ trans_message('subdealers') }}</span>
        <div class="relative w-auto">
            <button command="show-modal" commandfor="add-subdealer-modal"
                    class="btn-primary w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2.5 text-gray-700 cursor-pointer transition-all duration-300">
                <span>{{ trans_message('add_subdealer') }}</span>
            </button>
        </div>
    </div>
@endpush

@push('modal')
    <!-- Add Subdealer Modal -->
    <el-dialog>
        <dialog id="add-subdealer-modal" aria-labelledby="dialog-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0"
                 class="flex min-h-full items-start justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                <el-dialog-panel
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-white relative px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex flex-col sm:items-start">
                            <div class="flex pb-4 justify-between w-full items-center">
                                <h3 class="text-base font-semibold text-gray-800">{{ trans_message('add_subdealer') }}</h3>
                                <button type="button" command="close" commandfor="add-subdealer-modal"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <form class="w-full" id="addSubdealerForm">
                                @csrf
                                <!-- Logo Upload -->
                                <div class="flex flex-col items-center mb-4">
                                    <div class="relative">
                                        <div id="preview-container"
                                             class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-2 overflow-hidden">
                                            <svg id="default-icon" class="w-12 h-12 text-gray-400"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                                                <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z"/>
                                            </svg>
                                            <img id="preview-image" src="" alt="Preview"
                                                 class="hidden w-full h-full object-cover"/>
                                        </div>
                                        <input type="file" id="file-input" accept=".jpeg,.jpg,.png,.gif"
                                               class="hidden" name="logo"/>
                                        <label for="file-input"
                                               class="absolute -bottom-0 -right-0 w-8 h-8 bg-[#0073AF] rounded-full flex items-center justify-center hover:bg-[#0068A0] transition-colors text-white cursor-pointer">
                                            <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M9 3H15L17 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V6C2 5.44772 2.44772 5 3 5H7L9 3ZM12 19C15.3137 19 18 16.3137 18 13C18 9.68629 15.3137 7 12 7C8.68629 7 6 9.68629 6 13C6 16.3137 8.68629 19 12 19ZM12 17C9.79086 17 8 15.2091 8 13C8 10.7909 9.79086 9 12 9C14.2091 9 16 10.7909 16 13C16 15.2091 14.2091 17 12 17Z"></path>
                                            </svg>
                                        </label>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="flex flex-col gap-1 mb-4">
                                    <label class="block text-sm font-medium text-gray-700">{{ trans_message('name') }}</label>
                                    <input type="text"
                                           name="name"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="{{ trans_message('subdealer_name') }}">
                                    <label id="name-error" class="text-[red] error" for="name"
                                           style="display: none"></label>
                                </div>

                                <!-- Email -->
                                <div class="flex flex-col gap-1 mb-4">
                                    <label class="block text-sm font-medium text-gray-700">{{ trans_message('email') }}</label>
                                    <input type="email"
                                           name="email"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="email@example.com">
                                    <label id="email-error" class="text-[red] error" for="email"
                                           style="display: none"></label>
                                </div>

                                <!-- Phone -->
                                <div class="flex flex-col gap-1 mb-4">
                                    <label class="block text-sm font-medium text-gray-700">{{ trans_message('phone') }}</label>
                                    <input type="tel"
                                           name="phone"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="+31 123 456 789">
                                    <label id="phone-error" class="text-[red] error" for="phone"
                                           style="display: none"></label>
                                </div>

                                <!-- Action Buttons -->
                                <div class="grid grid-cols-[1fr_1fr] gap-3 pt-4 w-full">
                                    <button type="button" command="close" commandfor="add-subdealer-modal"
                                            class="btn-secondary modal-cancel px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300">
                                        {{ trans_message('cancel') }}
                                    </button>
                                    <button type="submit"
                                            class="btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex justify-center"
                                            id="addSubdealerBtn">
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

    <!-- Edit Subdealer Modal -->
    <el-dialog>
        <dialog id="edit-subdealer-modal" aria-labelledby="dialog-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0"
                 class="flex min-h-full items-start justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                <el-dialog-panel
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-white relative px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex flex-col sm:items-start">
                            <div class="flex pb-4 justify-between w-full items-center">
                                <h3 class="text-base font-semibold text-gray-800">{{ trans_message('edit_subdealer') }}</h3>
                                <button type="button" command="close" commandfor="edit-subdealer-modal"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path
                                                d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <form class="w-full" id="editSubdealerForm">
                                @csrf
                                <input type="hidden" name="id" id="editId">

                                <!-- Logo Upload -->
                                <div class="flex flex-col items-center mb-4">
                                    <div class="relative">
                                        <div id="edit-preview-container"
                                             class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-2 overflow-hidden">
                                            <svg id="edit-default-icon" class="w-12 h-12 text-gray-400"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                                                <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z"/>
                                            </svg>
                                            <img id="edit-preview-image" src="" alt="Preview"
                                                 class="hidden w-full h-full object-cover"/>
                                        </div>
                                        <input type="file" id="edit-file-input" accept=".jpeg,.jpg,.png,.gif"
                                               class="hidden" name="logo"/>
                                        <label for="edit-file-input"
                                               class="absolute -bottom-0 -right-0 w-8 h-8 bg-[#0073AF] rounded-full flex items-center justify-center hover:bg-[#0068A0] transition-colors text-white cursor-pointer">
                                            <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M9 3H15L17 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V6C2 5.44772 2.44772 5 3 5H7L9 3ZM12 19C15.3137 19 18 16.3137 18 13C18 9.68629 15.3137 7 12 7C8.68629 7 6 9.68629 6 13C6 16.3137 8.68629 19 12 19ZM12 17C9.79086 17 8 15.2091 8 13C8 10.7909 9.79086 9 12 9C14.2091 9 16 10.7909 16 13C16 15.2091 14.2091 17 12 17Z"></path>
                                            </svg>
                                        </label>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">{{ trans_message('name') }}</label>
                                    <input type="text" value="" id="editName"
                                           name="name"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="{{ trans_message('subdealer_name') }}">
                                    <label id="editName-error" class="text-[red] error" for="editName"
                                           style="display: none"></label>
                                </div>

                                <!-- Email -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">{{ trans_message('email') }}</label>
                                    <input type="email" value="" id="editEmail"
                                           name="email"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="email@example.com">
                                    <label id="editEmail-error" class="text-[red] error" for="editEmail"
                                           style="display: none"></label>
                                </div>

                                <!-- Phone -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">{{ trans_message('phone') }}</label>
                                    <input type="tel" value="" id="editPhone"
                                           name="phone"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="+31 123 456 789">
                                    <label id="editPhone-error" class="text-[red] error" for="editPhone"
                                           style="display: none"></label>
                                </div>

                                <!-- Action Buttons -->
                                <div class="grid grid-cols-[1fr_1fr] gap-3 pt-4 w-full">
                                    <button type="button" command="close" commandfor="edit-subdealer-modal"
                                            class="btn-secondary modal-cancel px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300">
                                        {{ trans_message('cancel') }}
                                    </button>
                                    <button type="submit"
                                            class="btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-gray-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex justify-center"
                                            id="editSubdealerBtn">
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
@endpush

@section('main')
    <section class="pt-4 sm:pt-6">
        <div class="flex flex-col md:flex-row items-center justify-end pb-6 gap-4">
            <div class="relative w-full md:w-auto flex-grow">
                <input type="text"
                       class="sm:pl-10 pl-8 py-2 sm:py-2.5 border border-[#e5e7eb] rounded-full w-full text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 filter-search"
                       placeholder="{{ trans_message('search_subdealers') }}">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px]"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z">
                    </path>
                </svg>
            </div>
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative w-full md:w-auto">
                    <select id="filter-sort_by"
                            class="filter-fields w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2 sm:py-2.5 pr-8 text-sm sm:text-base text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
{{--                        <option value="">{{ trans_message('sort_by') }}</option>--}}
                        <option value="id_desc">{{ trans_message('most_recent') }}</option>
                        <option value="id_asc">{{ trans_message('oldest') }}</option>
                        <option value="name_asc">{{ trans_message('name_asc') }}</option>
                        <option value="name_desc">{{ trans_message('name_desc') }}</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px] pointer-events-none"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                        </path>
                    </svg>
                </div>
                <div class="relative w-full hidden lg:flex md:w-auto">
                    <button command="show-modal" commandfor="add-subdealer-modal"
                            class="btn-primary w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2.5 text-gray-700 cursor-pointer transition-all duration-300"
                            onclick="resetForm();">
                        <span>{{ trans_message('add_subdealer') }}</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Card Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 subdealerList">
            <!-- Subdealer Cards will be loaded here -->
        </div>
    </section>
@endsection

@section('script')
    <script>
        // Image preview for Add form
        const fileInput = document.getElementById("file-input");
        const previewImage = document.getElementById("preview-image");
        const defaultIcon = document.getElementById("default-icon");

        fileInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove("hidden");
                    defaultIcon.classList.add("hidden");
                };
                reader.readAsDataURL(file);
            }
        });

        // Image preview for Edit form
        const editFileInput = document.getElementById("edit-file-input");
        const editPreviewImage = document.getElementById("edit-preview-image");
        const editDefaultIcon = document.getElementById("edit-default-icon");

        editFileInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    editPreviewImage.src = e.target.result;
                    editPreviewImage.classList.remove("hidden");
                    editDefaultIcon.classList.add("hidden");
                };
                reader.readAsDataURL(file);
            }
        });

        // Load subdealer list
        function subdealerList() {
            var sort_by = $('#filter-sort_by').val();
            var search = $('.filter-search').val();
            $.ajax({
                url: "{{ route('admin.subdealer.list') }}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "sort_by": sort_by,
                    "search": search,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('.subdealerList').html(data.message)
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

        subdealerList();

        // Reload on filter change
        $('.filter-fields, .filter-search').on('change keyup', function() {
            subdealerList();
        });

        // Add Subdealer Form
        $("#addSubdealerForm").validate({
            rules: {
                name: {required: true},
                email: {required: true, email: true},
                phone: {required: true},
            },
            messages: {
                name: {required: "{{ trans_message('name_required') }}"},
                email: {required: "{{ trans_message('email_required') }}", email: "{{ trans_message('email_valid') }}"},
                phone: {required: "{{ trans_message('phone_required') }}"},
            },
            errorPlacement: function (error, element) {
                element.after(error);
            },
            submitHandler: function (form, e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('admin.subdealer.add') }}",
                    method: "post",
                    dataType: "json",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        $('#addSubdealerBtn').attr('disabled', true).html(`
                            <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ trans_message('processing') }}
                        `);
                    },
                    success: function (result) {
                        $(".modal-cancel").click();
                        sendSuccess(result.message);
                        resetForm();
                        subdealerList();
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
                        $('#addSubdealerBtn').attr('disabled', false).html('{{ trans_message('save') }}');
                    },
                });
            }
        });

        // Edit Subdealer Form
        $("#editSubdealerForm").validate({
            rules: {
                name: {required: true},
                email: {required: true, email: true},
                phone: {required: true},
            },
            messages: {
                name: {required: "{{ trans_message('name_required') }}"},
                email: {required: "{{ trans_message('email_required') }}", email: "{{ trans_message('email_valid') }}"},
                phone: {required: "{{ trans_message('phone_required') }}"},
            },
            errorPlacement: function (error, element) {
                element.after(error);
            },
            submitHandler: function (form, e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('admin.subdealer.update') }}",
                    method: "post",
                    dataType: "json",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        $('#editSubdealerBtn').attr('disabled', true).html(`
                            <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ trans_message('processing') }}
                        `);
                    },
                    success: function (result) {
                        $(".modal-cancel").click();
                        sendSuccess(result.message);
                        resetForm();
                        subdealerList();
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data.hasOwnProperty('error')) {
                            $.each(data.error, function (key, value) {
                                $("#edit" + key.charAt(0).toUpperCase() + key.slice(1) + "-error").html(value).show();
                            });
                        } else if (data.hasOwnProperty('message')) {
                            actionError(xhr, data.message);
                        } else {
                            actionError(xhr);
                        }
                    },
                    complete: function () {
                        $('#editSubdealerBtn').attr('disabled', false).html('{{ trans_message('save') }}');
                    },
                });
            }
        });

        function resetForm() {
            $("#addSubdealerForm").trigger('reset');
            $("#editSubdealerForm").trigger('reset');
            $("label.error").hide();
            $('#preview-image').addClass('hidden');
            $('#default-icon').removeClass('hidden');
            $('#edit-preview-image').addClass('hidden');
            $('#edit-default-icon').removeClass('hidden');
        }

        function editSubdealer(id, element) {
            $.ajax({
                url: "{{ route('admin.subdealer.edit') }}",
                method: "post",
                dataType: "json",
                data: {
                    id: id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (result) {
                    $('#editId').val(result.data.id);
                    $('#editName').val(result.data.name);
                    $('#editEmail').val(result.data.email);
                    $('#editPhone').val(result.data.phone);

                    if (result.data.logo) {
                        $('#edit-preview-image').attr('src', result.data.logo).removeClass('hidden');
                        $('#edit-default-icon').addClass('hidden');
                    }

                    document.getElementById('edit-subdealer-modal').showModal();
                },
                error: function (xhr) {
                    actionError(xhr);
                }
            });
        }

        function deleteSubdealer(id, element) {
            Swal.fire({
                title: "{{ trans_message('are_you_sure') }}",
                text: "{{ trans_message('remove_subdealer_confirm') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "{{ trans_message('yes_delete') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.subdealer.delete') }}",
                        method: "post",
                        dataType: "json",
                        data: {
                            id: id,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (result) {
                            sendSuccess(result.message);
                            subdealerList();
                        },
                        error: function (xhr) {
                            actionError(xhr);
                        }
                    });
                }
            });
        }
    </script>
@endsection
