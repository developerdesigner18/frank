@extends('admin.master')
@section('title', 'Settings')
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('admin.settings') }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>{{ trans_message('settings') }}</span> </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span>{{ trans_message('edit_frequently_asked_questions') }}</span>
    </div>
    <div class="pt-6 flex justify-between items-center xl:hidden">
        <span class="text-2xl font-semibold text-gray-800">Edit Frequently Asked Questions</span>
    </div>
@endpush
@push('modal')
@endpush
@section('main')
    <form method="post" id="faqForm">
        @csrf
        <section class="modern-card pt-4 sm:pt-6">
            <!-- Tabs Section -->
            <div class="mb-4 sm:mb-6">
                <div class="flex justify-start">
                    <nav class="flex items-center gap-1 p-1 rounded-full bg-gray-100 w-full sm:w-auto">
                        <button type="button"
                                class="tab-btn change-type transition-all duration-300 font-medium text-xs sm:text-sm py-2 px-2 sm:px-3 rounded-full bg-[#0073AF] text-white active flex-1 sm:flex-none text-center"
                                data-tab="mystery-visitor">
                            <span class="hidden sm:inline">{{ trans_message('mystery_visitor') }}</span>
                            <span class="sm:hidden">{{ trans_message('mystery') }}</span>
                        </button>
                        <button type="button"
                                class="tab-btn change-type transition-all duration-300 font-medium text-xs sm:text-sm py-2 px-2 sm:px-3 rounded-full flex-1 sm:flex-none text-center"
                                data-tab="company">
                            {{ trans_message('company') }}
                        </button>
                    </nav>
                </div>
            </div>
            <div class="tab-content">
                <!-- Mystery Visitor Tab Content -->
                <div id="tab-mystery-visitor" class="tab-pane">
                    <div class="space-y-6 visitorData">
                        <!-- FAQ Item 1 -->
                        @if($visitor_faq)
                            @foreach($visitor_faq as $vfaq)
                                <div
                                    class="mainDiv bg-white rounded-xl border border-gray-200 p-3 sm:p-4 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4 sm:mb-6">
                                    <div class="viewQuestion hidden"></div>
                                    <div class="w-full flex flex-col gap-3 sm:gap-2 updateQuestion">
                                        <div class="w-full flex flex-col gap-1">
                                            <label
                                                class="block text-xs sm:text-sm font-medium text-gray-700">{{ trans_message('question') }}</label>
                                            <input type="text"
                                                   name="visitor_qus[]"
                                                   class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                   placeholder="{{ trans_message('question') }}"
                                                   value="{{ $vfaq['question'] }}">
                                        </div>

                                        <div class="w-full flex flex-col gap-1">
                                            <label
                                                class="block text-xs sm:text-sm font-medium text-gray-700">{{ trans_message('answer') }}</label>
                                            <textarea name="visitor_ans[]"
                                                      class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                      rows="3"
                                                      placeholder="{{ trans_message('answer') }} ">{{ $vfaq['answer'] }}</textarea>
                                        </div>

                                        <div
                                            class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                                            <button type="button" data-type="visitor"
                                                    class="add-more-btn btn-primary px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2 w-full sm:w-auto">
                                                {{ trans_message('add_more') }}
                                            </button>

                                            <div
                                                class="flex items-center space-x-1 sm:space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                                                <button type="button" onclick="viewQuestion(this);"
                                                        class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                                        title="{{ trans_message('view') }}">
                                                    <svg class="size-[16px] sm:size-[20px]"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                         fill="currentColor">
                                                        <path
                                                            d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button type="button" onclick="copyQuestion('visitor', this);"
                                                        class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                                        title="{{ trans_message('copy') }}">
                                                    <svg class="size-[16px] sm:size-[20px]"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                         fill="currentColor">
                                                        <path
                                                            d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6ZM6.9998 11V13H12.9998V11H6.9998ZM6.9998 15V17H12.9998V15H6.9998Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button type="button" onclick="deleteQuestion(this);"
                                                        class="cursor-pointer text-gray-400 hover:text-red-600 p-2 transition-all duration-200"
                                                        title="{{ trans_message('delete') }}">
                                                    <svg class="size-[16px] sm:size-[20px]"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                         fill="currentColor">
                                                        <path
                                                            d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- Company Tab Content -->
                <div id="tab-company" class="tab-pane hidden">
                    <div class="space-y-4 sm:space-y-6 companyData">
                        <!-- FAQ Item 1 -->
                        @if($company_faq)
                            @foreach($company_faq as $cfaq)
                                <div
                                    class="mainDiv bg-white rounded-xl border border-gray-200 p-3 sm:p-4 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4 sm:mb-6">
                                    <div class="viewQuestion hidden"></div>
                                    <div class="w-full flex flex-col gap-3 sm:gap-2 updateQuestion">
                                        <div class="w-full flex flex-col gap-1">
                                            <label
                                                class="block text-xs sm:text-sm font-medium text-gray-700">  {{ trans_message('question') }}
                                            </label>
                                            <input type="text"
                                                   name="company_qus[]"
                                                   class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                   placeholder="{{ trans_message('question') }}"
                                                   value="{{ $vfaq['question'] }}">
                                        </div>

                                        <div class="w-full flex flex-col gap-1">
                                            <label
                                                class="block text-xs sm:text-sm font-medium text-gray-700">{{ trans_message('answer') }}</label>
                                            <textarea name="company_ans[]"
                                                      class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                      rows="3"
                                                      placeholder="{{ trans_message('answer') }}">{{ $vfaq['answer'] }}</textarea>
                                        </div>

                                        <div
                                            class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                                            <button type="button" data-type="company"
                                                    class="add-more-btn btn-primary px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2 w-full sm:w-auto">
                                                {{ trans_message('add_more') }}
                                            </button>

                                            <div
                                                class="flex items-center space-x-1 sm:space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                                                <button type="button" onclick="viewQuestion(this);"
                                                        class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                                        title="{{ trans_message('view') }}">
                                                    <svg class="size-[16px] sm:size-[20px]"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                         fill="currentColor">
                                                        <path
                                                            d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button type="button" onclick="copyQuestion('company', this);"
                                                        class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                                        title="{{ trans_message('copy') }}">
                                                    <svg class="size-[16px] sm:size-[20px]"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                         fill="currentColor">
                                                        <path
                                                            d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6ZM6.9998 11V13H12.9998V11H6.9998ZM6.9998 15V17H12.9998V15H6.9998Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button type="button" onclick="deleteQuestion(this);"
                                                        class="cursor-pointer text-gray-400 hover:text-red-600 p-2 transition-all duration-200"
                                                        title="{{ trans_message('delete') }}">
                                                    <svg class="size-[16px] sm:size-[20px]"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                         fill="currentColor">
                                                        <path
                                                            d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Add New FAQ Button -->
            <div class="flex justify-center mt-6 sm:mt-8">
                <button type="button" id="add-faq-btn" data-type="visitor"
                        class="add-more-btn cursor-pointer bg-[#0073AF] text-white rounded-full p-3 sm:p-4 hover:bg-[#0068A0] transition-colors shadow-lg">
                    <svg class="size-[16px] sm:size-[20px]" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path>
                    </svg>
                </button>
            </div>
        </section>
    </form>
