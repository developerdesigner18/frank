@extends('user.master')
@section('title','Open Questions')
@push('style-link')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/questionnaire-style.css') }}">
@endpush
@push('style')
    <style>
        .custom-slider {
            width: 100%;
            appearance: none;
            height: 12px;
            border-radius: 20px;
            background: linear-gradient(to right, #e0e0e0, #007bff);
            outline: none;
        }

        .custom-slider::-webkit-slider-thumb {
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #241616;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            border: 2px solid #ccc;
        }

        .range-labels {
            display: flex;
            justify-content: space-between;
            color: black;
            font-size: 14px;
            margin-top: 5px;
        }

        .tab-image {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 0.5rem;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .tab-name, .question-count-badge {
                display: none;
            }
            .tab-image {
                margin-right: 0;
            }
            .category-tab {
                padding: 0.5rem 0.8rem;
            }

            .question-title {
                font-size: 0.9rem !important;
            }
        }
        .toast-container {
            right: 1rem !important;
        }

        .custom-container-fluid {
            padding-left: 0;
            padding-right: 0;
        }
    </style>
@endpush
@push('modal')
    <!-- Toast Container -->
    <div class="toast-container">
        <div id="toast" class="toast align-items-center text-white bg-success border-0" role="alert"
             aria-live="assertive"
             aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle me-2"></i>
                    <span id="toastMessage">Operation successful</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endpush
@section('main')

    <!-- Welcome Screen -->
    <div id="welcomeScreen" class="welcome-screen">
        <div class="welcome-card">
            <div class="welcome-icon">
                <i class="bi bi-clipboard-check"></i>
            </div>
            <h1 class="welcome-title">Welcome to the {{ $rowData->branch->branch_name }} Feedback Survey</h1>
            <div class="title-input-group">
                <input type="hidden" class="title-input" id="welcomeTitleInput"
                       placeholder="Enter your questionnaire title..." maxlength="100">
            </div>
            <button type="button" class="start-btn" id="startBuildingBtn" disabled>
                <span class="btn-text">Start Survey</span>
                <span class="loading-spinner d-none"></span>
            </button>
        </div>
    </div>

    <!-- Main Application -->
    <div id="mainApp" class="main-app">
        <!-- Header -->
        <header class="app-header">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h1 class="app-title" id="appTitle">{{ $rowData->branch->branch_name }}</h1>
                        <p class="app-subtitle">{{ $rowData->branch->address_1??'' }} {{ $rowData->branch->postal_code??'' }} {{ $rowData->branch->locality??'' }}</p>
                        <p class="app-subtitle"><span>{{ $questionnaire->name??'Untitled Questionnaire' }}</span></p>
                    </div>
                </div>
            </div>
        </header>

        <form method="post" class="questionForm" id="wrapped" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="visit_id" name="visit_id" value="{{ $rowData->id }}">
            <input type="hidden" class="user_id" name="user_id" value="{{ auth()->guard('web')->user()->id }}">
            <input type="hidden" name="branch_id" value="{{ $rowData->branch_id }}">
            <!-- Main Container -->
            <div class="main-container p-0">
                <!-- Category Section -->
                <div class="category-section">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">
                            <i class="bi bi-folder me-2"></i>
                            Categories
                        </h5>
                    </div>

                    <div class="category-tabs-wrapper">
                        @if($payload->categories)
                            @foreach($payload->categories as $cat_k => $category)
                                <input type="hidden" name="category[{{ $category->id }}]" value="{{ $category->name }}">
                                <div class="category-tab {{$cat_k==0 ? "active" : ""}} {{($cat_k+1)==count($payload->categories) ? "last-category" : ""}}" data-last="{{($cat_k+1)==count($payload->categories) ? "1" : "0"}}" data-category-id="{{$category->id}}">
                                    {!! (isset($category->imageUrl) && $category->imageUrl) ? '<img src="'.$category->imageUrl.'" alt="'.$category->name.'" class="tab-image" />' : '' !!}
                                    <span class="tab-name">{{$category->name}}</span>
                                    @php
                                        // Count the number of questions for the category
                                        $categoryQuestionCount = count(array_filter($payload->questions, function($question) use ($category) {
                                            return $question->categoryId == $category->id;
                                        }));
                                    @endphp
                                    {!! $categoryQuestionCount > 0 ? '<span class="question-count-badge">'.$categoryQuestionCount.'</span>' : '' !!}
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Content Area -->
                <div class="content-area">
                    <div id="categoryContentDiv">
                        <div class="p-3">
                            @if($payload->categories)
                                @foreach($payload->categories as $cat_k => $category)
                                    @php $qu_k=1; @endphp
                                    <div class="category-content category-content_{{$category->id}} {{$cat_k == 0 ? '' : 'd-none'}}" data-category-id="{{$category->id}}">
                                        <h4 class="mb-3">{{ $category->name }}</h4>
                                        @foreach($payload->questions as $question)
                                            @php
                                                $question_id = $question->id;
                                                $report_response_data = [];
                                                $report_result = $old_photos = [];

                                                if(isset($old_questions[$question->categoryId])){
                                                    $report_response_data = $old_questions[$question->categoryId];
                                                    $report_result = array_values(array_filter($report_response_data, function ($item) use ($question_id) {
                                                        if (gettype($item)=='array'){
                                                            return $item['qId'] == $question_id;
                                                        }else{
                                                            return $item->qId == $question_id;
                                                        }
                                                    }));
                                                    $report_result = (isset($report_result[0]))?(array)$report_result[0]:[];
//                                                    dd($report_result);
                                                    $old_photos = (!empty($report_result) && $report_result['photo'])?$report_result['photo']:[];
                                                }
                                            @endphp
                                            <input type="hidden" name="question[{{ $question->id }}][categoryId]" value="{{ $question->categoryId }}">
                                            <input type="hidden" name="question[{{ $question->id }}][categoryName]" value="{{ $categoryName = $categoryMap[$question->categoryId] ?? 'Unknown' }}">
                                            <input type="hidden" name="question[{{ $question->id }}][title]" value="{{ $question->title }}">
                                            <input type="hidden" name="question[{{ $question->id }}][type]" value="{{ $question->type }}">
                                            @if($question->categoryId == $category->id)
                                                <div class="mb-3 p-3 rounded-4" style="border: 2px solid #D2E0E0;" data-question-id="{{$question->id}}">
                                                    <div class="">
                                                        @if(isset($question->imageUrl) && $question->imageUrl)
                                                            <div class="question-image">
                                                                <img src="{{ $question->imageUrl }}" alt="Question image" height="100px" width="100px" class="img-fluid">
                                                            </div>
                                                        @endif

                                                        <div class="question-title">
                                                            {{$qu_k}}. {{$question->title}}
                                                            @if($question->required)
                                                                <span class="text-danger ms-1">*</span>
                                                            @endif
                                                        </div>

                                                        @if(isset($question->comment) && $question->comment)
                                                            <div class="question-comment">
                                                                <i class="bi bi-info-circle me-1"></i>
                                                                {{ $question->comment }}
                                                            </div>
                                                        @endif
                                                        @php
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
                                                            } elseif($question->required == true) {
                                                                $isRequired = true;
                                                            }
                                                        @endphp
                                                        @switch($question->type)
                                                            @case('RADIO')
                                                                @if($question->options)
                                                                    @php
                                                                        $scores = array_map(fn($options) => $options->score??0, $question->options);
                                                                        $minScore = min($scores);
                                                                        $maxScore = max($scores);
                                                                    @endphp
                                                                    <div class="mt-3">
                                                                        <input type="hidden" name="question[{{ $question->id }}][max]" value="{{ $maxScore }}">
                                                                        @foreach($question->options as $idx => $option)
                                                                            <div class="form-check mb-2">
                                                                                <input class="form-check-input answer-{{ $question->id }}" type="radio" name="question[{{ $question->id }}][answer]" id="radio-{{ $question->id }}-{{ $idx }}" value="{{ $option->value }},({{ $option->score??0 }})" {{ (isset($report_result['answer']) && $report_result['answer']==$option->value)?'checked':'' }} {{ $isReadonly ? 'disabled="disabled"' : '' }}>
                                                                                <label class="form-check-label d-flex justify-content-between align-items-center" for="radio-{{ $question->id }}-{{ $idx }}">
                                                                                    <span>{{ $option->text }}</span>
{{--                                                                                    @isset($option->score)--}}
{{--                                                                                        <span class="score-display">Score: {{ $option->score }}</span>--}}
{{--                                                                                    @endisset--}}
                                                                                </label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="form-group multi-input-block">
                                                                        <div class="" role="group">
                                                                            <input type="radio" class="btn-check input-type-radio" name="input_type_{{ $question->id }}" id="input_comment_{{ $question->id }}" value="comment" {{ (isset($report_result['type']) && $report_result['type']!='photo')?'checked':'' }}>
                                                                            <label class="btn" for="input_comment_{{ $question->id }}"><i class="mdi mdi-comment"></i> Comment</label>

                                                                            <input type="radio" class="btn-check input-type-radio" name="input_type_{{ $question->id }}" id="input_photo_{{ $question->id }}" value="photo" {{ (isset($report_result['type']) && $report_result['type']=='photo')?'checked':'' }}>
                                                                            <label class="btn" for="input_photo_{{ $question->id }}"><i class="mdi mdi-camera"></i> Photo</label>

                                                                            <span class="align-items-center gap-1">
                                                                                <input type="checkbox" class="na-checkbox ms-2" name="question[{{ $question->id }}][na]" value="1" id="input_na_{{ $question->id }}" {{ (isset($report_result['na']) && $report_result['na']==1)?'checked':'' }} onchange="getInputNa(this, '{{$question->id}}', {{$qu_k+1}}, 'radio');">
                                                                                <label for="input_na_{{ $question->id }}" class="mb-0">N/A</label>
                                                                            </span>
                                                                        </div>

                                                                        <div class="comment-box mt-3">
                                                                            <textarea class="form-control" name="question[{{ $question->id }}][comment]" style="height:120px;" placeholder="Add Comment Here...">{{ isset($report_result['comment'])?$report_result['comment']:'' }}</textarea>
                                                                        </div>

                                                                        <div class="photo-box mt-3 d-none">
                                                                            <input type="file" name="question[{{ $question->id }}][photo][]" class="form-control comment-photo-input" multiple accept="image/*">
                                                                            <div class="photo-preview mt-3 d-flex gap-2 flex-wrap">
                                                                                @if($old_photos)
                                                                                    @foreach($old_photos as $oldImg)
                                                                                        <div class="image-preview position-relative">
                                                                                            <input type="hidden" name="question[{{ $question->id }}][old_photo][]" value="{{ $oldImg }}">
                                                                                            <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}" class="rounded border" width="100" height="100" style="object-fit:cover;">
                                                                                        </div>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @break

                                                            @case('SELECT')
                                                                @php
                                                                    $scores = array_map(fn($options) => $options->score??0, $question->options);
                                                                    $maxScore = max($scores);
                                                                    $minScore = min($scores);
                                                                @endphp
                                                                <input type="hidden" name="question[{{ $question->id }}][max]" value="{{ $maxScore }}">
                                                                <select class="form-select answer-{{ $question->id }}" name="question[{{ $question->id }}][answer]">
                                                                    <option value="">Select an option</option>
                                                                    @foreach($question->options as $option)
                                                                        <option value="{{ $option->value }},({{ $option->score??0 }})" {{ (isset($report_result['answer']) && $report_result['answer']==$option->value)?'selected':'' }}>
                                                                            {{ $option->text }}
{{--                                                                            @isset($option->score)--}}
{{--                                                                                (Score: {{ $option->score }})--}}
{{--                                                                            @endisset--}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="form-group multi-input-block">
                                                                    <div class="" role="group">
                                                                        <input type="radio" class="btn-check input-type-radio" name="input_type_{{ $question->id }}" id="input_comment_{{ $question->id }}" value="comment" {{ (isset($report_result['type']) && $report_result['type']!='photo')?'checked':'' }}>
                                                                        <label class="btn" for="input_comment_{{ $question->id }}"><i class="mdi mdi-comment"></i> Comment</label>

                                                                        <input type="radio" class="btn-check input-type-radio" name="input_type_{{ $question->id }}" id="input_photo_{{ $question->id }}" value="photo" {{ (isset($report_result['type']) && $report_result['type']=='photo')?'checked':'' }}>
                                                                        <label class="btn" for="input_photo_{{ $question->id }}"><i class="mdi mdi-camera"></i> Photo</label>

                                                                        <span class="align-items-center gap-1">
                                                                            <input type="checkbox" class="na-checkbox ms-2" name="question[{{ $question->id }}][na]" value="1" id="input_na_{{ $question->id }}" {{ (isset($report_result['na']) && $report_result['na']==1)?'checked':'' }} onchange="getInputNa(this, '{{$question->id}}', {{$qu_k+1}}, 'select');">
                                                                            <label for="input_na_{{ $question->id }}" class="mb-0">N/A</label>
                                                                        </span>
                                                                    </div>

                                                                    <div class="comment-box mt-3">
                                                                        <textarea class="form-control" name="question[{{ $question->id }}][comment]" style="height:120px;" placeholder="Add Comment Here...">{{ isset($report_result['comment'])?$report_result['comment']:'' }}</textarea>
                                                                    </div>

                                                                    <div class="photo-box mt-3 d-none">
                                                                        <input type="file" name="question[{{ $question->id }}][photo][]" class="form-control comment-photo-input" multiple accept="image/*">
                                                                        <div class="photo-preview mt-3 d-flex gap-2 flex-wrap">
                                                                            @if($old_photos)
                                                                                @foreach($old_photos as $oldImg)
                                                                                    <div class="image-preview position-relative">
                                                                                        <input type="hidden" name="question[{{ $question->id }}][old_photo][]" value="{{ $oldImg }}">
                                                                                        <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}" class="rounded border" width="100" height="100" style="object-fit:cover;">
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @break

                                                            @case('SLIDER')
                                                                @php
                                                                    $scores = [];
                                                                    if(isset($question->minValue) && isset($question->maxValue)){
                                                                        $options = [];
                                                                        $minScore = $question->minValue??0;
                                                                        $maxScore = $question->maxValue??0;
                                                                    }else{
                                                                        $options = $question->options;
                                                                        if ($options){
                                                                            $scores = array_map(fn($options) => $options->score, $options);
                                                                            $minScore = min($scores);
                                                                            $maxScore = max($scores);
                                                                        }else{
                                                                            $minScore = 0;
                                                                            $maxScore = 0;
                                                                        }
                                                                    }
                                                                    $minScore = ($minScore>=0)?$minScore:0;
                                                                    $maxScore = ($maxScore>=0)?$maxScore:0;

                                                                    $step = $question->step ?? 1;
                                                                    if($isReadonly){
                                                                        $defaultValue = $minScore;
                                                                    }else{
                                                                        $defaultValue = (isset($report_result['answer']) && $report_result['answer'] > $minScore ?$report_result['answer']:$minScore);
                                                                    }
