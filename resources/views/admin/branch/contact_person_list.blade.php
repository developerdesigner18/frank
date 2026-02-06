@if($resultData->all())
    @foreach($resultData as $key => $row)
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex items-start justify-between">
                <!-- Left side with avatar and info -->
                <div class="flex flex-col items-start gap-3">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gray-200 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="text-base font-medium text-gray-900 mb-2">{{ $row->first_name }} {{ $row->last_name }}</h4>
                    </div>
                    <!-- Contact Info -->
                    <div class="flex items-center gap-2">
                        <!-- Phone -->
                        <div class="flex items-center gap-2">
                            <div class="flex text-xs text-gray-600 items-center gap-1 px-2 py-1 bg-gray-100 rounded-full">
                                <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 16.42V19.9561C21 20.4811 20.5941 20.9167 20.0705 20.9537C19.6331 20.9846 19.2763 21 19 21C10.1634 21 3 13.8366 3 5C3 4.72371 3.01545 4.36687 3.04635 3.9295C3.08337 3.40588 3.51894 3 4.04386 3H7.5801C7.83678 3 8.05176 3.19442 8.07753 3.4498C8.10067 3.67907 8.12218 3.86314 8.14207 4.00202C8.34435 5.41472 8.75753 6.75936 9.3487 8.00303C9.44359 8.20265 9.38171 8.44159 9.20185 8.57006L7.04355 10.1118C8.35752 13.1811 10.8189 15.6425 13.8882 16.9565L15.4271 14.8019C15.5572 14.6199 15.799 14.5573 16.001 14.6532C17.2446 15.2439 18.5891 15.6566 20.0016 15.8584C20.1396 15.8782 20.3225 15.8995 20.5502 15.9225C20.8056 15.9483 21 16.1633 21 16.42Z">
                                    </path>
                                </svg>
                                <span class="">{{ $row->mobile_number }}</span>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-center gap-2">
                            <div class="flex text-xs text-gray-600 items-center gap-1 px-2 py-1 bg-gray-100 rounded-full">
                                <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3ZM12.0606 11.6829L5.64722 6.2377L4.35278 7.7623L12.0731 14.3171L19.6544 7.75616L18.3456 6.24384L12.0606 11.6829Z">
                                    </path>
                                </svg>
                                <span class="">{{ $row->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Three dots menu -->
                <button popovertarget="contact-person-more-{{ $key }}"
                        class="cursor-pointer text-gray-400 hover:text-gray-600 transition-colors p-1">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3C10.9 3 10 3.9 10 5C10 6.1 10.9 7 12 7C13.1 7 14 6.1 14 5C14 3.9 13.1 3 12 3ZM12 17C10.9 17 10 17.9 10 19C10 20.1 10.9 21 12 21C13.1 21 14 20.1 14 19C14 17.9 13.1 17 12 17ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10Z" />
                    </svg>
                </button>
                <el-popover id="contact-person-more-{{ $key }}" anchor="bottom-end" popover
                            class="overflow-visible bg-white w-[170px] shadow-[0px_0px_12px_#0000001f] mt-2 py-2 border border-[#ebeef5] rounded-[20px] transition open:flex data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in">
                    <div class="w-full flex flex-col">
                        <button onclick="getEditBranchContact({{ $row->id }},this)"
                                class="cursor-pointer flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF]">
                            <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z">
                                </path>
                            </svg>
                            <span>Edit</span>
                        </button>
                        <button onclick="removeBranchContact({{ $row->id }},this)" class="cursor-pointer flex items-center text-[14px] font-medium px-6 py-3 text-red-500 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF]">
                            <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                                </path>
                            </svg>
                            <span>Delete</span>
                        </button>
                    </div>
                </el-popover>
            </div>
        </div>
    @endforeach
@else
    <h4 class="text-center">Branch Contact Not Found!</h4>
@endif