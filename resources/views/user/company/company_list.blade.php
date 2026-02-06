<!-- Company Card -->

@if($resultData)
    @foreach($resultData as $key => $row)

<div class="grid grid-cols-1 content-between group relative bg-white rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all duration-300 overflow-hidden">
    <!-- Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
    </div>

    <!-- Header Section -->
    <div class="relative p-6 pb-4">
        <!-- Status Badge -->
        <div class="absolute top-4 left-4">
            @if($row->status->name == 'ACTIVE')
                <span class="inline-flex items-center px-3 py-1.5 leading-none rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    {{ trans_message('active') }}

                </span>
            @elseif($row->status->name == 'DEACTIVATE')
                <span class="inline-flex items-center px-3 py-1.5 leading-none rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                    {{ trans_message('deactivate') }}
                </span>
            @endif

        </div>

        <!-- Company Avatar -->
        <div class="flex justify-center mb-4">
            <div class="relative">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 p-0.5 shadow-lg">
                    <div class="w-full h-full rounded-2xl bg-white flex items-center justify-center overflow-hidden">
                        <img src="{{ $row->image }}" alt="Company Logo" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>

        <!-- Company Info -->
        <div class="text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-2 capitalize short_desc_2">{{ $row->company_name }}</h3>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="relative p-6 pt-0">
        <div class="flex items-center justify-between justify-center pb-5">
            <div class="flex items-center leading-none gap-1 font-medium text-sm text-gray-600">
                <svg class="size-[14px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     fill="currentColor">
                    <path
                            d="M11 17.9381C7.05369 17.446 4 14.0796 4 10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10C20 14.0796 16.9463 17.446 13 17.9381V20.0116C16.9463 20.1039 20 20.7351 20 21.5C20 22.3284 16.4183 23 12 23C7.58172 23 4 22.3284 4 21.5C4 20.7351 7.05369 20.1039 11 20.0116V17.9381ZM12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z">
                    </path>
                </svg>
                <p>{{ count($row->branches) }} {{ trans_message('branches') }}</p>>
            </div>
{{--            <div class="flex items-center leading-none gap-1 font-medium text-sm text-gray-600">--}}
{{--                <svg class="size-[14px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"--}}
{{--                     fill="currentColor">--}}
{{--                    <path--}}
{{--                            d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">--}}
{{--                    </path>--}}
{{--                </svg>--}}
{{--                <p>4.8 Rating</p>--}}
{{--            </div>--}}
        </div>

        <!-- Action Button -->
        <a href="{{ route('company.branches.index', ['companyId' => $row->company_id]) }}"
           class="group/btn relative w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl">
            <span>{{ trans_message('view_branches') }}</span
            <svg class="w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                        d="M13.1714 12L8.22168 7.05025L9.63589 5.63604L15.9999 12L9.63589 18.364L8.22168 16.9497L13.1714 12Z" />
            </svg>
        </a>
    </div>
</div>

@endforeach
@endif