//                                                                    if($question->id == '1751808289103'){
//                                                                        dd($defaultValue);
//                                                                    }
                                                                @endphp
                                                                <input type="hidden" name="question[{{ $question->id }}][max]" value="{{ $maxScore }}">
                                                                <div class="form-group">
                                                                    <input type="range"
                                                                           id="slider-{{ $question->id }}"
                                                                           class="form-range custom-slider answer-{{ $question->id }} slider-input"
                                                                           name="question[{{ $question->id }}][answer]"
                                                                           min="{{ $minScore }}"
                                                                           max="{{ $maxScore }}"
                                                                           step="{{ $step }}"
                                                                           value="{{ $defaultValue }}"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-placement="top"
                                                                           title="{{ $defaultValue }}"
                                                                           {{ $isReadonly ? 'disabled="disabled"' : '' }} />

                                                                    <div class="range-labels">

                                                                        @if($maxScore > $minScore)
                                                                            @for($i = $minScore; $i <= $maxScore; $i++)
                                                                                @if($scores)
                                                                                    @php
                                                                                        $found = false;
                                                                                    @endphp

                                                                                    @foreach($options as $option)
                                                                                        @if($option->score == $i)
                                                                                            @php
                                                                                                $found = $option->text;
                                                                                            @endphp
                                                                                            @break
                                                                                        @endif
                                                                                    @endforeach

                                                                                    @if(isset($found))
                                                                                        <span>{{ $found }}</span>
                                                                                    @else
                                                                                        <span></span>
                                                                                    @endif
                                                                                @else
                                                                                    <span>{{ $i }}</span>
                                                                                @endif
                                                                            @endfor
                                                                        @else
                                                                            <span>0</span>
                                                                        @endif

