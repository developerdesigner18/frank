<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Satisfaction Survey form Wizard by Ansonika.">
    <meta name="author" content="Ansonika">
    <title>Survey | {{env('APP_NAME')}}</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('assets/logo/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon"
          href="{{ asset('assets/survey/img/apple-touch-icon-57x57-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"
          href="{{ asset('assets/survey/img/apple-touch-icon-72x72-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
          href="{{ asset('assets/survey/img/apple-touch-icon-114x114-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
          href="{{ asset('assets/survey/img/apple-touch-icon-144x144-precomposed.png') }}">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Caveat|Poppins:300,400,500,600,700&amp;display=swap"
          rel="stylesheet">

    <!-- BASE CSS -->
    <link href="{{ asset('assets/survey/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/survey/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/survey/css/vendors.css') }}" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <link href="{{asset('assets/admin/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('assets/admin/libs/dropify/dist/css/dropify.min.css')}}">

    <!-- YOUR CUSTOM CSS -->
    <link href="{{ asset('assets/survey/css/custom.css') }}" rel="stylesheet">

</head>

<body class="style_3">

<div id="preloader">
    <div data-loader="circle-side"></div>
</div><!-- /Preload -->

<div id="loader_form">
    <div data-loader="circle-side-2"></div>
</div><!-- /loader_form -->

<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-5 align-content-center">
                <a href="{{route('visit.index')}}" class="h6"><img src="{{ asset('assets/survey/img/back.png') }}"
                                                                   alt="" width="15" height="15"> Back</a>
            </div>
            <div class="col-7">
                <div id="social">
                    <ul>
                        <li><span class="text-white h6">{{ $questionnaire->name }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
</header>
<!-- /header -->

<div class="wrapper_centering">
    <div class="container_centering">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xl-6 col-lg-6 d-flex align-items-center justify-content-center">
                    <div class="">
                        <img src="{{ asset('assets/logo/main.png') }}" alt="">
                    </div>
                </div>
                <!-- /col -->
                <div class="col-xl-5 col-lg-5">
                    <div id="wizard_container" class="d-inline align-items-center">
                        <div id="top-wizard">
                            <div id="progressbar"></div>
                        </div>
                        <!-- /top-wizard -->
                        <form id="wrapped" class="questionForm" method="POST" autocomplete="off"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="visit_id" value="{{ $rowData->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->guard('web')->user()->id }}">
                            <input type="hidden" name="branch_id" value="{{ $rowData->branch_id }}">
                            <input type="hidden" name="title" value="{{ $payload->title }}">
                            <input id="website" name="website" type="text" value="">
                            <!-- Leave for security protection, read docs for details -->
                            <div id="middle-wizard">

                                @foreach($payload->questions as $qu_k => $question)

                                    @php
                                        $question_id = $question->id;
                                        $report_response_data = [];
                                        $report_result = $old_photos = [];
                                        if(isset($old_questions[$question->categoryId])){
                                            $report_response_data = $old_questions[$question->categoryId];
                                            $report_result = array_values(array_filter($report_response_data, function ($item) use ($question_id) {
                                                return $item->qId == $question_id;
                                            }));
                                            $report_result = ($report_result[0])?$report_result[0]:[];
                                            $old_photos = ($report_result->photo)?$report_result->photo:[];
                                        }
                                    @endphp

                                    <input type="hidden" name="question[{{ $question->id }}][categoryId]"
                                           value="{{ $question->categoryId }}">
                                    <input type="hidden" name="question[{{ $question->id }}][categoryName]"
                                           value="{{ $categoryName = $categoryMap[$question->categoryId] ?? 'Unknown' }}">
                                    <input type="hidden" name="question[{{ $question->id }}][title]"
                                           value="{{ $question->title }}">
                                    <input type="hidden" name="question[{{ $question->id }}][type]"
                                           value="{{ $question->type }}">
                                    {{--                                    <div class="{{ (count($payload->questions)==($qu_k+1))?'submit':'' }} step">--}}
                                    <div class="step">
                                        <h3 class="main_question"><strong>{{$qu_k+1}}
                                                of {{ count($payload->questions)+2 }} <span>({{ $categoryName }})</span></strong>{{$question->title}}
                                        </h3>
                                        @php
                                            $isRequired = false;
                                            $isReadonly = false;
                                            if(isset($report_result)) {
                                                if(isset($report_result->na)){
                                                    if($report_result->na == '0') {
                                                        $isRequired = true;
                                                    }
                                                    if($report_result->na == '1') {
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
                                                    <div class="review_block">
                                                        <ul>
                                                            @foreach($question->options as $idx => $option)
                                                                <li>
                                                                    <div class="checkbox_radio_container">
                                                                        <input type="radio"
                                                                               id="radio-{{ $question->id }}-{{ $idx }}"
                                                                               name="question[{{ $question->id }}][answer]"
                                                                               class="answer-{{ $question->id }} {{ $isRequired ? 'required' : '' }}"
                                                                               value="{{ $option->value }},({{ $option->score??0 }})"
                                                                               {{ (isset($report_result->answer) && $report_result->answer==$option->value)?'checked':'' }} {{ $isReadonly ? 'disabled="disabled"' : '' }} onchange="getVals(this, 'question_{{$qu_k+1}}', 'radio', '{{ $option->value }} (Score: {{ $option->score??0 }})');">
                                                                        <label class="radio"
                                                                               for="radio-{{ $question->id }}-{{ $idx }}"></label>
                                                                        <label for="radio-{{ $question->id }}-{{ $idx }}"
                                                                               class="wrapper">
                                                                            {{ $option->text }}
                                                                            @isset($option->score)
                                                                                (Score: {{ $option->score }})
                                                                            @endisset
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="form-group multi-input-block">
                                                        <div class="" role="group">
                                                            <input type="radio" class="btn-check input-type-radio"
                                                                   name="input_type_{{ $question->id }}"
                                                                   id="input_comment_{{ $question->id }}"
                                                                   value="comment" checked>
                                                            <label class="btn" for="input_comment_{{ $question->id }}">💬
                                                                Comment</label>

                                                            <input type="radio" class="btn-check input-type-radio"
                                                                   name="input_type_{{ $question->id }}"
                                                                   id="input_photo_{{ $question->id }}" value="photo">
                                                            <label class="btn" for="input_photo_{{ $question->id }}">📷
                                                                Photo</label>

                                                            <span class="align-items-center gap-1">
                                                                <input type="checkbox" class="na-checkbox ms-2"
                                                                       name="question[{{ $question->id }}][na]"
                                                                       value="1" id="input_na_{{ $question->id }}"
                                                                       {{ (isset($report_result->na) && $report_result->na==1)?'checked':'' }} onchange="getInputNa(this, '{{$question->id}}', {{$qu_k+1}}, 'radio');">
                                                                <label for="input_na_{{ $question->id }}" class="mb-0">N/A</label>
                                                            </span>
                                                        </div>

                                                        <div class="comment-box mt-3">
                                                            <textarea class="form-control"
                                                                      name="question[{{ $question->id }}][comment]"
                                                                      style="height:120px;"
                                                                      placeholder="Add Comment Here..."
                                                                      onkeyup="getVals(this, 'additional_comment_{{ $qu_k+1 }}');">{{ isset($report_result->comment)?$report_result->comment:'' }}</textarea>
                                                        </div>

                                                        <div class="photo-box mt-3 d-none">
                                                            <input type="file"
                                                                   name="question[{{ $question->id }}][photo][]"
                                                                   class="form-control comment-photo-input" multiple
                                                                   accept="image/*" style="height: 33px;"
                                                                   onchange="getVals(this, 'additional_photo_{{ $qu_k+1 }}');">
                                                            <div class="photo-preview mt-3 d-flex gap-2 flex-wrap">
                                                                @if($old_photos)
                                                                    @foreach($old_photos as $oldImg)
                                                                        <div class="image-preview position-relative">
                                                                            <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}"
                                                                                 class="rounded border" width="100"
                                                                                 height="100" style="object-fit:cover;">
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endif
                                                @break

                                            @case('SELECT')
                                                <div class="form-group">
                                                    <select class="form-control answer-{{ $question->id }} {{ $isRequired ? 'required' : '' }}"
                                                            name="question[{{ $question->id }}][answer]"
                                                            {{ $isReadonly ? 'disabled="disabled"' : '' }} onchange="getVals(this, 'question_{{$qu_k+1}}', 'select');">
                                                        <option value="">Select an option</option>
                                                        @foreach($question->options as $option)
                                                            <option value="{{ $option->value }},({{ $option->score??0 }})" {{ (isset($report_result->answer) && $report_result->answer==$option->value)?'selected':'' }}>
                                                                {{ $option->text }}
                                                                @isset($option->score)
                                                                    (Score: {{ $option->score }})
                                                                @endisset
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group multi-input-block">
                                                    <div class="" role="group">
                                                        <input type="radio" class="btn-check input-type-radio"
                                                               name="input_type_{{ $question->id }}"
                                                               id="input_comment_{{ $question->id }}" value="comment"
                                                               checked>
                                                        <label class="btn" for="input_comment_{{ $question->id }}">💬
                                                            Comment</label>

                                                        <input type="radio" class="btn-check input-type-radio"
                                                               name="input_type_{{ $question->id }}"
                                                               id="input_photo_{{ $question->id }}" value="photo">
                                                        <label class="btn" for="input_photo_{{ $question->id }}">📷
                                                            Photo</label>

                                                        <span class="align-items-center gap-1">
                                                            <input type="checkbox" class="na-checkbox ms-2"
                                                                   name="question[{{ $question->id }}][na]" value="1"
                                                                   id="input_na_{{ $question->id }}"
                                                                   {{ (isset($report_result->na) && $report_result->na==1)?'checked':'' }} onchange="getInputNa(this, '{{$question->id}}', {{$qu_k+1}}, 'select');">
                                                            <label for="input_na_{{ $question->id }}"
                                                                   class="mb-0">N/A</label>
                                                        </span>
                                                    </div>

                                                    <div class="comment-box mt-3">
                                                        <textarea class="form-control"
                                                                  name="question[{{ $question->id }}][comment]"
                                                                  style="height:120px;"
                                                                  placeholder="Add Comment Here..."
                                                                  onkeyup="getVals(this, 'additional_comment_{{ $qu_k+1 }}');">{{ isset($report_result->comment)?$report_result->comment:'' }}</textarea>
                                                    </div>

                                                    <div class="photo-box mt-3 d-none">
                                                        <input type="file" name="question[{{ $question->id }}][photo][]"
                                                               class="form-control comment-photo-input" multiple
                                                               accept="image/*" style="height: 33px;"
                                                               onchange="getVals(this, 'additional_photo_{{ $qu_k+1 }}');">
                                                        <div class="photo-preview mt-3 d-flex gap-2 flex-wrap">
                                                            @if($old_photos)
                                                                @foreach($old_photos as $oldImg)
                                                                    <div class="image-preview position-relative">
                                                                        <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}"
                                                                             class="rounded border" width="100"
                                                                             height="100" style="object-fit:cover;">
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                                @break

                                            @case('SLIDER')
                                                @php
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
                                                        $defaultValue = 0;
                                                    }else{
                                                        $defaultValue = (isset($report_result->answer)?($report_result->answer??0):$minScore);
                                                    }
                                                @endphp
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
                                                           {{ $isReadonly ? 'disabled="disabled"' : '' }}
                                                           onchange="getVals(this, 'question_{{$qu_k+1}}','range');"/>

                                                    <div class="range-labels">
                                                        @if($options)
                                                            @foreach($options as $opt)
                                                                <span>{{ $opt->text }}</span>
                                                            @endforeach
                                                        @else
                                                            @if(isset($question->minValue) && isset($question->maxValue))
                                                                @if($question->maxValue>0)
                                                                    @for($i = $minScore; $i <= $maxScore; $i += round(($maxScore - $minScore)/4))
                                                                        <span>{{ $i }}</span>
                                                                    @endfor
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                {{--                                                <div class="form-group">--}}
                                                {{--                                                    <input type="range" class="form-range answer-{{ $question->id }} slider-input" name="question[{{ $question->id }}][answer]" min="{{ $minScore }}" max="{{ $maxScore }}" step="{{ $question->step??1 }}" value="{{ $minScore }}" onchange="getVals(this, 'question_{{$qu_k+1}}','range');">--}}
                                                {{--                                                    <div class="d-flex justify-content-between small text-muted mt-1">--}}
                                                {{--                                                        <span class="text-white">{{ $minScore }}</span>--}}
                                                {{--                                                        <span class="fw-bold slider-value text-white">{{ $minScore }}</span>--}}
                                                {{--                                                        <span class="text-white">{{ $maxScore }}</span>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
                                                <div class="form-group multi-input-block">
                                                    <div class="" role="group">
                                                        <input type="radio" class="btn-check input-type-radio"
                                                               name="input_type_{{ $question->id }}"
                                                               id="input_comment_{{ $question->id }}" value="comment"
                                                               checked>
                                                        <label class="btn" for="input_comment_{{ $question->id }}">💬
                                                            Comment</label>

                                                        <input type="radio" class="btn-check input-type-radio"
                                                               name="input_type_{{ $question->id }}"
                                                               id="input_photo_{{ $question->id }}" value="photo">
                                                        <label class="btn" for="input_photo_{{ $question->id }}">📷
                                                            Photo</label>

                                                        <span class="align-items-center gap-1">
                                                            <input type="checkbox" class="na-checkbox ms-2"
                                                                   name="question[{{ $question->id }}][na]" value="1"
                                                                   id="input_na_{{ $question->id }}"
                                                                   {{ (isset($report_result->na) && $report_result->na==1)?'checked':'' }} onchange="getInputNa(this, '{{$question->id}}', {{$qu_k+1}}, 'range');">
                                                            <label for="input_na_{{ $question->id }}"
                                                                   class="mb-0">N/A</label>
                                                        </span>
                                                    </div>

                                                    <div class="comment-box mt-3">
                                                        <textarea class="form-control"
                                                                  name="question[{{ $question->id }}][comment]"
                                                                  style="height:120px;"
                                                                  placeholder="Add Comment Here..."
                                                                  onkeyup="getVals(this, 'additional_comment_{{ $qu_k+1 }}');">{{ isset($report_result->comment)?$report_result->comment:'' }}</textarea>
                                                    </div>

                                                    <div class="photo-box mt-3 d-none">
                                                        <input type="file" name="question[{{ $question->id }}][photo][]"
                                                               class="form-control comment-photo-input" multiple
                                                               accept="image/*" style="height: 33px;"
                                                               onchange="getVals(this, 'additional_photo_{{ $qu_k+1 }}');">
                                                        <div class="photo-preview mt-3 d-flex gap-2 flex-wrap">
                                                            @if($old_photos)
                                                                @foreach($old_photos as $oldImg)
                                                                    <div class="image-preview position-relative">
                                                                        <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}"
                                                                             class="rounded border" width="100"
                                                                             height="100" style="object-fit:cover;">
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                                @break

                                            @case('AMOUNT')
                                                <div class="form-group">
                                                    <label for="amount-{{ $question->id }}">{{ $question->placeholder ?? 'Enter your Amount' }}</label>
                                                    <input type="number" step="any"
                                                           class="answer-{{ $question->id }} form-control {{ $isRequired ? 'required' : '' }}"
                                                           id="amount-{{ $question->id }}"
                                                           name="question[{{ $question->id }}][answer]"
                                                           value="{{ isset($report_result->answer)?$report_result->answer:'' }}"
                                                           {{ $isReadonly ? 'readonly="readonly"' : '' }} onkeyup="getVals(this, 'question_{{$qu_k+1}}');">
                                                </div>
                                                <div class="form-group multi-input-block">
                                                    <div class="" role="group">
                                                        <input type="radio" class="btn-check input-type-radio"
                                                               name="input_type_{{ $question->id }}"
                                                               id="input_comment_{{ $question->id }}" value="comment"
                                                               checked>
                                                        <label class="btn" for="input_comment_{{ $question->id }}">💬
                                                            Comment</label>

                                                        <input type="radio" class="btn-check input-type-radio"
                                                               name="input_type_{{ $question->id }}"
                                                               id="input_photo_{{ $question->id }}" value="photo">
                                                        <label class="btn" for="input_photo_{{ $question->id }}">📷
                                                            Photo</label>

                                                        <span class="align-items-center gap-1">
                                                            <input type="checkbox" class="na-checkbox ms-2"
                                                                   name="question[{{ $question->id }}][na]" value="1"
                                                                   id="input_na_{{ $question->id }}"
                                                                   {{ (isset($report_result->na) && $report_result->na==1)?'checked':'' }} onchange="getInputNa(this, '{{$question->id}}', {{$qu_k+1}});">
                                                            <label for="input_na_{{ $question->id }}"
                                                                   class="mb-0">N/A</label>
                                                        </span>
                                                    </div>

                                                    <div class="comment-box mt-3">
                                                        <textarea class="form-control"
                                                                  name="question[{{ $question->id }}][comment]"
                                                                  style="height:120px;"
                                                                  placeholder="Add Comment Here..."
                                                                  onkeyup="getVals(this, 'additional_comment_{{ $qu_k+1 }}');">{{ isset($report_result->comment)?$report_result->comment:'' }}</textarea>
                                                    </div>

                                                    <div class="photo-box mt-3 d-none">
                                                        <input type="file" name="question[{{ $question->id }}][photo][]"
                                                               class="form-control comment-photo-input" multiple
                                                               accept="image/*" style="height: 33px;"
                                                               onchange="getVals(this, 'additional_photo_{{ $qu_k+1 }}');">
                                                        <div class="photo-preview mt-3 d-flex gap-2 flex-wrap">
                                                            @if($old_photos)
                                                                @foreach($old_photos as $oldImg)
                                                                    <div class="image-preview position-relative">
                                                                        <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}"
                                                                             class="rounded border" width="100"
                                                                             height="100" style="object-fit:cover;">
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                                @break

                                            @case('TEXT')
                                                <div class="form-group">
                                                    <label for="text-{{ $question->id }}">{{ $question->placeholder ?? 'Enter your Text' }}</label>
                                                    <input type="text"
                                                           class="answer-{{ $question->id }} form-control {{ $isRequired ? 'required' : '' }}"
                                                           id="text-{{ $question->id }}"
                                                           name="question[{{ $question->id }}][answer]"
                                                           value="{{ isset($report_result->answer)?$report_result->answer:'' }}"
                                                           {{ $isReadonly ? 'readonly="readonly"' : '' }} onkeyup="getVals(this, 'question_{{$qu_k+1}}');">
                                                </div>
                                                <div class="form-group multi-input-block">
                                                    <div class="" role="group">
                                                        <input type="radio" class="btn-check input-type-radio"
                                                               name="input_type_{{ $question->id }}"
                                                               id="input_comment_{{ $question->id }}" value="comment"
                                                               checked>
                                                        <label class="btn" for="input_comment_{{ $question->id }}">💬
                                                            Comment</label>

                                                        <input type="radio" class="btn-check input-type-radio"
                                                               name="input_type_{{ $question->id }}"
                                                               id="input_photo_{{ $question->id }}" value="photo">
                                                        <label class="btn" for="input_photo_{{ $question->id }}">📷
                                                            Photo</label>

                                                        <span class="align-items-center gap-1">
                                                            <input type="checkbox" class="na-checkbox ms-2"
                                                                   name="question[{{ $question->id }}][na]" value="1"
                                                                   id="input_na_{{ $question->id }}"
                                                                   {{ (isset($report_result->na) && $report_result->na==1)?'checked':'' }} onchange="getInputNa(this, '{{$question->id}}', {{$qu_k+1}});">
                                                            <label for="input_na_{{ $question->id }}"
                                                                   class="mb-0">N/A</label>
                                                        </span>
                                                        {{--                                                        <span class="align-items-center">--}}
                                                        {{--                                                            <input type="checkbox" class="na-checkbox" id="input_na_{{ $question->id }}" name="question[{{ $question->id }}][na]" value="1" {{ (isset($report_result) && $report_result->na==1)?'checked':'' }} onchange="getVals(this, '{{$question->id}}', {{$qu_k+1}});">--}}
                                                        {{--                                                            <label class="checkbox" for="input_na_{{ $question->id }}"></label>--}}
                                                        {{--                                                            <label for="input_na_{{ $question->id }}" class="wrapper">N/A</label>--}}
                                                        {{--                                                        </span>--}}
                                                    </div>

                                                    <div class="comment-box mt-3">
                                                        <textarea class="form-control"
                                                                  name="question[{{ $question->id }}][comment]"
                                                                  style="height:120px;"
                                                                  placeholder="Add Comment Here..."
                                                                  onkeyup="getVals(this, 'additional_comment_{{ $qu_k+1 }}');">{{ isset($report_result->comment)?$report_result->comment:'' }}</textarea>
                                                    </div>

                                                    <div class="photo-box mt-3 d-none">
                                                        <input type="file" name="question[{{ $question->id }}][photo][]"
                                                               class="form-control comment-photo-input" multiple
                                                               accept="image/*" style="height: 33px;"
                                                               onchange="getVals(this, 'additional_photo_{{ $qu_k+1 }}');">
                                                        <div class="photo-preview mt-3 d-flex gap-2 flex-wrap">
                                                            @if($old_photos)
                                                                @foreach($old_photos as $oldImg)
                                                                    <div class="image-preview position-relative">
                                                                        <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}"
                                                                             class="rounded border" width="100"
                                                                             height="100" style="object-fit:cover;">
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                                @break

                                            @case('COMMENT')
                                                <div class="form-group">
                                                    <label for="message-{{ $question->id }}">{{ $question->placeholder ?? 'Enter your comment' }}</label>
                                                    <textarea name="question[{{ $question->id }}][answer]"
                                                              id="message-{{ $question->id }}"
                                                              class="answer-{{ $question->id }} form-control {{ $isRequired ? 'required' : '' }}"
                                                              style="height:120px;"
                                                              {{ $isReadonly ? 'readonly="readonly"' : '' }} onkeyup="getVals(this, 'question_{{$qu_k+1}}');">{{ isset($report_result->answer)?$report_result->answer:'' }}</textarea>
                                                </div>
                                                <div class="form-group multi-input-block">
                                                    <div class="" role="group">
                                                        <input type="radio" class="btn-check input-type-radio"
                                                               name="input_type_{{ $question->id }}"
                                                               id="input_comment_{{ $question->id }}" value="comment"
                                                               checked>
                                                        <label class="btn" for="input_comment_{{ $question->id }}">💬
                                                            Comment</label>

                                                        <input type="radio" class="btn-check input-type-radio"
                                                               name="input_type_{{ $question->id }}"
                                                               id="input_photo_{{ $question->id }}" value="photo">
                                                        <label class="btn" for="input_photo_{{ $question->id }}">📷
                                                            Photo</label>

                                                        <span class="align-items-center gap-1">
                                                            <input type="checkbox" class="na-checkbox ms-2"
                                                                   name="question[{{ $question->id }}][na]" value="1"
                                                                   id="input_na_{{ $question->id }}"
                                                                   {{ (isset($report_result->na) && $report_result->na==1)?'checked':'' }} onchange="getInputNa(this, '{{$question->id}}', {{$qu_k+1}});">
                                                            <label for="input_na_{{ $question->id }}"
                                                                   class="mb-0">N/A</label>
                                                        </span>
                                                    </div>

                                                    <div class="comment-box mt-3">
                                                        <textarea class="form-control"
                                                                  name="question[{{ $question->id }}][comment]"
                                                                  style="height:120px;"
                                                                  placeholder="Add Comment Here..."
                                                                  onkeyup="getVals(this, 'additional_comment_{{ $qu_k+1 }}');">{{ isset($report_result->comment)?$report_result->comment:'' }}</textarea>
                                                    </div>

                                                    <div class="photo-box mt-3 d-none">
                                                        <input type="file" name="question[{{ $question->id }}][photo][]"
                                                               class="form-control comment-photo-input" multiple
                                                               accept="image/*" style="height: 33px;"
                                                               onchange="getVals(this, 'additional_photo_{{ $qu_k+1 }}');">
                                                        <div class="photo-preview mt-3 d-flex gap-2 flex-wrap">
                                                            @if($old_photos)
                                                                @foreach($old_photos as $oldImg)
                                                                    <div class="image-preview position-relative">
                                                                        <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}"
                                                                             class="rounded border" width="100"
                                                                             height="100" style="object-fit:cover;">
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
                                @endforeach
                                <!-- /step 1-->

                                <div class="step">
                                    <h3 class="main_question"><strong>{{ count($payload->questions)+1 }}
                                            of {{ count($payload->questions)+2 }}</strong>Summary</h3>
                                    <div class="summary">
                                        <ul>
                                            @foreach($payload->questions as $qu_step_k => $question)
                                                @php
                                                    $question_id = $question->id;
                                                    $report_response_data = [];
                                                    $report_result = $old_photos = [];
                                                    if(isset($old_questions[$question->categoryId])){
                                                        $report_response_data = $old_questions[$question->categoryId];
                                                        $report_result = array_values(array_filter($report_response_data, function ($item) use ($question_id) {
                                                            return $item->qId == $question_id;
                                                        }));
                                                        $report_result = ($report_result[0])?$report_result[0]:[];
                                                        $old_photos = ($report_result->photo)?$report_result->photo:[];
                                                    }
                                                @endphp
                                                <li>
                                                    <strong>{{$qu_step_k+1}}</strong>
                                                    <h5>{{$question->title}}</h5>
                                                    <p id="question_{{$qu_step_k+1}}" class="mb-2">
                                                        @if($report_result)
                                                            {{ (isset($report_result->na) && $report_result->na==1)?'N/A':$report_result->answer }}
                                                            @if($report_result->score)
                                                                , (Score: {{ $report_result->score??0 }})
                                                            @endif
                                                        @endif
                                                    </p>
                                                    <p id="additional_comment_{{$qu_step_k+1}}">
                                                        {{ isset($report_result->comment)?$report_result->comment:'' }}
                                                    </p>
                                                    <div id="additional_photo_{{$qu_step_k+1}}_summary"
                                                         class="photo-preview-summary d-flex gap-2 flex-wrap">
                                                        @if($old_photos)
                                                            @foreach($old_photos as $oldImg)
                                                                <div class="image-preview position-relative">
                                                                    <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$oldImg) }}"
                                                                         class="rounded border" width="100" height="100"
                                                                         style="object-fit:cover;">
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="submit step">
                                    <h3 class="main_question"><strong>{{ count($payload->questions)+2 }}
                                            of {{ count($payload->questions)+2 }}</strong>Visits Conducted</h3>
                                    <div class="form-group">
                                        <label for="started_date">Started</label>
                                        <input type="datetime-local" class="form-control required last_date"
                                               value="{{ (isset($visit_report_data->started_date)?$visit_report_data->started_date:'') }}"
                                               name="started_date">
                                    </div>
                                    <div class="form-group">
                                        <label for="completed_date">Completed</label>
                                        <input type="datetime-local" class="form-control required last_date"
                                               value="{{ (isset($visit_report_data->completed_date)?$visit_report_data->completed_date:'') }}"
                                               name="completed_date">
                                    </div>
                                </div>
                                <!-- /last step-->

                            </div>
                            <!-- /middle-wizard -->

                            <div id="bottom-wizard">
                                <button type="button" name="backward" class="backward">Prev</button>
                                <button type="button" name="forward" class="forward">Next</button>
                                <button type="button" name="process" data-visit_id="{{ $rowData->id }}"
                                        data-user_id="{{ auth()->guard('web')->user()->id }}"
                                        class="submit last_submit">Submit
                                </button>
                            </div>
                            <!-- /bottom-wizard -->

                        </form>
                    </div>
                    <!-- /Wizard container -->
                </div>
                <!-- /col -->
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container_centering -->
    <footer>

    </footer>
    <!-- /footer -->
