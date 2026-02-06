
@if($resultData->all())
    @foreach($resultData as $key => $row)
        <div class="group relative bg-white rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all duration-300 overflow-hidden">
            <!-- Gradient Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            </div>

            <!-- Header Section -->
            <div class="relative p-6 pb-4">
                <!-- Status Badge -->
                <div class="absolute top-4 left-4">
                    @if($row->status->name == 'ACTIVE')
                        <span class="inline-flex items-center px-3 py-1.5 leading-none rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            Active
                        </span>
                    @elseif($row->status->name == 'INACTIVE')
                        <span class="inline-flex items-center px-3 py-1.5 leading-none rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                            Inactive
                        </span>
                    @endif
                </div>

                <!-- Options Menu (Three Dots) -->
                <button popovertarget="companies-edits-{{$key}}"
                        class="cursor-pointer absolute top-4 right-4 p-2 rounded-full text-gray-400 hover:text-gray-600 hover:bg-white/80 transition-all duration-200 group-hover:opacity-100">
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
                        <button type="button" onclick="getBranch({{ $row->id }},this)"
                                class="cursor-pointer flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF]">
                            <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z">
                                </path>
                            </svg>
                            <span>Edit</span>
                        </button>
                        <button type="button" onclick="removeBranch({{ $row->id }},this)" class="cursor-pointer flex items-center text-[14px] font-medium px-6 py-3 text-red-500 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF]">
                            <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                                </path>
                            </svg>
                            <span>Delete</span>
                        </button>
                    </div>
                </el-popover>

                <!-- Branch Avatar -->
                <div class="flex justify-center mb-4">
                    <div class="relative">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 p-0.5 shadow-lg">
                            <div class="w-full h-full rounded-2xl bg-white flex items-center justify-center overflow-hidden">
                                <img src="{{ $row->image }}" alt="Branch Logo" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Branch Info -->
                <div class="text-center">
                    <h3 class="text-lg font-bold text-gray-900 mb-2 capitalize short_desc_2">{{ $row->branch_name }}</h3>
                    <div class="flex items-center justify-center text-sm text-gray-500 mb-3">
                        <span class="font-mono text-xs">ID: {{ $row->branch_uid??$row->id }}</span>
                    </div>
                </div>
            </div>

            <!-- Visit Statistics Section -->
            <div class="relative px-6 pb-5">
                <div class="grid grid-cols-2 gap-2">
                    <div class="text-center px-3 py-1.5 flex items-center justify-between gap-2 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                        <div class="text-sm font-medium text-blue-700">Open</div>
                        <div class="text-sm font-bold text-blue-600">{{ $row->visits->where('status','=','OPEN')->count() }}</div>
                    </div>
                    <div class="text-center px-3 py-1.5 flex items-center justify-between gap-2 bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl border border-amber-200">
                        <div class="text-sm font-medium text-amber-700">Scheduled</div>
                        <div class="text-sm font-bold text-amber-600">
                            {{ $row->visits()->where(function($query) {
                                $query->where('status','=', 'IN_PROGRESS')
                                    ->orWhere('status','=', 'SCHEDULED')
                                    ->orWhere('status','=', 'ASSIGNED');
                            })->count() }}
                        </div>
                    </div>
                    <div class="text-center px-3 py-1.5 flex items-center justify-between gap-2 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                        <div class="text-sm font-medium text-purple-700">Pending</div>
                        <div class="text-sm font-bold text-purple-600">{{ $row->visits->where('status','=','PENDING')->count() }}</div>
                    </div>
                    <div class="text-center px-3 py-1.5 flex items-center justify-between gap-2 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl border border-emerald-200">
                        <div class="text-sm font-medium text-emerald-700">Done</div>
                        <div class="text-sm font-bold text-emerald-600">{{ $row->visits->where('status','=','COMPLETED')->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Address Section -->
            <div class="relative px-6 pb-5">
                <div class="flex items-start gap-2">
                    <svg class="size-[16px] text-gray-500" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11 17.9381C7.05369 17.446 4 14.0796 4 10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10C20 14.0796 16.9463 17.446 13 17.9381V20.0116C16.9463 20.1039 20 20.7351 20 21.5C20 22.3284 16.4183 23 12 23C7.58172 23 4 22.3284 4 21.5C4 20.7351 7.05369 20.1039 11 20.0116V17.9381ZM12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z">
                        </path>
                    </svg>
                    <p class="text-sm w-[calc(100%-24px)] font-medium leading-[16px] text-gray-500">
                        {{ $row->address_1??'' }},
                        {{ $row->postal_code??'' }}
                        {{ $row->locality??'' }}
                    </p>
                </div>
            </div>

            <!-- Action Buttons Section -->
            <div class="relative p-6 pt-0">
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.company.branch.visits.index',[$row->branch_uid]) }}"
                       class="group/btn relative w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl col-span-2">
                        <span>All Visits</span>
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13.1714 12L8.22168 7.05025L9.63589 5.63604L15.9999 12L9.63589 18.364L8.22168 16.9497L13.1714 12Z" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.company.branch.visit.report',[$row->branch_uid])}}"
                       class="group/btn flex items-center justify-center gap-2 px-3 py-2.5 bg-white border border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition-all duration-300 shadow-sm hover:shadow-md">
                        <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor">
                            <path d="M11 7H13V17H11V7ZM15 11H17V17H15V11ZM7 13H9V17H7V13ZM15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                            </path>
                        </svg>
                        <span class="text-sm leading-none">Reports</span>
                    </a>
                    <button type="button" onclick="branchContactList({{ $row->id }},this)"
                            class="cursor-pointer group/btn flex items-center justify-center gap-2 px-3 py-2.5 bg-white border border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition-all duration-300 shadow-sm hover:shadow-md">
                        <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor">
                            <path d="M21 16.42V19.9561C21 20.4811 20.5941 20.9167 20.0705 20.9537C19.6331 20.9846 19.2763 21 19 21C10.1634 21 3 13.8366 3 5C3 4.72371 3.01545 4.36687 3.04635 3.9295C3.08337 3.40588 3.51894 3 4.04386 3H7.5801C7.83678 3 8.05176 3.19442 8.07753 3.4498C8.10067 3.67907 8.12218 3.86314 8.14207 4.00202C8.34435 5.41472 8.75753 6.75936 9.3487 8.00303C9.44359 8.20265 9.38171 8.44159 9.20185 8.57006L7.04355 10.1118C8.35752 13.1811 10.8189 15.6425 13.8882 16.9565L15.4271 14.8019C15.5572 14.6199 15.799 14.5573 16.001 14.6532C17.2446 15.2439 18.5891 15.6566 20.0016 15.8584C20.1396 15.8782 20.3225 15.8995 20.5502 15.9225C20.8056 15.9483 21 16.1633 21 16.42Z">
                            </path>
                        </svg>
                        <span class="text-sm leading-none">Contact</span>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@else
    <h4 class="font-medium text-[17px]">No Branch Found!</h4>
@endif