{{--                                                                        @if($options)--}}
{{--                                                                            @foreach($options as $opt)--}}
{{--                                                                                <span>{{ $opt->text }}</span>--}}
{{--                                                                            @endforeach--}}
{{--                                                                        @else--}}
{{--                                                                            @if(isset($question->minValue) && isset($question->maxValue))--}}
{{--                                                                                @if($question->maxValue>0)--}}
{{--                                                                                    @for($i = $minScore; $i <= $maxScore; $i += round(($maxScore - $minScore)/4))--}}
{{--                                                                                        <span>{{ $i }}</span>--}}
{{--                                                                                    @endfor--}}
{{--                                                                                @endif--}}
{{--                                                                            @endif--}}
{{--                                                                        @endif--}}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group multi-input-block">
                                                                    <div class="" role="group">
                                                                        <input type="radio" class="btn-check input-type-radio" name="input_type_{{ $question->id }}" id="input_comment_{{ $question->id }}" value="comment" {{ (isset($report_result['type']) && $report_result['type']!='photo')?'checked':'' }}>
                                                                        <label class="btn" for="input_comment_{{ $question->id }}"><i class="mdi mdi-comment"></i> Comment</label>

                                                                        <input type="radio" class="btn-check input-type-radio" name="input_type_{{ $question->id }}" id="input_photo_{{ $question->id }}" value="photo" {{ (isset($report_result['type']) && $report_result['type']=='photo')?'checked':'' }}>
                                                                        <label class="btn" for="input_photo_{{ $question->id }}"><i class="mdi mdi-camera"></i> Photo</label>

                                                                        <span class="align-items-center gap-1">
                                                                            <input type="checkbox" class="na-checkbox ms-2" name="question[{{ $question->id }}][na]" value="1" id="input_na_{{ $question->id }}" {{ (isset($report_result['na']) && $report_result['na']==1)?'checked':'' }} onchange="getInputNa(this, '{{$question->id}}', {{$qu_k+1}}, 'range');">
                                                                            <label for="input_na_{{ $question->id }}" class="mb-0">N/A</label>
                                                                        </span>
                                                                    </div>

                                                                    <div class="comment-box mt-3">
                                                                        <textarea class="form-control" name="question[{{ $question->id }}][comment]" style="height:120px;" placeholder="Add Comment Here...">{{ isset($report_result['comment'])?$report_result['comment']:'' }}</textarea>
                                                                    </div>

                                                                    <div class="photo-box mt-3 d-none">
                                                                        <input type="file" name="question[{{ $question->id }}][photo][]" class="form-control comment-photo-input" multiple accept="image/*">
                                                                        <div class="photo-preview mt-3 d-flex gap-2 flex-wrap">
                                                                            @if($old_photos)
                                                                                @foreach($old_photos as $oldImg)
                                                                                    <div class="image-preview position-relative">
                                                                                        <input type="hidden" name="question[{{ $question->id }}][old_photo][]" value="{{ $oldImg }}">
                                                                                        <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}" class="rounded border" width="100" height="100" style="object-fit:cover;">
{{--                                                                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-preview px-1 py-0">&times;</button>--}}
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @break

                                                            @case('AMOUNT')
                                                                <div class="input-group">
                                                                    <span class="input-group-text">{{ currency_icon() }}</span>
                                                                    <input type="number" class="form-control answer-{{ $question->id }}" name="question[{{ $question->id }}][answer]" placeholder="{{ $question->placeholder ?? 'Enter amount' }}" value="{{ isset($report_result['answer'])?$report_result['answer']:'' }}" {{ $isReadonly ? 'readonly="readonly"' : '' }}>
                                                                </div>
                                                                <div class="form-group multi-input-block">
                                                                    <div class="" role="group">
                                                                        <input type="radio" class="btn-check input-type-radio" name="input_type_{{ $question->id }}" id="input_comment_{{ $question->id }}" value="comment" {{ (isset($report_result['type']) && $report_result['type']!='photo')?'checked':'' }}>
                                                                        <label class="btn" for="input_comment_{{ $question->id }}"><i class="mdi mdi-comment"></i> Comment</label>

                                                                        <input type="radio" class="btn-check input-type-radio" name="input_type_{{ $question->id }}" id="input_photo_{{ $question->id }}" value="photo" {{ (isset($report_result['type']) && $report_result['type']=='photo')?'checked':'' }}>
                                                                        <label class="btn" for="input_photo_{{ $question->id }}"><i class="mdi mdi-camera"></i> Photo</label>

                                                                        <span class="align-items-center gap-1">
                                                                        <input type="checkbox" class="na-checkbox ms-2" name="question[{{ $question->id }}][na]" value="1" id="input_na_{{ $question->id }}" {{ (isset($report_result['na']) && $report_result['na']==1)?'checked':'' }} onchange="getInputNa(this, '{{$question->id}}', {{$qu_k+1}});">
                                                                        <label for="input_na_{{ $question->id }}" class="mb-0">N/A</label>
                                                                    </span>
                                                                    </div>

                                                                    <div class="comment-box mt-3">
                                                                        <textarea class="form-control" name="question[{{ $question->id }}][comment]" style="height:120px;" placeholder="Add Comment Here...">{{ isset($report_result['comment'])?$report_result['comment']:'' }}</textarea>
                                                                    </div>

                                                                    <div class="photo-box mt-3 d-none">
                                                                        <input type="file" name="question[{{ $question->id }}][photo][]" class="form-control comment-photo-input" multiple accept="image/*">
                                                                        <div class="photo-preview mt-3 d-flex gap-2 flex-wrap">
                                                                            @if($old_photos)
                                                                                @foreach($old_photos as $oldImg)
                                                                                    <div class="image-preview position-relative">
                                                                                        <input type="hidden" name="question[{{ $question->id }}][old_photo][]" value="{{ $oldImg }}">
                                                                                        <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}" class="rounded border" width="100" height="100" style="object-fit:cover;">
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @break

                                                            @case('TEXT')
                                                                <input type="text" class="form-control answer-{{ $question->id }}" name="question[{{ $question->id }}][answer]" placeholder="{{ $question->placeholder ?? 'Enter your answer' }}" value="{{ isset($report_result['answer'])?$report_result['answer']:'' }}" {{ $isReadonly ? 'readonly="readonly"' : '' }}>
                                                                <div class="form-group multi-input-block">
                                                                    <div class="" role="group">
                                                                        <input type="radio" class="btn-check input-type-radio" name="input_type_{{ $question->id }}" id="input_comment_{{ $question->id }}" value="comment" {{ (isset($report_result['type']) && $report_result['type']!='photo')?'checked':'' }}>
                                                                        <label class="btn" for="input_comment_{{ $question->id }}"><i class="mdi mdi-comment"></i> Comment</label>

                                                                        <input type="radio" class="btn-check input-type-radio" name="input_type_{{ $question->id }}" id="input_photo_{{ $question->id }}" value="photo" {{ (isset($report_result['type']) && $report_result['type']=='photo')?'checked':'' }}>
                                                                        <label class="btn" for="input_photo_{{ $question->id }}"><i class="mdi mdi-camera"></i> Photo</label>

                                                                        <span class="align-items-center gap-1">
                                                                            <input type="checkbox" class="na-checkbox ms-2" name="question[{{ $question->id }}][na]" value="1" id="input_na_{{ $question->id }}" {{ (isset($report_result['na']) && $report_result['na']==1)?'checked':'' }} onchange="getInputNa(this, '{{$question->id}}', {{$qu_k+1}});">
                                                                            <label for="input_na_{{ $question->id }}" class="mb-0">N/A</label>
                                                                        </span>
                                                                    </div>

                                                                    <div class="comment-box mt-3">
                                                                        <textarea class="form-control" name="question[{{ $question->id }}][comment]" style="height:120px;" placeholder="Add Comment Here...">{{ isset($report_result['comment'])?$report_result['comment']:'' }}</textarea>
                                                                    </div>

                                                                    <div class="photo-box mt-3 d-none">
                                                                        <input type="file" name="question[{{ $question->id }}][photo][]" class="form-control comment-photo-input" multiple accept="image/*">
                                                                        <div class="photo-preview mt-3 d-flex gap-2 flex-wrap">
                                                                            @if($old_photos)
                                                                                @foreach($old_photos as $oldImg)
                                                                                    <div class="image-preview position-relative">
                                                                                        <input type="hidden" name="question[{{ $question->id }}][old_photo][]" value="{{ $oldImg }}">
                                                                                        <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}" class="rounded border" width="100" height="100" style="object-fit:cover;">
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @break

                                                            @case('COMMENT')
                                                                <textarea class="form-control answer-{{ $question->id }}" rows="3" name="question[{{ $question->id }}][answer]" placeholder="{{ $question->placeholder ?? 'Enter your comment' }}" {{ $isReadonly ? 'readonly="readonly"' : '' }}>{{ isset($report_result['answer'])?$report_result['answer']:'' }}</textarea>
                                                                <div class="form-group multi-input-block">
                                                                    <div class="" role="group">
                                                                        <input type="radio" class="btn-check input-type-radio" name="input_type_{{ $question->id }}" id="input_comment_{{ $question->id }}" value="comment" {{ (isset($report_result['type']) && $report_result['type']!='photo')?'checked':'' }}>
                                                                        <label class="btn" for="input_comment_{{ $question->id }}"><i class="mdi mdi-comment"></i> Comment</label>

                                                                        <input type="radio" class="btn-check input-type-radio" name="input_type_{{ $question->id }}" id="input_photo_{{ $question->id }}" value="photo" {{ (isset($report_result['type']) && $report_result['type']=='photo')?'checked':'' }}>
                                                                        <label class="btn" for="input_photo_{{ $question->id }}"><i class="mdi mdi-camera"></i> Photo</label>

                                                                        <span class="align-items-center gap-1">
                                                                            <input type="checkbox" class="na-checkbox ms-2" name="question[{{ $question->id }}][na]" value="1" id="input_na_{{ $question->id }}" {{ (isset($report_result['na']) && $report_result['na']==1)?'checked':'' }} onchange="getInputNa(this, '{{$question->id}}', {{$qu_k+1}});">
                                                                            <label for="input_na_{{ $question->id }}" class="mb-0">N/A</label>
                                                                        </span>
                                                                    </div>

                                                                    <div class="comment-box mt-3">
                                                                        <textarea class="form-control" name="question[{{ $question->id }}][comment]" style="height:120px;" placeholder="Add Comment Here...">{{ isset($report_result['comment'])?$report_result['comment']:'' }}</textarea>
                                                                    </div>

                                                                    <div class="photo-box mt-3 d-none">
                                                                        <input type="file" name="question[{{ $question->id }}][photo][]" class="form-control comment-photo-input" multiple accept="image/*">
                                                                        <div class="photo-preview mt-3 d-flex gap-2 flex-wrap">
                                                                            @if($old_photos)
                                                                                @foreach($old_photos as $oldImg)
                                                                                    <div class="image-preview position-relative">
                                                                                        <input type="hidden" name="question[{{ $question->id }}][old_photo][]" value="{{ $oldImg }}">
                                                                                        <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}" class="rounded border" width="100" height="100" style="object-fit:cover;">
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @break
                                                            @default
                                                                {{-- Default case if none of the types match --}}
                                                        @endswitch
                                                    </div>
                                                </div>
                                                @php $qu_k++; @endphp
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="category-section visits-conducted d-none mt-3">
                    <h5 class="">
                        <i class="bi bi-folder me-2"></i>
                        Visits Conducted
                    </h5>
                    <div class="form-group">
                        <label for="started_date">Started</label>
                        <input type="text" class="form-control last_date" value="{{ (isset($visit_report_data->started_date)?$visit_report_data->started_date:'') }}" name="started_date">
                    </div>
                    <div class="form-group">
                        <label for="completed_date">Completed</label>
                        <input type="text" class="form-control last_date" value="{{ (isset($visit_report_data->completed_date)?$visit_report_data->completed_date:'') }}" name="completed_date">
                    </div>
                    <button type="submit" class="btn btn-outline-success mt-4 last_submit" data-visit_id="{{ $rowData->id }}" data-user_id="{{ auth()->guard('web')->user()->id }}" >
                        <i class="bi bi-save me-1"></i>
                        Submit
                    </button>
                </div>

            </div>

        </form>
    </div>

