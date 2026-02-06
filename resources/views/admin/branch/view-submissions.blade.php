@extends('admin.master')
@section('title',' Visit Reports')
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('admin.visit.index',['page'=>'completed']) }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>Completed Visits</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-500">{{ $visitReport->visit->branch->branch_name }}</span>
    </div>
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">Visit Reports</span>
    </div>
@endpush
@section('main')
    @php
        $score = $response_data['score']??'0';
        $max_score = $response_data['max_score']??'0';
        $ratingPercent = ($max_score > 0) ? ($score / $max_score) * 100 : 0;
        $stars = round(($ratingPercent / 100) * 5, 1); // convert 0–100% to 0–5 stars
    @endphp
    <section class="pt-4 sm:pt-6">
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
                                <span class="text-xs font-semibold text-gray-700">{{ round($ratingPercent, 2) }}%</span>
                                <div class="raty-rating-mobile" data-score="{{ $stars }}"></div>
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
                            <span class="text-sm font-semibold text-gray-700">{{ round($ratingPercent, 2) }}%</span>
                            <div class="raty-rating" data-score="{{ $stars }}"></div>
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
                                <span class="text-xs sm:text-sm font-medium text-gray-600">Start Date</span>
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-gray-900 bg-gray-50 px-2 py-1 sm:px-3 sm:py-1 rounded-lg border border-gray-200">
                                {{\Carbon\Carbon::parse($visitReport->started_date)->format('d/m/Y (D)')}}
                            </span>
                        </div>
                        <!-- End Date -->
                        <div class="flex items-center space-x-2 sm:space-x-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                <span class="text-xs sm:text-sm font-medium text-gray-600">End Date</span>
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-gray-900 bg-gray-50 px-2 py-1 sm:px-3 sm:py-1 rounded-lg border border-gray-200">
                                {{\Carbon\Carbon::parse($visitReport->completed_date)->format('d/m/Y (D)')}}
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('admin.visit.generate.pdf',$visitReport->visit_id) }}" target="_blank"
                           class="flex items-center justify-center space-x-2 px-3 py-2 sm:px-4 sm:py-2.5 bg-red-600 hover:bg-red-700 cursor-pointer text-white text-xs sm:text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3.9985 2C3.44749 2 3 2.44405 3 2.9918V21.0082C3 21.5447 3.44476 22 3.9934 22H20.0066C20.5551 22 21 21.5489 21 20.9925L20.9997 7L16 2H3.9985ZM10.5 7.5H12.5C12.5 9.98994 14.6436 12.6604 17.3162 13.5513L16.8586 15.49C13.7234 15.0421 10.4821 16.3804 7.5547 18.3321L6.3753 16.7191C7.46149 15.8502 8.50293 14.3757 9.27499 12.6534C10.0443 10.9373 10.5 9.07749 10.5 7.5ZM11.1 13.4716C11.3673 12.8752 11.6043 12.2563 11.8037 11.6285C12.2754 12.3531 12.8553 13.0182 13.5102 13.5953C12.5284 13.7711 11.5666 14.0596 10.6353 14.4276C10.8 14.1143 10.9551 13.7948 11.1 13.4716Z"/>
                            </svg>
                            <span>Download Report</span>
                        </a>
                    </div>

                    <!-- Categories Section -->
                    <div class="mt-6 space-y-3">
                        @if($response_data['category'])
                            @foreach($response_data['category'] as $category_id => $category)
                                @php
                                    $cat_score = $response_data['score_result'][$category_id]??'0';
                                    $cat_max_score = $response_data['max_score_result'][$category_id]??'0';
                                    $cat_ratingPercent = ($cat_max_score > 0) ? ($cat_score / $cat_max_score) * 100 : 0;
                                    $cat_stars = round(($cat_ratingPercent / 100) * 5, 1); // convert 0–100% to 0–5 stars
                                @endphp
                                        <!-- Category -->
                                <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center space-x-3">
                                        <!-- Category Name -->
                                        <div>
                                            <h4 class="text-sm sm:text-base font-medium text-gray-900">{{ $category ?? 'Unknown' }}
                                            </h4>
                                        </div>
                                    </div>
                                    <!-- Rating and Arrow -->
                                    <div class="flex items-center space-x-2">

                                        @if($cat_ratingPercent > 0)
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm font-semibold text-gray-700">{{ round($cat_ratingPercent, 2) }}%</span>
                                                <div class="raty-cat-rating" data-score="{{ $cat_stars }}"></div>
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                No Rating
                                            </span>
                                        @endif
                                        <a href="{{ route('admin.visit.category.section',['reportId'=>$visitReport->report_uid, 'categoryId'=>$category_id]) }}">
                                            <svg class="w-4 h-4 text-[#0073AF]" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $('.raty-rating').each(function () {

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
        $('.raty-rating-mobile').each(function () {

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
        $('.raty-cat-rating').each(function () {

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
