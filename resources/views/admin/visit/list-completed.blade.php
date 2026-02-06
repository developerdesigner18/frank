{{--@dd($resultData)--}}
@if($resultData->all())
@foreach($resultData as $report)
    @php
        $responseData = is_string($report->response_data) ? json_decode($report->response_data, true) : $report->response_data;
        $score = $responseData['score']??'0';
        $max_score = $responseData['max_score']??'0';
        $ratingPercent = ($max_score > 0) ? ($score / $max_score) * 100 : 0;
        $stars = round(($ratingPercent / 100) * 5, 1); // convert 0–100% to 0–5 stars
        $fullStars = floor($stars);
        $halfStar = ($stars - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

        // Calculate reimbursement from AMOUNT type questions
        $reimbursementAmount = calculateReimbursementAmount($responseData);
    @endphp
    <!-- Visit Report Card - Responsive Design -->
    <div class="bg-white border border-gray-200 rounded-xl sm:rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-3 py-3 sm:px-6 sm:py-4 border-b border-gray-100">
            <!-- Mobile Layout -->
            <div class="block sm:hidden">
                <div class="flex items-start justify-between mb-3">
                    <!-- Date Badge -->
                    <div class="flex flex-col items-center justify-center bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm">
                        <span class="text-lg font-bold text-gray-800">{{\Carbon\Carbon::parse($report->started_date)->format('d')}}</span>
                        <span class="text-xs font-medium text-gray-600 uppercase tracking-wide">{{\Carbon\Carbon::parse($report->started_date)->format('M')}}</span>
                    </div>
                    <!-- Rating Section -->
                    <div class="flex items-center space-x-1">
                        <span class="text-xs font-semibold text-gray-700">{{ round($ratingPercent, 2) }}%</span>
                        <div class="raty-rating-mobile" data-score="{{ $stars }}"></div>
                    </div>
                </div>

                        <!-- Title and Info -->
                <div class="mb-3">
                    <h3 class="text-base font-semibold text-gray-900 mb-2 leading-tight">{{$report->visit->branch->branch_name  ?? ''}} -
                        {{\Carbon\Carbon::parse($report->started_date)->format('F Y')}}</h3>
                    <div class="flex items-center flex-wrap gap-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                            {{ $responseData['title'] ?? ($report->visit->questionnaire->name??'No title') }}
                        </span>

                        <!-- Price Toggle Switch -->
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-gray-700">Price:</span>
                            <span class="text-xs font-semibold text-[#0073AF]">{{ currency_icon() }} {{ number_format($report->visit->price ?? 0, 2) }}</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                       class="sr-only peer price-toggle"
                                       {{ $report->price_paid ? 'checked' : '' }}
                                       data-visit-id="{{ $report->visit_id }}"
                                       data-amount="{{ $report->visit->price ?? 0 }}"
                                       onchange="togglePricePayment({{ $report->visit_id }}, {{ $report->visit->price ?? 0 }}, this.checked, this)">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0073AF]"></div>
                            </label>
                        </div>

                        <!-- Reimbursement Toggle Switch -->
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-gray-700">Reimburse:</span>
                            <span class="text-xs font-semibold text-emerald-600">{{ currency_icon() }} {{ number_format($reimbursementAmount, 2) }}</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                       class="sr-only peer reimbursement-toggle"
                                       {{ $report->reimbursement_paid ? 'checked' : '' }}
                                       data-visit-id="{{ $report->visit_id }}"
                                       data-amount="{{ $reimbursementAmount }}"
                                       onchange="toggleReimbursementPayment({{ $report->visit_id }}, {{ $reimbursementAmount }}, this.checked, this)">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop Layout -->
            <div class="hidden sm:flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Date Badge -->
                    <div class="flex flex-col items-center justify-center bg-white border border-gray-200 rounded-xl px-4 py-3 shadow-sm">
                        <span class="text-2xl font-bold text-gray-800">
                            {{\Carbon\Carbon::parse($report->started_date)->format('d')}}
                       </span>
                        <span class="text-sm font-medium text-gray-600 uppercase tracking-wide">
                            {{\Carbon\Carbon::parse($report->started_date)->format('M')}}
                        </span>
                    </div>
                    <!-- Title and Info -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1"> {{$report->visit->branch->branch_name  ?? ''}} -
                            {{\Carbon\Carbon::parse($report->started_date)->format('F Y')}}</h3>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                {{ $responseData['title'] ?? ($report->visit->questionnaire->name??'No title') }}
                            </span>

                            <!-- Price Toggle Switch -->
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-medium text-gray-700">Price:</span>
                                <span class="text-xs font-semibold text-[#0073AF]">{{ currency_icon() }} {{ number_format($report->visit->price ?? 0, 2) }}</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox"
                                           class="sr-only peer price-toggle"
                                           {{ $report->price_paid ? 'checked' : '' }}
                                           data-visit-id="{{ $report->visit_id }}"
                                           data-amount="{{ $report->visit->price ?? 0 }}"
                                           onchange="togglePricePayment({{ $report->visit_id }}, {{ $report->visit->price ?? 0 }}, this.checked, this)">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0073AF]"></div>
                                </label>
                            </div>

                            <!-- Reimbursement Toggle Switch -->
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-medium text-gray-700">Paid by MV:</span>
                                <span class="text-xs font-semibold text-emerald-600">{{ currency_icon() }} {{ number_format($reimbursementAmount, 2) }}</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox"
                                           class="sr-only peer reimbursement-toggle"
                                           {{ $report->reimbursement_paid ? 'checked' : '' }}
                                           data-visit-id="{{ $report->visit_id }}"
                                           data-amount="{{ $reimbursementAmount }}"
                                           onchange="toggleReimbursementPayment({{ $report->visit_id }}, {{ $reimbursementAmount }}, this.checked, this)">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                                </label>
                            </div>
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

        @php
            $startDate = \Carbon\Carbon::parse($report->started_date);
            $endDate   = \Carbon\Carbon::parse($report->completed_date);
        @endphp

        <!-- Content Section -->
        <div class="p-3 sm:p-6">
            <!-- Date Range -->
            <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6 space-y-3 sm:space-y-0">
                <!-- Start Date -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-xs sm:text-sm font-medium text-gray-600">Date</span>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold text-gray-900 bg-gray-50 px-2 py-1 sm:px-3 sm:py-1 rounded-lg border border-gray-200">
                        {{ $startDate->translatedFormat('d/m/Y') }} from {{ $startDate->translatedFormat('H:i') }} to {{ $endDate->translatedFormat('H:i') }}
                    </span>
                </div>
                <!-- End Date -->
{{--                <div class="flex items-center space-x-2 sm:space-x-4">--}}
{{--                    <div class="flex items-center space-x-2">--}}
{{--                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>--}}
{{--                        <span class="text-xs sm:text-sm font-medium text-gray-600">End Date</span>--}}
{{--                    </div>--}}
{{--                    <span class="text-xs sm:text-sm font-semibold text-gray-900 bg-gray-50 px-2 py-1 sm:px-3 sm:py-1 rounded-lg border border-gray-200">--}}
{{--                        {{\Carbon\Carbon::parse($report->completed_date)->format('d/m/Y (D)')}}--}}
{{--                    </span>--}}
{{--                </div>--}}
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('admin.questionnaire.response',['visitId'=>$report->visit->unioqid]) }}"
                        class="flex items-center justify-center space-x-2 px-3 py-2 sm:px-4 sm:py-2.5 bg-gray-600 hover:bg-gray-700 cursor-pointer text-white text-xs sm:text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z">
                        </path>
                    </svg>
                    <span>{{ trans_message('edit') }}</span>
                </a>
                <div class="flex items-center">
                    <div class="relative">
                        <button popovertarget="download-options-{{$report->id}}"
                                class="flex items-center justify-center space-x-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 cursor-pointer text-white text-xs sm:text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3.9985 2C3.44749 2 3 2.44405 3 2.9918V21.0082C3 21.5447 3.44476 22 3.9934 22H20.0066C20.5551 22 21 21.5489 21 20.9925L20.9997 7L16 2H3.9985ZM10.5 7.5H12.5C12.5 9.98994 14.6436 12.6604 17.3162 13.5513L16.8586 15.49C13.7234 15.0421 10.4821 16.3804 7.5547 18.3321L6.3753 16.7191C7.46149 15.8502 8.50293 14.3757 9.27499 12.6534C10.0443 10.9373 10.5 9.07749 10.5 7.5ZM11.1 13.4716C11.3673 12.8752 11.6043 12.2563 11.8037 11.6285C12.2754 12.3531 12.8553 13.0182 13.5102 13.5953C12.5284 13.7711 11.5666 14.0596 10.6353 14.4276C10.8 14.1143 10.9551 13.7948 11.1 13.4716Z" />
                            </svg>
                            <span>Report Actions</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <el-popover id="download-options-{{$report->id}}" anchor="bottom-start" popover
                                    class="overflow-visible bg-white w-[180px] shadow-[0px_0px_12px_#0000001f] mt-1 py-1 border border-[#ebeef5] rounded-lg transition open:flex flex-col data-closed:opacity-0">
                            <a href="{{ route('admin.visit.download.pdf', $report->visit_id) }}" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Report
                            </a>
                            <a href="{{ route('admin.visit.generate.pdf', $report->visit_id) }}" target="_blank" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View Report
                            </a>
                        </el-popover>
                    </div>
                </div>
                <a href="{{ route('admin.visit.submissions',$report->report_uid) }}"
                   class="flex items-center justify-center space-x-2 px-3 py-2 sm:px-4 sm:py-2.5 bg-[#0073AF] hover:bg-[#0068A0] cursor-pointer text-white text-xs sm:text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>{{ trans_message('view_submissions') }}</span>
                </a>
            </div>
        </div>
    </div>
