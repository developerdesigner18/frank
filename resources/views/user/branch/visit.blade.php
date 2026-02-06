@extends('user.master')
@section('title',$branch->company->company_name.' - '.$branch->branch_name)
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('company') }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>{{ trans_message('companies') }}</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <a href="{{ route('company.branches.index',['companyId'=>$branch->company->company_id]) }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>{{ $branch->company->company_name }}  {{ trans_message('branches') }}</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-500">{{ $branch->company->company_name }} - {{ $branch->branch_name }}</span>
    </div>
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">{{ $branch->company->company_name }} - {{ $branch->branch_name }}</span>
    </div>
@endpush
@section('main')

    <section class="pt-4 sm:pt-6">
        <!-- Company Header Section -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <!-- Company Logo and Name -->
            <div class="flex items-center justify-center p-4 sm:p-6">
                <div class="flex flex-col items-center gap-2">
                    <!-- Company Logo -->
                    <div class="relative">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 p-0.5 shadow-lg">
                            <div class="w-full h-full rounded-2xl bg-white flex items-center justify-center overflow-hidden">
                                <img src="{{ $branch->company->image }}" alt="Company Logo" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                    <!-- Company Name -->
                    <div>
                        <h1 class="text-lg text-center font-bold text-gray-900 mb-1 capitalize">{{ $branch->company->company_name }}
                        </h1>
{{--                        <p class="text-sm font-medium text-gray-600 text-center">Visit Management System</p>--}}
                    </div>
                </div>
            </div>

            <!-- Filter Tags Section -->
            <div class="px-6 pb-6">
                <div class="flex flex-wrap gap-3 justify-center">
                    <!-- My First Branch Tags -->
                    <span class="bg-white border border-gray-300 px-4 py-2 leading-none rounded-full text-sm font-semibold font-medium hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                        {{ $branch->branch_name }}
                    </span>
                    <span class="bg-white border border-gray-300 text-gray-700 px-4 py-2 leading-none rounded-full text-sm font-semibold  hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                        {{ $branch->locality }}
                    </span>
                    <span class="bg-white border border-gray-300 text-gray-700 px-4 py-2 leading-none rounded-full text-sm font-semibold  hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                        {{ $branch->postal_code }}
                    </span>
                    <!-- Standard Tag -->
                    <span class="bg-white border border-gray-300 text-gray-700 px-4 py-2 leading-none rounded-full text-sm font-semibold hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                        {{ $branch->route }}
                    </span>
                    <!-- Active Tag -->
                    <span class="inline-flex items-center px-4 py-2 leading-none rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                        {{ $branch->status }}
                    </span>
                </div>
            </div>

            <!-- Information Bar -->
            <div class="bg-blue-50 border-t border-blue-100 px-6 py-4">
                <p class="text-center text-gray-700 font-semibold text-sm">
                    {{ $branch->address_1??'' }},
                    {{ $branch->postal_code??'' }}
                    {{ $branch->locality??'' }}
                </p>
            </div>
        </div>

        <!-- Content Area -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex overflow-x-auto">
                    <button type="button"
                            class="flex-shrink-0 px-6 py-4 text-sm font-semibold text-blue-600 bg-blue-50 transition-colors duration-200 cursor-pointer">
                        {{ trans_message('available') }}
                    </button>
                    <button type="button"
                            class="flex-shrink-0 px-6 py-4 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                        {{ trans_message('interested') }}
                    </button>
                    <button type="button"
                            class="flex-shrink-0 px-6 py-4 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                        {{ trans_message('scheduled') }}
                    </button>
                    <button type="button"
                            class="flex-shrink-0 px-6 py-4 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                        {{ trans_message('pending') }}
                    </button>
                    <button type="button"
                            class="flex-shrink-0 px-6 py-4 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                        {{ trans_message('completed') }}

                    </button>
                </nav>
            </div>
            <div class="p-8">
                <!-- Tab Content Area -->
                <div id="tab-content">

                    <!-- Available Tab Content -->
                    <div id="available-content" class="tab-content active">
                        <!-- Visit Entry Cards -->
                        @if($available_visits->all())
                            <div class="space-y-4">
                                @foreach($available_visits as $available)
                                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                                        <div class="flex flex-col sm:flex-row">
                                            <!-- Date Indicator Section -->
                                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 min-w-[100px] flex items-center justify-center flex-col flex-shrink-0">
                                                <div class="text-center">
                                                    <div class="text-3xl sm:text-4xl font-bold text-gray-800 mb-1">{{ dateToHuman($available->start_datetime, 'd') }}</div>
                                                    <div class="text-sm font-medium text-gray-600 uppercase tracking-wide">{{ dateToHuman($available->start_datetime, 'M') }}</div>
                                                </div>
                                            </div>

                                            <!-- Duration Details Section -->
                                            <div class="flex-1 p-4 sm:p-6 border-b sm:border-b-0 sm:border-r border-gray-100">
                                                <div class="space-y-3">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                            <span class="text-sm font-medium text-gray-600">{{ trans_message('start_label') }}</span>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-800">{{ dateToHuman($available->start_datetime, 'd/m/y (D)') }}</span>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                            <span class="text-sm font-medium text-gray-600">{{ trans_message('end_label') }}</span>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-800">{{ dateToHuman($available->end_datetime, 'd/m/y (D)') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Value and Action Section -->
                                            <div class="p-4 sm:p-6 flex flex-col sm:items-end justify-center gap-3">
                                                <div class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-full text-sm font-semibold">
                                                    {{ currency_icon() }}{{ $available->price??0 }}
                                                </div>
{{--                                                <button type="button" onclick="requestVisit({{$available->id}},this)"--}}
{{--                                                   class="cursor-pointer group/btn relative flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl">--}}
{{--                                                    Request--}}
{{--                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">--}}
{{--                                                        <path d="M8.59 16.59L13.17 12L8.59 7.41L10 6l6 6-6 6-1.41-1.41z" />--}}
{{--                                                    </svg>--}}
{{--                                                </button>--}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Load More Button -->
{{--                            <div class="text-center mt-8">--}}
{{--                                <button--}}
{{--                                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">--}}
{{--                                    Load More Visits--}}
{{--                                </button>--}}
{{--                            </div>--}}
                        @else
                            <div class="flex flex-col items-center justify-center py-10 gap-2">
                                <svg class="size-[40px] text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 3V1H7V3H3C2.44772 3 2 3.44772 2 4V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V4C22 3.44772 21.5523 3 21 3H17V1H15V3H9ZM4 10H20V19H4V10ZM4 5H7V6H9V5H15V6H17V5H20V8H4V5ZM9.87862 10.9644L12 13.0858L14.1212 10.9644L15.5355 12.3785L13.4142 14.5001L15.5354 16.6212L14.1213 18.0354L12 15.9143L9.87855 18.0354L8.46442 16.6211L10.5857 14.5001L8.46436 12.3785L9.87862 10.9644Z">
                                    </path>
                                </svg>
                                <p class="text-base font-medium text-gray-500">No Upcoming Visit Events</p>
                            </div>
                        @endif

                    </div>

                    <!-- Interested Tab Content -->
                    <div id="interested-content" class="tab-content hidden">
                        <!-- Visit Entry Cards -->
                        @if($interested_visits->all())
                            <div class="space-y-4">
                                @foreach($interested_visits as $interested)
                                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                                        <div class="flex flex-col sm:flex-row">
                                            <!-- Date Indicator Section -->
                                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 min-w-[100px] flex items-center justify-center flex-col flex-shrink-0">
                                                <div class="text-center">
                                                    <div class="text-3xl sm:text-4xl font-bold text-gray-800 mb-1">{{ dateToHuman($interested->start_datetime, 'd') }}</div>
                                                    <div class="text-sm font-medium text-gray-600 uppercase tracking-wide">{{ dateToHuman($interested->start_datetime, 'M') }}</div>
                                                </div>
                                            </div>

                                            <!-- Duration Details Section -->
                                            <div class="flex-1 p-4 sm:p-6 border-b sm:border-b-0 sm:border-r border-gray-100">
                                                <div class="space-y-3">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                            <span class="text-sm font-medium text-gray-600">{{ trans_message('start_label') }}</span>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-800">{{ dateToHuman($interested->start_datetime, 'd/m/y (D)') }}</span>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                            <span class="text-sm font-medium text-gray-600">{{ trans_message('end_label') }}</span>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-800">{{ dateToHuman($interested->end_datetime, 'd/m/y (D)') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Value and Action Section -->
                                            <div class="p-4 sm:p-6 flex flex-col sm:items-end justify-center gap-3">
                                                <div class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-full text-sm font-semibold">
                                                    {{ currency_icon() }}{{ $interested->price??0 }}
                                                </div>
{{--                                                <a href="checkmijnzaak/user/pages/other-page/visits-pages/completed-visit-report.html"--}}
{{--                                                   class="group/btn relative flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl">--}}
{{--                                                    View Submissions--}}
{{--                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">--}}
{{--                                                        <path d="M8.59 16.59L13.17 12L8.59 7.41L10 6l6 6-6 6-1.41-1.41z" />--}}
{{--                                                    </svg>--}}
{{--                                                </a>--}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Load More Button -->
{{--                            <div class="text-center mt-8">--}}
{{--                                <button--}}
{{--                                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">--}}
{{--                                    Load More Visits--}}
{{--                                </button>--}}
{{--                            </div>--}}
                        @else
                            <div class="flex flex-col items-center justify-center py-10 gap-2">
                                <svg class="size-[40px] text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 3V1H7V3H3C2.44772 3 2 3.44772 2 4V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V4C22 3.44772 21.5523 3 21 3H17V1H15V3H9ZM4 10H20V19H4V10ZM4 5H7V6H9V5H15V6H17V5H20V8H4V5ZM9.87862 10.9644L12 13.0858L14.1212 10.9644L15.5355 12.3785L13.4142 14.5001L15.5354 16.6212L14.1213 18.0354L12 15.9143L9.87855 18.0354L8.46442 16.6211L10.5857 14.5001L8.46436 12.3785L9.87862 10.9644Z">
                                    </path>
                                </svg>
                                    <p class="text-base font-medium text-gray-500">No Upcoming Visit Events</p>
                            </div>
                        @endif
                    </div>

                    <!-- Scheduled Tab Content -->
                    <div id="scheduled-content" class="tab-content hidden">
                        <!-- Visit Entry Cards -->
                        @if($scheduled_visits->all())
                            <div class="space-y-4">
                                @foreach($scheduled_visits as $scheduled)
                                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                                        <div class="flex flex-col sm:flex-row">
                                            <!-- Date Indicator Section -->
                                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 min-w-[100px] flex items-center justify-center flex-col flex-shrink-0">
                                                <div class="text-center">
                                                    <div class="text-3xl sm:text-4xl font-bold text-gray-800 mb-1">{{ dateToHuman($scheduled->start_datetime, 'd') }}</div>
                                                    <div class="text-sm font-medium text-gray-600 uppercase tracking-wide">{{ dateToHuman($scheduled->start_datetime, 'M') }}</div>
                                                </div>
                                            </div>

                                            <!-- Duration Details Section -->
                                            <div class="flex-1 p-4 sm:p-6 border-b sm:border-b-0 sm:border-r border-gray-100">
                                                <div class="space-y-3">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                            <span class="text-sm font-medium text-gray-600">{{ trans_message('start_label') }}</span>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-800">{{ dateToHuman($scheduled->start_datetime, 'd/m/y (D)') }}</span>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                            <span class="text-sm font-medium text-gray-600">{{ trans_message('end_label') }}</span>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-800">{{ dateToHuman($scheduled->end_datetime, 'd/m/y (D)') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Value and Action Section -->
                                            <div class="p-4 sm:p-6 flex flex-col sm:items-end justify-center gap-3">
                                                <div class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-full text-sm font-semibold">
                                                    {{ currency_icon() }}{{ $scheduled->price??0 }}
                                                </div>
{{--                                                <a href="checkmijnzaak/user/pages/other-page/visits-pages/completed-visit-report.html"--}}
{{--                                                   class="group/btn relative flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl">--}}
{{--                                                    View Submissions--}}
{{--                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">--}}
{{--                                                        <path d="M8.59 16.59L13.17 12L8.59 7.41L10 6l6 6-6 6-1.41-1.41z" />--}}
{{--                                                    </svg>--}}
{{--                                                </a>--}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Load More Button -->
{{--                            <div class="text-center mt-8">--}}
{{--                                <button--}}
{{--                                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">--}}
{{--                                    Load More Visits--}}
{{--                                </button>--}}
{{--                            </div>--}}
                        @else
                            <div class="flex flex-col items-center justify-center py-10 gap-2">
                                <svg class="size-[40px] text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 3V1H7V3H3C2.44772 3 2 3.44772 2 4V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V4C22 3.44772 21.5523 3 21 3H17V1H15V3H9ZM4 10H20V19H4V10ZM4 5H7V6H9V5H15V6H17V5H20V8H4V5ZM9.87862 10.9644L12 13.0858L14.1212 10.9644L15.5355 12.3785L13.4142 14.5001L15.5354 16.6212L14.1213 18.0354L12 15.9143L9.87855 18.0354L8.46442 16.6211L10.5857 14.5001L8.46436 12.3785L9.87862 10.9644Z">
                                    </path>
                                </svg>
                                <p class="text-base font-medium text-gray-500">No Visit Events Scheduled</p>
                            </div>
                        @endif
                    </div>

                    <!-- In Uitvoering Tab Content -->
                    <div id="pending-content" class="tab-content hidden">
                        <!-- Visit Entry Cards -->
                        @if($pending_visits->all())
                            <div class="space-y-4">
                                @foreach($pending_visits as $pending)
                                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                                        <div class="flex flex-col sm:flex-row">
                                            <!-- Date Indicator Section -->
                                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 min-w-[100px] flex items-center justify-center flex-col flex-shrink-0">
                                                <div class="text-center">
                                                    <div class="text-3xl sm:text-4xl font-bold text-gray-800 mb-1">{{ dateToHuman($pending->start_datetime, 'd') }}</div>
                                                    <div class="text-sm font-medium text-gray-600 uppercase tracking-wide">{{ dateToHuman($pending->start_datetime, 'M') }}</div>
                                                </div>
                                            </div>

                                            <!-- Duration Details Section -->
                                            <div class="flex-1 p-4 sm:p-6 border-b sm:border-b-0 sm:border-r border-gray-100">
                                                <div class="space-y-3">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                            <span class="text-sm font-medium text-gray-600">Start:</span>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-800">{{ dateToHuman($pending->start_datetime, 'd/m/y (D)') }}</span>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                            <span class="text-sm font-medium text-gray-600">{{ trans_message('end_label') }}</span>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-800">{{ dateToHuman($pending->end_datetime, 'd/m/y (D)') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Value and Action Section -->
                                            <div class="p-4 sm:p-6 flex flex-col sm:items-end justify-center gap-3">
                                                <div class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-full text-sm font-semibold">
                                                    {{ currency_icon() }}{{ $pending->price??0 }}
                                                </div>
{{--                                                <a href="checkmijnzaak/user/pages/other-page/visits-pages/completed-visit-report.html"--}}
{{--                                                   class="group/btn relative flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl">--}}
{{--                                                    View Submissions--}}
{{--                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">--}}
{{--                                                        <path d="M8.59 16.59L13.17 12L8.59 7.41L10 6l6 6-6 6-1.41-1.41z" />--}}
{{--                                                    </svg>--}}
{{--                                                </a>--}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Load More Button -->
{{--                            <div class="text-center mt-8">--}}
{{--                                <button--}}
{{--                                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">--}}
{{--                                    Load More Visits--}}
{{--                                </button>--}}
{{--                            </div>--}}
                        @else
                            <div class="flex flex-col items-center justify-center py-10 gap-2">
                                <svg class="size-[40px] text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 3V1H7V3H3C2.44772 3 2 3.44772 2 4V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V4C22 3.44772 21.5523 3 21 3H17V1H15V3H9ZM4 10H20V19H4V10ZM4 5H7V6H9V5H15V6H17V5H20V8H4V5ZM9.87862 10.9644L12 13.0858L14.1212 10.9644L15.5355 12.3785L13.4142 14.5001L15.5354 16.6212L14.1213 18.0354L12 15.9143L9.87855 18.0354L8.46442 16.6211L10.5857 14.5001L8.46436 12.3785L9.87862 10.9644Z">
                                    </path>
                                </svg>
                                <p class="text-base font-medium text-gray-500">{{ trans_message('no_upcoming_visits') }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Completed Tab Content -->
                    <div id="completed-content" class="tab-content hidden">
                        <!-- Visit Entry Cards -->
                        @if($completed_visits->all())
                            <div class="space-y-4">
                                @foreach($completed_visits as $completed)
                                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                                        <div class="flex flex-col sm:flex-row">
                                            <!-- Date Indicator Section -->
                                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 min-w-[100px] flex items-center justify-center flex-col flex-shrink-0">
                                                <div class="text-center">
                                                    <div class="text-3xl sm:text-4xl font-bold text-gray-800 mb-1">{{ dateToHuman($completed->start_datetime, 'd') }}</div>
                                                    <div class="text-sm font-medium text-gray-600 uppercase tracking-wide">{{ dateToHuman($completed->start_datetime, 'M') }}</div>
                                                </div>
                                            </div>

                                            <!-- Duration Details Section -->
                                            <div class="flex-1 p-4 sm:p-6 border-b sm:border-b-0 sm:border-r border-gray-100">
                                                <div class="space-y-3">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                            <span class="text-sm font-medium text-gray-600">{{ trans_message('start_label') }}</span>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-800">{{ dateToHuman($completed->start_datetime, 'd/m/y (D)') }}</span>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                            <span class="text-sm font-medium text-gray-600">{{ trans_message('end_label') }}</span>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-800">{{ dateToHuman($completed->end_datetime, 'd/m/y (D)') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Value and Action Section -->
                                            <div class="p-4 sm:p-6 flex flex-col sm:items-end justify-center gap-3">
                                                <div class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-full text-sm font-semibold">
                                                    {{ currency_icon() }}{{ $completed->price??0 }}
                                                </div>
                                                <a href="{{ route('visit.submissions',$completed->report->report_uid) }}"
                                                   class="group/btn relative flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl">
                                                    {{ trans_message('no_upcoming_visits') }}
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M8.59 16.59L13.17 12L8.59 7.41L10 6l6 6-6 6-1.41-1.41z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Load More Button -->
{{--                            <div class="text-center mt-8">--}}
{{--                                <button--}}
{{--                                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">--}}
{{--                                    Load More Visits--}}
{{--                                </button>--}}
{{--                            </div>--}}
                        @else
                            <div class="flex flex-col items-center justify-center py-10 gap-2">
                                <svg class="size-[40px] text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 3V1H7V3H3C2.44772 3 2 3.44772 2 4V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V4C22 3.44772 21.5523 3 21 3H17V1H15V3H9ZM4 10H20V19H4V10ZM4 5H7V6H9V5H15V6H17V5H20V8H4V5ZM9.87862 10.9644L12 13.0858L14.1212 10.9644L15.5355 12.3785L13.4142 14.5001L15.5354 16.6212L14.1213 18.0354L12 15.9143L9.87855 18.0354L8.46442 16.6211L10.5857 14.5001L8.46436 12.3785L9.87862 10.9644Z">
                                    </path>
                                </svg>
                                <p class="text-base font-medium text-gray-500">No Visit Events Completed</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script !src="">
        // Tab Navigation Functionality
        function switchTab(tabName) {
            // Remove active class from all tabs
            const tabs = document.querySelectorAll('nav button');
            tabs.forEach(tab => {
                tab.classList.remove('text-blue-600', 'border-blue-600', 'bg-blue-50');
                tab.classList.add('text-gray-500', 'hover:text-gray-700', 'hover:bg-gray-50');
            });

            // Add active class to selected tab
            const activeTab = document.querySelector(`[data-tab="${tabName}"]`);
            if (activeTab) {
                activeTab.classList.remove('text-gray-500', 'hover:text-gray-700', 'hover:bg-gray-50');
                activeTab.classList.add('text-blue-600', 'border-blue-600', 'bg-blue-50');
            }

            // Hide all tab content
            const allContent = document.querySelectorAll('.tab-content');
            allContent.forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('active');
            });

            // Show selected tab content
            const selectedContent = document.getElementById(`${tabName}-content`);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
                selectedContent.classList.add('active');
            }
        }

        // Filter Tag Functionality
        function toggleFilter(tagElement) {
            // Toggle active state
            if (tagElement.classList.contains('bg-emerald-100')) {
                // If already active, deactivate
                tagElement.classList.remove('bg-emerald-100', 'border-emerald-200', 'text-emerald-800');
                tagElement.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
            } else {
                // If not active, activate
                tagElement.classList.remove('bg-white', 'border-gray-300', 'text-gray-700');
                tagElement.classList.add('bg-emerald-100', 'border-emerald-200', 'text-emerald-800');
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function () {
            // Add data attributes to tabs
            const tabs = document.querySelectorAll('nav button');
            const tabNames = ['available', 'interested', 'scheduled', 'pending', 'completed'];

            tabs.forEach((tab, index) => {
                tab.setAttribute('data-tab', tabNames[index]);
                tab.addEventListener('click', () => switchTab(tabNames[index]));
            });

            // Add click handlers to filter tags
            const filterTags = document.querySelectorAll('.px-4.py-2');
            filterTags.forEach(tag => {
                tag.addEventListener('click', () => toggleFilter(tag));
            });

            // Add click handlers to "View Submissions" buttons
            const viewButtons = document.querySelectorAll('button');
            viewButtons.forEach(button => {
                if (button.textContent.includes('View Submissions')) {
                    button.addEventListener('click', function (e) {
                        e.stopPropagation();
                        console.log('View Submissions clicked');
                    });
                }
            });

            // Add click handler to "Load More" button
            const loadMoreButton = document.querySelector('button');
            if (loadMoreButton && loadMoreButton.textContent.includes('Load More Visits')) {
                loadMoreButton.addEventListener('click', function () {
                    console.log('Loading more visits...');
                    loadMoreButton.textContent = 'Loading...';
                    loadMoreButton.disabled = true;

                    setTimeout(() => {
                        loadMoreButton.textContent = 'Load More Visits';
                        loadMoreButton.disabled = false;
                    }, 2000);
                });
            }

            // Initialize with available tab active
            switchTab('available');
        });

        // Add CSS for smooth transitions
        const style = document.createElement('style');
        style.textContent = `
    .tab-content {
        transition: opacity 0.3s ease-in-out;
    }
    .tab-content.hidden {
        display: none;
    }
    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
        document.head.appendChild(style);


        // Request visit
        function requestVisit(id, element) {
            var available_count = parseInt($('.available_count').html());
            var interested_count = parseInt($('.interested_count').html());
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to Request this visit?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, Request",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
                buttonsStyling: !1,
            }).then(function (t) {
                if (t.value) {
                    $.ajax({
                        url: "{{route('visit.request')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            // $(element).addClass('<i class="spinner-border fs-10 spinner-border-sm m-1 mx-0"></i>');
                            // $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendSuccess(data.message);
                            available_count = available_count-1;
                            interested_count = interested_count+1;
                            $('.available_count').html(available_count);
                            $('.interested_count').html(interested_count);
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
                            visitList();
                        }
                    });
                }
            });
        }
    </script>
@endsection
