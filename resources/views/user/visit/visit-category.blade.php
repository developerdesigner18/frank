@extends('user.master')
@section('title', trans_message('visit_reports'))
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('visit.index',['page'=>'completed']) }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>{{ trans_message('completed_visits') }}</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <a href="{{ route('visit.submissions',$visitReport->report_uid) }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>{{ $visitReport->visit->branch->branch_name }}</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-500">{{ $response_data['category'][$categoryId] }}</span>
    </div>
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">{{ trans_message('visit_reports') }}</span>
    </div>
@endpush
@section('main')
    @php
        $score = $response_data['score_result'][$categoryId]??'0';
        $max_score = $response_data['max_score_result'][$categoryId]??'0';
        $ratingPercent = ($max_score > 0) ? ($score / $max_score) * 100 : 0;
        $stars = round(($ratingPercent / 100) * 5, 1); // convert 0–100% to 0–5 stars
    @endphp
    <section class="pt-4 sm:pt-6">
        <!-- Back Button -->
        <div class="mb-4 sm:mb-6">
            <a href="{{ route('visit.submissions',$visitReport->report_uid) }}"
               class="inline-flex items-center space-x-2 px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>{{ trans_message('back_to_submissions') }}</span>
            </a>
        </div>
        <div class="flex flex-col gap-4">
            <!-- Visit Report Card - Responsive Design -->
            <div class="bg-white border border-gray-200 rounded-xl sm:rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-3 py-3 sm:px-6 sm:py-4 border-b border-gray-100">
                    <!-- Mobile Layout -->
                    <div class="block sm:hidden">
                        <div class="flex items-start justify-between mb-3">
                            <!-- Date Badge -->
                            <div class="flex flex-col items-center justify-center bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm">
                                <span class="text-lg font-bold text-gray-800">{{\Carbon\Carbon::parse($visitReport->started_date)->format('d')}}</span>
                                <span class="text-xs font-medium text-gray-600 uppercase tracking-wide">{{\Carbon\Carbon::parse($visitReport->started_date)->format('M')}}</span>
                            </div>
                            <!-- Rating Section -->
                            <div class="flex items-center space-x-1">
                                @if($ratingPercent>0)
                                    <span class="text-xs font-semibold text-gray-700">{{ round($ratingPercent, 2) }}%</span>
                                    <div class="raty-rating-mobile" data-score="{{ $stars }}"></div>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                         {{ trans_message('no_rating') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- Title and Info -->
                        <div class="mb-3">
                            <h3 class="text-base font-semibold text-gray-900 mb-2 leading-tight">{{$visitReport->visit->branch->branch_name  ?? ''}}
                                {{\Carbon\Carbon::parse($visitReport->started_date)->format('F Y')}}</h3>
                            <div class="flex items-center flex-wrap gap-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                    {{ $response_data['title'] ?? ($visitReport->visit->questionnaire->name??'No title') }}
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-[#0073AF] text-white">
                                    {{ currency_icon() }} {{ $visitReport->visit->price??'0' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Layout -->
                    <div class="hidden sm:flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Date Badge -->
                            <div class="flex flex-col items-center justify-center bg-white border border-gray-200 rounded-xl px-4 py-3 shadow-sm">
                                <span class="text-2xl font-bold text-gray-800">{{\Carbon\Carbon::parse($visitReport->started_date)->format('d')}}</span>
                                <span class="text-sm font-medium text-gray-600 uppercase tracking-wide">{{\Carbon\Carbon::parse($visitReport->started_date)->format('M')}}</span>
                            </div>
                            <!-- Title and Info -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{$visitReport->visit->branch->branch_name  ?? ''}}
                                    {{\Carbon\Carbon::parse($visitReport->started_date)->format('F Y')}}</h3>
                                <div class="flex items-center space-x-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                        {{ $response_data['title'] ?? ($visitReport->visit->questionnaire->name??'No title') }}
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#0073AF] text-white">
                                        {{ currency_icon() }} {{$visitReport->visit->price??'0'}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Rating Section -->
                        <div class="flex items-center space-x-2">
                            @if($ratingPercent>0)
                                <span class="text-sm font-semibold text-gray-700">{{ round($ratingPercent, 2) }}%</span>
                                <div class="raty-rating" data-score="{{ $stars }}"></div>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                 {{ trans_message('no_rating') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-3 sm:p-6">
                    <!-- Date Range -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6 space-y-3 sm:space-y-0">
                        <!-- Start Date -->
                        <div class="flex items-center space-x-2 sm:space-x-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-xs sm:text-sm font-medium text-gray-600">    {{ trans_message('start_date') }}</span>
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-gray-900 bg-gray-50 px-2 py-1 sm:px-3 sm:py-1 rounded-lg border border-gray-200">
                                {{\Carbon\Carbon::parse($visitReport->started_date)->format('d/m/Y (D)')}}
                            </span>
                        </div>
                        <!-- End Date -->
                        <div class="flex items-center space-x-2 sm:space-x-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                <span class="text-xs sm:text-sm font-medium text-gray-600">{{ trans_message('end_date') }}</span>
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-gray-900 bg-gray-50 px-2 py-1 sm:px-3 sm:py-1 rounded-lg border border-gray-200">
                                {{\Carbon\Carbon::parse($visitReport->completed_date)->format('d/m/Y (D)')}}
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('visit.generate.pdf',$visitReport->visit_id) }}" target="_blank"
                           class="flex items-center justify-center space-x-2 px-3 py-2 sm:px-4 sm:py-2.5 bg-red-600 hover:bg-red-700 cursor-pointer text-white text-xs sm:text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3.9985 2C3.44749 2 3 2.44405 3 2.9918V21.0082C3 21.5447 3.44476 22 3.9934 22H20.0066C20.5551 22 21 21.5489 21 20.9925L20.9997 7L16 2H3.9985ZM10.5 7.5H12.5C12.5 9.98994 14.6436 12.6604 17.3162 13.5513L16.8586 15.49C13.7234 15.0421 10.4821 16.3804 7.5547 18.3321L6.3753 16.7191C7.46149 15.8502 8.50293 14.3757 9.27499 12.6534C10.0443 10.9373 10.5 9.07749 10.5 7.5ZM11.1 13.4716C11.3673 12.8752 11.6043 12.2563 11.8037 11.6285C12.2754 12.3531 12.8553 13.0182 13.5102 13.5953C12.5284 13.7711 11.5666 14.0596 10.6353 14.4276C10.8 14.1143 10.9551 13.7948 11.1 13.4716Z" />
                            </svg>

                            <span>{{ trans_message('download_report') }}</span>                        </a>
                    </div>

                    <!-- Questions -->
                    @if($questions)
                        @foreach($questions as $question)
                            @php
                                $qType = $question['qType']??'TEXT';
                                $qu_score = (!$question['score']) ? 0 : $question['score'];
                                $qu_max_score = $question['max_score']??0;
                                $final_score = ($qu_max_score>0)? round(($qu_score / $qu_max_score)*100,2) :0;
                            @endphp
                            <div class="mt-6">
                                <div class="bg-white border border-gray-200 rounded-lg p-4 sm:p-6">
                                    <!-- Question Header -->
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm sm:text-base font-medium text-[#0073AF]">{{ $question['title'] }}</h3>
                                        <span class="text-xs sm:text-sm text-gray-500 italic">
                                            @if($qType != 'SLIDER' && $qType != 'RADIO')
                                                {{ $qType == 'AMOUNT'? currency_icon().' '.number_format((float)($question['answer'] ?? 0), 2, ',', '.'):($question['answer'] ?? '') }}
                                            @else
                                                @if($qu_max_score>0)
                                                    {{ $qu_score }}/{{ $qu_max_score }}
                                                @endif
                                            @endif
                                        </span>
                                    </div>

                                    @if(isset($question['answer_image']) && !empty($question['answer_image']))
                                        <!-- Image Display -->
                                        <div class="mt-4">
                                            <div class="w-full h-48 sm:h-64 rounded-lg overflow-hidden bg-gray-100">
                                                <img src="{{ $question['answer_image'] }}"
                                                     alt="Question 2 Image" class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                    @endif
                                    @if($question['comment'])
                                        <div class="space-y-2 mt-4">
                                            {{ $question['comment'] }}
                                        </div>
                                    @endif
                                    @if(count($question['photo'])>0)
                                        <div class="space-y-2 mt-4 flex space-x-2">
                                            @foreach($question['photo'] as $image)
                                                @if ($image && $image != null && $image != '')
                                                    <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$image) }}" width="200" height="100">
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $('.raty-rating').each(function() {
            let score = $(this).data('score'); // get the score from data attribute
            $(this).raty({
                readOnly: true,
                score: score,                  // 0–5 value
                starType: 'i',                 // use <i> tags (FontAwesome)
                hints: ['bad', 'poor', 'regular', 'good', 'excellent'],
                starOn: 'fa fa-star text-yellow-400',
                starOff: 'fa fa-star text-gray-300',
                starHalf: 'fa fa-star-half-alt text-yellow-400',
            });
        });
        $('.raty-rating-mobile').each(function() {

            let score = $(this).data('score'); // get the score from data attribute
            $(this).raty({
                readOnly: true,
                score: score,                  // 0–5 value
                starType: 'i',                 // use <i> tags (FontAwesome)
                hints: ['bad', 'poor', 'regular', 'good', 'excellent'],
                starOn: 'fa fa-star text-yellow-400',
                starOff: 'fa fa-star text-gray-300',
                starHalf: 'fa fa-star-half-alt text-yellow-400',
            });
        });
    </script>
@endsection
