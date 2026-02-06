@extends('admin.master')
@section('title', 'Settings')
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('admin.settings') }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>settings</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-500">Edit Video Tutorials and Guides</span>
    </div>
    <div class="pt-6 flex justify-between items-center xl:hidden">
        <span class="text-2xl font-semibold text-gray-800">Edit Video Tutorials and Guides</span>
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
                            <span class="hidden sm:inline">Mystery Visitor</span>
                            <span class="sm:hidden">Mystery</span>
                        </button>
                        <button type="button"
                                class="tab-btn change-type transition-all duration-300 font-medium text-xs sm:text-sm py-2 px-2 sm:px-3 rounded-full flex-1 sm:flex-none text-center"
                                data-tab="company">
                            Company
                        </button>
                    </nav>
                </div>
            </div>
            <div class="tab-content">
                <!-- Mystery Visitor Tab Content -->
                <div id="tab-mystery-visitor" class="tab-pane">
                    <div class="space-y-6 visitorData">
                        <!-- FAQ Item 1 -->
                        @if($visitor_guides)
                            @foreach($visitor_guides as $vk => $vguides)
                                <div class="mainDiv bg-white rounded-xl border border-gray-200 p-3 sm:p-4 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4 sm:mb-6"
                                     data-qid="{{ $vk }}" data-type="visitor_guides">
                                    <div class="viewQuestion hidden"></div>
                                    <div class="w-full flex flex-col gap-3 sm:gap-2 updateQuestion">
                                        <div class="w-full flex flex-col gap-1">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Title</label>
                                            <div class="flex gap-2">
                                                <input type="text"
                                                       name="visitor_qus[]"
                                                       class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="Title"
                                                       value="{{ $vguides['question'] }}">
                                                <button popovertarget="visits-visitor-edits-{{$vk}}"
                                                        class="flex items-center justify-center sm:size-[42px] size-[32px] border border-gray-300 rounded-lg questionTypeBtn">
                                                    <input type="hidden" name="visitor_ans[type][]" class="questionType"
                                                           value="{{ $vguides['answer']['type']??'code' }}">
                                                    <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <el-popover id="visits-visitor-edits-{{$vk}}" anchor="bottom-end"
                                                            popover=""
                                                            class="overflow-visible bg-white w-[170px] shadow-[0px_0px_12px_#0000001f] mt-2 py-2 border border-[#ebeef5] rounded-[20px] transition open:flex data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in"
                                                            aria-labelledby="popover-button-1" tabindex="-1"
                                                            style="--button-width: 20px;">
                                                    <div class="w-full flex flex-col questionTypeDropdown">
                                                        <button type="button" data-value="code" command="show-modal"
                                                                commandfor="edit-visit-model"
                                                                class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF] questionTypeDropdownBtn {{ $vguides['answer']['type']=='code'?'bg-gray-100':'' }}"
                                                                aria-expanded="false">
                                                            <span>Embed Code</span>
                                                        </button>
                                                        <button type="button" data-value="link"
                                                                class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] questionTypeDropdownBtn {{ $vguides['answer']['type']=='link'?'bg-gray-100':'' }}">
                                                            <span>External Link</span>
                                                        </button>
                                                        <button type="button" data-value="file"
                                                                class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] questionTypeDropdownBtn {{ $vguides['answer']['type']=='file'?'bg-gray-100':'' }}">
                                                            <span>Upload</span>
                                                        </button>
                                                    </div>
                                                </el-popover>
                                            </div>

                                            <div class="pt-3 flex flex-col gap-3">
                                                <textarea name="visitor_ans[code][]"
                                                          class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                          rows="3" placeholder="Enter or Paste Code"
                                                          style="{{ $vguides['answer']['type']=='code'?'':'display:none;' }}">{{ $vguides['answer']['code']??'' }}</textarea>
                                                <input type="url" name="visitor_ans[link][]"
                                                       value="{{ $vguides['answer']['link']??'' }}"
                                                       class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="Enter video url"
                                                       style="{{ $vguides['answer']['type']=='link'?'':'display:none;' }}">

                                                <!--- File --->
                                                <div class="flex items-center gap-2 fileDiv"
                                                     style="{{ $vguides['answer']['type']=='file'?'':'display:none;' }}">
                                                    <div class="fileInput size-[100px] bg-gray-100 border flex items-center relative justify-center brder-dashed border-gray-300 rounded-lg {{ (isset($vguides['answer']['file']) || !empty($vguides['answer']['file'])) ? 'hidden' : '' }}">
                                                        <!-- Progress Bar (Hidden by default) -->
                                                        <div class="progress-bar hidden absolute inset-0 flex items-center justify-center">
                                                            <div class="relative w-12 h-12">
                                                                <svg class="w-12 h-12 transform -rotate-90"
                                                                     viewBox="0 0 48 48">
                                                                    <circle cx="24" cy="24" r="18" stroke="#e5e7eb"
                                                                            stroke-width="4" fill="none"></circle>
                                                                    <circle cx="24" cy="24" r="18" stroke="#0073AF"
                                                                            stroke-width="4" fill="none"
                                                                            stroke-dasharray="113.097"
                                                                            stroke-dashoffset="113.097"
                                                                            class="progress-circle"></circle>
                                                                </svg>
                                                                <span class="absolute inset-0 flex items-center justify-center text-xs font-medium text-[#0073AF] progress-text">0%</span>
                                                            </div>
                                                        </div>

                                                        <!-- Upload Icon -->
                                                        <div class="upload-icon">
                                                            <svg class="size-[24px]" xmlns="http://www.w3.org/2000/svg"
                                                                 viewBox="0 0 24 24" fill="currentColor">
                                                                <path d="M4 5V19H20V7H11.5858L9.58579 5H4ZM12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM10 10.5C10 11.3284 9.32843 12 8.5 12C7.67157 12 7 11.3284 7 10.5C7 9.67157 7.67157 9 8.5 9C9.32843 9 10 9.67157 10 10.5ZM18 17L14 11L7 17H18Z"></path>
                                                            </svg>
                                                        </div>

                                                        <input type="file" name="visitor_ans[file][]" accept="video/*"
                                                               class="opacity-0 absolute inset-0 cursor-pointer file-upload-input">
                                                    </div>
                                                    <div class="fileData">
                                                        <input type="hidden" name="visitor_ans[old_file][]"
                                                               value="{{ isset($vguides['answer']['file'])? $vguides['answer']['file'] :'' }}">
                                                        @if(isset($vguides['answer']['file']))
                                                            <div class="flex items-center gap-2 bg-[#0073AF]/10 px-3 py-2 rounded-full uploaded-file">
                                                                <a href="{{asset(SETTING_PATH.$vguides['answer']['file'])}}"
                                                                   target="_blank"
                                                                   class="text-[#0073AF] text-sm font-medium" download>Download
                                                                    video</a>
                                                                <button type="button"
                                                                        class="cursor-pointer text-[#0073AF] hover:text-[#0073AF]/80 removeFile"
                                                                        data-id="{{ $vk }}" data-type="visitor_guides">
                                                                    <svg class="size-[16px]"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         viewBox="0 0 24 24" fill="currentColor">
                                                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                                            <button type="button" data-type="visitor"
                                                    class="add-more-btn cursor-pointer btn-primary px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2 w-full sm:w-auto">
                                                Add more
                                            </button>

                                            <div class="flex items-center space-x-1 sm:space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                                                <button type="button" onclick="viewQuestion('visitor', this);"
                                                        class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                                        title="View">
                                                    <svg class="size-[16px] sm:size-[20px]"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                         fill="currentColor">
                                                        <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button type="button" onclick="copyQuestion('visitor', this);"
                                                        class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                                        title="Copy">
                                                    <svg class="size-[16px] sm:size-[20px]"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                         fill="currentColor">
                                                        <path d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6ZM6.9998 11V13H12.9998V11H6.9998ZM6.9998 15V17H12.9998V15H6.9998Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button type="button" onclick="deleteQuestion(this);"
                                                        class="cursor-pointer text-gray-400 hover:text-red-600 p-2 transition-all duration-200"
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
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- Company Tab Content -->
                <div id="tab-company" class="tab-pane hidden">
                    <div class="space-y-4 sm:space-y-6 companyData">
                        <!-- FAQ Item 1 -->
                        @if($company_guides)
                            @foreach($company_guides as $ck => $cguides)
                                <div class="mainDiv bg-white rounded-xl border border-gray-200 p-3 sm:p-4 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4 sm:mb-6"
                                     data-qid="{{ $ck }}" data-type="company_guides">
                                    <div class="viewQuestion hidden"></div>
                                    <div class="w-full flex flex-col gap-3 sm:gap-2 updateQuestion">
                                        <div class="w-full flex flex-col gap-1">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Title</label>
                                            <div class="flex gap-2">
                                                <input type="text"
                                                       name="company_qus[]"
                                                       class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="Title"
                                                       value="{{ $cguides['question'] }}">
                                                <button type="button" popovertarget="visits-company-edits-{{$ck}}"
                                                        class="flex items-center justify-center sm:size-[42px] size-[32px] border border-gray-300 rounded-lg questionTypeBtn">
                                                    <input type="hidden" name="company_ans[type][]" class="questionType"
                                                           value="{{ $cguides['answer']['type']??'code' }}">
                                                    <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <el-popover id="visits-company-edits-{{$ck}}" anchor="bottom-end"
                                                            popover=""
                                                            class="overflow-visible bg-white w-[170px] shadow-[0px_0px_12px_#0000001f] mt-2 py-2 border border-[#ebeef5] rounded-[20px] transition open:flex data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in"
                                                            aria-labelledby="popover-button-1" tabindex="-1"
                                                            style="--button-width: 20px;">
                                                    <div class="w-full flex flex-col questionTypeDropdown">
                                                        <button type="button" data-value="code" command="show-modal"
                                                                commandfor="edit-visit-model"
                                                                class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF] questionTypeDropdownBtn {{ $cguides['answer']['type']=='code'?'bg-gray-100':'' }}"
                                                                aria-expanded="false">
                                                            <span>Embed Code</span>
                                                        </button>
                                                        <button type="button" data-value="link"
                                                                class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] questionTypeDropdownBtn {{ $cguides['answer']['type']=='link'?'bg-gray-100':'' }}">
                                                            <span>External Link</span>
                                                        </button>
                                                        <button type="button" data-value="file"
                                                                class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] questionTypeDropdownBtn {{ $cguides['answer']['type']=='file'?'bg-gray-100':'' }}">
                                                            <span>Upload</span>
                                                        </button>
                                                    </div>
                                                </el-popover>
                                            </div>

                                            <div class="pt-3 flex flex-col gap-3">
                                                <textarea name="company_ans[code][]"
                                                          class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                          rows="3" placeholder="Enter or Paste Code"
                                                          style="{{ $cguides['answer']['type']=='code'?'':'display:none;' }}">{{ $cguides['answer']['code']??'' }}</textarea>
                                                <input type="url" name="company_ans[link][]"
                                                       value="{{ $cguides['answer']['link']??'' }}"
                                                       class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="Enter video url"
                                                       style="{{ $cguides['answer']['type']=='link'?'':'display:none;' }}">

                                                <!--- File --->
                                                <div class="flex items-center gap-2 fileDiv"
                                                     style="{{ $cguides['answer']['type']=='file'?'':'display:none;' }}">
                                                    <div class="fileInput size-[100px] bg-gray-100 border flex items-center relative justify-center brder-dashed border-gray-300 rounded-lg {{ (isset($cguides['answer']['file']) || !empty($cguides['answer']['file'])) ? 'hidden' : '' }}">
                                                        <!-- Progress Bar (Hidden by default) -->
                                                        <div class="progress-bar hidden absolute inset-0 flex items-center justify-center">
                                                            <div class="relative w-12 h-12">
                                                                <svg class="w-12 h-12 transform -rotate-90"
                                                                     viewBox="0 0 48 48">
                                                                    <circle cx="24" cy="24" r="18" stroke="#e5e7eb"
                                                                            stroke-width="4" fill="none"></circle>
                                                                    <circle cx="24" cy="24" r="18" stroke="#0073AF"
                                                                            stroke-width="4" fill="none"
                                                                            stroke-dasharray="113.097"
                                                                            stroke-dashoffset="113.097"
                                                                            class="progress-circle"></circle>
                                                                </svg>
                                                                <span class="absolute inset-0 flex items-center justify-center text-xs font-medium text-[#0073AF] progress-text">0%</span>
                                                            </div>
                                                        </div>

                                                        <!-- Upload Icon -->
                                                        <div class="upload-icon">
                                                            <svg class="size-[24px]" xmlns="http://www.w3.org/2000/svg"
                                                                 viewBox="0 0 24 24" fill="currentColor">
                                                                <path d="M4 5V19H20V7H11.5858L9.58579 5H4ZM12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM10 10.5C10 11.3284 9.32843 12 8.5 12C7.67157 12 7 11.3284 7 10.5C7 9.67157 7.67157 9 8.5 9C9.32843 9 10 9.67157 10 10.5ZM18 17L14 11L7 17H18Z"></path>
                                                            </svg>
                                                        </div>

                                                        <input type="file" name="company_ans[file][]" accept="video/*"
                                                               class="opacity-0 absolute inset-0 cursor-pointer file-upload-input">
                                                    </div>
                                                    <div class="fileData">
                                                        <input type="hidden" name="company_ans[old_file][]"
                                                               value="{{ isset($cguides['answer']['file'])? $cguides['answer']['file'] :'' }}">
                                                        @if(isset($cguides['answer']['file']))
                                                            <div class="flex items-center gap-2 bg-[#0073AF]/10 px-3 py-2 rounded-full uploaded-file">
                                                                <a href="{{asset(SETTING_PATH.$cguides['answer']['file'])}}"
                                                                   target="_blank"
                                                                   class="text-[#0073AF] text-sm font-medium" download>Download
                                                                    video</a>
                                                                <button type="button"
                                                                        class="cursor-pointer text-[#0073AF] hover:text-[#0073AF]/80 removeFile"
                                                                        data-id="{{ $ck }}" data-type="company_guides">
                                                                    <svg class="size-[16px]"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         viewBox="0 0 24 24" fill="currentColor">
                                                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                                            <button type="button" data-type="company"
                                                    class="add-more-btn cursor-pointer btn-primary px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2 w-full sm:w-auto">
                                                Add more
                                            </button>

                                            <div class="flex items-center space-x-1 sm:space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                                                <button type="button" onclick="viewQuestion('company', this);"
                                                        class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                                        title="View">
                                                    <svg class="size-[16px] sm:size-[20px]"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                         fill="currentColor">
                                                        <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button type="button" onclick="copyQuestion('company', this);"
                                                        class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                                        title="Copy">
                                                    <svg class="size-[16px] sm:size-[20px]"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                         fill="currentColor">
                                                        <path d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6ZM6.9998 11V13H12.9998V11H6.9998ZM6.9998 15V17H12.9998V15H6.9998Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button type="button" onclick="deleteQuestion(this);"
                                                        class="cursor-pointer text-gray-400 hover:text-red-600 p-2 transition-all duration-200"
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
@section('style')
    <style>
        .progress-circle {
            transition: stroke-dashoffset 0.3s ease;
        }

        .progress-bar {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 0.5rem;
        }
    </style>
