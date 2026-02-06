@extends('admin.master')
@section('title', trans_message('questionnaires'))

@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('admin.questionnaire.index') }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            @section('title', trans_message('questionnaires'))
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-500 navbar-name">{{ $questionnaire->name }}</span>
    </div>
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">{{ trans_message('questionnaires') }}</span>
    </div>
@endpush
@push('modal')
    <!-- Rename Questionnaire Model -->
    <el-dialog>
        <dialog id="rename-questionnaire-model" aria-labelledby="dialog-title"
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
                                <h3 id="add-category-dialog-title" class="text-base font-semibold text-gray-800">
                                    {{ trans_message('rename_questionnaire') }}                                </h3>
                                <button type="button" command="close" commandfor="rename-questionnaire-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <form class="flex flex-col gap-4 w-full" id="renameQuestionnaireForm">
                                @csrf
                                <input type="hidden" name="id" value="{{ $questionnaire->id }}">
                                <div class="w-full flex flex-col gap-1">
                                    <div class="relative">
                                        <input type="text" id="name" name="name" value="{{ $questionnaire->name }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <label id="name-error" class="text-[red] error" for="name"></label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 w-full">
                                    <button type="button" command="close" commandfor="rename-questionnaire-model"
                                            class="btn-secondary px-4 py-2 flex justify-center items-center gap-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300"
                                            aria-expanded="true">
                                        {{ trans_message('cancel') }}

                                    </button>
                                    <button type="submit"
                                            class="btn-primary px-4 py-2 flex justify-center items-center gap-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300"
                                            aria-expanded="true" id="renameQuestionnaireBtn">
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

    <!-- add/edit Category Model -->
    <el-dialog>
        <dialog id="add-category-model" aria-labelledby="dialog-title"
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
                                <h3 id="add-category-dialog-title" class="text-base font-semibold text-gray-800">
                                    <span id="category-modal-title">    {{ trans_message('add_category') }}
