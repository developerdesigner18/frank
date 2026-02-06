@extends('admin.master')
@section('title','Questionnaires')
@push('navbar')
    <div class="pt-6 flex lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">Visit Form</span>
    </div>
@endpush
@section('style')
    <style>
        /* Custom Checkbox Styles */
        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            background-color: #ffffff;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .custom-checkbox:hover {
            border-color: #0073AF;
            box-shadow: 0 0 0 3px rgba(0, 115, 175, 0.1);
        }

        .custom-checkbox:checked {
            background-color: #0073AF;
            border-color: #0073AF;
        }

        .custom-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 2px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .custom-checkbox:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 115, 175, 0.2);
        }

        .custom-checkbox-label {
            user-select: none;
        }

        .custom-checkbox-text {
            font-weight: 500;
            color: #374151;
            transition: color 0.2s ease;
        }

        .custom-checkbox:checked + .custom-checkbox-text {
            color: #0073AF;
            font-weight: 600;
        }

        .custom-checkbox-container:hover .custom-checkbox-text {
            color: #0073AF;
        }

        /* Comment Section Styles */
        .comment-textarea {
            min-height: 120px;
            font-family: inherit;
            line-height: 1.5;
        }

        .comment-textarea::placeholder {
            color: #9ca3af;
            font-style: italic;
        }

        .comment-textarea:focus::placeholder {
            color: #d1d5db;
        }

        .comment-btn {
            min-width: 80px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .comment-btn-cancel:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .comment-btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .comment-btn:active {
            transform: translateY(0);
        }

        .comment-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Photo Upload Section Styles */

        .upload-dropzone {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 3rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #fafafa;
            position: relative;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .upload-dropzone:hover {
            border-color: #0073AF;
            background-color: #f0f9ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 115, 175, 0.15);
        }

        .upload-dropzone.dragover {
            border-color: #0073AF;
            background-color: #e0f2fe;
            transform: scale(1.02);
        }

        .upload-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .upload-icon {
            position: relative;
            display: inline-block;
        }

        .upload-icon svg {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .upload-text p {
            margin: 0;
        }

        .upload-text p:first-child {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .upload-text p:last-child {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .photo-preview {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 200px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            background-color: #f9fafb;
            overflow: hidden;
        }

        .uploaded-image {
            max-width: 100%;
            max-height: 300px;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .remove-photo-btn {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background-color: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .remove-photo-btn:hover {
            background-color: #dc2626;
            transform: scale(1.1);
        }

        .remove-photo-btn:active {
            transform: scale(0.95);
        }

        /* File input styling */
        #photoInput {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Animation for photo preview */
        .photo-preview.show {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive design */
        @media (max-width: 640px) {
            .upload-dropzone {
                padding: 2rem 1rem;
                min-height: 150px;
            }

            .upload-icon svg {
                width: 3rem;
                height: 3rem;
            }

            .upload-text p:first-child {
                font-size: 1rem;
            }
        }
    </style>
@endsection
@section('main')
    <section class="pt-4 sm:pt-6">

        <!-- Header Section -->
        <div
            class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200 p-4 mb-6 shadow-sm">
            <!-- Title with Enhanced Styling -->
            <div class="text-center mb-4">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    {{--                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">--}}
                    {{--                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />--}}
                    {{--                    </svg>--}}
                    <img src="{{ $visit->branch->image }}" class="h-[100%] rounded-full">
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $visit->branch->branch_name }}</h1>
                <p class="text-gray-600 text-lg">Questionnaire Response Form</p>
            </div>

            <!-- Enhanced Status Cards -->
            <div class="flex flex-wrap items-center justify-center gap-4 mb-4">
                <div
                    class="flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm text-gray-700 rounded-full text-sm font-medium shadow-sm">
                    <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                    {{ $visit->questionnaire->name }}
                </div>
                @if($visit->published == 1)
                    <div class="flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-medium shadow-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        Active
                    </div>
                @else
                    <div class="flex items-center gap-2 px-4 py-2 bg-red-100 text-red-700 rounded-full text-sm font-medium shadow-sm">
                        <svg class="w-3 h-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g id="inactive">
                                <path d="M13.6,23.9c-7.8,1-14.5-5.6-13.5-13.5c0.7-5.3,5-9.7,10.3-10.3c7.8-1,14.5,5.6,13.5,13.5C23.2,18.9,18.9,23.2,13.6,23.9z M13.7,2.1C6.9,1,1,6.9,2.1,13.7c0.7,4.1,4,7.5,8.2,8.2C17.1,23,23,17.1,21.9,10.3C21.2,6.2,17.8,2.8,13.7,2.1z"/>
                                <polyline points="5.6,4.2 19.8,18.3 18.4,19.8 4.2,5.6"/>
                            </g>
                        </svg>
                        Inactive
                    </div>
                @endif
                @if($visit->status->name !== 'PENDING' && $visit->status->name !== 'COMPLETED')
                    <div class="flex items-center gap-2 px-2 py-2 bg-orange-100 text-orange-700 rounded-full text-sm font-medium shadow-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                        {{--                        In Progress--}}
                    </div>
                @endif
            </div>

            <!-- Enhanced Breadcrumb -->
            <div class="text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/60 backdrop-blur-sm rounded-lg text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                    {{ $visit->branch->branch_name }}, {{ $visit->branch->address_1 }}
                    , {{ $visit->branch->postal_code }} {{ $visit->branch->locality }}
                </div>
            </div>
        </div>

        <form method="post" id="questionForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="title" name="title" value="{{$questionnaire->name}}">
            <input type="hidden" class="visit_id" name="visit_id" value="{{ $visit->id }}">
            <input type="hidden" class="user_id" name="user_id" value="{{ $visit->visitor_id??'' }}">
            <input type="hidden" name="branch_id" value="{{ $visit->branch_id }}">
            <div class="w-full">
                @if($payload['categories'] && count($payload['categories']) > 0)
                    @foreach($payload['categories'] as $cat_k => $category)
                        <input type="hidden" name="category[{{ $category['id'] }}]" value="{{ $category['name'] }}">
                        <!-- Niho! View 1 -->
                        <div class="view-content {{ $cat_k>0?'hidden':'' }}" id="niho-view-{{$cat_k}}">
                            <div class="text-center mb-6 relative">
                                <div class="flex items-center justify-center gap-2 mb-4">
                                    @if($cat_k>0)
                                        <!-- Arrow prevView -->
                                        <button type="button" onclick="showPrevView()"
                                                class="cursor-pointer absolute left-0 bg-gray-100 hover:bg-gray-200 rounded-lg p-2 transition-colors">
                                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                      d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    <span class="flex text-2xl font-semibold text-gray-800">
                                        {!! (isset($category['imageUrl']) && $category['imageUrl']) ? '<img src="'.$category['imageUrl'].'" alt="'.$category['name'].'" class="size-[30px] object-contain" />' : '' !!}
                                        {{ $category['name'] }}
                                    </span>
                                    <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    @if((count($payload['categories'])-1)!==$cat_k)
                                        <!-- Arrow next -->
                                        <button type="button" onclick="showNextView()"
                                                class="cursor-pointer absolute right-0 bg-gray-100 hover:bg-gray-200 rounded-lg p-2 transition-colors">
                                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                                <div class="w-full h-1 bg-green-400 rounded-full mb-6"></div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                @if(isset($category['questions']))
                                    @foreach($category['questions'] as $question)
                                        @php
                                            $question_id = $question['id'];
                                            $report_response_data = [];
                                            $report_result = $old_photos = [];

                                            if(isset($old_questions[$question['categoryId']])){
                                                $report_response_data = $old_questions[$question['categoryId']];
                                                $report_result = array_values(array_filter($report_response_data, function ($item) use ($question_id) {
                                                    if (gettype($item)=='array'){
                                                        return $item['qId'] == $question_id;
                                                    }else{
                                                        return $item->qId == $question_id;
                                                    }
                                                }));
                                                $report_result = (isset($report_result[0]))?(array)$report_result[0]:[];
                                                $old_photos = (!empty($report_result) && $report_result['photo'])?$report_result['photo']:[];
                                            }

                                            // Get all option texts
                                            $allOptionTexts = array_map(function($opt) {
                                                return $opt['text'];
                                            }, $question['options']??[]);

                                            // Get all option scores
                                            $allOptionScores = array_map(function($opt) {
                                                return $opt['score'];
                                            }, $question['options']??[]);

                                            $min = $allOptionScores? min($allOptionScores):0;
                                            $max = $allOptionScores? max($allOptionScores):0;
                                            $step = count($allOptionScores) > 1 ? ($max - $min) / (count($allOptionScores) - 1) : 1;

                                            $isRequired = false;
                                            $isReadonly = false;
                                            if(isset($report_result)) {
                                                if(isset($report_result['na'])){
                                                    if($report_result['na'] == '0') {
                                                        $isRequired = true;
                                                    }
                                                    if($report_result['na'] == '1') {
                                                        $isReadonly = true;
                                                    }
                                                }
                                            } elseif($question['required'] == true) {
                                                $isRequired = true;
                                            }
                                        @endphp
                                        <input type="hidden" name="question[{{ $question['id'] }}][categoryId]"
                                               value="{{ $question['categoryId'] }}">
                                        <input type="hidden" name="question[{{ $question['id'] }}][categoryName]"
                                               value="{{ $category['name'] }}">
                                        <input type="hidden" name="question[{{ $question['id'] }}][title]"
                                               value="{{ $question['title'] }}">
                                        <input type="hidden" name="question[{{ $question['id'] }}][type]"
                                               value="{{ $question['type'] }}">
                                        <input type="hidden" name="question[{{ $question['id'] }}][max]"
                                               value="{{ $max }}">
                                        <div class="border border-gray-300 md:px-30 lg:px-20 xl:px-60 p-[20px] rounded-lg text-center w-full question-container">
                                            <span class="font-semibold text-black">{{ $question['title'] }}</span>
                                            <hr class="border-gray-300 my-2">
                                            @if ($question['type']==='RADIO' || $question['type']==='SELECT')
                                                <div class="w-full mt-4 flex justify-center gap-0">
                                                    @if($allOptionTexts)
                                                        @foreach($allOptionTexts as $optKey => $optVal)
                                                            <div class="flex items-center justify-center">
                                                                <input type="radio"
                                                                       id="opt-{{ $question['id'] }}-{{ $optKey }}"
                                                                       name="question[{{ $question['id'] }}][answer]"
                                                                       value="{{ $optVal }},({{ $allOptionScores[$optKey]??0 }})"
                                                                       {{ (isset($report_result['answer']) && $report_result['answer']==$optVal)?'checked':'' }}
                                                                       {{ $isReadonly ? 'disabled="disabled"' : '' }}
                                                                       class="hidden peer">
                                                                <label for="opt-{{ $question['id'] }}-{{ $optKey }}" class="cursor-pointer transition-all duration-200 p-2 rounded-lg peer-checked:ring-4 peer-checked:ring-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50 opacity-100">
                                                                    @if($question['type'] === 'RADIO')
                                                                        <img src="{{ asset('assets/emojis/glossy') }}/{{ ['00.png', '01.png'][$optKey] ?? '00.png' }}" alt="{{ $optVal??'' }}" class="w-12 h-12 object-contain rounded-full">
                                                                    @else
                                                                        {{ $optVal??'' }}
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endif
                                            @if ($question['type']==='SLIDER')
                                                @php
                                                    $defaultValue = (isset($report_result['answer']) && $report_result['answer'] != '' ? $report_result['answer'] : null);
                                                @endphp
                                                <div class="mt-4">
                                                    <!-- Emoji Radio Buttons for Slider -->
                                                    <div class="flex justify-center items-center gap-1 flex-wrap">
                                                        @foreach($allOptionTexts as $index => $text)
                                                            @php
                                                                $score = $allOptionScores[$index];
                                                                $isChecked = ($defaultValue == $score);
                                                            @endphp
                                                            <div class="flex flex-col items-center">
                                                                <input type="radio"
                                                                       id="slider-opt-{{ $question['id'] }}-{{ $index }}"
                                                                       name="question[{{ $question['id'] }}][answer]"
                                                                       value="{{ $score }}"
                                                                       class="hidden peer"
                                                                    {{ $isChecked ? 'checked' : '' }}
                                                                    {{ $isReadonly ? 'disabled="disabled"' : '' }}>

                                                                <label for="slider-opt-{{ $question['id'] }}-{{ $index }}"
                                                                       class="cursor-pointer transition-all duration-200 hover:scale-105 peer-checked:ring-4 peer-checked:ring-blue-500 peer-checked:scale-110 opacity-100 rounded-full">
                                                                    <img src="{{ asset('assets/emojis/glossy') }}/{{ ['00.png', '04.png', '03.png', '02.png', '01.png'][$index] ?? '00.png' }}" alt="{{ $text }}" class="w-12 h-12 object-contain rounded-full">
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($question['type']==='AMOUNT')
                                                <div class="relative mt-4">
                                                    <input type="number" id="hs-leading-icon"
                                                           name="question[{{ $question['id'] }}][answer]"
                                                           value="{{ isset($report_result['answer'])?$report_result['answer']:'' }}"
                                                           class="block border border-gray-200 disabled:opacity-50 disabled:pointer-events-none focus:border-blue-500 focus:outline-none focus:ring-blue-500 focus:z-10 ps-11 px-4 py-2.5 rounded-lg sm:py-3 sm:text-sm w-full"
                                                           placeholder="0"
                                                        {{ $isReadonly ? 'readonly="readonly"' : '' }} >
                                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                        {{ currency_icon() }}
                                                    </div>
                                                </div>

                                                <div class="image-container mt-3">
                                                    <div class="image-preview border border-gray-300 my-2 p-3 rounded-[8px] md:h-[310px] relative {{ !isset($report_result['answer_image']) || empty($report_result['answer_image']) ? 'hidden' : '' }}">
                                                        <img src="{{ isset($report_result['answer_image'])?$report_result['answer_image']:'' }}"
                                                             alt="Preview" class="h-[100%] w-full object-cover">
                                                        <button type="button"
                                                                class="absolute bg-red-500 cursor-pointer h-5 remove-image-btn right-1 rounded-full text-white top-1 w-5"
                                                                data-image="{{ isset($report_result['answer_image'])?$report_result['answer_image']:'' }}">
                                                            &times;
                                                        </button>
                                                    </div>
                                                    <label class="flex items-center gap-4 mb-3 cursor-pointer image-input justify-center {{ !isset($report_result['answer_image']) || empty($report_result['answer_image']) ?'':'hidden' }}">
                                                        <div class="size-[100px] bg-gray-100 border flex items-center justify-center border-dashed border-gray-300 rounded-lg overflow-hidden relative">
                                                            <svg class="size-[24px] text-gray-400"
                                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                 fill="currentColor">
                                                                <path d="M4 5V19H20V7H11.5858L9.58579 5H4ZM12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM10 10.5C10 11.3284 9.32843 12 8.5 12C7.67157 12 7 11.3284 7 10.5C7 9.67157 7.67157 9 8.5 9C9.32843 9 10 9.67157 10 10.5ZM18 17L14 11L7 17H18Z"></path>
                                                            </svg>
                                                            <img class="absolute inset-0 w-full h-full object-cover hidden"
                                                                 alt="preview">
                                                        </div>
                                                        <input type="file" accept="image/*"
                                                               name="question[{{ $question['id'] }}][answer_image]"
                                                               class="hidden question_image">
                                                    </label>
                                                    <input type="hidden"
                                                           name="question[{{ $question['id'] }}][answer_old_image]"
                                                           value="{{ !isset($report_result['answer_image']) || empty($report_result['answer_image']) ?'':$report_result['answer_image'] }}"
                                                           class="hidden answer_old_image">
                                                </div>
                                            @endif
                                            @if ($question['type']==='TEXT')
                                                <div class="mt-4">
                                                    <input type="text" name="question[{{ $question['id'] }}][answer]"
                                                           value="{{ isset($report_result['answer'])?$report_result['answer']:'' }}"
                                                           placeholder="Enter Text"
                                                           {{ $isReadonly ? 'readonly="readonly"' : '' }}
                                                           class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>
                                            @endif
                                            @if ($question['type']==='COMMENT')
                                                <div class="mt-4">
                                                    <textarea rows="3" name="question[{{ $question['id'] }}][answer]"
                                                              placeholder="Enter Comment"
                                                              {{ $isReadonly ? 'readonly="readonly"' : '' }}
                                                              class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ isset($report_result['answer'])?$report_result['answer']:'' }}</textarea>
                                                </div>
                                            @endif
                                            <hr class="border-gray-300 my-2">
                                            <div class="modern-card">
                                                <input type="hidden"
                                                       name="question[{{ $question['id'] }}][comment_type]"
                                                       class="input_comment"
                                                       value="{{ (isset($report_result['comment_type']))?$report_result['comment_type']:'' }}">
                                                <div class="flex justify-center items-center gap-2">
                                                    <div class="flex items-center gap-3">
                                                        <button type="button" data-type="comment"
                                                                class="tab-btn commentBtn text-xs py-1.5 px-2.5 flex items-center gap-2 cursor-pointer !text-gray-700 !bg-transparent active"
                                                                data-tab="comments-{{ $question['id'] }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                 fill="currentColor" class="size-[18px]">
                                                                <path d="M14.45 19L12 22.5L9.55 19H3C2.73478 19 2.48043 18.8946 2.29289 18.7071C2.10536 18.5196 2 18.2652 2 18V4C2 3.73478 2.10536 3.48043 2.29289 3.29289C2.48043 3.10536 2.73478 3 3 3H21C21.2652 3 21.5196 3.10536 21.7071 3.29289C21.8946 3.48043 22 3.73478 22 4V18C22 18.2652 21.8946 18.5196 21.7071 18.7071C21.5196 18.8946 21.2652 19 21 19H14.45ZM13.409 17H20V5H4V17H10.591L12 19.012L13.409 17Z">
                                                                </path>
                                                            </svg>
                                                            Comments
                                                        </button>
                                                        <button type="button" data-type="photo"
                                                                class="tab-btn commentBtn text-xs py-1.5 px-2.5 flex items-center gap-2 cursor-pointer !text-gray-700 !bg-transparent"
                                                                data-tab="photo-{{ $question['id'] }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                 fill="currentColor" class="size-[18px]">
                                                                <path d="M4 5V19H20V7H11.5858L9.58579 5H4ZM12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM10 10.5C10 11.3284 9.32843 12 8.5 12C7.67157 12 7 11.3284 7 10.5C7 9.67157 7.67157 9 8.5 9C9.32843 9 10 9.67157 10 10.5ZM18 17L14 11L7 17H18Z">
                                                                </path>
                                                            </svg>
                                                            Photo
                                                        </button>
                                                        <div class="custom-checkbox-container text-xs !text-gray-700 !bg-transparent">
                                                            <label class="custom-checkbox-label flex items-center gap-2 cursor-pointer hover:bg-gray-50 rounded-md px-2 py-1 transition-colors duration-200">
                                                                <input type="checkbox"
                                                                       name="question[{{ $question['id'] }}][na]"
                                                                       value="1" id="checkbox"
                                                                       {{ (isset($report_result['na']) && $report_result['na']==1)?'checked':'' }}
                                                                       class="custom-checkbox na-checkbox"
                                                                       data-type="{{ $question['type'] }}"
                                                                       data-id="{{ $question['id'] }}">
                                                                <span class="custom-checkbox-text">N/A</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-content">
                                                    <!-- This Week Tab Content -->
                                                    <div id="tab-comments-{{ $question['id'] }}"
                                                         class="tab-pane {{ (isset($report_result['comment_type'])) && $report_result['comment_type']=='comment'?'':'hidden' }}">
                                                        <div class="pt-4 sm:pt-6">
                                                            <div class="comment-section bg-white">
                                                                <div class="pb-4">
                                                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                                                        Add Comment
                                                                    </h3>
                                                                    <p class="text-sm text-gray-500">Share your thoughts
                                                                        or feedback</p>
                                                                </div>

                                                                <div class="comment-form flex flex-col">
                                                                    <textarea
                                                                        class="comment-textarea w-full p-4 border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                                                        name="question[{{ $question['id'] }}][comment]"
                                                                        rows="6" placeholder="Add Comment Here..."
                                                                        id="commentText">{{ isset($report_result['comment'])?$report_result['comment']:'' }}</textarea>

                                                                    <div class="flex justify-end gap-3 mt-4">
                                                                        <button type="button"
                                                                                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 commentBtn"
                                                                                data-type="">
                                                                            Cancel
                                                                        </button>
                                                                        {{--                                                                        <button type="button"--}}
                                                                        {{--                                                                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg hover:shadow-xl"--}}
                                                                        {{--                                                                                onclick="saveComment()">--}}
                                                                        {{--                                                                            Save--}}
                                                                        {{--                                                                        </button>--}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- This Month Tab Content -->
                                                    <div id="tab-photo-{{ $question['id'] }}"
                                                         class="tab-pane {{ (isset($report_result['comment_type'])) && $report_result['comment_type']=='photo'?'':'hidden' }}">
                                                        <div class="pt-4 sm:pt-6">
                                                            <div class="photo-upload-section">
                                                                <div class="mb-4">
                                                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                                                        Upload Photo
                                                                    </h3>
                                                                    <p class="text-sm text-gray-500">Select or drag and
                                                                        drop an image file</p>
                                                                </div>

                                                                <div class="photo-upload-area flex flex-col">

                                                                    {{--                                                                    <div class="upload-dropzone border-2 border-dashed border-gray-300 rounded-lg p-6 cursor-pointer text-center upload-box"--}}
                                                                    {{--                                                                         data-id="{{ $question['id'] }}"--}}
                                                                    {{--                                                                         data-visit_id="{{ $visit->id }}"--}}
                                                                    {{--                                                                         data-cat_id="{{ $question['categoryId'] }}">--}}
                                                                    {{--                                                                        <div class="upload-content">--}}
                                                                    {{--                                                                            <div class="upload-icon">--}}
                                                                    {{--                                                                                <svg xmlns="http://www.w3.org/2000/svg"--}}
                                                                    {{--                                                                                     viewBox="0 0 24 24"--}}
                                                                    {{--                                                                                     fill="currentColor"--}}
                                                                    {{--                                                                                     class="w-16 h-16 text-gray-400 mx-auto">--}}
                                                                    {{--                                                                                    <path--}}
                                                                    {{--                                                                                            d="M4 5V19H20V7H11.5858L9.58579 5H4ZM12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM10 10.5C10 11.3284 9.32843 12 8.5 12C7.67157 12 7 11.3284 7 10.5C7 9.67157 7.67157 9 8.5 9C9.32843 9 10 9.67157 10 10.5ZM18 17L14 11L7 17H18Z" />--}}
                                                                    {{--                                                                                    <circle cx="18" cy="6" r="2" fill="white" stroke="currentColor" stroke-width="1" />--}}
                                                                    {{--                                                                                </svg>--}}
                                                                    {{--                                                                            </div>--}}
                                                                    {{--                                                                            <div class="upload-text mt-3">--}}
                                                                    {{--                                                                                <p class="text-gray-600 font-medium">Click to upload or drag and drop</p>--}}
                                                                    {{--                                                                                <p class="text-sm text-gray-400 mt-1">PNG, JPG, GIF up to 10MB each</p>--}}
                                                                    {{--                                                                            </div>--}}
                                                                    {{--                                                                        </div>--}}

                                                                    {{--                                                                        <input type="file"--}}
                                                                    {{--                                                                               class="hidden photo-input"--}}
                                                                    {{--                                                                               name="question[{{ $question['id'] }}][photo][]"--}}
                                                                    {{--                                                                               accept="image/*"--}}
                                                                    {{--                                                                               multiple />--}}
                                                                    {{--                                                                    </div>--}}
                                                                    <label class="flex items-center gap-4 mb-3 cursor-pointer image-input justify-center">
                                                                        <div class="size-[100px] bg-gray-100 border flex items-center justify-center border-dashed border-gray-300 rounded-lg overflow-hidden relative">
                                                                            <svg class="size-[24px] text-gray-400"
                                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                                 viewBox="0 0 24 24"
                                                                                 fill="currentColor">
                                                                                <path d="M4 5V19H20V7H11.5858L9.58579 5H4ZM12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM10 10.5C10 11.3284 9.32843 12 8.5 12C7.67157 12 7 11.3284 7 10.5C7 9.67157 7.67157 9 8.5 9C9.32843 9 10 9.67157 10 10.5ZM18 17L14 11L7 17H18Z"></path>
                                                                            </svg>
                                                                            <img class="absolute inset-0 w-full h-full object-cover hidden"
                                                                                 alt="preview">
                                                                        </div>

                                                                        <input type="file"
                                                                               accept="image/*"
                                                                               name="question[{{ $question['id'] }}][photo][]"
                                                                               multiple
                                                                               class="hidden photo-input-image"
                                                                               data-visit_id="{{ $visit->id }}"
                                                                               data-id="{{ $question['id'] }}"
                                                                               data-cat_id="{{ $question['categoryId'] }}">
                                                                    </label>

                                                                    <!-- Preview container -->
                                                                    <div id="previewContainer"
                                                                         class="previewContainer mt-4 grid grid-cols-2 md:grid-cols-4 gap-3">
                                                                        @if($old_photos)
                                                                            @foreach($old_photos as $oldImg)
                                                                                <div class="relative group">
                                                                                    <input type="hidden"
                                                                                           name="question[{{ $question['id'] }}][old_photo][]"
                                                                                           value="{{ $oldImg }}">
                                                                                    <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}"
                                                                                         class="w-full h-32 object-cover rounded-lg shadow-sm border">
                                                                                    <button type="button"
                                                                                            data-image="{{ $oldImg }}"
                                                                                            class="cursor-pointer absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 text-xs group-hover:flex items-center justify-center comment-image-remove-btn"
                                                                                            title="Remove">×
                                                                                    </button>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>


                                                                    <div class="flex justify-end gap-3 mt-6">
                                                                        <button type="button"
                                                                                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 commentBtn"
                                                                                data-type="">
                                                                            Cancel
                                                                        </button>
                                                                        {{--                                                                        <button type="button"--}}
                                                                        {{--                                                                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg hover:shadow-xl"--}}
                                                                        {{--                                                                                onclick="savePhoto()">--}}
                                                                        {{--                                                                            Save--}}
                                                                        {{--                                                                        </button>--}}
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @if((count($payload['categories'])-1)===$cat_k)
                                    <div class="w-full md:px-30 lg:px-20 xl:px-60 p-[20px] border border-gray-300 rounded-lg mt-8 mb-3">
                                        <h2 class="text-xl font-semibold text-gray-800 text-center mb-6">Visits
                                            Conducted</h2>

                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Started</label>
                                                <div class="relative">
                                                    <div class="flex items-center gap-3 p-4 border border-gray-300 rounded-lg focus-within:border-blue-500 focus-within:bg-white transition-all duration-200">
                                                        <svg class="w-4 h-4 text-gray-500" fill="currentColor"
                                                             viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                  clip-rule="evenodd"></path>
                                                        </svg>
                                                        <input type="text" name="started_date" placeholder="Started"
                                                               class="last_date flex-1 bg-transparent text-gray-700 font-medium focus:outline-none"
                                                               value="{{ (isset($visit_report_data->started_date)?$visit_report_data->started_date:'') }}"
                                                               id="startedDateTime">
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Completed</label>
                                                <div class="relative">
                                                    <div class="flex items-center gap-3 p-4 border border-gray-300 rounded-lg focus-within:border-green-500 focus-within:bg-white transition-all duration-200">
                                                        <svg class="w-4 h-4 text-gray-500" fill="currentColor"
                                                             viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                  clip-rule="evenodd"></path>
                                                        </svg>
                                                        <input type="text" name="completed_date" placeholder="Completed"
                                                               class="last_date flex-1 bg-transparent text-gray-700 font-medium focus:outline-none"
                                                               value="{{ (isset($visit_report_data->completed_date)?$visit_report_data->completed_date:'') }}"
                                                               id="completedDateTime">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="flex mt-2 {{ $cat_k==0?'justify-end':'justify-between' }}">
                                    @if($cat_k>0)
                                        <button type="button" onclick="showPrevView()"
                                                class="cursor-pointer bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-medium transition-colors">
                                            Previous
                                        </button>
                                    @endif
                                    @if((count($payload['categories'])-1)!==$cat_k)
                                        <button type="button" onclick="showNextView()"
                                                class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                            Next
                                        </button>
                                    @else
                                        <div>
                                            <button type="button"
                                                    class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                                Save for Later
                                            </button>
                                            <button type="button" data-visit_id="{{ $visit->id }}"
                                                    data-user_id="{{ $visit->visitor_id??'' }}"
                                                    class="cursor-pointer questionnaire_submit bg-[#E6A23C] hover:bg-[#EEBE77] text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                                Submit Questions
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </form>
    </section>
@endsection
@section('script')
    <script>
        let autoSaveTimer;

        const views = document.querySelectorAll('.view-content');
        let currentView = 0;

        function scrollCurrentViewToTop() {
            // Scroll to the current view element
            const activeView = views[currentView];
            if (activeView) {
                // Scroll the view into the viewport at the top
                activeView.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        function showNextView() {
            if (currentView < views.length - 1) {
                views[currentView].classList.add('hidden');
                currentView++;
                views[currentView].classList.remove('hidden');

                scrollCurrentViewToTop();
            }
        }

        function showPrevView() {
            if (currentView > 0) {
                views[currentView].classList.add('hidden');
                currentView--;
                views[currentView].classList.remove('hidden');

                scrollCurrentViewToTop();
            }
        }

        setTimeout(() => {
            $('.slider-range').on('input', function () {
                $(this).closest('div').find('.slider-value').text(this.value);
            });
        }, 10);


        $(document).delegate('.question_image', 'change', function (e) {
            const file = e.target.files[0];
            const input = this; // reference to current input element
            const container = $(input).closest('.image-container');
            const previewDiv = container.find('.image-preview');
            const inputDiv = container.find('.image-input');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (ev) {
                    previewDiv.removeClass('hidden').html(`
                        <img src="${ev.target.result}" alt="Preview" class="h-[100%] w-full object-cover">
                        <button type="button" class="absolute bg-red-500 cursor-pointer h-5 remove-image-btn right-1 rounded-full text-white top-1 w-5">&times;</button>
                    `);
                };
                reader.readAsDataURL(file);
                inputDiv.addClass('hidden');
            }
        });

        // custom checkbox button
        $(document).delegate('.na-checkbox', 'click', function (e) {
            const el = $(this);
            var container = el.closest('.question-container');
            var type = el.attr('data-type');
            var id = el.attr('data-id');
            if (el.prop('checked')) {
                if (type === 'RADIO' || type === 'SELECT') {
                    container.find('input[name="question[' + id + '][answer]"]').prop('checked', false);
                    container.find('input[name="question[' + id + '][answer]"]').attr('disabled', 'disabled');
                } else if (type === 'SLIDER') {
                    var min = container.find('input[name="question[' + id + '][answer]"]').attr('min');
                    container.find('input[name="question[' + id + '][answer]"]').val(min);
                    container.find('.slider-value').html(min);
                    container.find('input[name="question[' + id + '][answer]"]').attr('disabled', 'disabled');
                } else {
                    container.find('input[name="question[' + id + '][answer]"], textarea[name="question[' + id + '][answer]"]').val('');
                    container.find('input[name="question[' + id + '][answer]"], textarea[name="question[' + id + '][answer]"]').attr('readonly', 'readonly');
                }
            } else {
                if (type === 'RADIO' || type === 'SELECT' || type === 'SLIDER') {
                    container.find('input[name="question[' + id + '][answer]"]').removeAttr('disabled');
                } else {
                    container.find('input[name="question[' + id + '][answer]"], textarea[name="question[' + id + '][answer]"]').removeAttr('readonly');
                }
            }
        });

        // Remove image button functionality
        $(document).delegate('.remove-image-btn', 'click', function (e) {
            e.stopPropagation(); // prevent triggering file input
            var el = $(this);
            const container = $(this).closest('.image-container');
            const input = container.find('.question_image');
            var image = $(this).data('image');

            container.find('.image-preview').addClass('hidden').html(``);
            container.find('.image-input').removeClass('hidden');
            input.val(''); // reset file input
            container.find('.answer_old_image').val(''); // reset file input

            $.ajax({
                url: '{{ route('admin.questionnaire.response.delete.comment.image') }}',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    image: image
                },
                success: function (response) {
                    el.closest('div').remove();
                    autoSaveForm();
                },
                error: function () {
                    sendToast('Something went wrong while deleting the image.');
                }
            });
        });

        // Remove image button functionality
        $(document).delegate('.comment-image-remove-btn', 'click', function (e) {
            e.stopPropagation();
            var el = $(this);
            var image = $(this).data('image');

            $.ajax({
                url: '{{ route('admin.questionnaire.response.delete.comment.image') }}',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    image: image
                },
                success: function (response) {
                    el.closest('div').remove();
                    autoSaveForm();
                },
                error: function () {
                    sendToast('Something went wrong while deleting the image.');
                }
            });
        });


        $(".last_date").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
        });

        $('form#questionForm').on('change input', 'input, select, textarea', function () {
            autoSaveForm();
        });

        $('.commentBtn').on('click', function (e) {
            var type = $(this).data('type');
            $(this).closest('.modern-card').find('.input_comment').val(type);
            if (type == "") {
                $(this).closest('.modern-card').find('.tab-pane').addClass('hidden');
            }
            autoSaveForm();
        });

        function autoSaveForm(callback = null) {
            const form = document.getElementById('questionForm');
            const url = "{{ route('admin.questionnaire.response.update',['id' => $questionnaire->id]) }}";
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
                        sendToast('Data save failed:' + xhr.responseText, "danger");
                    }
                });
            }, 1000); // wait 1 second after last change
        }

        $(document).ready(function () {
            $(document).on('change', '.photo-input-image', function (e) {
                const input = this;
                const visit_id = $(this).data('visit_id');
                const id = $(this).data('id');
                const cat_id = $(this).data('cat_id');

                autoSaveForm(function () {
                    previewImages(visit_id, id, cat_id, input);
                });
            });
        });

        function previewImages(visit_id, id, cat_id, input) {
            const container = $(input).closest('.modern-card').find('.previewContainer');
            setTimeout(function () {
                $.ajax({
                    url: '{{ route('admin.questionnaire.response.comment.image') }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        visit_id: visit_id,
                        id: id,
                        cat_id: cat_id,
                    },
                    success: function (response) {
                        var photos = response.message.photos;
                        container.empty();

                        // Loop through each photo
                        photos.forEach(function (photo) {
                            $(input).val('');
                            const imageUrl = "{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH) }}/" + photo;

                            const imgWrapper = `
                                <div class="relative group">
                                    <input type="hidden" name="question[${id}][old_photo][]" value="${photo}">
                                    <img src="${imageUrl}" class="w-full h-32 object-cover rounded-lg shadow-sm border">
                                    <button type="button" data-image="${photo}"
                                            class="cursor-pointer absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 text-xs group-hover:flex items-center justify-center comment-image-remove-btn"
                                            title="Remove">×</button>
                                </div>
                            `;

                            container.append(imgWrapper);
                        });
                    },
                    error: function (xhr) {
                        sendToast('Data save failed:' + xhr.responseText, "danger");
                    }
                });
            }, 2000);
        }

        $(document).on("click", ".questionnaire_submit", function (e) {
            e.preventDefault();
            var visit_id = $(this).attr('data-visit_id');
            var user_id = $(this).attr('data-user_id');
            $.ajax({
                url: "{{route('admin.questionnaire.response.submit')}}", // Your save endpoint
                method: "POST",
                data: {
                    visit_id: visit_id,
                    user_id: user_id,
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                dataType: "json",
                beforeSend: function () {
                    // Show loading state
                },
                success: function (result) {
                    sendToast(result.message);
                    setTimeout(function () {
                        window.location.href = "{{route('admin.visit.index',['page'=>'pending'])}}";
                    }, 1000);
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data && data.hasOwnProperty('message')) {
                        sendToast(data.message, 'danger');
                    } else {
                        sendToast('An error occurred while saving', 'danger');
                    }
                }
            });
        });

    </script>

@endsection
