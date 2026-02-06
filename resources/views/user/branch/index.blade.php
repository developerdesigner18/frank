@extends('user.master')
@section('title', $company->company_name.' '.trans_message('branches'))
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('admin.company.index') }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>{{ trans_message('companies') }}</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-500">{{ $company->company_name }}</span>
    </div>
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800 short_desc_2">{{ $company->company_name }}  {{ trans_message('branches') }}</span>
    </div>
@endpush
@section('main')
    <section class="pt-4 sm:pt-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
            <!-- Branch Card -->
            @if($allBranch->count() > 0)
            @foreach ($allBranch as $branch)
            <div class="group relative bg-white rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all duration-300 overflow-hidden">
                <!-- Gradient Background -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>

                <!-- Header Section -->
                <div class="relative p-6 pb-4">
                    <!-- Branch Avatar -->
                    <div class="flex justify-center mb-4">
                        <div class="relative">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 p-0.5 shadow-lg">
                                <div class="w-full h-full rounded-2xl bg-white flex items-center justify-center overflow-hidden">
                                    <img src="{{ $branch->image }}" alt="Branch Logo" class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Branch Info -->
                    <div class="text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 capitalize short_desc_2">{{ $branch->branch_name }}</h3>
                    </div>
                </div>

                <!-- Visit Statistics Section -->
                <div class="relative px-6 pb-5">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="text-center px-3 py-1.5 flex items-center justify-between gap-2 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                            <div class="text-sm font-medium text-blue-700">{{ trans_message('open') }}</div>
                            <div class="text-sm font-bold text-blue-600">{{ $branch->visits->where('status','=','OPEN')->count() }}</div>
                        </div>
                        <div class="text-center px-3 py-1.5 flex items-center justify-between gap-2 bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl border border-amber-200">
                            <div class="text-sm font-medium text-amber-700">{{ trans_message('scheduled') }}</div>
                            <div class="text-sm font-bold text-amber-600">
                                {{ $branch->visits()->where('visitor_id','=',$user_id)->where(function($query) {
                               $query->where('status','=', 'IN_PROGRESS')
                                   ->orWhere('status','=', 'SCHEDULED')
                                   ->orWhere('status','=', 'ASSIGNED');
                           })->count() }}
                            </div>
                        </div>
                        <div class="text-center px-3 py-1.5 flex items-center justify-between gap-2 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                            <div class="text-sm font-medium text-purple-700">{{ trans_message('pending') }}</div>
                            <div class="text-sm font-bold text-purple-600">{{ $branch->visits->where('visitor_id','=',$user_id)->where('status','=','PENDING')->count() }}</div>
                        </div>
                        <div class="text-center px-3 py-1.5 flex items-center justify-between gap-2 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl border border-emerald-200">
                            <div class="text-sm font-medium text-emerald-700">{{ trans_message('done') }}</div>
                            <div class="text-sm font-bold text-emerald-600">{{ $branch->visits->where('visitor_id','=',$user_id)->where('status','=','COMPLETED')->count() }}</div>
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="relative px-6 pb-5">
                    <div class="flex items-center justify-center gap-2">
                        <p class="text-sm text-center w-[calc(100%-24px)] font-medium leading-[16px] text-gray-500">
                            {{ $branch->address_1??'' }},
                            {{ $branch->postal_code??'' }}
                            {{ $branch->locality??'' }}
                        </p>
                    </div>
                </div>
                <!-- Action Buttons Section -->
                <div class="relative p-6 pt-0">
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('company.branch.visits.index',[$branch->branch_uid]) }}"
                           class="group/btn relative w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl col-span-2">
                            <span>{{ trans_message('all_visits') }} </span>
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                        d="M13.1714 12L8.22168 7.05025L9.63589 5.63604L15.9999 12L9.63589 18.364L8.22168 16.9497L13.1714 12Z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
                <h4 class="font-medium text-[17px]">No Branch Found!</h4>
            @endif
        </div>
    </section>
@endsection

@section('script')
    <script !src="">

    </script>
@endsection
