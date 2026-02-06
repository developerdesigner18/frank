
<!-- Company Card -->
@if($resultData)
    @foreach($resultData as $key => $row)
        <div class="grid grid-cols-1 content-between group relative bg-white rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all duration-300 overflow-hidden">
            <!-- Gradient Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            </div>

            <!-- Header Section -->
            <div class="relative p-6 pb-4">
                <!-- Options Menu (Three Dots) -->
                <button popovertarget="companies-edits-{{$key}}"
                        class="absolute cursor-pointer top-4 right-4 p-2 rounded-full text-gray-400 hover:text-gray-600 hover:bg-white/80 transition-all duration-200 group-hover:opacity-100">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path d="M12 3C10.9 3 10 3.9 10 5C10 6.1 10.9 7 12 7C13.1 7 14 6.1 14 5C14 3.9 13.1 3 12 3ZM12 17C10.9 17 10 17.9 10 19C10 20.1 10.9 21 12 21C13.1 21 14 20.1 14 19C14 17.9 13.1 17 12 17ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10Z">
                        </path>
                    </svg>
                </button>

                <!-- Visits Edits Popover -->
                <el-popover id="companies-edits-{{$key}}" anchor="bottom-end" popover
                            class="overflow-visible bg-white w-[170px] shadow-[0px_0px_12px_#0000001f] mt-2 py-2 border border-[#ebeef5] rounded-[20px] transition open:flex data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in">
                    <div class="w-full flex flex-col">
                        <button onclick="getCompany({{ $row->id }},this)"
                                class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF] cursor-pointer">
                            <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z">
                                </path>
                            </svg>
                            <span>{{ trans_message('edit') }}</span>                        </button>
                        <button onclick="removeCompany({{ $row->id }},this)" class="flex items-center text-[14px] font-medium px-6 py-3 text-red-500 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF] cursor-pointer">
                            <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                                </path>
                            </svg>
                            <span>{{ trans_message('delete') }}</span>
                        </button>
                    </div>
                </el-popover>

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
                                <img src="{{ $row->image }}" alt="Company Logo"
                                     class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 capitalize short_desc_2">{{ $row->company_name }}</h3>
                    <div class="flex items-center justify-center text-sm text-gray-500 mb-3">
                        <span class="font-mono text-xs">ID: {{ $row->company_id }}</span>
                    </div>
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
                        <p>{{ count($row->branches) }} Branches</p>
                    </div>
{{--                    <div class="flex items-center leading-none gap-1 font-medium text-sm text-gray-600">--}}
{{--                        <svg class="size-[14px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"--}}
{{--                             fill="currentColor">--}}
{{--                            <path--}}
{{--                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">--}}
{{--                            </path>--}}
{{--                        </svg>--}}
{{--                        <p>4.8 Rating</p>--}}
{{--                    </div>--}}
                </div>

                <!-- Action Button -->
                <a href="{{ route('admin.company.branches.index', ['companyId' => $row->company_id]) }}"
                   class="group/btn relative w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl">
                    <span>{{ trans_message('view_branches') }}</span>

                    <svg class="w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13.1714 12L8.22168 7.05025L9.63589 5.63604L15.9999 12L9.63589 18.364L8.22168 16.9497L13.1714 12Z" />
                    </svg>
                </a>
            </div>
        </div>
    @endforeach
@endif