@endforeach
@else
    <h4 class="font-medium text-[17px]">No Visit Reports Found!</h4>
@endif

<script>
    $('.raty-rating').each(function() {
// ... existing raty code ...

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

    // Toggle Price Payment Status
    function togglePricePayment(visitId, amount, isChecked, checkbox) {
        const newStatus = isChecked;
        const statusText = newStatus ? 'paid' : 'unpaid';

        Swal.fire({
            title: `Are you sure you want to mark €${parseFloat(amount).toFixed(2)} as ${statusText}?`,
            text: newStatus ? "This will mark the price as paid." : "This will mark the price as unpaid.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: newStatus ? '#10b981' : '#0073AF',
            cancelButtonColor: '#6b7280',
            confirmButtonText: `Mark as ${statusText.charAt(0).toUpperCase() + statusText.slice(1)}`,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make AJAX request to toggle status
                $.ajax({
                    url: '{{ route("admin.visit.toggle.price.payment") }}',
                    type: 'POST',
                    data: {
                        visit_id: visitId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Keep checkbox in new state
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        // Revert checkbox on error
                        $(checkbox).prop('checked', !isChecked);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Failed to update payment status',
                        });
                    }
                });
            } else {
                // User cancelled - revert checkbox
                $(checkbox).prop('checked', !isChecked);
            }
        });
    }

    // Toggle Reimbursement Payment Status
    function toggleReimbursementPayment(visitId, amount, isChecked, checkbox) {
        const newStatus = isChecked;
        const statusText = newStatus ? 'paid' : 'unpaid';

        Swal.fire({
            title: `Are you sure you want to mark the reimbursement amount of €${parseFloat(amount).toFixed(2)} as ${statusText}?`,
            text: newStatus ? "This will mark the reimbursement as paid." : "This will mark the reimbursement as unpaid.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: newStatus ? '#10b981' : '#059669',
            cancelButtonColor: '#6b7280',
            confirmButtonText: `Mark as ${statusText.charAt(0).toUpperCase() + statusText.slice(1)}`,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make AJAX request to toggle status
                $.ajax({
                    url: '{{ route("admin.visit.toggle.reimbursement.payment") }}',
                    type: 'POST',
                    data: {
                        visit_id: visitId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Keep checkbox in new state
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        // Revert checkbox on error
                        $(checkbox).prop('checked', !isChecked);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Failed to update payment status',
                        });
                    }
                });
            } else {
                // User cancelled - revert checkbox
                $(checkbox).prop('checked', !isChecked);
            }
        });
    }
</script>
