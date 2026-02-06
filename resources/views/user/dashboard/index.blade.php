@extends('user.master')
@section('title', trans_message('dashboard'))
@push('navbar')
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">            {{ trans_message('dashboard') }}
</span>
    </div>
@endpush
@section('main')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-6">
    <div
        class="gradient-blue h-full text-white p-4 md:p-6 rounded-2xl shadow-lg flex flex-col justify-between">
        <div class="group flex justify-between items-start flex-col h-full">
            <div class="flex items-center space-x-3">
                <div class="bg-white/30 p-2 md:p-3 rounded-full">
                    <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M7 4V2H17V4H20.0066C20.5552 4 21 4.44495 21 4.9934V21.0066C21 21.5552 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5551 3 21.0066V4.9934C3 4.44476 3.44495 4 3.9934 4H7ZM7 6H5V20H19V6H17V8H7V6ZM9 4V6H15V4H9Z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-base font-semibold">{{ trans_message('available_visits') }}</h3>
            </div>
            <div class="pt-10 md:pt-6 flex justify-between items-end w-full">
                <p class="text-5xl font-bold">{{ sprintf('%02d', $available ?? 0) }} </p>
                <a class="bg-white/30 p-2 md:p-3 rounded-full group-hover:bg-white/40 transition-colors"
                    href="{{ route('visit.index',['page'=>'available']) }}">
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
        class="gradient-green h-full text-white p-4 md:p-6 rounded-2xl shadow-lg flex flex-col justify-between">
        <div class="group flex justify-between items-start flex-col h-full">
            <div class="flex items-center space-x-3">
                <div class="bg-white/30 p-2 md:p-3 rounded-full">
                    <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12H4C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C9.25022 4 6.82447 5.38734 5.38451 7.50024L8 7.5V9.5H2V3.5H4L3.99989 5.99918C5.82434 3.57075 8.72873 2 12 2ZM13 7L12.9998 11.585L16.2426 14.8284L14.8284 16.2426L10.9998 12.413L11 7H13Z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-base font-semibold">{{ trans_message('scheduled_visits') }}</h3>
            </div>
            <div class="pt-10 md:pt-6 flex justify-between items-end w-full">
                <p class="text-5xl font-bold">{{ sprintf('%02d', $scheduled ?? 0 )}}</p>
                <a class="bg-white/30 p-2 md:p-3 rounded-full group-hover:bg-white/40 transition-colors"
                    href="{{ route('visit.index',['page'=>'scheduled']) }}">
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
        class="gradient-orange h-full text-white p-4 md:p-6 rounded-2xl shadow-lg flex flex-col justify-between">
        <div class="group flex justify-between items-start flex-col h-full">
            <div class="flex items-center space-x-3">
                <div class="bg-white/30 p-2 md:p-3 rounded-full">
                    <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12ZM12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM17.4571 9.45711L16.0429 8.04289L11 13.0858L8.20711 10.2929L6.79289 11.7071L11 15.9142L17.4571 9.45711Z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-base font-semibold">{{ trans_message('pending_visits') }}</h3>
            </div>
            <div class="pt-10 md:pt-6 flex justify-between items-end w-full">
                <p class="text-5xl font-bold">{{ sprintf('%02d', $pending ?? 0 )}}</p>
                <a class="bg-white/30 p-2 md:p-3 rounded-full group-hover:bg-white/40 transition-colors"
                    href="{{ route('visit.index',['page'=>'pending']) }}">
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
                            d="M12 20V22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9998 7V14H19V8H15V4H5V20H12ZM14.4646 19.4647L18.0001 23.0002L22.9498 18.0505L21.5356 16.6362L18.0001 20.1718L15.8788 18.0505L14.4646 19.4647Z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-base font-semibold">{{ trans_message('completed_visits') }}</h3>
            </div>
            <div class="pt-10 md:pt-6 flex justify-between items-end w-full">
                <p class="text-5xl font-bold">{{ sprintf('%02d', $completed ?? 0) }}</p>
                <a class="bg-white/30 p-2 md:p-3 rounded-full group-hover:bg-white/40 transition-colors"
                    href="{{ route('visit.index',['page'=>'completed']) }}">
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
</div>
{{-- <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-5 gap-6 pt-6">
                    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg xl:col-span-3 flex flex-col gap-6">
                        <h3 class="text-lg font-semibold text-gray-800">Scheduled Visits</h3>
                        <div class="flex-1 flex justify-center items-center">
                            <div class="flex flex-col items-center justify-center py-10 gap-2">
                                <svg class="size-[40px] text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M9 3V1H7V3H3C2.44772 3 2 3.44772 2 4V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V4C22 3.44772 21.5523 3 21 3H17V1H15V3H9ZM4 10H20V19H4V10ZM4 5H7V6H9V5H15V6H17V5H20V8H4V5ZM9.87862 10.9644L12 13.0858L14.1212 10.9644L15.5355 12.3785L13.4142 14.5001L15.5354 16.6212L14.1213 18.0354L12 15.9143L9.87855 18.0354L8.46442 16.6211L10.5857 14.5001L8.46436 12.3785L9.87862 10.9644Z">
                                    </path>
                                </svg>
                                <p class="text-base font-medium text-gray-500">No scheduled visits</p>
                            </div>
                        </div>
                    </div>
                    --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-5 gap-6 pt-6">
    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg xl:col-span-3 flex flex-col gap-6">
        <h3 class="text-lg font-semibold text-gray-800">{{ trans_message('scheduled_visits') }}</h3>

        <div class="flex flex-col pt-4 sm:pt-6 gap-4">
            @if( $scheduled_visits)
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
                                    <p class="text-sm md:text-xl font-semibold text-gray-700">{{ $schedule_visit->branch->branch_name??'' }} - {{ dateToHuman($schedule_visit->start_datetime, 'M Y') }}</p>
                                    <div class="flex items-center flex-wrap md:gap-2 pt-1 gap-1">
                                        <a href="{{ $schedule_visit->unioqid? route('visit.survey',$schedule_visit->unioqid):'javascript:void(0);' }}" class="text-[10px] md:text-xs font-semibold bg-[#0073AF] text-white px-2 md:px-3 py-1 rounded-full">{{ trans_message('form') }}</a>
                                        <span class="text-[10px] md:text-xs border border-gray-200 font-medium bg-white text-gray-600 px-2 md:px-3 py-1 rounded-full">{{ $schedule_visit->branch->branch_name??'' }}</span>
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
                        <div class="grid grid-cols-2 md:grid-cols-1 md:grid-row-2  gap-1">
                            <span class="text-[10px] md:text-xs border border-gray-200 font-medium bg-white text-gray-600 px-3 py-2 flex items-center rounded-[4px]"> {{ trans_message('start') }}:
                                {{ dateToHuman($schedule_visit->start_datetime, 'd/m/y (D)') }}</span>
                            <span class="text-[10px] md:text-xs border border-gray-200 font-medium bg-white text-gray-600 px-3 py-2 flex items-center rounded-[4px]">{{ trans_message('end') }}:
                                {{ dateToHuman($schedule_visit->end_datetime, 'd/m/y (D)') }}</span>
                        </div>
                    </div>
              @endforeach
            @else
                <div class="flex flex-1 justify-center items-center min-h-[400px]">
                    <div class="flex flex-col items-center justify-center gap-3 py-10">
                        <svg class="size-[48px] text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M9 3V1H7V3H3C2.44772 3 2 3.44772 2 4V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V4C22 3.44772 21.5523 3 21 3H17V1H15V3H9ZM4 10H20V19H4V10ZM4 5H7V6H9V5H15V6H17V5H20V8H4V5Z" />
                        </svg>
                        <p class="text-base font-medium text-gray-500">No scheduled visits</p>
                    </div>
                </div>
            @endif

        </div>

    </div>
    <div class="xl:col-span-2 flex flex-col gap-6">
        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg flex flex-col gap-6">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">{{ trans_message('company_scores') }}</h3>
                <a class="text-[#0073AF] text-sm font-semibold items-center flex" href="{{ route('visit.index',['page'=>'completed']) }}">
                    See More
                </a>
            </div>
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img alt="DDS Test logo" class="h-8 w-8 rounded-full object-cover mr-3"
                            src="{{ asset('assets/user/image/user.png') }}">
                        <div>
                            <p class="text-lg font-semibold text-gray-600">{{ trans_message('dds_test') }}</p>
                            <p class="text-xs text-gray-500">{{ trans_message('nan_percent') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                            </path>
                        </svg>
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                            </path>
                        </svg>
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502V15.968ZM12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                            </path>
                        </svg>
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                            </path>
                        </svg>
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img alt="DDS Test logo" class="h-8 w-8 rounded-full object-cover mr-3"
                            src="{{ asset('assets/user/image/user.png') }}">
                        <div>
                            <p class="text-lg font-semibold text-gray-600">{{ trans_message('sligro') }}</p>
                            <p class="text-xs text-gray-500">{{ trans_message('twenty_four_percent') }}</p>

                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                            </path>
                        </svg>
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                            </path>
                        </svg>
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502V15.968ZM12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                            </path>
                        </svg>
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                            </path>
                        </svg>
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="bg-[#F3E8FF] p-4 sm:p-6 rounded-2xl shadow-lg flex items-center justify-between gap-6">
            <div>
                <h4 class="font-semibold text-purple-800">{{ trans_message('video_tutorials') }}</h4>
                <p class="text-sm text-purple-600">{{ trans_message('learn_how_to_use_platform') }}</p>
            </div>
            <div class="flex items-center justify-center">
                <svg class="size-[24px] text-purple-600" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M6 20.1957V3.80421C6 3.01878 6.86395 2.53993 7.53 2.95621L20.6432 11.152C21.2699 11.5436 21.2699 12.4563 20.6432 12.848L7.53 21.0437C6.86395 21.46 6 20.9812 6 20.1957Z">
                    </path>
                </svg>
            </div>
        </div>
        <a href="{{asset(SETTING_PATH. $email_attachment_file->value??'javascript:void(0);')}}" target="_blank" class="bg-[#E0E7FF] p-4 sm:p-6 rounded-2xl shadow-lg flex items-center justify-between gap-6">
            <div>
                <h4 class="font-semibold text-indigo-800">Manuals</h4>
                <p class="text-sm text-indigo-600">Read the documentation</p>
            </div>
            <div class="flex items-center justify-center">
                <svg class="size-[24px] text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M13 21V23H11V21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H9C10.1947 3 11.2671 3.52375 12 4.35418C12.7329 3.52375 13.8053 3 15 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H13ZM20 19V5H15C13.8954 5 13 5.89543 13 7V19H20ZM11 19V7C11 5.89543 10.1046 5 9 5H4V19H11Z">
                    </path>
                </svg>
            </div>
        </a>
        <div
            class="bg-[#E0E7FF] p-4 sm:p-6 rounded-2xl shadow-lg flex items-center justify-between gap-6">
            <div>
                <h4 class="font-semibold text-indigo-800">Frequently Asked Questions</h4>
                <p class="text-sm text-indigo-600">Find answers to common questions</p>
            </div>
            <div class="flex items-center justify-center">
                <svg class="size-[24px] text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M5.76282 17H20V5H4V18.3851L5.76282 17ZM6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM11 14H13V16H11V14ZM8.56731 8.81346C8.88637 7.20919 10.302 6 12 6C13.933 6 15.5 7.567 15.5 9.5C15.5 11.433 13.933 13 12 13H11V11H12C12.8284 11 13.5 10.3284 13.5 9.5C13.5 8.67157 12.8284 8 12 8C11.2723 8 10.6656 8.51823 10.5288 9.20577L8.56731 8.81346Z">
                    </path>
                </svg>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script !src="">

</script>
@endsection
