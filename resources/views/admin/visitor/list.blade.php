@if($resultData->all())
    @foreach($resultData as $key => $row)

        <div class="group relative bg-white rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            </div>
            <div class="relative p-4 sm:p-6 flex flex-col gap-3">
                <div class="flex items-start justify-between">
                    <!-- Left side with avatar and info -->
                    <div class="flex items-start gap-4 flex-col flex-1">
                        <div class="flex items-center gap-3">
                            <!-- Avatar -->
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl overflow-hidden flex-shrink-0">
                                <img src="{{ $row->profile_image }}" alt="Test Visitor" class="w-full h-full object-cover">
                            </div>

                            <!-- Details -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">{{ $row->first_name??'Anonymous visitor' }} {{ $row->last_name??'' }}</h3>
                            </div>
                        </div>
                    </div>


                    <!-- Right side with status badges and menu -->
                    <div class="flex items-start gap-3 pr-5">
                        <!-- Status Badges -->
                        <div class="flex flex-col items-end justify-end sm:flex-row gap-2">
                            @if(!$row->email_verified_at)
                                <span class="inline-flex items-center px-3 py-1.5 leading-none rounded-full text-xs font-semibold bg-orange-100 text-orange-800 border border-orange-200">
        {{ trans_message('email_not_verified') }}
    </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 leading-none rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
        {{ trans_message('email_verified') }}
    </span>
                            @endif

                            @if(!$row->email || !$row->mobile_number || !$row->profile_image || !$row->bank_account)
                                <span class="inline-flex items-center px-3 py-1.5 leading-none rounded-full text-xs font-semibold bg-orange-100 text-orange-800 border border-orange-200">
        {{ trans_message('profile_incomplete') }}
    </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 leading-none rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
        {{ trans_message('profile_complete') }}
    </span>
                            @endif
                        </div>
                        <div>
                            <button popovertarget="visitors-edits-{{$key}}"
                                    class="absolute cursor-pointer top-2 right-2 p-2 rounded-full text-gray-400 hover:text-gray-600 transition-all duration-200"
                                    id="popover-button-1" type="button" aria-haspopup="true"
                                    aria-controls="visitors-edits" aria-expanded="false">
                                <svg class="size-5" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 3C10.9 3 10 3.9 10 5C10 6.1 10.9 7 12 7C13.1 7 14 6.1 14 5C14 3.9 13.1 3 12 3ZM12 17C10.9 17 10 17.9 10 19C10 20.1 10.9 21 12 21C13.1 21 14 20.1 14 19C14 17.9 13.1 17 12 17ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10Z">
                                    </path>
                                </svg>
                            </button>
                            <el-popover id="visitors-edits-{{$key}}" anchor="bottom-end" popover=""
                                        class="overflow-visible bg-white w-[180px] shadow-[0px_0px_12px_#0000001f] mt-2 py-2 border border-[#ebeef5] rounded-[20px] transition open:flex data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in"
                                        aria-labelledby="popover-button-1" tabindex="-1"
                                        style="--button-width: 36px;">
                                <div class="w-full flex flex-col">
                                    <button type="button" onclick="getVisitor({{ $row->id }},this)"
                                            class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF]"
                                            aria-expanded="false">
                                        <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z">
                                            </path>
                                        </svg>
                                        <span>{{ trans_message('edit') }}</span>
                                    </button>
                                    @if($row->status->value == 'DEACTIVATE')
                                        <button type="button" onclick="statusVisitor({{ $row->id }},'active',this)" class="flex items-center text-[14px] font-medium px-6 py-3 text-emerald-500 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF]">
                                            <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M5.23379 7.72989C6.65303 5.48625 9.15342 4 12.0002 4C14.847 4 17.3474 5.48625 18.7667 7.72989L20.4569 6.66071C18.6865 3.86199 15.5612 2 12.0002 2C8.43928 2 5.31393 3.86199 3.54356 6.66071L5.23379 7.72989ZM12.0002 20C9.15342 20 6.65303 18.5138 5.23379 16.2701L3.54356 17.3393C5.31393 20.138 8.43928 22 12.0002 22C15.5612 22 18.6865 20.138 20.4569 17.3393L18.7667 16.2701C17.3474 18.5138 14.847 20 12.0002 20ZM12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3431 6 9 7.34315 9 9C9 10.6569 10.3431 12 12 12ZM12 13C14.2091 13 16 14.7909 16 17H8C8 14.7909 9.79086 13 12 13ZM6 12C6 13.6569 4.65685 15 3 15C1.34315 15 0 13.6569 0 12C0 10.3431 1.34315 9 3 9C4.65685 9 6 10.3431 6 12ZM21 15C22.6569 15 24 13.6569 24 12C24 10.3431 22.6569 9 21 9C19.3431 9 18 10.3431 18 12C18 13.6569 19.3431 15 21 15Z">
                                                </path>
                                            </svg>
                                            <span>{{ trans_message('active') }}</span>
                                        </button>
                                    @elseif($row->status->value == 'ACTIVE')
                                        <button type="button" onclick="statusVisitor({{ $row->id }},'deactivate',this)" class="flex items-center text-[14px] font-medium px-6 py-3 text-red-500 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF]">
                                            <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M5.23379 7.72989C6.65303 5.48625 9.15342 4 12.0002 4C14.847 4 17.3474 5.48625 18.7667 7.72989L20.4569 6.66071C18.6865 3.86199 15.5612 2 12.0002 2C8.43928 2 5.31393 3.86199 3.54356 6.66071L5.23379 7.72989ZM12.0002 20C9.15342 20 6.65303 18.5138 5.23379 16.2701L3.54356 17.3393C5.31393 20.138 8.43928 22 12.0002 22C15.5612 22 18.6865 20.138 20.4569 17.3393L18.7667 16.2701C17.3474 18.5138 14.847 20 12.0002 20ZM12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3431 6 9 7.34315 9 9C9 10.6569 10.3431 12 12 12ZM12 13C14.2091 13 16 14.7909 16 17H8C8 14.7909 9.79086 13 12 13ZM6 12C6 13.6569 4.65685 15 3 15C1.34315 15 0 13.6569 0 12C0 10.3431 1.34315 9 3 9C4.65685 9 6 10.3431 6 12ZM21 15C22.6569 15 24 13.6569 24 12C24 10.3431 22.6569 9 21 9C19.3431 9 18 10.3431 18 12C18 13.6569 19.3431 15 21 15Z">
                                                </path>
                                            </svg>
                                            <span>{{ trans_message('deactivate') }}</span>
                                        </button>
                                    @endif
                                    @if($row->status->value == 'INVITED')
                                        <button onclick="resendInviteVisitor({{ $row->id }},'{{ $row->email }}',this)"
                                                class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF]"
                                                aria-expanded="false">
                                            <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M1.94607 9.31543C1.42353 9.14125 1.4194 8.86022 1.95682 8.68108L21.043 2.31901C21.5715 2.14285 21.8746 2.43866 21.7265 2.95694L16.2733 22.0432C16.1223 22.5716 15.8177 22.59 15.5944 22.0876L11.9999 14L17.9999 6.00005L9.99992 12L1.94607 9.31543Z">
                                                </path>
                                            </svg>
                                                <span>{{ trans_message('resend_invite') }}<</span>
                                        </button>
                                    @endif

                                    <button type="button" onclick="removeVisitor({{ $row->id }},this)" class="flex items-center text-[14px] font-medium px-6 py-3 text-red-500 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF]">
                                        <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                                            </path>
                                        </svg>
                                        <span>{{ trans_message('delete') }}</span>
                                    </button>
                                </div>
                            </el-popover>
                        </div>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <a href="{{ route('admin.visitor.visits',['visitorId'=>$row->uid]) }}"
                       class="group/btn relative flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl">
                        <span>All Visits</span>
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13.1714 12L8.22168 7.05025L9.63589 5.63604L15.9999 12L9.63589 18.364L8.22168 16.9497L13.1714 12Z">
                            </path>
                        </svg>
                    </a>
                    <button
                            class="inline-flex items-center justify-center space-x-2 px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>{{ $row->email }}</span>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@else
    <h4 class="font-medium text-[17px]">No Visitors Found!</h4>
@endif
