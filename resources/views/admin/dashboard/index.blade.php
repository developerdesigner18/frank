@extends('admin.master')
@section('title', trans_message('dashboard'))
@push('navbar')
    <div class="pt-6 flex lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">{{ trans_message('dashboard') }}</span>
    </div>
@endpush
@section('main')

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="gradient-blue h-full text-white p-4 md:p-6 rounded-2xl shadow-lg flex flex-col justify-between">
            <div class="group flex justify-between items-start flex-col h-full">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/30 p-2 md:p-3 rounded-full">
                        <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor">
                            <path d="M9 19H12V12.9416L8 9.45402L4 12.9416V19H7V15H9V19ZM21 21H3C2.44772 21 2 20.5523 2 20V12.4868C2 12.1978 2.12501 11.9229 2.34282 11.733L6 8.54435V4C6 3.44772 6.44772 3 7 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21ZM16 11V13H18V11H16ZM16 15V17H18V15H16ZM16 7V9H18V7H16ZM12 7V9H14V7H12Z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold">{{ trans_message('companies') }}</h3>
                </div>
                <div class="pt-10 md:pt-6 flex justify-between items-end w-full">
                    <p class="text-5xl font-bold">{{ sprintf("%02d", $companyCount)}}</p>
                    <a class="bg-white/30 p-2 md:p-3 rounded-full group-hover:bg-white/40 transition-colors"
                       href="{{route('admin.company.index')}}">
                        <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor">
                            <path
                                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div
                class="gradient-purple h-full text-white p-4 md:p-6 rounded-2xl shadow-lg flex flex-col justify-between">
            <div class="group flex justify-between items-start flex-col h-full">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/30 p-2 md:p-3 rounded-full">
                        <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor">
                            <path
                                    d="M12 14V22H4C4 17.5817 7.58172 14 12 14ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM21.4462 20.032L22.9497 21.5355L21.5355 22.9497L20.032 21.4462C19.4365 21.7981 18.7418 22 18 22C15.7909 22 14 20.2091 14 18C14 15.7909 15.7909 14 18 14C20.2091 14 22 15.7909 22 18C22 18.7418 21.7981 19.4365 21.4462 20.032ZM18 20C19.1046 20 20 19.1046 20 18C20 16.8954 19.1046 16 18 16C16.8954 16 16 16.8954 16 18C16 19.1046 16.8954 20 18 20Z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold">{{ trans_message('mystery_visitors') }}</h3>
                </div>
                <div class="pt-10 md:pt-6 flex justify-between items-end w-full">
                    <p class="text-5xl font-bold">{{ sprintf("%02d",$visitorCount)}}</p>
                    <a class="bg-white/30 p-2 md:p-3 rounded-full group-hover:bg-white/40 transition-colors"
                       href="{{route('admin.visitor.index')}}">
                        <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor">
                            <path
                                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="modern-card col-span-1 sm:col-span-2">
            <div class="flex justify-between sm:items-center flex-col sm:flex-row gap-2">
                <h3 class="text-lg font-semibold text-gray-800">{{ trans_message('visits_overview') }}</h3>
                <div class="flex items-center gap-1 p-1 rounded-full bg-gray-100 self-end sm:w-auto">
                    <button class="tab-btn text-xs py-1.5 px-2.5 rounded-full bg-[#0073AF] text-white active"
                            data-tab="week">{{ trans_message('this_week') }}</button>
                    <button class="tab-btn text-xs py-1.5 px-2.5 rounded-full"
                            data-tab="month">{{ trans_message('this_month') }}</button>
                    <button class="tab-btn text-xs py-1.5 px-2.5 rounded-full"
                            data-tab="year">{{ trans_message('this_year') }}</button>
                </div>
            </div>

            <div class="tab-content">
                <!-- This Week Tab Content -->
                <div id="tab-week" class="tab-pane hidden">
                    <div class="pt-4 sm:pt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div
                                class="text-center flex flex-col items-center justify-center gap-2 p-4 sm:p-6 bg-yellow-50 rounded-lg">
                            <div class="text-sm sm:text-base font-medium text-gray-400">{{ trans_message('completed_visits') }}
                            </div>
                            <div class="text-3xl font-semibold text-yellow-600">{{ sprintf("%02d",$completedWeek) }}</div>
                        </div>
                        <div
                                class="text-center flex flex-col items-center justify-center gap-2 p-4 sm:p-6 bg-green-50 rounded-lg">
                            <div class="text-sm sm:text-base font-medium text-gray-400">{{ trans_message('all_visits') }}</div>
                            <div class="text-3xl font-semibold text-green-600">{{ sprintf("%02d",$totalVisitsWeek) }}</div>
                        </div>
                    </div>
                </div>

                <!-- This Month Tab Content -->
                <div id="tab-month" class="tab-pane hidden">
                    <div class="pt-4 sm:pt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div
                                class="text-center flex flex-col items-center justify-center gap-2 p-4 sm:p-6 bg-yellow-50 rounded-lg">
                            <div class="text-sm sm:text-base font-medium text-gray-400">{{ trans_message('completed_visits') }}
                            </div>
                            <div class="text-3xl font-semibold text-yellow-600">{{ sprintf("%02d",$completedMonth) }}</div>
                        </div>
                        <div
                                class="text-center flex flex-col items-center justify-center gap-2 p-4 sm:p-6 bg-green-50 rounded-lg">
                            <div class="text-sm sm:text-base font-medium text-gray-400">{{ trans_message('all_visits') }}</div>
                            <div class="text-3xl font-semibold text-green-600">{{ sprintf("%02d",$totalVisitsMonth) }}</div>
                        </div>
                    </div>
                </div>

                <!-- This Year Tab Content -->
                <div id="tab-year" class="tab-pane">
                    <div class="pt-4 sm:pt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div
                                class="text-center flex flex-col items-center justify-center gap-2 p-4 sm:p-6 bg-yellow-50 rounded-lg">
                            <div class="text-sm sm:text-base font-medium text-gray-400">{{ trans_message('completed_visits') }}
                            </div>
                            <div class="text-3xl font-semibold text-yellow-600">{{ sprintf("%02d",$completedYear) }}</div>
                        </div>
                        <div
                                class="text-center flex flex-col items-center justify-center gap-2 p-4 sm:p-6 bg-green-50 rounded-lg">
                            <div class="text-sm sm:text-base font-medium text-gray-400">{{ trans_message('all_visits') }}</div>
                            <div class="text-3xl font-semibold text-green-600">{{ sprintf("%02d",$totalVisitsYear) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-6 grid grid-cols-2 gap-4">
        <div class="modern-card col-span-2">
            <h3 class="text-lg font-semibold text-gray-800">{{ trans_message('scheduled_visits') }}</h3>
            <div class="flex flex-col pt-4 sm:pt-6 gap-4">
                @if($scheduled_visits)
                    @foreach($scheduled_visits as $schedule_visit)
                        @php
                            $check_date_class = 'bg-gray-50 border-[#e5e7eb]';
                            $check_date_class_2 = 'text-gray-700';
                            $check_date_border = 'border-gray-200';
                            if (\Carbon\Carbon::parse($schedule_visit->start_datetime)->lt(\Carbon\Carbon::now())){
                                $check_date_class = 'bg-red-50 border-red-200';
                                $check_date_class_2 = 'text-red-500';
                                $check_date_border = 'border-red-200';
                            }
                        @endphp
                        <div class="flex items-stretch md:flex-row flex-col gap-2 justify-between p-3 md:p-4 border {{ $check_date_class }} rounded-xl">
                            <div class="flex flex-1 relative">
                                <div class="flex items-stretch gap-2 md:gap-4 w-full">
                                    <div class="flex items-center justify-center flex-col border {{ $check_date_border }} aspect-square py-2 px-2 md:px-4 bg-white rounded-[4px]">
                                        <p class="text-xl md:text-2xl leading-none font-bold {{ $check_date_class_2 }}">{{ dateToHuman($schedule_visit->start_datetime, 'd') }}</p>
                                        <p class="text-xs md:text-sm text-gray-500">{{ dateToHuman($schedule_visit->start_datetime, 'M') }}</p>
                                    </div>
                                    <div class="flex flex-col justify-center w-[calc(100%-80px)] md:w-[calc(100%-100px)]">
                                        <p class="text-sm md:text-xl font-semibold text-gray-700">{{ $schedule_visit->branch->branch_name??'' }}
                                            - {{ dateToHuman($schedule_visit->start_datetime, 'M Y') }}</p>
                                        <div class="flex items-center flex-wrap md:gap-2 pt-1 gap-1">
                                            <a href="{{ $schedule_visit->unioqid? route('admin.questionnaire.response',['visitId'=>$schedule_visit->unioqid]):'javascript:void(0);' }}"
                                               class="text-[10px] md:text-xs font-semibold bg-[#0073AF] text-white px-2 md:px-3 py-1 rounded-full">{{ trans_message('form') }}</a>
                                            <span class="text-[10px] md:text-xs border border-gray-200 font-medium bg-white text-gray-600 px-2 md:px-3 py-1 rounded-full">{{ $schedule_visit->questionnaire->name??'No title' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute right-0 md:right-3 top-0 text-red-500 size-[20px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 9.5C12.8284 9.5 13.5 8.82843 13.5 8C13.5 7.17157 12.8284 6.5 12 6.5C11.1716 6.5 10.5 7.17157 10.5 8C10.5 8.82843 11.1716 9.5 12 9.5ZM14 15H13V10.5H10V12.5H11V15H10V17H14V15Z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-1 md:grid-row-2  gap-1">
                            <span class="text-[10px] md:text-xs border border-gray-200 font-medium bg-white text-gray-600 px-3 py-2 flex items-center rounded-[4px]">{{ trans_message('start') }}:
                            {{ dateToHuman($schedule_visit->start_datetime, 'd/m/y (D)') }}</span>
                                <span class="text-[10px] md:text-xs border border-gray-200 font-medium bg-white text-gray-600 px-3 py-2 flex items-center rounded-[4px]">{{ trans_message('end') }}:
                            {{ dateToHuman($schedule_visit->end_datetime, 'd/m/y (D)') }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4>{{ trans_message('no_visits_found') }}</h4>
                @endif

                {{--<div class="flex items-stretch justify-between md:flex-row flex-col gap-2 p-3 md:p-4 bg-gray-50 border border-[#e5e7eb] rounded-xl">
                    <div class="flex flex-1 relative">
                        <div class="flex items-stretch gap-2 md:gap-4 w-full">
                            <div
                                    class="flex items-center justify-center flex-col border border-[#e5e7eb] aspect-square py-2 px-2 md:px-4 bg-white rounded-[4px]">
                                <p class="text-xl md:text-2xl leading-none font-bold text-gray-700">10</p>
                                <p class="text-xs md:text-sm text-gray-500">Sep</p>
                            </div>
                            <div
                                    class="flex flex-col justify-center w-[calc(100%-80px)] md:w-[calc(100%-100px)]">
                                <p class="text-sm md:text-xl font-semibold text-gray-700">test branch 1 -
                                    Sep
                                    2024</p>
                                <div class="flex items-center flex-wrap gap-2 pt-1">
                                    <span
                                            class="text-[10px] md:text-xs font-semibold bg-[#0073AF] text-white px-2 md:px-3 py-1 rounded-full">Form</span>
                                    <span
                                            class="text-[10px] md:text-xs border border-gray-200 font-medium bg-white text-gray-600 px-2 md:px-3 py-1 flex items-center rounded-full">test
                                        branch 1</span>

                                </div>
                            </div>
                        </div>
                        <div class="absolute right-0 md:right-3 top-0 text-red-500 size-[20px]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                        d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 9.5C12.8284 9.5 13.5 8.82843 13.5 8C13.5 7.17157 12.8284 6.5 12 6.5C11.1716 6.5 10.5 7.17157 10.5 8C10.5 8.82843 11.1716 9.5 12 9.5ZM14 15H13V10.5H10V12.5H11V15H10V17H14V15Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-1 md:grid-row-2 gap-1">
                        <span
                                class="text-[10px] md:text-xs border border-gray-200 font-medium bg-white text-gray-600 px-3 py-2 flex items-center rounded-[4px]">Start:
                            14/08/24 (We)</span>
                        <span
                                class="text-[10px] md:text-xs border border-gray-200 font-medium bg-white text-gray-600 px-3 py-2 flex items-center rounded-[4px]">End:
                            22/08/24 (Th)</span>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script !src="">
        $(document).ready(function () {
            sendToast('{{ trans_message('welcome_aboard') }}', 'primary');
        });
    </script>
@endsection