@endsection

@section('script')
    <script !src="">
        $(document).ready(function(){
            localStorage.removeItem("questionnaire_questions")
            localStorage.removeItem("questionnaire_categories")
            localStorage.removeItem("questionnaire_active_category")
            localStorage.removeItem("questionnaire_title")


            let tableQue = @json($questionnaire->payload)

                let
            parseQue = JSON.parse(tableQue);


            localStorage.setItem('questionnaire_questions', JSON.stringify(parseQue.questions));
            localStorage.setItem('questionnaire_categories', JSON.stringify(parseQue.categories));
            localStorage.setItem('questionnaire_title', "{{$questionnaire->name}}");
        });
    </script>
    <script>
        let autoSaveTimer;

        $('form#wrapped').on('change input', 'input, select, textarea', function () {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(function () {
                autoSaveForm();
            }, 1000); // wait 1 second after last change
        });

        function autoSaveForm() {
            const form = document.getElementById('wrapped');
            const url = "{{ route('visit.questionnaire.update',['id' => $questionnaire->id]) }}";
            const formData = new FormData(form);

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
                    showToast("Data saved successfully");
                },
                error: function (xhr) {
                    showToast('Data save failed:'+xhr.responseText, "danger");
                }
            });
        }

        $(".last_date").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
        });

        $(document).ready(function(){
            /*$(document).on("click", ".last_submit", function(e) {
                e.preventDefault();
                var visit_id = $(this).attr('data-visit_id');
                var user_id = $(this).attr('data-user_id');
                $.ajax({
                    url: "{{route('visit.questionnaire.submit')}}", // Your save endpoint
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
                        sendToast(result.message || 'Questionnaire saved successfully!', 'success');
                        setTimeout(function () {
                            window.location.href = "{{route('visit.index')}}";
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
            });*/

            $(".questionForm").validate({
                rules: {
                    started_date: {required: true},
                    completed_date: {required: true},
                },
                messages: {
                    started_date: {required: "Please select started date and time"},
                    completed_date: {required: "Please select completed date and time"},
                },
                errorClass: 'text-danger error',
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();

                    var visit_id = $('.visit_id').val();
                    var user_id = $('.user_id').val();
                    $.ajax({
                        url: "{{ route('visit.questionnaire.submit') }}",
                        method: "POST",
                        dataType: "json",
                        data: {
                            visit_id: visit_id,
                            user_id: user_id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        beforeSend: function () {
                            $('#addVisitBtn').attr('disabled', true);
                            $("#addVisitBtnSpinner").show();
                        },
                        success: function (result) {
                            sendToast(result.message, 'success');
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('errors')) {
                                $.each(data.errors, function (key, value) {
                                    $("#" + key + "-error").html(value[0]).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                sendError(data.message);
                            } else {
                                sendError("An error occurred. Please try again.");
                            }
                        },
                        complete: function () {
                            setTimeout(function () {
                                window.location.href = "{{route('visit.index')}}";
                            }, 1000);
                        }
                    });
                }
            });
            /*$(document).on("submit", ".questionForm", function(e) {
                e.preventDefault()
                var formData = new FormData(this);
                $.ajax({
                    url: "{{route('visit.questionnaire.update',['id' => $questionnaire->id])}}", // Your save endpoint
                    method: "POST",
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        // Show loading state
                    },
                    success: function (result) {
                        // showToast(result.message || 'Questionnaire saved successfully!', 'success');
                        console.log(result.message || 'Questionnaire saved successfully!');

                        window.location.href = "{{route('visit.index')}}";
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data && data.hasOwnProperty('message')) {
                            // showToast(data.message, 'danger');
                            console.log(data.message);
                        } else {
                            // showToast('An error occurred while saving', 'danger');
                            console.log('An error occurred while saving');
                        }
                    }
                });
            });*/

            $('.multi-input-block').each(function () {
                const $block = $(this);
                const $radios = $block.find('.input-type-radio');
                const $photoInput = $block.find('.comment-photo-input');
                const $previewBox = $block.find('.photo-preview');

                function updateDisplay() {
                    const selected = $block.find('.input-type-radio:checked').val();
                    $block.find('.comment-box, .photo-box').addClass('d-none');

                    if (selected === 'comment') {
                        $block.find('.comment-box').removeClass('d-none');
                    } else if (selected === 'photo') {
                        $block.find('.photo-box').removeClass('d-none');
                    }
                }

                $radios.on('change', function () {
                    updateDisplay();
                });

                $photoInput.on('change', function() {
                    $previewBox.empty(); // Clear old previews
                    const files = this.files;

                    if (files.length > 0) {
                        [...files].forEach(file => {
                            if (!file.type.startsWith('image/')) return;

                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const preview = $(`
                                    <div class="image-preview position-relative">
                                        <img src="${e.target.result}" class="rounded border" width="100" height="100" style="object-fit:cover;">
    <!--                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-preview">&times;</button>-->
                                    </div>
                                `);
                                $previewBox.append(preview);
                            };
                            reader.readAsDataURL(file);
                        });
                    }
                });

                // Remove image preview (Qushan)
                $previewBox.on('click', '.remove-preview', function () {
                    autoSaveForm();
                    // $(this).closest('.image-preview').remove();
                });

                // Initial check
                updateDisplay();
            });
        });

        function getInputNa(input, questionId, questionKey, type='text',){
            if(input.checked) {
                if(type == 'range'){
                    $('.answer-'+questionId).val('0');
                    $('.slider-value').html('0');
                    $('.answer-'+questionId).removeClass('required');
                    $('.answer-'+questionId).attr('disabled','disabled');
                }else if(type == 'select'){
                    $('.answer-'+questionId+' option[value=""]').attr('selected', 'selected');
                    $('.answer-'+questionId).removeClass('required');
                    $('.answer-'+questionId).attr('disabled','disabled');
                }else if(type == 'radio'){
                    $('.answer-'+questionId).prop('checked', false);
                    $('.answer-'+questionId).removeClass('required');
                    $('.answer-'+questionId).attr('disabled','disabled');
                }else{
                    $('.answer-'+questionId).val('');
                    $('.answer-'+questionId).removeClass('required');
                    $('.answer-'+questionId).attr('readonly','readonly');
                }
            }else{
                if(type == 'range'){
                    $('.answer-'+questionId).addClass('required');
                    $('.answer-'+questionId).removeAttr('disabled');
                }else if(type == 'select'){
                    $('.answer-'+questionId+' option[value=""]').removeAttr('selected');
                    $('.answer-'+questionId).addClass('required');
                    $('.answer-'+questionId).removeAttr('disabled');
                }else if(type == 'radio'){
                    $('.answer-'+questionId).addClass('required');
                    $('.answer-'+questionId).removeAttr('disabled');
                }else{
                    $('.answer-'+questionId).addClass('required');
                    $('.answer-'+questionId).removeAttr('readonly');
                }
            }
        }


        // Question Types Configuration
        const QUESTION_TYPES = {
            RADIO: {
                label: "Multiple Choice",
                value: "RADIO",
                icon: "bi-record-circle",
                description: "Single selection from multiple options",
            },
            SLIDER: {
                label: "Slider",
                value: "SLIDER",
                icon: "bi-sliders",
                description: "Select a value within a range",
            },
            SELECT: {
                label: "Dropdown",
                value: "SELECT",
                icon: "bi-menu-down",
                description: "Select from a dropdown menu",
            },
            AMOUNT: {
                label: "Numeric Amount",
                value: "AMOUNT",
                icon: "bi-currency-dollar",
                description: "Enter a numeric value",
            },
            TEXT: {
                label: "Short Text",
                value: "TEXT",
                icon: "bi-input-cursor-text",
                description: "Brief text response",
            },
            COMMENT: {
                label: "Long Text",
                value: "COMMENT",
                icon: "bi-card-text",
                description: "Detailed text response",
            },
        }

        // Global State
        let questions = []
        let categories = []
        let activeCategory = null
        let isPreviewMode = true
        let currentQuestionType = ""
        let editingQuestionId = null
        let sortableInstance = null
        let questionnaireTitle = ""
        let currentQuestionImageUrl = ""
        let currentCategoryImageUrl = ""

        // Toast instance
        let toastInstance = null

        // Initialize the application
        $(document).ready(() => {
            toastInstance = new bootstrap.Toast(document.getElementById("toast"))

            loadDataFromStorage()
            initializeWelcomeScreen()
        })

        function initializeWelcomeScreen() {
            setupWelcomeEventListeners()

            // If we have a saved title, show the main app
            if (questionnaireTitle) {
                $("#welcomeTitleInput").val(questionnaireTitle)
                $("#startBuildingBtn").prop("disabled", false)
            }
        }

        function setupWelcomeEventListeners() {
            // Title input validation
            $("#welcomeTitleInput").on("input", function () {
                const title = $(this).val().trim()
                $("#startBuildingBtn").prop("disabled", !title)
            })

            // Enter key to start
            $("#welcomeTitleInput").keypress((e) => {
                if (e.which === 13 && !$("#startBuildingBtn").prop("disabled")) {
                    startBuilding()
                }
            })

            // Start building button
            $("#startBuildingBtn").click(startBuilding)
        }

        function startBuilding() {
            const title = $("#welcomeTitleInput").val().trim()
            if (!title) return

            // Show loading state
            const btn = $("#startBuildingBtn")
            btn.prop("disabled", true)
            btn.find(".btn-text").text("Loading...")
            btn.find(".loading-spinner").removeClass("d-none")

            // Save title
            questionnaireTitle = title
            localStorage.setItem("questionnaire_title", title)

            // Simulate loading for smooth transition
            setTimeout(() => {
                // Hide welcome screen and show main app
                $("#welcomeScreen").fadeOut(500, () => {
                    $("#mainApp").fadeIn(500)
                    initializeMainApp()
                })
            }, 1000)
        }

        function initializeMainApp() {
            setupMainEventListeners()

            // Create default category if none exist
            if (categories.length === 0) {
                createDefaultCategory()
            }

            renderCategoryTabs()
            updateCategoryContent()
        }

        function createDefaultCategory() {
            const defaultCategory = {
                id: "default",
                name: "General",
                imageUrl: "",
            }
            categories.push(defaultCategory)
            activeCategory = "default"
            saveDataToStorage()
        }

        function setupMainEventListeners() {

            // Question image upload
            $("#questionImageInput").change(handleQuestionImageUpload)
            $("#removeQuestionImage").click(removeQuestionImage)

            // Type selector
            $("#selectTypeBtn").click(() => showTypeSelector())
            $("#changeTypeBtn").click(() => showTypeSelector())

            // Dynamic event handlers
            $(document).on("click", ".category-tab", function () {
                const categoryId = $(this).data("category-id")
                const last_cate = $(this).attr("data-last")
                $('.category-tab').removeClass('active');
                $(this).addClass('active');

                $('.category-content').addClass('d-none');
                $('.category-content_'+categoryId).removeClass('d-none');
                // setActiveCategory(String(categoryId))

                $('.visits-conducted').addClass('d-none');
                if(last_cate==1){
                    $('.visits-conducted').removeClass('d-none');
                }
            })

            $(document).on("input", ".slider-input", function () {
                const value = $(this).val()
                $(this).siblings(".d-flex").find(".slider-value").text(value)
            })
        }

        // Image Upload Functions
        function handleQuestionImageUpload(e) {
            const file = e.target.files[0]
            if (!file) return

            if (!file.type.startsWith("image/")) {
                showToast("Please select a valid image file", "danger")
                return
            }

            // Show progress
            $("#questionUploadProgress").show()
            const progressBar = $("#questionUploadProgress .progress-bar")

            // Simulate upload progress (replace with actual AJAX call)
            simulateImageUpload(file, progressBar, (imageUrl) => {
                currentQuestionImageUrl = imageUrl
                showImagePreview("#questionImagePreview", imageUrl)
                $("#questionUploadProgress").hide()
                showToast("Image uploaded successfully", "success")
            })
        }

        function simulateImageUpload(file, progressBar, callback) {
            // Here's where you would make your actual AJAX call:

            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', "{{csrf_token()}}");

            $.ajax({
                url: "{{route('admin.questionnaire.upload.images')}}", // Your upload endpoint
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    const xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            const percentComplete = evt.loaded / evt.total * 100;
                            progressBar.css('width', percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function (response) {
                    callback(response.data.imageUrl); // Use the URL returned from server
                },
                error: function () {
                    showToast('Upload failed', 'danger');
                    progressBar.parent().parent().hide();
                }
            });

        }

        function showImagePreview(previewSelector, imageUrl) {
            const preview = $(previewSelector)
            preview.find("img").attr("src", imageUrl)
            preview.show()
        }

        function removeQuestionImage() {
            currentQuestionImageUrl = ""
            $("#questionImagePreview").hide()
            $("#questionImageInput").val("")
            showToast("Image removed", "info")
        }

        function performCategoryDeletion(categoryId) {
            categories = categories.filter((cat) => cat.id !== categoryId)
            questions = questions.filter((q) => q.categoryId !== categoryId)

            if (activeCategory === categoryId) {
                activeCategory = categories[0]?.id || null
            }

            saveDataToStorage()
            renderCategoryTabs()
            updateCategoryContent()
            showToast("Category deleted successfully", "danger")
        }

        function setActiveCategory(categoryId) {
            activeCategory = categoryId
            renderCategoryTabs()
            updateCategoryContent()
        }

        function renderCategoryTabs() {
            const container = $("#categoryTabsContainer")
            container.empty()

            categories.forEach((category) => {
                const questionCount = questions.filter((q) => q.categoryId === category.id).length
                const isActive = category.id === activeCategory

                const tab = $(`
                    <div class="category-tab ${isActive ? "active" : ""}" data-category-id="${category.id}">
                        ${category.imageUrl ? `<img src="${category.imageUrl}" alt="${category.name}" class="tab-image" />` : ""}
                        <span class="tab-name">${category.name}</span>
                        ${questionCount > 0 ? `<span class="question-count-badge">${questionCount}</span>` : ""}
                    </div>
                `)

                container.append(tab)
            })
        }

        function updateCategoryContent() {
            const container = $("#categoryContent")
            container.empty()

            if (!activeCategory) {
                container.html('<div class="text-center p-5 text-muted">No categories available</div>')
                return
            }

            const categoryQuestions = questions.filter((q) => q.categoryId === activeCategory)
            const currentCategory = categories.find((c) => c.id === activeCategory)

            const questionsContainer = $('<div class="p-3"></div>')

            categoryQuestions.forEach((question, index) => {
                const questionHtml = createQuestionItem(question, index)
                questionsContainer.append(questionHtml)
            })

            container.append(questionsContainer)
        }

        function hideQuestionBuilder() {
            $("#questionBuilder").slideUp(400)
        }

        function showTypeSelector() {
            $("#selectTypeBtn").hide()
            $("#selectedTypeDisplay").hide()
            $("#typeSelector").slideDown(300)
        }

        function loadDataFromStorage() {
            const storedQuestions = localStorage.getItem("questionnaire_questions")
            const storedCategories = localStorage.getItem("questionnaire_categories")
            const storedActiveCategory = localStorage.getItem("questionnaire_active_category")
            const storedTitle = localStorage.getItem("questionnaire_title")

            if (storedQuestions) {
                questions = JSON.parse(storedQuestions)
            }

            if (storedCategories) {
                categories = JSON.parse(storedCategories)
            }

            if (storedActiveCategory) {
                activeCategory = String(storedActiveCategory)
            }

            if (storedTitle) {
                questionnaireTitle = storedTitle
            }
        }

        function showToast(message, type = "success") {
            const toast = $("#toast")
            $("#toastMessage").text(message)

            toast.removeClass("bg-success bg-danger bg-info bg-warning bg-secondary")
            switch (type) {
                case "success":
                    toast.addClass("bg-success")
                    break
                case "danger":
                    toast.addClass("bg-danger")
                    break
                case "info":
                    toast.addClass("bg-info")
                    break
                case "warning":
                    toast.addClass("bg-warning")
                    break
                case "secondary":
                    toast.addClass("bg-secondary")
                    break
            }

            toastInstance.show()
        }

        document.addEventListener('DOMContentLoaded', function () {
            const sliders = document.querySelectorAll('[data-bs-toggle="tooltip"]');

            sliders.forEach(slider => {
                // Initialize tooltip with hover trigger only
                const tooltip = new bootstrap.Tooltip(slider, {
                    trigger: 'hover',
                    placement: 'top'
                });

                // Update tooltip value on input
                slider.addEventListener('input', function () {
                    this.setAttribute('title', this.value);
                    const ttInstance = bootstrap.Tooltip.getInstance(this);
                    if (ttInstance) {
                        ttInstance.setContent({ '.tooltip-inner': this.value });
                    }
                });
            });
        });

    </script>
@endsection