@endsection
@section('script')
    <script>
        let autoSaveTimer;

        $('form#faqForm').on('change input', 'input, textarea', function () {
            autoSaveForm();
        });

        $('.change-type').on('click', function (e) {
            var type = $(this).attr('data-tab');
            if (type === 'company') {
                $('#add-faq-btn').attr('data-type', 'company');
            } else {
                $('#add-faq-btn').attr('data-type', 'visitor');
            }
        });

        function createMainDiv(type, cardCount, question, questionType = 'code', answer = {}) {

            var cardHtml = `<div class="mainDiv bg-white rounded-xl border border-gray-200 p-3 sm:p-4 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4 sm:mb-6" data-qid="${cardCount}" data-type="${type}_guides">
                <div class="viewQuestion hidden"></div>
                <div class="w-full flex flex-col gap-3 sm:gap-2 updateQuestion">
                    <div class="w-full flex flex-col gap-1">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700">Title</label>
                        <div class="flex gap-2">
                            <input type="text"
                                   name="${type}_qus[]"
                                   class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Title"
                                   value="${question}">
                            <button popovertarget="visits-${type}-edits-${cardCount}"
                                    class="flex items-center justify-center sm:size-[42px] size-[32px] border border-gray-300 rounded-lg questionTypeBtn">
                                <input type="hidden" name="${type}_ans[type][]" class="questionType" value="${questionType}">
                                <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                    </path>
                                </svg>
                            </button>
                            <el-popover id="visits-${type}-edits-${cardCount}" anchor="bottom-end" popover=""
                                        class="overflow-visible bg-white w-[170px] shadow-[0px_0px_12px_#0000001f] mt-2 py-2 border border-[#ebeef5] rounded-[20px] transition open:flex data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in"
                                        aria-labelledby="popover-button-1" tabindex="-1"
                                        style="--button-width: 20px;">
                                <div class="w-full flex flex-col questionTypeDropdown">
                                    <button type="button" data-value="code" command="show-modal" commandfor="edit-visit-model"
                                            class="questionTypeDropdownBtn flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF] ${checkCondition(questionType, 'code', 'bg-gray-100', '')}"
                                            aria-expanded="false">
                                        <span>Embed Code</span>
                                    </button>
                                    <button type="button" data-value="link"
                                            class="questionTypeDropdownBtn flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] ${checkCondition(questionType, 'link', 'bg-gray-100', '')}">
                                        <span>External Link</span>
                                    </button>
                                    <button type="button" data-value="file"
                                            class="questionTypeDropdownBtn flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] ${checkCondition(questionType, 'file', 'bg-gray-100', '')}">
                                        <span>Upload</span>
                                    </button>
                                </div>
                            </el-popover>
                        </div>

                        <div class="pt-3 flex flex-col gap-3">
                            <textarea name="${type}_ans[code][]" class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    rows="3" placeholder="Enter or Paste Code" ${checkCondition(questionType, 'code', '', 'style="display:none;"')}>${answer.code ?? ''}</textarea>
                            <input type="url" name="${type}_ans[link][]" value="${answer.link ?? ''}"
                                   class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter video url" ${checkCondition(questionType, 'link', '', 'style="display:none;"')}>

                           <!--- File --->
                            <div class="flex items-center gap-2 fileDiv" ${checkCondition(questionType, 'file', '', 'style="display:none;"')}>
                                <div class="fileInput size-[100px] bg-gray-100 border flex items-center relative justify-center brder-dashed border-gray-300 rounded-lg">
                                    <!-- Progress Bar (Hidden by default) -->
                                    <div class="progress-bar hidden absolute inset-0 flex items-center justify-center">
                                        <div class="relative w-12 h-12">
                                            <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 48 48">
                                                <circle cx="24" cy="24" r="18" stroke="#e5e7eb" stroke-width="4" fill="none"></circle>
                                                <circle cx="24" cy="24" r="18" stroke="#0073AF" stroke-width="4" fill="none"
                                                        stroke-dasharray="113.097" stroke-dashoffset="113.097" class="progress-circle"></circle>
                                            </svg>
                                            <span class="absolute inset-0 flex items-center justify-center text-xs font-medium text-[#0073AF] progress-text">0%</span>
                                        </div>
                                    </div>

                                    <!-- Upload Icon -->
                                    <div class="upload-icon">
                                        <svg class="size-[24px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M4 5V19H20V7H11.5858L9.58579 5H4ZM12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM10 10.5C10 11.3284 9.32843 12 8.5 12C7.67157 12 7 11.3284 7 10.5C7 9.67157 7.67157 9 8.5 9C9.32843 9 10 9.67157 10 10.5ZM18 17L14 11L7 17H18Z"></path>
                                        </svg>
                                    </div>

                                    <input type="file" name="${type}_ans[file][]" accept="video/*" class="opacity-0 absolute inset-0 cursor-pointer file-upload-input">
                                </div>
                                <div class="fileData">
                                    <input type="hidden" name="${type}_ans[old_file][]" value="">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                        <button type="button" data-type="${type}"
                                class="add-more-btn cursor-pointer btn-primary px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2 w-full sm:w-auto">
                            Add more
                        </button>

                        <div class="flex items-center space-x-1 sm:space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                            <button type="button" onclick="viewQuestion('${type}', this);"
                                    class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                    title="View">
                                <svg class="size-[16px] sm:size-[20px]"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                    </path>
                                </svg>
                            </button>
                            <button type="button" onclick="copyQuestion('${type}', this);"
                                    class="cursor-pointer text-gray-400 hover:text-gray-600 p-2 transition-all duration-200"
                                    title="Copy">
                                <svg class="size-[16px] sm:size-[20px]"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6ZM6.9998 11V13H12.9998V11H6.9998ZM6.9998 15V17H12.9998V15H6.9998Z">
                                    </path>
                                </svg>
                            </button>
                            <button type="button" onclick="deleteQuestion(this);"
                                    class="cursor-pointer text-gray-400 hover:text-red-600 p-2 transition-all duration-200"
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
            </div>`;
            if (type === 'company') {
                $('.companyData').append(cardHtml)
            } else {
                $('.visitorData').append(cardHtml);
            }
        }

        $(document).ready(function () {
            // File upload handling
            $(document).on('change', '.file-upload-input', function (e) {
                const fileInput = $(this);
                const file = fileInput[0].files[0];

                if (!file) return;

                // Check if file is a video
                if (!file.type.startsWith('video/')) {
                    sendToast('Please select a video file', 'danger');
                    fileInput.val('');
                    return;
                }

                // Check file size (e.g., 50MB limit)
                const maxSize = 50 * 1024 * 1024; // 50MB in bytes
                if (file.size > maxSize) {
                    sendToast('Video file size must be less than 50MB', 'danger');
                    fileInput.val('');
                    return;
                }
                clearTimeout(autoSaveTimer);
                uploadFileWithProgress(fileInput, file);
            });

            $(document).delegate('.add-more-btn', 'click', function (e) {
                var type = $(this).attr('data-type');
                if (type === 'company') {
                    var lastMainDiv = $('.companyData .mainDiv').last();
                    var lastQid = lastMainDiv.data('qid');
                } else {
                    var lastMainDiv = $('.visitorData .mainDiv').last();
                    var lastQid = lastMainDiv.data('qid');
                }
                createMainDiv(type, (lastQid + 1), 'Question');
                autoSaveForm();
            });

        });

        function uploadFileWithProgress(fileInput, file) {
            const container = fileInput.closest('.fileInput');
            const progressBar = container.find('.progress-bar');
            const uploadIcon = container.find('.upload-icon');
            const progressCircle = container.find('.progress-circle');
            const progressText = container.find('.progress-text');
            const fileDataDiv = container.closest('.fileDiv').find('.fileData');
            const type = container.closest('.mainDiv').find('.questionType').val();
            const tabType = container.closest('.tab-pane').attr('id').includes('company') ? 'company' : 'visitor';
            // const qid = container.closest('.mainDiv').attr('data-qid');

            if (tabType === 'company') {
                const qid = $('.companyData .mainDiv').length;
            } else {
                const qid = $('.visitorData .mainDiv').length;
            }

            // Show progress bar, hide upload icon
            progressBar.removeClass('hidden');
            uploadIcon.addClass('hidden');

            const form = document.getElementById('faqForm');
            const url = "{{ route('admin.settings.guides.action') }}";
            const formData = new FormData(form);

            $.ajax({
                url: '{{ route("admin.settings.guides.action") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    const xhr = new window.XMLHttpRequest();

                    // Upload progress
                    xhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            const percentComplete = (e.loaded / e.total) * 100;
                            updateProgressBar(progressCircle, progressText, percentComplete);
                        }
                    }, false);

                    return xhr;
                },
                success: function (response) {
                    // Upload complete - hide progress bar
                    progressBar.addClass('hidden');

                    // Hide file input, show uploaded file
                    container.addClass('hidden');

                    // Fetch the uploaded file details
                    setTimeout(function () {
                        fetchUploadedFile(fileDataDiv, tabType, qid, container);
                        container.find('input[type="file"]').val('');
                    }, 1000);

                    sendToast('Video uploaded successfully!');
                },
                error: function (xhr, status, error) {
                    // Reset on error
                    progressBar.addClass('hidden');
                    uploadIcon.removeClass('hidden');
                    fileInput.val('');

                    let errorMessage = 'Upload failed';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    sendToast(errorMessage, 'danger');
                }
            });
        }

        function updateProgressBar(progressCircle, progressText, percent) {
            const circumference = 2 * Math.PI * 18; // 18 is the radius
            const offset = circumference - (percent / 100) * circumference;

            progressCircle.css('stroke-dashoffset', offset);
            progressText.text(Math.round(percent) + '%');
        }

        function fetchUploadedFile(fileDataDiv, type, questionIndex, fileInput) {
            $.ajax({
                url: '{{ route("admin.settings.guides.get.file") }}',
                method: 'POST',
                dataType: "JSON",
                data: {
                    type: type + '_guides',
                    id: questionIndex,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status) {
                        const file = response.message.file;
                        const fileUrl = response.message.url;

                        fileDataDiv.removeClass('hidden');
                        // Create the uploaded file display
                        const fileHtml = `<input type="hidden" name="${type}_ans[old_file][]" value="${file}">
                            <div class="flex items-center gap-2 bg-[#0073AF]/10 px-3 py-2 rounded-full uploaded-file">
                                <a href="${fileUrl}" target="_blank" class="text-[#0073AF] text-sm font-medium" download>Download video</a>
                                <button type="button" class="cursor-pointer text-[#0073AF] hover:text-[#0073AF]/80 removeFile" data-id="${questionIndex}" data-type="${type}_guides">
                                    <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path>
                                    </svg>
                                </button>
                            </div>
                        `;

                        fileDataDiv.html(fileHtml);

                        // Trigger auto-save to persist the changes
                        autoSaveForm();
                    } else {
                        sendToast('Failed to fetch uploaded file details', 'danger');
                    }
                },
                error: function (xhr, status, error) {
                    sendToast('Error fetching uploaded file details', 'danger');
                    console.error('Error fetching file details:', error);
                }
            });
        }

        // Add event listeners for dropdown option selection
        $(document).on('click', '.questionTypeDropdownBtn', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const selectedValue = $(this).attr('data-value');
            const dropdownWrapper = $(this).closest('.questionTypeDropdown');

            dropdownWrapper.find('button').removeClass('bg-gray-100');
            $(this).addClass('hover:bg-[#EFF6FF]');
            $(this).addClass('bg-gray-100');

            // Update the hidden input field
            const mainDiv = $(this).closest('.mainDiv');
            mainDiv.find('.questionType').val(selectedValue);

            // Optional: Update placeholder or UI dynamically
            const textarea = mainDiv.find('textarea');
            const urlInput = mainDiv.find('input[type="url"]');
            const fileInput = mainDiv.find('input[type="file"]');

            // Hide/show based on selected type
            textarea.toggle(selectedValue === 'code');
            urlInput.toggle(selectedValue === 'link');
            fileInput.closest('.fileDiv').toggle(selectedValue === 'file');

            autoSaveForm();
        });

        function viewQuestion(type, button) {
            const container = $(button).closest('.mainDiv');
            const question = container.find('input[name="' + type + '_qus[]"]').val();
            const questionType = container.find('input[name="' + type + '_ans[type][]"]').val();
            const questionCode = container.find('textarea[name="' + type + '_ans[code][]"]').val();
            const questionLink = container.find('input[name="' + type + '_ans[link][]"]').val();
            const questionFile = container.find('input[name="' + type + '_ans[old_file][]"]').val();

            let newOptionHtml = `
                <div class="flex font-medium justify-between questionTitle text-[17px]" onclick="editQuestion(this);">
                    <span>${question}</span>
                    <svg width="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289Z" fill="#0F1729"></path> </g></svg>
                </div>
                <hr class="border-gray-300 my-2">
                <div class="w-full" onclick="editQuestion(this);">`;
            if (questionType === 'code') {
                newOptionHtml += `${questionCode}`;
            }
            if (questionType === 'link') {
                newOptionHtml += `${questionLink}`;
            }
            if (questionType === 'file' && questionFile !== '') {
                var fileUrl = "{{ asset(SETTING_PATH) }}/" + questionFile;
                newOptionHtml += `<div class="flex items-center">
                            <div class="flex items-center gap-2 bg-[#0073AF]/10 px-3 py-2 rounded-full uploaded-file">
                                <a href="${fileUrl}" target="_blank" class="text-[#0073AF] text-sm font-medium" download>Download video</a>
                            </div>
                        </div>
                        `;
            }
            newOptionHtml += `</div>`;

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
            const question = container.find('input[name="' + type + '_qus[]"]').val();
            const questionType = container.find('input[name="' + type + '_ans[type][]"]').val();
            const questionCode = container.find('textarea[name="' + type + '_ans[code][]"]').val();
            const questionLink = container.find('input[name="' + type + '_ans[link][]"]').val();

            const ans = {'code': questionCode, 'link': questionLink};
            if (type === 'company') {
                var lastMainDiv = $('.companyData .mainDiv').last();
                var lastQid = lastMainDiv.data('qid');
            } else {
                var lastMainDiv = $('.visitorData .mainDiv').last();
                var lastQid = lastMainDiv.data('qid');
            }
            createMainDiv(type, (lastQid + 1), question, questionType, ans);
            autoSaveForm();
        }

        function autoSaveForm(callback = null) {
            const form = document.getElementById('faqForm');
            const url = "{{ route('admin.settings.guides.action') }}";
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
                    error: function (xhr) {
                        // sendToast('Data save failed:' + xhr.responseText, "danger");
                    }
                });
            }, 2000);
        }

        function checkCondition(var1, var2, val, else_val = '') {
            const arr1 = Array.isArray(var1) ? var1 : [var1];
            const arr2 = Array.isArray(var2) ? var2 : [var2];

            const allMatch = arr1.every(v1 => arr2.includes(v1));

            return allMatch ? val : else_val;
        }

        $(document).delegate('.removeFile', 'click', function (e) {
            e.preventDefault();
            var el = $(this);
            var id = $(this).attr('data-id');
            var type = $(this).attr('data-type');
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to remove this file?",
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
                        url: "{{ route('admin.settings.guides.file.delete') }}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "type": type,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            el.attr('disabled', true);
                        },
                        success: function (data) {
                            el.closest('.fileData').find('input[name="visitor_ans[old_file][]"]').val('');
                            el.closest('.fileData').find('input[name="company_ans[old_file][]"]').val('');
                            el.closest('.fileData').addClass('hidden');
                            el.closest('.fileDiv').find('.fileInput').removeClass('hidden');
                            el.closest('div').remove();
                            autoSaveForm();
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
                            el.attr('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
@endsection
