@forelse($subdealers as $key => $subdealer)
    <div class="grid grid-cols-1 content-between group relative bg-white rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all duration-300 overflow-hidden">
        <!-- Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>

        <!-- Header Section -->
        <div class="relative p-6 pb-4">
            <!-- Options Menu (Three Dots) -->
            <button popovertarget="subdealer-edits-{{$key}}"
                    class="absolute cursor-pointer top-4 right-4 p-2 rounded-full text-gray-400 hover:text-gray-600 hover:bg-white/80 transition-all duration-200 group-hover:opacity-100">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     fill="currentColor">
                    <path d="M12 3C10.9 3 10 3.9 10 5C10 6.1 10.9 7 12 7C13.1 7 14 6.1 14 5C14 3.9 13.1 3 12 3ZM12 17C10.9 17 10 17.9 10 19C10 20.1 10.9 21 12 21C13.1 21 14 20.1 14 19C14 17.9 13.1 17 12 17ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10Z">
                    </path>
                </svg>
            </button>

            <!-- Subdealer Edits Popover -->
            <el-popover id="subdealer-edits-{{$key}}" anchor="bottom-end" popover
                        class="overflow-visible bg-white w-[170px] shadow-[0px_0px_12px_#0000001f] mt-2 py-2 border border-[#ebeef5] rounded-[20px] transition open:flex data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in">
                <div class="w-full flex flex-col">
                    <button onclick="editSubdealer({{ $subdealer->id }},this)"
                            class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF] cursor-pointer">
                        <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z">
                            </path>
                        </svg>
                        <span>{{ trans_message('edit') }}</span>
                    </button>
                    <button onclick="deleteSubdealer({{ $subdealer->id }},this)" class="flex items-center text-[14px] font-medium px-6 py-3 text-red-500 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF] cursor-pointer">
                        <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                            </path>
                        </svg>
                        <span>{{ trans_message('delete') }}</span>
                    </button>
                </div>
            </el-popover>

            <!-- Subdealer Avatar -->
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 p-0.5 shadow-lg">
                        <div class="w-full h-full rounded-2xl bg-white flex items-center justify-center overflow-hidden">
                            @if($subdealer->logo)
                                <img src="{{ $subdealer->logo }}" alt="{{ $subdealer->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <svg class="w-10 h-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                                    <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subdealer Info -->
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-900 mb-2 capitalize short_desc_2">{{ $subdealer->name }}</h3>
                <div class="flex items-center justify-center text-sm text-gray-500 mb-2">
                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3ZM20 7.238L12.0718 14.338L4 7.216V19H20V7.238ZM4.511 5L12.0619 11.662L19.501 5H4.511Z"></path>
                    </svg>
                    <span class="truncate text-xs">{{ $subdealer->email }}</span>
                </div>
                <div class="flex items-center justify-center text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z"></path>
                    </svg>
                    <span class="text-xs">{{ $subdealer->phone }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="relative p-6 pt-0">
            <div class="flex items-center justify-center pb-4">
                <div class="flex items-center leading-none gap-1 font-medium text-xs text-gray-500">
                    <svg class="size-[14px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z">
                        </path>
                    </svg>
                    <p>{{ trans_message('added') }}: {{ dateToHuman($subdealer->created_at, 'd M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-span-full">
        <div class="py-12 text-center w-full bg-white rounded-2xl shadow border border-gray-100">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path>
            </svg>
            <h5 class="text-lg font-medium text-gray-700">{{ trans_message('no_subdealers_found') }}</h5>
            <p class="text-sm text-gray-500 mt-2">{{ trans_message('click_add_subdealer_to_create') }}</p>
        </div>
    </div>
@endforelse