</span>
                                </h3>
                                <button type="button" command="close" commandfor="add-category-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <form id="categoryForm" class="flex flex-col gap-4 w-full">
                                @csrf
                                <input type="hidden" id="questionnaire_id" name="questionnaire_id"
                                       value="{{ $questionnaire->id }}">
                                <input type="hidden" id="category_id" name="category_id" value="">
                                <input type="hidden" id="remove_image" name="remove_image" value="0">
                                <div class="w-full flex flex-col gap-1">
                                    <label for="category_name" class="block text-sm font-medium text-gray-700">Category
                                        Name</label>
                                    <div class="relative">
                                        <input type="text" id="category_name" name="name"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="{{ trans_message('enter_category_name') }}">
                                        <label id="name-error" class="text-[red] error" for="category_name"></label>
                                    </div>
                                </div>
                                <div class="w-full flex flex-col gap-1">
                                    <label for="category_image"
                                           class="block text-sm font-medium text-gray-700"> {{ trans_message('category_image') }}</label>
                                    <div class="flex items-center gap-4">
                                        <!-- Image Preview Area -->
                                        <div id="image-preview"
                                             class="size-[100px] bg-gray-100 border flex items-center relative justify-center border-dashed border-gray-300 rounded-lg overflow-hidden">
                                            <svg class="size-[24px] text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M4 5V19H20V7H11.5858L9.58579 5H4ZM12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM10 10.5C10 11.3284 9.32843 12 8.5 12C7.67157 12 7 11.3284 7 10.5C7 9.67157 7.67157 9 8.5 9C9.32843 9 10 9.67157 10 10.5ZM18 17L14 11L7 17H18Z"></path>
                                            </svg>
                                        </div>

                                        <!-- File Input Area -->
                                        <div class="flex flex-col gap-2">
                                            <input type="file" id="category_image" name="image" accept="image/*"
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#0073AF] file:text-white hover:file:bg-[#0068A0] transition-colors">
                                            <div class="flex flex-col gap-2">
                                                <span class="text-xs text-gray-500"> {{ trans_message('upload_image_optional') }}</span>
                                                <span class="text-xs text-gray-400">    {{ trans_message('max_size_2mb') }}</span>
                                                <button type="button" id="remove-image-btn"
                                                        class="hidden w-fit px-3 py-1.5 text-xs font-medium text-red-600 bg-white border border-red-600 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                                        onclick="removeCategoryImage()">
                                                    {{ trans_message('remove_image') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 w-full">
                                    <button type="button" command="close" commandfor="add-category-model"
                                            class="btn-secondary px-4 py-2 flex justify-center items-center gap-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300"
                                            aria-expanded="true">
                                        {{ trans_message('cancel') }}
                                    </button>
                                    <button type="submit" id="categorySubmitBtn"
                                            class="btn-primary px-4 py-2 flex justify-center items-center gap-2 text-sm font-medium text-white bg-[#0073AF] border border-[#0073AF] rounded-lg hover:bg-[#0068A0] cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#0073AF] transition-all duration-300"
                                            aria-expanded="true">
                                        <span id="categorySubmitText"> {{ trans_message('add_category') }}</span>
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

    <section class="">
        <div class="flex flex-col md:flex-row items-center justify-end pb-6 gap-4">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative w-full flex md:w-auto">
                    <a href="{{ route('admin.questionnaire.view',['quid' => $questionnaire->quid]) }}"
                       class="btn-secondary w-full appearance-none border border-[#e5e7eb] bg-gray-100 px-4 py-2.5 text-gray-700 cursor-pointer transition-all duration-300"
                       aria-expanded="false">
                        <svg class="size-[16px] sm:size-[20px]" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                            </path>
                        </svg>
                    </a>
                </div>
                <div class="relative w-full flex md:w-auto">
                    <button type="button" onclick="changePublish({{ $questionnaire->id }},0,this)"
                            class="btn-secondary w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2.5 text-gray-700 cursor-pointer transition-all duration-300"
                            aria-expanded="false">
                        <span>{{ trans_message('save_draft') }}</span>
                    </button>
                </div>
                <div class="relative w-full flex md:w-auto">
                    <button type="button" onclick="changePublish({{ $questionnaire->id }},1,this)"
                            class="btn-primary flex justify-center items-center gap-2 w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2.5 text-gray-700 cursor-pointer transition-all duration-300"
                            aria-expanded="false">
                        <span>{{ trans_message('publish') }}</span>
                    </button>
                </div>
            </div>
        </div>


        <form method="post" id="questionForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="payload[title]" value="{{ $questionnaire->name }}">
            <input type="hidden" name="current_category_id" class="current_category_id"
                   value="{{ (isset($payload['categories']) && count($payload['categories']) > 0)? $payload['categories'][0]['id']:'' }}">
            <div class="flex flex-col gap-4 questionsCardDiv" id="questions-container">
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-semibold text-gray-700 navbar-name">{{ $questionnaire->name }}</h1>
                    <button type="button" class="bg-gray-100 rounded-full p-2" command="show-modal"
                            commandfor="rename-questionnaire-model">
                        <svg class="size-[18px] text-gray-700" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z">
                            </path>
                        </svg>
                    </button>
                </div>
                <div class="mb-8 flex items-center justify-between">
                    <div class="flex items-center flex-wrap gap-4" id="categories-container">
                        <button type="button" command="show-modal" commandfor="add-category-model"
                                class="group/btn relative flex items-center cursor-pointer justify-center gap-2 px-4 py-2.5 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl">
                            {{ trans_message('new_category') }}                            </button>
                        @if($payload['categories'] && count($payload['categories']) > 0)
                            @foreach($payload['categories'] as $cat_k => $category)
                                <div class="category-wrapper" data-category-id="{{ $category['id'] }}" data-key="{{$cat_k}}">
                                    <input type="hidden" name="payload[categories][{{ $cat_k }}][id]"
                                           value="{{ $category['id'] }}">
                                    <input type="hidden" name="payload[categories][{{ $cat_k }}][name]"
                                           value="{{ $category['name'] }}">
                                    <input type="hidden" name="payload[categories][{{ $cat_k }}][image]"
                                           value="{{ $category['imageUrl']??'' }}">
                                    <div class="flex items-center gap-2 bg-[#0073AF]/10 px-3 py-2 rounded-full category-item cursor-move {{ $cat_k==0?'border border-[#0073AF]':'' }}"
                                         data-category-id="{{ $category['id'] }}" data-key="{{$cat_k}}"
                                         onclick="filterQuestionsByCategory('{{ $category['id'] }}',{{$cat_k}},this)">
                                        {!! (isset($category['imageUrl']) && $category['imageUrl']) ? '<img src="'.$category['imageUrl'].'" alt="'.$category['name'].'" class="size-[20px] object-contain" />' : '' !!}
                                        <span class="text-[#0073AF] text-sm font-medium">{{ $category['name'] }}</span>
                                        <div class="flex items-center gap-1">
                                            <button type="button"
                                                    onclick="editCategory('{{ $category['id'] }}', '{{ $category['name'] }}', '{{ $category['imageUrl'] ?? '' }}')"
                                                    class="text-[#0073AF] hover:text-[#0073AF]/80 p-1"
                                                    title="Edit Category">
                                                <svg class="size-[14px]" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z"></path>
                                                </svg>
                                            </button>
                                            <button type="button"
                                                    onclick="deleteCategory('{{ $category['id'] }}', '{{ $category['name'] }}')"
                                                    class="text-red-500 hover:text-red-700 p-1" title="Delete Category">
                                                <svg class="size-[14px]" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-gray-500 text-sm italic">
                                {{ trans_message('no_categories_yet') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="categoryQuestionsList flex flex-col gap-4" id="">
                    <!-- Questions List -->
                </div>
            </div>
            <div class="flex justify-center mt-8">
                <button type="button" id="add-faq-btn"
                        data-id="{{ (isset($payload['categories']) && count($payload['categories']) > 0)? $payload['categories'][0]['id']:'' }}"
                        data-key="0"
                        class="cursor-pointer bg-[#0073AF] text-white rounded-full p-3 sm:p-4 hover:bg-[#0068A0] transition-colors shadow-lg">
                    <svg class="size-[16px] sm:size-[20px]" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </section>
@endsection
@section('script')
    <script>
        let autoSaveTimer;

        // Make the outer list sortable
        // new Sortable(document.getElementById('sortableCategoryQuestionsList'), {
        //     group: 'nested', // if you later add nested sortables
        //     animation: 150,  // smooth drag animation
        //     handle: null,    // you can set a specific handle if needed
        // });


        $(document).ready(function () {
            // Add CSS styles for SortableJS
            const style = document.createElement('style');
            style.textContent = `
                .sortable-ghost {
                    opacity: 0.4 !important;
                    background-color: #dbeafe !important;
                }
                .sortable-drag {
                    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
                }
                .sortable-chosen {
                    background-color: #eff6ff !important;
                }
            `;
            document.head.appendChild(style);

            const picker = new EmojiButton({
                position: 'top-start',
                theme: 'light'
            });

            let activeInput = null; // will store the input related to clicked button

            $(document).on('click', '.emoji-button', function () {
                // find the nearest input for this button
                activeInput = $(this).closest('.emoji-wrap').find('.emoji-input');
                picker.togglePicker(this); // show picker near the clicked button
            });

            picker.on('emoji', emoji => {
                if (activeInput) {
                    activeInput.val(activeInput.val() + emoji);
                }
                autoSaveQuestionnaire();
            });
        });

        let CATEGORY_ID = '{{ (isset($payload['categories']) && count($payload['categories']) > 0)? $payload['categories'][0]['id']:'' }}';

        $(document).ready(function () {

            // Rename Questionnaire Form
            $("#renameQuestionnaireForm").validate({
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
                        url: "{{route('admin.questionnaire.rename')}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#renameQuestionnaireBtn').attr('disabled', true).html(`
                                <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            `);
                        },
                        success: function (result) {
                            $('#rename-questionnaire-model')[0].close();
                            sendToast(result.message);
                            $('.navbar-name').html(result.data);
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#renameQuestionnaireForm #" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message);
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            $('#renameQuestionnaireBtn').attr('disabled', false).html('save');
                        },
                    });
                }
            });

            // Category Form Validation and Submission
            $("#categoryForm").validate({
                rules: {
                    name: {required: true, maxlength: 255},
                },
                messages: {
                    required: "{{ trans_message('category_name_required') }}",
                    maxlength: "{{ trans_message('category_name_max') }}"
                },
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const isEdit = $('#category_id').val() !== '';
                    const url = isEdit ? "{{route('admin.questionnaire.category.update')}}" : "{{route('admin.questionnaire.category.add')}}";

                    $.ajax({
                        url: url,
                        method: "post",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#categorySubmitBtn').attr('disabled', true).html(`
                                <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            `);
                        },
                        success: function (result) {
                            $('#add-category-model')[0].close();
                            sendToast(result.message);
                            loadCategories();
                            resetCategoryForm();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#categoryForm #" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message);
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            const submitText = $('#category_id').val() !== '' ? 'Update Category' : 'Add Category';
                            $('#categorySubmitBtn').attr('disabled', false).html(`<span id="categorySubmitText">${submitText}</span>`);
                        },
                    });
                }
            });

            // Image preview functionality
            $('#category_image').on('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#image-preview').html(`<img src="${e.target.result}" alt="Preview" class="size-[100px] object-cover rounded-lg">`);
                        $('#remove-image-btn').removeClass('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
            $(document).delegate('.question_image', 'change', function (e) {
                const file = e.target.files[0];
                const input = this; // store reference to current input element

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (ev) {
                        $(input).closest('.image-container')
                            .find('.image-preview')
                            .html(`<img src="${ev.target.result}" alt="Preview" class="size-[100px] object-cover rounded-lg">`);
                    };
                    reader.readAsDataURL(file);
                }
            });

        });

        // Global functions for category operations
        function updateImagePreview(imageSrc) {
            $('#image-preview').html(`<img src="${imageSrc}" alt="Preview" class="size-[100px] object-cover rounded-lg">`);
            $('#remove-image-btn').removeClass('hidden');
        }

        function resetImagePreview() {
            $('#image-preview').html(`
                <svg class="size-[24px] text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4 5V19H20V7H11.5858L9.58579 5H4ZM12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM10 10.5C10 11.3284 9.32843 12 8.5 12C7.67157 12 7 11.3284 7 10.5C7 9.67157 7.67157 9 8.5 9C9.32843 9 10 9.67157 10 10.5ZM18 17L14 11L7 17H18Z"></path>
                </svg>
            `);
        }

        function removeCategoryImage() {
            $('#category_image').val('');
            $('#remove_image').val('1'); // Set flag to remove image
            resetImagePreview();
            $('#remove-image-btn').addClass('hidden');
        }

        function resetCategoryForm() {
            $('#categoryForm')[0].reset();
            $('#category_id').val('');
            $('#remove_image').val('0'); // Reset remove image flag
            $('#category-modal-title').text('Add Category');
            $('#categorySubmitText').text('Add Category');
            resetImagePreview();
            $('#remove-image-btn').addClass('hidden');
            $('#name-error').hide();
        }

        function editCategory(categoryId, categoryName, imageUrl) {
            $('#category_id').val(categoryId);
            $('#category_name').val(categoryName);
            $('#remove_image').val('0'); // Reset remove image flag
            $('#category-modal-title').text('Edit Category');
            $('#categorySubmitText').text('Update Category');

            if (imageUrl) {
                updateImagePreview(imageUrl);
            } else {
                resetImagePreview();
                $('#remove-image-btn').addClass('hidden');
            }

            $('#add-category-model')[0].showModal();
        }

        function deleteCategory(categoryId, categoryName) {
            Swal.fire({
                title: "{{ trans_message('are_you_sure') }}",
                text: `{!! trans_message('delete_category_confirmation', ['category' => '${categoryName}']) !!}`,
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
                        url: "{{route('admin.questionnaire.category.delete')}}",
                        method: "post",
                        dataType: "json",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            questionnaire_id: $('#questionnaire_id').val(),
                            category_id: categoryId
                        },
                        beforeSend: function () {
                            // Show loading state
                        },
                        success: function (result) {
                            sendToast(result.message);
                            loadCategories();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message);
                            } else {
                                actionError(xhr);
                            }
                        }
                    });
                }
            });
        }

        function loadCategories() {
            // Store the currently active category ID before reloading
            const activeCategory = $('.category-item.border').attr('data-category-id');

            $.ajax({
                url: "{{route('admin.questionnaire.category.list')}}",
                method: "post",
                dataType: "json",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    questionnaire_id: $('#questionnaire_id').val()
                },
                success: function (result) {
                    let categoriesHtml = '<button type="button" command="show-modal" commandfor="add-category-model" class="group/btn relative flex items-center cursor-pointer justify-center gap-2 px-4 py-2.5 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl">New Category</button>';
                    if (result.data && result.data.length > 0) {
                        var key = 0;
                        result.data.forEach(function (category) {
                            const imageHtml = category.imageUrl ? `<img src="${category.imageUrl}" alt="${category.name}" class="size-[20px] object-contain" />` : '';
                            // Check if this category should be active
                            const isActive = activeCategory ? (category.id === activeCategory) : (key === 0);
                            const activeClass = isActive ? 'border border-[#0073AF]' : '';

                            categoriesHtml += `
                                <div class="category-wrapper" data-category-id="${category.id}" data-key="${key}">
                                    <input type="hidden" name="payload[categories][${key}][id]" value="${category.id}">
                                    <input type="hidden" name="payload[categories][${key}][name]" value="${category.name}">
                                    <input type="hidden" name="payload[categories][${key}][image]" value="${category.imageUrl || ''}">
                                    <div class="flex items-center gap-2 bg-[#0073AF]/10 px-3 py-2 rounded-full category-item cursor-pointer ${activeClass}"
                                        data-category-id="${category.id}" data-key="${key}"
                                        onclick="filterQuestionsByCategory('${category.id}',${key},this)">
                                        ${imageHtml}
                                        <span class="text-[#0073AF] text-sm font-medium">${category.name}</span>
                                        <div class="flex items-center gap-1">
                                            <button type="button" onclick="editCategory('${category.id}', '${category.name}', '${category.imageUrl || ''}')"
                                                    class="text-[#0073AF] hover:text-[#0073AF]/80 p-1" title="Edit Category">
                                                <svg class="size-[14px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z"></path>
                                                </svg>
                                            </button>
                                            <button type="button" onclick="deleteCategory('${category.id}', '${category.name}')"
                                                    class="text-red-500 hover:text-red-700 p-1" title="Delete Category">
                                                <svg class="size-[14px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            key++;
                        });
                    } else {
                        categoriesHtml = '<div class="text-gray-500 text-sm italic">No categories added yet. Click "New Category" to add one.</div>';
                    }
                    $('#categories-container').html(categoriesHtml);
                    
                    // Re-initialize category sortable after loading
                    initializeCategorySortable();
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
                }
            });
        }

        // Function to remove a question card
        function removeQuestionCard(cardId) {
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to delete this question card?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, remove",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
                buttonsStyling: !1,
            }).then(function (result) {
                if (result.value) {
                    $('#' + cardId).fadeOut(300, function () {
                        $(this).remove();
                        setTimeout(() => {
                            autoSaveQuestionnaire();
                        }, 300);
                    });
                }
            });
        }


        // Add click event handler for the add-faq-btn
        $(document).ready(function () {
            $('#add-faq-btn').on('click', function () {
                var id = $(this).attr('data-id');
                var key = $(this).attr('data-key');
                if (id) {
                    $.ajax({
                        url: "{{ route('admin.questionnaire.add.new.question', $questionnaire->id) }}",
                        method: "post",
                        dataType: "json",
                        data: {
                            category_id: id,
                            category_key: key,
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            // Show loading state
                        },
                        success: function (result) {
                            sendToast(result.message);
                            categoryQuestionsList(id, key);
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message);
                            } else {
                                actionError(xhr);
                            }
                        }
                    });
                }
            });

            // Add event listeners for dropdown option selection
            $(document).on('click', '.questionTypeDropdown .py-1 button[data-value]', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const selectedValue = $(this).data('value');
                const selectedText = $(this).data('text');
                const dropdownWrapper = $(this).closest('.dropdown-wrapper');
                const questionCard = $(this).closest('.questionCard');

                $('.questionTypeDropdown button').removeClass('bg-gray-100');
                $(this).addClass('hover:bg-gray-100');
                $(this).addClass('bg-gray-100');

                // Update the questionTypeText span
                dropdownWrapper.find('.questionTypeText').text(selectedText);

                // Update the hidden input field
                dropdownWrapper.find('.questionType').val(selectedValue);

                // Toggle options visibility based on question type
                toggleOptionsVisibility(questionCard, selectedValue);

                // Close the dropdown
                dropdownWrapper.find('.dropdown').addClass('hidden');
                autoSaveQuestionnaire();
            });

            // Function to toggle options container visibility based on question type
            function toggleOptionsVisibility(questionCard, questionType) {
                const optionsContainer = $(questionCard).find('.options-container');
                const imageContainer = $(questionCard).find('.image-container');
                const addMoreButton = $(questionCard).find('.add-more-options');

                // Get category and question keys from the addMoreButton onclick attribute
                let cate_key = 0;
                let questionKey = 0;
                const onclickAttr = addMoreButton.attr('onclick');
                if (onclickAttr) {
                    const matches = onclickAttr.match(/addMoreOptions\(\s*(\d+)\s*,\s*(\d+)/);
                    if (matches) {
                        cate_key = matches[1];
                        questionKey = matches[2];
                    }
                }

                addMoreButton.removeAttr('disabled').removeClass('bg-blue-300 border-blue-300').addClass('btn-primary bg-blue-600 border-blue-600 cursor-pointer');

                if (questionType === 'SELECT') {
                    optionsContainer.find('.opt-score').val('').addClass('hidden');
                } else if (questionType === 'AMOUNT' || questionType === 'TEXT' || questionType === 'COMMENT') {
                    optionsContainer.html('');
                    addMoreButton.attr('disabled', 'disabled').removeClass('btn-primary bg-blue-600 border-blue-600 cursor-pointer').addClass('bg-blue-300 border-blue-300');
                } else if (questionType === 'RADIO') {
                    // For RADIO, ensure we have exactly 2 options with default scores (No=0, Yes=2)
                    optionsContainer.find('.opt-score').removeClass('hidden');
                    const currentOptions = optionsContainer.find('.main-content');

                    if (currentOptions.length !== 2) {
                        optionsContainer.html('');
                        // Default values: No = 0, Yes = 2
                        const defaultScores = ['0', '2'];
                        for (let i = 0; i < 2; i++) {
                            const glossyImages = ['00.png', '01.png']; // Red (No), Green (Yes)
                            const glossyImage = glossyImages[i];
                            const newOptionHtml = `
                                <div class="flex items-center main-content gap-4 my-4" data-id="${i}">
                                    <span class="cursor-move drag-handle text-gray-400">☰</span>
                                    <div class="relative">
                                        <img src="{{ asset('assets/emojis/glossy') }}/${glossyImage}" alt="" class="w-10 h-10 rounded-full">
                                        <input type="text" name="payload[categories][${cate_key}][questions][${questionKey}][options][${i}][text]" value="${i}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent opt-text hidden"
                                               placeholder="label">
                                    </div>
                                    <div>
                                        <input type="number" name="payload[categories][${cate_key}][questions][${questionKey}][options][${i}][score]" value="${defaultScores[i]}"
                                               class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent opt-score"
                                               >
                                    </div>
                                    <button type="button" class="remove-option cursor-pointer text-red-500 hover:text-red-700 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>`;
                            optionsContainer.append(newOptionHtml);
                        }
                        addMoreButton.removeClass('hidden');
                        addMoreButton.attr('data-last_opt_key', 1);

                        // Re-initialize Sortable for the new options
                        const containerId = optionsContainer.attr('id');
                        if (containerId && document.getElementById(containerId)) {
                            new Sortable(document.getElementById(containerId), {
                                group: 'shared',
                                animation: 150,
                                ghostClass: 'bg-blue-100',
                                onEnd: function (evt) {
                                    const container = evt.to;
                                    $(container).children('.main-content').each(function (newIndex) {
                                        $(this).attr('data-id', newIndex);
                                        $(this).find('input').each(function () {
                                            let name = $(this).attr('name');
                                            if (name) {
                                                name = name.replace(/\[options\]\[\d+\]/, `[options][${newIndex}]`);
                                                $(this).attr('name', name);
                                            }
                                        });
                                    });
                                }
                            });
                        }

                        // Trigger autosave after regenerating options
                        autoSaveQuestionnaire();
                    }
                } else if (questionType === 'SLIDER') {
                    // For SLIDER, ensure we have exactly 5 options (0-4) with default scores
                    optionsContainer.find('.opt-score').removeClass('hidden');
                    const currentOptions = optionsContainer.find('.main-content');

                    if (currentOptions.length !== 5) {
                        optionsContainer.html('');
                        for (let i = 0; i < 5; i++) {
                            const glossyImages = ['00.png', '04.png', '03.png', '02.png', '01.png']; // Red, Orange, Yellow, Light Green, Dark Green
                            const glossyImage = glossyImages[i];
                            const newOptionHtml = `
                                <div class="flex items-center main-content gap-4 my-4" data-id="${i}">
                                    <span class="cursor-move drag-handle text-gray-400">☰</span>
                                    <div class="relative">
                                        <img src="{{ asset('assets/emojis/glossy') }}/${glossyImage}" alt="" class="w-10 h-10 rounded-full">
                                        <input type="text" name="payload[categories][${cate_key}][questions][${questionKey}][options][${i}][text]" value="${i}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent opt-text hidden"
                                               placeholder="label">
                                    </div>
                                    <div>
                                        <input type="number" name="payload[categories][${cate_key}][questions][${questionKey}][options][${i}][score]" value="${i}"
                                               class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent opt-score"
                                               >
                                    </div>
                                </div>`;
                            optionsContainer.append(newOptionHtml);
                        }
                        addMoreButton.addClass('hidden');
                        addMoreButton.attr('data-last_opt_key', 4);

                        // Re-initialize Sortable for the new options
                        const containerId = optionsContainer.attr('id');
                        if (containerId && document.getElementById(containerId)) {
                            new Sortable(document.getElementById(containerId), {
                                group: 'shared',
                                animation: 150,
                                ghostClass: 'bg-blue-100',
                                onEnd: function (evt) {
                                    const container = evt.to;
                                    $(container).children('.main-content').each(function (newIndex) {
                                        $(this).attr('data-id', newIndex);
                                        $(this).find('input').each(function () {
                                            let name = $(this).attr('name');
                                            if (name) {
                                                name = name.replace(/\[options\]\[\d+\]/, `[options][${newIndex}]`);
                                                $(this).attr('name', name);
                                            }
                                        });
                                    });
                                }
                            });
                        }

                        // Trigger autosave after regenerating options
                        autoSaveQuestionnaire();
                    }
                } else {
                    optionsContainer.find('.opt-score').removeClass('hidden');
                }

                if (questionType === 'AMOUNT') {
                    imageContainer.removeClass('hidden');
                } else {
                    imageContainer.addClass('hidden').val('');
                }
            }

            // Add event listener for remove option button
            $(document).on('click', '.remove-option', function () {
                removeOption(this);
            });

            $(document).delegate(".requiredToggleBtn", "click", function () {
                var type = $(this).attr('data-type');
                $(this).closest('div').find('input').val(type);
                $(this).closest('div').find('.required_false').addClass("bg-[#0073AF] text-white");
                $(this).closest('div').find('.required_true').removeClass("bg-[#0073AF] text-white");
                if (type === '1') {
                    console.log(type);
                    $(this).closest('div').find('.required_false').removeClass("bg-[#0073AF] text-white");
                    $(this).closest('div').find('.required_true').addClass("bg-[#0073AF] text-white");
                }
                autoSaveQuestionnaire();
            });
        });

        // category questionnaire
        function filterQuestionsByCategory(id, key, el) {
            $('.category-item').removeClass('border border-[#0073AF]');
            $(el).addClass('border border-[#0073AF]');
            $('#add-faq-btn').attr('data-id', id);
            $('#add-faq-btn').attr('data-key', key);
            $('.current_category_id').val(id);
            categoryQuestionsList(id, key);
        }

        function categoryQuestionsList(category_id, cate_key) {
            $.ajax({
                url: "{{ route('admin.questionnaire.questions.list', $questionnaire->id) }}",
                method: "post",
                dataType: "json",
                data: {
                    category_id: category_id,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    // Show loading state
                },
                success: function (result) {
                    // sendToast(result.message);
                    generateQuestionCard(result.data.questions, cate_key);
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data.hasOwnProperty('message')) {
                        actionError(xhr, data.message);
                    } else {
                        actionError(xhr);
                    }
                }
            });
        }

        categoryQuestionsList(CATEGORY_ID, 0);

        function generateQuestionCard(questions, cate_key) {

            let questionCardHtml = '';
            let questionKey = 0;
            $.each(questions, function (key, question) {

                const uid = question.id || '';
                const cate_id = question.categoryId || '';
                const required = question.required || '0';
                const type = question.type || 'RADIO';
                const title = question.title || '';
                const comment = question.comment || '';
                const imageUrl = question.imageUrl || '';
                let options = [];
                // Safety check before accessing length
                if(question.options && question.options.length > 1){
                    console.log('Question has options:', question.options.length);
                    options = question.options;
                }else if(type === 'RADIO') {
                    // Default values: No = 0, Yes = 2
                    options = [
                        {text: '0', score: '0'},
                        {text: '1', score: '2'},
                    ];
                }else if(type === 'SLIDER') {
                    // Default values: 0 to 4
                    options = [
                        {text: '0', score: '0'},
                        {text: '1', score: '1'},
                        {text: '2', score: '2'},
                        {text: '3', score: '3'},
                        {text: '4', score: '4'},
                    ];
                }

                const cardId = `questionCard_${questionKey}`;
                questionCardHtml += `
                <div class="questionCard bg-card-light content-wrapper bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 p-6" data-id="${questionKey}" id="${cardId}" data-qkey="${questionKey}">
                    <div class="viewQuestion hidden">

                    </div>
                    <div class="updateQuestion">
                    <input type="hidden" name="payload[categories][${cate_key}][questions][${questionKey}][id]" value="${uid}">
                    <input type="hidden" name="payload[categories][${cate_key}][questions][${questionKey}][categoryId]" value="${cate_id}">
                    <div class="flex items-center justify-between mb-4">
                        <div class="">
<!--                            <button type="button" class="cursor-pointer show-btn" onclick="toggleInput(this, 'show')">-->
<!--                                <svg class="text-gray-800 w-[20px]" xmlns="http://www.w3.org/2000/svg"-->
<!--                                     viewBox="0 0 24 24" fill="#000000">-->
<!--                                    <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">-->
<!--                                    </path>-->
<!--                                </svg>-->
<!--                            </button>-->

                            <button type="button" class="cursor-pointer hide-btn hidden" onclick="toggleInput(this, 'hide')">
                                <svg class="text-gray-800 w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M11.9999 10.8284L7.0502 15.7782L5.63599 14.364L11.9999 8L18.3639 14.364L16.9497 15.7782L11.9999 10.8284Z">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <div class="flex gap-4">

                            <div class="relative dropdown-wrapper">
                                <div class="flex items-center gap-2">
                                    <!-- Dropdown Toggle Button -->
                                    <button type="button" onclick="toggleDropdown(this)"
                                            class="questionTypeBtn cursor-pointer flex px-3 py-2 border border-gray-300 rounded-lg text-gray-500 hover:bg-gray-50 transition-colors">
                                        <input type="hidden" name="payload[categories][${cate_key}][questions][${questionKey}][type]" class="questionType" value="${type}">
                                        <span class="text-gray-500 questionTypeText">${getQuestionTypeText(type)}</span>
                                        <svg class="w-[30px] h-[30px]" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M7 10l5 5 5-5z" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Dropdown Menu -->
                                <div class="dropdown questionTypeDropdown absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-10">
                                    <ul class="py-1 text-gray-700">
                                        <li><button type="button" class="w-full px-4 py-2 text-left ${checkCondition(type, 'RADIO', 'bg-gray-100', 'hover:bg-gray-100')}" data-value="RADIO" data-text="Radio Group">{{ trans_message('radio_group') }}</button>
                                        </li>
                                        <li><button type="button" class="w-full px-4 py-2 text-left ${checkCondition(type, 'SLIDER', 'bg-gray-100', 'hover:bg-gray-100')}" data-value="SLIDER" data-text="Slider"> {{ trans_message('slider') }}</button>
                                        </li>
                                        <!--<li><button type="button" class="w-full px-4 py-2 text-left ${checkCondition(type, 'SELECT', 'bg-gray-100', 'hover:bg-gray-100')}" data-value="SELECT" data-text="Select">{{ trans_message('select') }}</button>
                                        </li>-->
                                        <li><button type="button" class="w-full px-4 py-2 text-left ${checkCondition(type, 'AMOUNT', 'bg-gray-100', 'hover:bg-gray-100')}" data-value="AMOUNT" data-text="Amount">{{ trans_message('amount') }}</button>
                                        </li>
                                        <li><button type="button" class="w-full px-4 py-2 text-left ${checkCondition(type, 'TEXT', 'bg-gray-100', 'hover:bg-gray-100')}" data-value="TEXT" data-text="Text"> {{ trans_message('text') }}</button>
                                        </li>
                                        <li><button type="button" class="w-full px-4 py-2 text-left ${checkCondition(type, 'COMMENT', 'bg-gray-100', 'hover:bg-gray-100')}" data-value="COMMENT" data-text="Comment Only">{{ trans_message('comment_only') }}</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-1 p-1 rounded-full bg-gray-100 self-end sm:w-auto">
                                    <input type="hidden" name="payload[categories][${cate_key}][questions][${questionKey}][required]" value="${required}">
                                    <button type="button" class="text-xs py-1.5 px-2.5 rounded-full ${checkCondition(required, '1', '', 'bg-[#0073AF] text-white')} requiredToggleBtn required_false" data-type="0">
                                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22H2L4.92893 19.0711C3.11929 17.2614 2 14.7614 2 12ZM6.82843 20H12C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 14.1524 4.85124 16.1649 6.34315 17.6569L7.75736 19.0711L6.82843 20ZM8 13H16C16 15.2091 14.2091 17 12 17C9.79086 17 8 15.2091 8 13Z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button type="button" class="text-xs py-1.5 px-2.5 rounded-full ${checkCondition(required, '1', 'bg-[#0073AF] text-white')} requiredToggleBtn required_true" data-type="1">
                                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512"
                                             x="0" y="0" viewBox="0 0 100 100" fill="currentColor"
                                              xml:space="preserve">
                                                <g>
                                                    <path d="M49.994 2.5C23.756 2.5 2.5 23.768 2.5 49.994 2.5 76.232 23.756 97.5 49.994 97.5S97.5 76.232 97.5 49.994C97.5 23.768 76.232 2.5 49.994 2.5zm28.058 40.552L65.787 54.938c-.253.253-.38.632-.38 1.011l2.782 16.565c.253 1.644-1.517 2.908-3.034 2.15l-14.921-7.967a1.754 1.754 0 0 0-1.138 0l-14.668 7.84c-1.517.759-3.288-.506-3.035-2.15l2.908-16.817c.127-.38 0-.759-.379-1.012L21.91 42.925c-1.265-1.138-.506-3.287 1.138-3.54l16.817-2.403c.38 0 .759-.253.885-.632l7.46-15.174c.76-1.517 2.909-1.517 3.668 0l7.587 15.3a.95.95 0 0 0 .885.633l16.564 2.402c1.77.253 2.403 2.276 1.138 3.54z"
                                                            fill="" opacity="1" data-original="" class="">
                                                    </path>
                                                </g>
                                            </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent question_title"
                              placeholder="Type your question here..." rows="3" name="payload[categories][${cate_key}][questions][${questionKey}][title]">${title}</textarea>
                    <input type="hidden" name="payload[categories][${cate_key}][questions][${questionKey}][comment]">
                    <input type="hidden" name="payload[categories][${cate_key}][questions][${questionKey}][imageUrl]">
                    <div class="text-gray-700 mt-2 input-display"></div>
                    <div class="options-container ${['RADIO', 'SLIDER'].includes(type) ? 'flex flex-wrap gap-6 items-start' : ''}" id="sortable${questionKey}">`;
                let lastoptIndex = 0;
                if (type !== 'AMOUNT' && type !== 'TEXT' && type !== 'COMMENT') {
                    const isHorizontal = ['RADIO', 'SLIDER'].includes(type);
                    $.each(options, function (index, opt) {
                        const opt_text = opt.text || index;
                        const opt_score = opt.score || '';
                        questionCardHtml += `
                        <div class="flex items-center main-content ${isHorizontal ? 'gap-2 mb-0' : 'gap-4 my-4'} " data-id="${index}">
                            <span class="cursor-move drag-handle text-gray-400">☰</span>
                            <div class="relative">
                                <img src="{{ asset('assets/emojis/glossy') }}/${type === 'SLIDER' ? ['00.png', '04.png', '03.png', '02.png', '01.png'][index] || '00.png' : (index === 0 ? '00.png' : '01.png')}" alt="" class="w-10 h-10 rounded-full">
                                <input type="text" name="payload[categories][${cate_key}][questions][${questionKey}][options][${index}][text]" value="${opt_text}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent opt-text ${checkCondition([type, type], ['RADIO', 'SLIDER'], 'hidden', '')}"
                                       placeholder="label">
                            </div>
                            <div>
                                <input type="number" name="payload[categories][${cate_key}][questions][${questionKey}][options][${index}][score]" value="${opt_score}"
                                       class="${isHorizontal ? 'w-20 text-center px-1 py-1' : 'w-20 px-3 py-2'} border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent opt-score ${checkCondition(type, 'SELECT', 'hidden', '')}"
                                       >
                            </div>
                        </div>`;
                        lastoptIndex = index;
                    });
                }
                questionCardHtml += `</div>
                    <div class="flex flex-col button-content sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                        <button type="button" onclick="addMoreOptions(${cate_key},${questionKey},this);"
                                data-last_opt_key="${lastoptIndex}"
                                class="${checkCondition([type, type, type], ['AMOUNT', 'TEXT', 'COMMENT'], 'bg-blue-300 border-blue-300', 'btn-primary bg-blue-600 border-blue-600 cursor-pointer')} ${checkCondition([type, type], ['RADIO', 'SLIDER'], 'hidden', '')} add-more-options px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white border rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2 w-full sm:w-auto"
                                ${checkCondition([type, type, type], ['AMOUNT', 'TEXT', 'COMMENT'], 'disabled="disabled"')}>
                         {{ trans_message('add_more') }}
                </button>

                <div class="flex items-center space-x-1 sm:space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                    <button type="button" onclick="viewQuestion('${uid}',this);" class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                    title="View">
                                <svg class="size-[16px] sm:size-[20px]" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                    </path>
                                </svg>
                            </button>
                            <button type="button" onclick="copyQuestion('${uid}','${cate_id}','${cate_key}');" class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                    title="Copy">
                                <svg class="size-[16px] sm:size-[20px]" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6ZM6.9998 11V13H12.9998V11H6.9998ZM6.9998 15V17H12.9998V15H6.9998Z">
                                    </path>
                                </svg>
                            </button>
                            <button type="button" class="cursor-pointer text-gray-400 hover:text-red-600 p-2 transition-all duration-200"
                                    title="Delete" onclick="removeQuestionCard('${cardId}')">
                                <svg class="size-[16px] sm:size-[20px]" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                </div>
            `;

                questionKey++;
            });

            // Inject the generated HTML
            $('.categoryQuestionsList').html(questionCardHtml);

            // Initialize SortableJS for question cards drag-and-drop
            initializeQuestionSortable();

            // Initialize Sortable for each dynamically generated list
            $.each(questions, function (key, question) {
                new Sortable(document.getElementById('sortable' + key), {
                    group: 'shared',
                    animation: 150,
                    ghostClass: 'bg-blue-100',
                    onEnd: function (evt) {
                        const container = evt.to; // the sorted container
                        const questionIndex = key; // current question key
                        const cateIndex = cate_key; // current category key

                        // Loop through all option elements and update their name attributes
                        $(container).children('.main-content').each(function (newIndex) {
                            $(this).attr('data-id', newIndex); // Update data-id if needed

                            // Update input names inside this option
                            $(this).find('input').each(function () {
                                let name = $(this).attr('name');

                                if (name) {
                                    // Replace the option index using regex
                                    name = name.replace(/\[options\]\[\d+\]/, `[options][${newIndex}]`);
                                    $(this).attr('name', name);
                                    // autoSaveQuestionnaire();
                                }
                            });
                        });

                        console.log('Options reordered. Names updated.');
                    }
                });
            });
        }

        // Helper to display readable text for question type
        function getQuestionTypeText(type) {
            switch (type) {
                case 'RADIO':
                    return 'Radio Group';
                case 'SLIDER':
                    return 'Slider';
                case 'SELECT':
                    return 'Select';
                case 'AMOUNT':
                    return 'Amount';
                case 'TEXT':
                    return 'Text';
                case 'COMMENT':
                    return 'Comment Only';
                default:
                    return 'Radio Group';
            }
        }

        function checkCondition(var1, var2, val, else_val = '') {
            const arr1 = Array.isArray(var1) ? var1 : [var1];
            const arr2 = Array.isArray(var2) ? var2 : [var2];

            const allMatch = arr1.every(v1 => arr2.includes(v1));

            return allMatch ? val : else_val;
        }

        // Function to add more options to options container
        function viewQuestion(qid, button) {
            const container = $(button).closest('.questionCard');
            const title = container.find('.question_title').html();
            const type = container.find('.questionType').val();

            // sabhi option text inputs find karo
            let allOptionTexts = container.find('input[name*="[options]"][name$="[text]"]');

            // sabhi option score inputs find karo
            let allOptionScores = container.find('input[name*="[options]"][name$="[score]"]');

            allOptionTexts = allOptionTexts.map(function () {
                return $(this).val();
            }).get();

            allOptionScores = allOptionScores.map(function () {
                return $(this).val();
            }).get();

            console.log(allOptionTexts, allOptionScores);

            let newOptionHtml = `
                <div class="questionTitle text-2xl" onclick="editQuestion(this);">
                    ${title}
                </div>
                <div class="w-full my-4" onclick="editQuestion(this);">
            `;
            if (type === 'RADIO') {
                newOptionHtml += `<div class="w-full mt-4 flex justify-center gap-3">`;
                $.each(allOptionTexts, function (index, opt) {
                    const glossyImage = ['00.png', '01.png'][index] || '00.png';
                    newOptionHtml += `
                        <div>
                            <input type="radio" id="opt-${qid}-${index}" name="opt-${qid}" class="hidden peer">
                            <label for="opt-${qid}-${index}" class="cursor-pointer transition-all duration-200 p-2 rounded-lg peer-checked:ring-4 peer-checked:ring-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50 opacity-100">
                                <img src="{{ asset('assets/emojis/glossy') }}/${glossyImage}" alt="${opt || ''}" class="w-12 h-12 object-contain rounded-full">
                            </label>
                        </div>
                    `;
                });
                newOptionHtml += `</div>`;
            } else if (type === 'SELECT') {
                $.each(allOptionTexts, function (index, opt) {
                    newOptionHtml += `
                        <input type="radio" id="opt-${qid}-${index}" name="opt-${qid}">
                        <label for="opt-${qid}-${index}">${opt || ''}</label>
                    `;
                });
            }
            if (type === 'SLIDER') {
                newOptionHtml += `<div class="w-full mt-4 flex justify-center gap-2">`;
                $.each(allOptionTexts, function (index, opt) {
                    const glossyImage = ['00.png', '01.png', '02.png', '03.png', '04.png'][index] || '00.png';
                    newOptionHtml += `
                        <div>
                            <input type="radio" id="opt-${qid}-${index}" name="opt-${qid}" class="hidden peer">
                            <label for="opt-${qid}-${index}" class="cursor-pointer transition-all duration-200 p-2 rounded-lg peer-checked:ring-4 peer-checked:ring-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50 opacity-100">
                                <img src="{{ asset('assets/emojis/glossy') }}/${glossyImage}" alt="${opt || ''}" class="w-12 h-12 object-contain rounded-full">
                            </label>
                        </div>
                    `;
                });
                newOptionHtml += `</div>`;
            }
            if (type === 'AMOUNT') {
                newOptionHtml += `<div class="relative">
                  <input type="text" id="hs-leading-icon" class="block border border-gray-200 disabled:opacity-50 disabled:pointer-events-none focus:border-blue-500 focus:outline-none focus:ring-blue-500 focus:z-10 ps-11 px-4 py-2.5 rounded-lg sm:py-3 sm:text-sm w-full" placeholder="0">
                  <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                    {{ currency_icon() }}
                </div>
              </div>
              <div class="image-container mt-3">
                  <div class="flex items-center gap-4 mb-3">
                      <div class="image-preview size-[100px] bg-gray-100 border flex items-center relative justify-center border-dashed border-gray-300 rounded-lg overflow-hidden">
                          <svg class="size-[24px] text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M4 5V19H20V7H11.5858L9.58579 5H4ZM12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM10 10.5C10 11.3284 9.32843 12 8.5 12C7.67157 12 7 11.3284 7 10.5C7 9.67157 7.67157 9 8.5 9C9.32843 9 10 9.67157 10 10.5ZM18 17L14 11L7 17H18Z"></path>
                          </svg>
                      </div>
                  </div>
              </div>`;
            }
            newOptionHtml += `</div>`;
            container.find('.updateQuestion').addClass('hidden');
            container.find('.viewQuestion').removeClass('hidden').html(newOptionHtml);
        }

        function editQuestion(button) {
            const container = $(button).closest('.questionCard');
            container.find('.viewQuestion').addClass('hidden');
            container.find('.updateQuestion').removeClass('hidden');
        }

        function addMoreOptions(cate_key, questionKey, button) {
            var optionKey = parseInt($(button).attr('data-last_opt_key')) + 1;
            const optionsContainer = $(button).closest('.questionCard').find('.options-container');
            const type = $(button).closest('.questionCard').find('.questionType').val();
            const newOptionHtml = `
                <div class="flex items-center main-content gap-4 my-4" id="${optionKey}">
                    <span class="cursor-move drag-handle text-gray-400">☰</span>
                    <div class="relative emoji-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                             xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0"
                             viewBox="0 0 368 368" style="enable-background:new 0 0 512 512"
                             xml:space="preserve" class="h-6 w-6 absolute text-gray-500 right-3 top-[9px] emoji-button cursor-pointer">
                            <g>
                                <path d="M261.336 226.04c-3.296-2.952-8.36-2.664-11.296.624C233.352 245.312 209.288 256 184 256c-25.28 0-49.352-10.688-66.04-29.336-2.952-3.288-8-3.576-11.296-.624-3.296 2.944-3.568 8-.624 11.296C125.76 259.368 154.176 272 184 272c29.832 0 58.248-12.64 77.96-34.664 2.944-3.296 2.664-8.352-.624-11.296z"
                                        fill="#6a7282" opacity="1" data-original="#000000" class=""></path>
                                <path d="M184 0C82.544 0 0 82.544 0 184s82.544 184 184 184 184-82.544 184-184S285.456 0 184 0zm0 352c-92.64 0-168-75.36-168-168S91.36 16 184 16s168 75.36 168 168-75.36 168-168 168z"
                                        fill="#6a7282" opacity="1" data-original="#000000" class=""></path>
                                <path d="M248 128c-22.056 0-40 17.944-40 40 0 4.416 3.584 8 8 8s8-3.584 8-8c0-13.232 10.768-24 24-24s24 10.768 24 24c0 4.416 3.584 8 8 8s8-3.584 8-8c0-22.056-17.944-40-40-40zM144 168c0 4.416 3.584 8 8 8s8-3.584 8-8c0-22.056-17.944-40-40-40s-40 17.944-40 40c0 4.416 3.584 8 8 8s8-3.584 8-8c0-13.232 10.768-24 24-24s24 10.768 24 24z"
                                        fill="#6a7282" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <input type="text" name="payload[categories][${cate_key}][questions][${questionKey}][options][${optionKey}][text]"
                               class="emoji-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent opt-text"
                               placeholder="lable">
                    </div>
                    <div>
                        <input type="number" name="payload[categories][${cate_key}][questions][${questionKey}][options][${optionKey}][score]"
                               class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent opt-score ${checkCondition(type, 'SELECT', 'hidden', '')}"
                               >
                    </div>
                    <svg class="h-6 w-6 cursor-pointer text-gray-500 remove-option" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                        </path>
                    </svg>
                </div>
            `;
            $(button).attr('data-last_opt_key', optionKey);
            optionsContainer.append(newOptionHtml);
        }

        // Function to remove an option
        function removeOption(button) {
            $(button).closest('.main-content').fadeOut(300, function () {
                $(this).remove();
                autoSaveQuestionnaire();
            });
        }

        // Auto-save questionnaire
        function autoSaveQuestionnaire() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(function () {
                const form = document.querySelector('#questionForm');
                const formData = new FormData(form);
                $.ajax({
                    url: "{{ route('admin.questionnaire.update', $questionnaire->id) }}",
                    method: "post",
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        // Show loading state
                    },
                    success: function (result) {
                        sendToast(result.message);
                        // loadCategories();
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data.hasOwnProperty('message')) {
                            actionError(xhr, data.message);
                        } else {
                            actionError(xhr);
                        }
                    }
                });
            }, 2000); // 2000ms = 2 seconds
        }

        $('#questionForm').on('change', function () {
            autoSaveQuestionnaire();
        });

        function copyQuestion(qus_id, category_id, cate_key) {
            $.ajax({
                url: "{{ route('admin.questionnaire.add.new.question', $questionnaire->id) }}",
                method: "post",
                dataType: "json",
                data: {
                    qus_id: qus_id,
                    category_id: category_id,
                    category_key: cate_key,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    // Show loading state
                },
                success: function (result) {
                    sendToast(result.message);
                    categoryQuestionsList(category_id, cate_key);
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data.hasOwnProperty('message')) {
                        actionError(xhr, data.message);
                    } else {
                        actionError(xhr);
                    }
                }
            });
        }


        // Initialize SortableJS for question cards
        let questionSortableInstance = null;
        
        function initializeQuestionSortable() {
            const questionsList = document.querySelector('.categoryQuestionsList');
            
            console.log('Initializing question sortable...', questionsList);
            
            if (questionsList) {
                // Destroy existing instance if any
                if (questionSortableInstance) {
                    questionSortableInstance.destroy();
                }
                
                // Create new Sortable instance
                questionSortableInstance = new Sortable(questionsList, {
                    animation: 150,          // Smooth animation
                    ghostClass: 'sortable-ghost',  // Class for the drop placeholder
                    dragClass: 'sortable-drag',    // Class for the dragging element
                    chosenClass: 'sortable-chosen', // Class for the chosen item
                    filter: 'button, input, textarea, select, .options-container',  // Don't drag from interactive elements
                    preventOnFilter: false,
                    onStart: function(evt) {
                        console.log('Drag started', evt);
                    },
                    onEnd: function(evt) {
                        console.log('Drag ended', evt);
                        // Reorder questions after drag ends
                        reorderQuestions();
                        autoSaveQuestionnaire();
                    }
                });
                
                console.log('Question sortable initialized successfully', questionSortableInstance);
            } else {
                console.error('Questions list container not found!');
            }
        }

        // Initialize SortableJS for categories
        let categorySortableInstance = null;
        
        function initializeCategorySortable() {
            const categoriesContainer = document.querySelector('#categories-container');
            
            console.log('Initializing category sortable...', categoriesContainer);
            
            if (categoriesContainer) {
                // Destroy existing instance if any
                if (categorySortableInstance) {
                    categorySortableInstance.destroy();
                }
                
                // Create new Sortable instance
                categorySortableInstance = new Sortable(categoriesContainer, {
                    animation: 150,                    // Smooth animation
                    ghostClass: 'sortable-ghost',      // Class for the drop placeholder
                    dragClass: 'sortable-drag',        // Class for the dragging element
                    chosenClass: 'sortable-chosen',    // Class for the chosen item
                    draggable: '.category-wrapper',    // Only category wrappers are draggable
                    handle: '.category-item',          // Drag by clicking on the category item
                    filter: 'button[command="show-modal"]',  // Don't drag the "New Category" button
                    preventOnFilter: false,
                    onStart: function(evt) {
                        console.log('Category drag started', evt);
                    },
                    onEnd: function(evt) {
                        console.log('Category drag ended', evt);
                        // Reorder categories after drag ends
                        reorderCategories();
                        autoSaveQuestionnaire();
                    }
                });
                
                console.log('Category sortable initialized successfully', categorySortableInstance);
            } else {
                console.error('Categories container not found!');
            }
        }

        // Function to reorder categories and update their indices
        function reorderCategories() {
            let newIndex = 0;
            
            // Iterate through all category wrappers
            $('#categories-container .category-wrapper').each(function() {
                const $wrapper = $(this);
                const categoryId = $wrapper.attr('data-category-id');
                
                // Update wrapper data-key
                $wrapper.attr('data-key', newIndex);
                
                // Update all hidden inputs within this wrapper
                $wrapper.find('input[type="hidden"]').each(function() {
                    let name = $(this).attr('name');
                    if (name && name.includes('[categories]')) {
                        // Replace the category index
                        name = name.replace(/\[categories\]\[\d+\]/, `[categories][${newIndex}]`);
                        $(this).attr('name', name);
                    }
                });
                
                // Update the category-item div attributes
                const $categoryItem = $wrapper.find('.category-item');
                $categoryItem.attr('data-key', newIndex);
                $categoryItem.attr('onclick', `filterQuestionsByCategory('${categoryId}',${newIndex},this)`);
                
                newIndex++;
            });
            
            console.log('Categories reordered, total categories:', newIndex);
        }

        // Initialize category sortable on page load
        $(document).ready(function() {
            initializeCategorySortable();
        });

        // Function to reorder questions and update their indices
        function reorderQuestions() {
            $('.categoryQuestionsList .questionCard').each(function(newIndex) {
                const $questionCard = $(this);
                const oldQKey = $questionCard.attr('data-qkey');
                
                // Update data attributes
                $questionCard.attr('data-id', newIndex);
                $questionCard.attr('data-qkey', newIndex);
                $questionCard.attr('id', 'questionCard_' + newIndex);
                
                // Get category key from the first input name
                const firstInput = $questionCard.find('input[name*="[categories]"]').first();
                const nameAttr = firstInput.attr('name');
                let cateKey = 0;
                if (nameAttr) {
                    const cateMatch = nameAttr.match(/\[categories\]\[(\d+)\]/);
                    if (cateMatch) {
                        cateKey = cateMatch[1];
                    }
                }
                
                // Update all input and textarea names within this question card
                $questionCard.find('input, textarea').each(function() {
                    let name = $(this).attr('name');
                    if (name && name.includes('[questions]')) {
                        // Replace the question index
                        name = name.replace(/\[questions\]\[\d+\]/, `[questions][${newIndex}]`);
                        $(this).attr('name', name);
                    }
                });
                
                // Update button onclick attributes
                const uid = $questionCard.find('input[name*="[id]"]').first().val() || '';
                const cate_id = $questionCard.find('input[name*="[categoryId]"]').first().val() || '';
                const cardId = 'questionCard_' + newIndex;
                
                // Update button onclick attributes
                $questionCard.find('button[onclick*="viewQuestion"]').attr('onclick', `viewQuestion('${uid}',this);`);
                $questionCard.find('button[onclick*="copyQuestion"]').attr('onclick', `copyQuestion('${uid}','${cate_id}','${cateKey}');`);
                $questionCard.find('button[onclick*="removeQuestionCard"]').attr('onclick', `removeQuestionCard('${cardId}')`);
                
                // Update add more options button
                $questionCard.find('button[onclick*="addMoreOptions"]').each(function() {
                    const lastOptKey = $(this).attr('data-last_opt_key') || '0';
                    $(this).attr('onclick', `addMoreOptions(${cateKey},${newIndex},this);`);
                });
            });
        }


        function changePublish(id, status = 0, element) {
            $.ajax({
                url: "{{ route('admin.questionnaire.update.publish') }}",
                method: "POST",
                data: {
                    id: id,
                    status: status,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    sendToast(response.message);
                },
                error: function (xhr) {
                    actionError(xhr);
                }
            });
        }
    </script>
@endsection