@endsection
@section('script')
    <script>
        let autoSaveTimer;

        $('.change-type').on('click', function (e) {
            var type = $(this).attr('data-tab');
            if (type === 'company') {
                $('#add-faq-btn').attr('data-type', 'company');
            } else {
                $('#add-faq-btn').attr('data-type', 'visitor');
            }
        });

        $('.add-more-btn').on('click', function (e) {
            var type = $(this).attr('data-type');
            if (type === 'company') {
                $('.companyData').append(`<div class="mainDiv bg-white rounded-xl border border-gray-200 p-3 sm:p-4 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4 sm:mb-6">
                    <div class="viewQuestion hidden"></div>
                    <div class="w-full flex flex-col gap-3 sm:gap-2 updateQuestion">
                        <div class="w-full flex flex-col gap-1">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Question</label>
                            <input type="text" name="company_qus[]"
                                   class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Question"
                                   value="Question">
                        </div>

                        <div class="w-full flex flex-col gap-1">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Answer</label>
                            <textarea name="company_ans[]"
                                    class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    rows="3"
                                    placeholder="Answer">Answer</textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                            <button type="button" class="btn-primary px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2 w-full sm:w-auto">
                                Add more
                            </button>

                            <div class="flex items-center space-x-1 sm:space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                                <button type="button" onclick="viewQuestion(this);" class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                        title="View">
                                    <svg class="size-[16px] sm:size-[20px]"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" onclick="copyQuestion('company', this);" class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                        title="Copy">
                                    <svg class="size-[16px] sm:size-[20px]"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6ZM6.9998 11V13H12.9998V11H6.9998ZM6.9998 15V17H12.9998V15H6.9998Z">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" onclick="deleteQuestion(this);" class="cursor-pointer text-gray-400 hover:text-red-600 p-2 transition-all duration-200"
                                        title="Delete">
                                    <svg class="size-[16px] sm:size-[20px]"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`);
            } else {
                $('.visitorData').append(`<div class="mainDiv bg-white rounded-xl border border-gray-200 p-3 sm:p-4 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4 sm:mb-6">
                    <div class="viewQuestion hidden"></div>
                    <div class="w-full flex flex-col gap-3 sm:gap-2 updateQuestion">
                        <div class="w-full flex flex-col gap-1">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700">{{ trans_message('question') }}</label>
                            <input type="text" name="visitor_qus[]"
                                   class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="{{ trans_message('question') }}"
                                  value="{{ trans_message('question') }}">
                        </div>

                        <div class="w-full flex flex-col gap-1">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700">{{ trans_message('answer') }}</label>
                            <textarea name="visitor_ans[]"
                                    class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    rows="3"
                                   placeholder="{{ trans_message('answer') }}">placeholder="{{ trans_message('answer') }}"</textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                            <button type="button" class="btn-primary px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2 w-full sm:w-auto">
                                 {{ trans_message('add_more') }}
                </button>

                <div class="flex items-center space-x-1 sm:space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                    <button type="button" onclick="viewQuestion(this);" class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                            title="{{ trans_message('view') }}">
                                    <svg class="size-[16px] sm:size-[20px]"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" onclick="copyQuestion('visitor', this);" class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                        title="{{ trans_message('copy') }}">
                                    <svg class="size-[16px] sm:size-[20px]"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6ZM6.9998 11V13H12.9998V11H6.9998ZM6.9998 15V17H12.9998V15H6.9998Z">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" onclick="deleteQuestion(this);" class="cursor-pointer text-gray-400 hover:text-red-600 p-2 transition-all duration-200"
                                        title="{{ trans_message('delete') }}"">
                                    <svg class="size-[16px] sm:size-[20px]"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`);
            }
            autoSaveForm();
        });

        function viewQuestion(button) {
            const container = $(button).closest('.mainDiv');
            const question = container.find('input').val();
            const answer = container.find('textarea').val();

            let newOptionHtml = `
                <div class="flex font-medium justify-between questionTitle text-[17px]" onclick="editQuestion(this);">
                    <span>${question}</span>
                    <svg width="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289Z" fill="#0F1729"></path> </g></svg>
                </div>
                <hr class="border-gray-300 my-2">
                <div class="w-full" onclick="editQuestion(this);">
                    ${answer}
                </div>
            `;

            container.find('.updateQuestion').addClass('hidden');
            container.find('.viewQuestion').removeClass('hidden').html(newOptionHtml);
        }

        function editQuestion(button) {
            const container = $(button).closest('.mainDiv');
            container.find('.viewQuestion').addClass('hidden');
            container.find('.updateQuestion').removeClass('hidden');
        }

        function deleteQuestion(button) {
            const container = $(button).closest('.mainDiv');
            container.remove();
            autoSaveForm();
        }

        function copyQuestion(type, button) {
            const container = $(button).closest('.mainDiv');
            const question = container.find('input').val();
            const answer = container.find('textarea').val();

            if (type === 'company') {
                $('.companyData').append(`<div class="mainDiv bg-white rounded-xl border border-gray-200 p-3 sm:p-4 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4 sm:mb-6">
                    <div class="viewQuestion hidden"></div>
                    <div class="w-full flex flex-col gap-3 sm:gap-2 updateQuestion">
                        <div class="w-full flex flex-col gap-1">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700">{{ trans_message('question') }}</label>
                            <input type="text" name="company_qus[]"
                                   class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="{{ trans_message('question') }}"
                                   value="${question}">
                        </div>

                        <div class="w-full flex flex-col gap-1">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Answer</label>
                            <textarea name="company_ans[]"
                                    class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    rows="3"
                                    placeholder="Answer">${answer}</textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                            <button type="button" class="btn-primary px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2 w-full sm:w-auto">
                               {{ trans_message('add_more') }}
                </button>

                <div class="flex items-center space-x-1 sm:space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                    <button type="button" onclick="viewQuestion(this);" class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                            title="{{ trans_message('view') }}">
                                    <svg class="size-[16px] sm:size-[20px]"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" onclick="copyQuestion('company', this);" class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                        title="{{ trans_message('copy') }}">
                                    <svg class="size-[16px] sm:size-[20px]"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6ZM6.9998 11V13H12.9998V11H6.9998ZM6.9998 15V17H12.9998V15H6.9998Z">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" onclick="deleteQuestion(this);" class="cursor-pointer text-gray-400 hover:text-red-600 p-2 transition-all duration-200"
                                        title="{{ trans_message('delete') }}">
                                    <svg class="size-[16px] sm:size-[20px]"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`);
            } else {
                $('.visitorData').append(`<div class="mainDiv bg-white rounded-xl border border-gray-200 p-3 sm:p-4 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4 sm:mb-6">
                    <div class="viewQuestion hidden"></div>
                    <div class="w-full flex flex-col gap-3 sm:gap-2 updateQuestion">
                        <div class="w-full flex flex-col gap-1">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700">{{ trans_message('question') }}</label>
                            <input type="text" name="visitor_qus[]"
                                   class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="{{ trans_message('question') }}"
                                   value="${question}">
                        </div>

                        <div class="w-full flex flex-col gap-1">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Answer</label>
                            <textarea name="visitor_ans[]"
                                    class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    rows="3"
                                    placeholder="{{ trans_message('answer') }}>${answer}</textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                            <button type="button" class="btn-primary px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2 w-full sm:w-auto">
                                {{ trans_message('add_more') }}
                </button>

                <div class="flex items-center space-x-1 sm:space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                    <button type="button" onclick="viewQuestion(this);" class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                            title="{{ trans_message('view') }}">
                                    <svg class="size-[16px] sm:size-[20px]"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" onclick="copyQuestion('visitor', this);" class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                        title="{{ trans_message('copy') }}">
                                    <svg class="size-[16px] sm:size-[20px]"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6ZM6.9998 11V13H12.9998V11H6.9998ZM6.9998 15V17H12.9998V15H6.9998Z">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" onclick="deleteQuestion(this);" class="cursor-pointer text-gray-400 hover:text-red-600 p-2 transition-all duration-200"
                                       title="{{ trans_message('delete') }}">
                                    <svg class="size-[16px] sm:size-[20px]"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`);
            }
            autoSaveForm();
        }

        $('form#faqForm').on('change input', 'input, textarea', function () {
            autoSaveForm();
        });

        function autoSaveForm(callback = null) {
            const form = document.getElementById('faqForm');
            const url = "{{ route('admin.settings.faq.action') }}";
            const formData = new FormData(form);

            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(function () {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        sendToast(response.message);

                        // Run callback if provided
                        if (typeof callback === 'function') {
                            callback();
                        }
                    },
                    // error: function (xhr) {
                    //     sendToast('Data save failed:' + xhr.responseText, "danger");
                    // }
                    error: function (xhr) {
                        sendToast('{{ trans_message("data_save_failed") }}: ' + xhr.responseText, "danger");
                    }
                });
            }, 2000);
        }

    </script>
@endsection
