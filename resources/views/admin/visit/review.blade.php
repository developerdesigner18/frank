@extends('admin.master')
@section('title',' Visit Review')
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('admin.visit.index',['page'=>'pending']) }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>Pending Visits</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-500">{{ $visit->branch->branch_name }}</span>
    </div>
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">Visit Review</span>
    </div>
@endpush
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

        <div class="w-full">
            @if($payload['categories'] && count($payload['categories']) > 0)
                @foreach($payload['categories'] as $cat_k => $category)
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
                            @if(isset($old_questions[$category['id']]))
                                @foreach($old_questions[$category['id']] as $question)
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
                                                            <img src="{{ asset(SURVEY_QUESTIONNAIRE_IMAGES_PATH.$image) }}"
                                                                 width="200" height="100">
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
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
                                                    <input type="text" placeholder="Started" readonly
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
                                                    <input type="text" placeholder="Completed" readonly
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
                                        <button type="button" onclick="visitReportStatus({{$visit_id}}, 'reject', this)"
                                                class="cursor-pointer bg-red-400 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                            Reject
                                        </button>
                                        <button type="button"
                                                onclick="visitReportStatus({{$visit_id}}, 'approved', this)"
                                                class="cursor-pointer questionnaire_submit bg-green-400 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                            Approve
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </section>
@endsection
@section('script')

    <script>

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

        // Request visit
        function visitReportStatus(id, type, element) {
            var msg = "";
            if (type === 'reject') {
                msg = "This action will put back this event to In Progress status.";
            }
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to " + type + " this visit? " + msg,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, " + type,
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
                buttonsStyling: !1,
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('admin.visit.visitReportStatus')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "type": type,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            // $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendToast(data.message);
                            if (type === 'reject') {
                                window.location.href = "{{ route('admin.visit.index',['page'=>'scheduled']) }}";
                            } else {
                                window.location.href = "{{ route('admin.visit.index',['page'=>'completed']) }}";
                            }
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('message')) {
                                sendError(data.message);
                            } else {
                                sendError("An error occurred. Please try again.");
                            }
                        },
                        complete: function () {
                            $(element).attr('disabled', false);
                        }
                    });
                }
            });
        }
    </script>
@endsection