</div>
<!-- /wrapper_centering -->

<!-- Modal terms -->
<div class="modal fade" id="terms-txt" tabindex="-1" role="dialog" aria-labelledby="termsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="termsLabel">Terms and conditions</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Lorem ipsum dolor sit amet, in porro albucius qui, in <strong>nec quod novum accumsan</strong>, mei
                    ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne
                    quod dicunt sensibus.</p>
                <p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam
                    dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt
                    sensibus. Lorem ipsum dolor sit amet, <strong>in porro albucius qui</strong>, in nec quod novum
                    accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum
                    sanctus, pro ne quod dicunt sensibus.</p>
                <p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam
                    dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt
                    sensibus.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn_1" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- COMMON SCRIPTS -->
<script src="{{ asset('assets/survey/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/survey/js/common_scripts.min.js') }}"></script>
<script src="{{ asset('assets/survey/js/functions.js') }}"></script>

<!-- Wizard script -->
<script src="{{ asset('assets/survey/js/survey_func.js') }}"></script>

<script src="{{asset('assets/admin/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'></script>

@include('admin.layouts.common-js')
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
                sendToast('Data saved successfully.');
            },
            error: function (xhr) {
                sendToast('Data save failed:' + xhr.responseText, 'danger');
            }
        });
    }

    $(document).ready(function () {
        // $(document).on("input", ".slider-input", function () {
        //     const value = $(this).val()
        //     $(this).siblings(".d-flex").find(".slider-value").text(value)
        // });

        $(document).on("click", ".last_submit", function (e) {
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

    });
    $(document).ready(function () {
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

            $photoInput.on('change', function () {
                $previewBox.empty(); // Clear old previews
                const files = this.files;

                if (files.length > 0) {
                    [...files].forEach(file => {
                        if (!file.type.startsWith('image/')) return;

                        const reader = new FileReader();
                        reader.onload = function (e) {
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
                $(this).closest('.image-preview').remove();
            });

            // Initial check
            updateDisplay();
        });
    });

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
                    ttInstance.setContent({'.tooltip-inner': this.value});
                }
            });
        });
    });

</script>


</body>
</html>
