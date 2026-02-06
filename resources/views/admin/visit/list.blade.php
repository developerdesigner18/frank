@if($resultData->all())
    @foreach($resultData as $key => $row)
        <div class="flex p-4 bg-white flex-col rounded-xl relative border border-gray-200 hover:shadow-md transition-all">
            <div class="flex justify-between w-full items-center gap-4 pb-3">
                <span class="flex gap-2.5 sm:items-center sm:flex-row flex-col flex-1">
                    <span class="size-[40px] rounded-full overflow-hidden">
                        <img src="{{ $row->branch->image }}" class="h-[100%]">
                    </span>
                    <div class="flex flex-col gap-0.5">
                        <span class="text-sm sm:text-base font-medium text-gray-800">{{ $row->branch->branch_name??'' }} · {{ dateToHuman($row->start_datetime, 'M Y') }}</span>
                        <div class="flex items-center flex-wrap xs:gap-3 gap-1">
                            <div class="flex items-center gap-1.5">
                                <svg class="size-[14px] text-gray-400"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path d="M18.364 17.364L12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364ZM12 15C14.2091 15 16 13.2091 16 11C16 8.79086 14.2091 7 12 7C9.79086 7 8 8.79086 8 11C8 13.2091 9.79086 15 12 15ZM12 13C10.8954 13 10 12.1046 10 11C10 9.89543 10.8954 9 12 9C13.1046 9 14 9.89543 14 11C14 12.1046 13.1046 13 12 13Z">
                                    </path>
                                </svg>
                                <span class="text-xs sm:text-sm font-medium text-gray-500">{{ $row->branch->address_1 }}, {{ $row->branch->postal_code }} {{ $row->branch->locality }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor" class="size-[14px] text-gray-400">
                                    <path d="M7 1V3H3C2.44772 3 2 3.44772 2 4V20C2 20.5523 2.44772 21 3 21H10.7546C9.65672 19.6304 9 17.8919 9 16C9 11.5817 12.5817 8 17 8C18.8919 8 20.6304 8.65672 22 9.75463V4C22 3.44772 21.5523 3 21 3H17V1H15V3H9V1H7ZM23 16C23 19.3137 20.3137 22 17 22C13.6863 22 11 19.3137 11 16C11 12.6863 13.6863 10 17 10C20.3137 10 23 12.6863 23 16ZM16 12V16.4142L18.2929 18.7071L19.7071 17.2929L18 15.5858V12H16Z">
                                    </path>
                                </svg>
                                <span class="text-xs sm:text-sm -tracking-[1px] font-medium text-gray-500">
                                    {{ dateToHuman($row->start_datetime, 'd/m/Y') }}
                                    &nbsp;-&nbsp;
                                    {{ dateToHuman($row->end_datetime, 'd/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </span>
                <div class="flex items-center absolute right-3 top-3 gap-2">
                    @if($row->status->name == 'OPEN')
                        @if($row->interests->count() > 0)
                            <button type="button" class="bg-[#F0F9EB] px-3 sm:py-2 py-1.5 text-[10px] sm:text-xs font-medium border border-[#12B76A] rounded-full text-[#12B76A]">
                                {{ trans_message('status_interested') }}
                            </button>
                        @else
                            <button type="button" class="bg-[#F0F9EB] px-3 sm:py-2 py-1.5 text-[10px] sm:text-xs font-medium border border-[#12B76A] rounded-full text-[#12B76A]">
                                {{ trans_message('status_open') }}
                            </button>
                        @endif

                    @elseif($row->status->name == 'INTERESTED')
                        <button type="button" class="bg-[#F0F9EB] px-3 sm:py-2 py-1.5 text-[10px] sm:text-xs font-medium border border-[#12B76A] rounded-full text-[#12B76A]">
                            {{ trans_message('status_interested') }}
                        </button>

                    @elseif($row->status->name == 'SCHEDULED' || $row->status->name == 'IN_PROGRESS')
                        <button type="button" class="bg-red-50 px-3 sm:py-2 py-1.5 text-[10px] sm:text-xs font-medium border border-red-500 rounded-full text-red-500">
                            {{ trans_message('status_in_progress') }}
                        </button>

                    @elseif($row->status->name == 'PENDING')
                        <button type="button" class="bg-[#ecf5ff] px-3 sm:py-2 py-1.5 text-[10px] sm:text-xs font-medium border border-[#409eff] rounded-full text-[#409eff]">
                            {{ trans_message('status_pending') }}
                        </button>

                    @elseif($row->status->name == 'COMPLETED')
                        <button type="button" class="bg-[#ecf5ff] px-3 sm:py-2 py-1.5 text-[10px] sm:text-xs font-medium border border-[#409eff] rounded-full text-[#409eff]">
                            {{ trans_message('status_completed') }}
                        </button>

                    @elseif($row->status->name == 'ASSIGNED')
                        <button type="button" class="bg-[#F0F9EB] px-3 sm:py-2 py-1.5 text-[10px] sm:text-xs font-medium border border-[#12B76A] rounded-full text-[#12B76A]">
                            {{ trans_message('status_assigned') }}
                        </button>

                    @else
                        <button type="button" class="bg-[#F0F9EB] px-3 sm:py-2 py-1.5 text-[10px] sm:text-xs font-medium border border-[#12B76A] rounded-full text-[#12B76A]">
                            {{ $row->status->name }}
                        </button>
                    @endif

                    <div class="relative flex items-center">
                        <button popovertarget="visits-edits-{{$key}}"
                                class="size-5 text-gray-500 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                 fill="currentColor">
                                <path d="M12 3C10.9 3 10 3.9 10 5C10 6.1 10.9 7 12 7C13.1 7 14 6.1 14 5C14 3.9 13.1 3 12 3ZM12 17C10.9 17 10 17.9 10 19C10 20.1 10.9 21 12 21C13.1 21 14 20.1 14 19C14 17.9 13.1 17 12 17ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10Z">
                                </path>
                            </svg>
                        </button>
                        <!-- Visits Edits Popover -->
                        <el-popover id="visits-edits-{{$key}}" anchor="bottom-end" popover
                                    class="overflow-visible bg-white w-[170px] shadow-[0px_0px_12px_#0000001f] mt-2 py-2 border border-[#ebeef5] rounded-[20px] transition open:flex data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in">
                            <div class="w-full flex flex-col">
                                @if(in_array($row->status->name, ['PENDING', 'COMPLETED', 'SCHEDULED', 'IN_PROGRESS', 'ASSIGNED', 'VISITED', 'APPROVED']))
                                    <a href="{{ route('admin.questionnaire.response',['visitId'=>$row->unioqid]) }}"
                                       class="cursor-pointer flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF]">
                                        <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z">
                                            </path>
                                        </svg>
                                        <span>{{ trans_message('edit') }}</span>
                                    </a>
                                @else
                                    <button onclick="getVisit({{ $row->id }},this)"
                                            class="cursor-pointer flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF]">
                                        <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z">
                                            </path>
                                        </svg>
                                        <span>{{ trans_message('edit') }}</span>
                                    </button>
                                @endif

                                @if($row->status->name == 'OPEN' || $row->status->name == 'INTERESTED')
                                    <button onclick="duplicateVisit({{ $row->id }},this)" class="cursor-pointer flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF]">
                                        <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6ZM6.9998 11V13H12.9998V11H6.9998ZM6.9998 15V17H12.9998V15H6.9998Z">
                                            </path>
                                        </svg>
                                        <span>{{ trans_message('duplicate') }}</span>
                                    </button>
                                @endif
                                <button type="button" onclick="removeVisit({{ $row->id }},this)" class="cursor-pointer flex items-center text-[14px] font-medium px-6 py-3 text-red-500 border-l-4 gap-2 border-transparent hover:bg-[#EFF6FF]">
                                    <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                                        </path>
                                    </svg>
                                    <span>{{ trans_message('delete') }}</span>                                </button>
                            </div>
                        </el-popover>
                    </div>
                </div>
            </div>
            <div class="flex justify-between gap-2 flex-col sm:flex-row">
                <div class="flex flex-col items-start sm:items-center sm:flex-row flex-wrap gap-3 w-full">

                    @if($row->status->name !== 'PENDING' && $row->status->name !== 'COMPLETED')
                        @if($row->questionnaire && $row->unioqid)
                            <a href="{{ route('admin.questionnaire.response',['visitId'=>$row->unioqid]) }}"
                               class="border border-[#e5e7eb] bg-[#0073AF] text-white flex items-center px-3 sm:py-2 py-1.5 text-[10px] sm:text-xs font-medium rounded-full text-gray-700 gap-1.5">
                                <span>{{ trans_message('form') }}</span>
                                <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                    </path>
                                </svg>
                            </a>
                        @else
                            <button type="button" onclick="sendToast('{{ trans_message('questionnaire_not_available') ?? 'Questionnaire is not available' }}', 'danger')"
                                    class="border border-[#e5e7eb] bg-[#0073AF] text-white flex items-center px-3 sm:py-2 py-1.5 text-[10px] sm:text-xs font-medium rounded-full text-gray-700 gap-1.5 cursor-pointer">
                                <span>{{ trans_message('form') }}</span>
                                <svg class="size-[16px]" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                    </path>
                                </svg>
                            </button>
                        @endif
                    @endif

                    @if(isset($row->visitor) && $row->status->name !== 'INTERESTED')
                        <a href="javascript:void(0);" class="border border-[#e5e7eb] bg-gray-100 flex items-center px-3 sm:py-2 py-1.5 text-[10px] sm:text-xs font-medium rounded-full text-gray-700 gap-1.5">
                            <span>{{ $row->visitor->first_name }} {{ $row->visitor->last_name??'' }}</span>
                        </a>
                    @endif

                    <a href="javascript:void(0);" class="border border-[#e5e7eb] bg-gray-100 flex items-center px-3 sm:py-2 py-1.5 text-[10px] sm:text-xs font-medium rounded-full text-gray-700 gap-1.5">
                        <span>{{ $row->questionnaire->name ?? '-' }}</span>
                    </a>

                    <button type="button" class="border border-[#e5e7eb] flex font-semibold gap-1 items-center px-3 py-1.5 rounded-full sm:ml-auto sm:py-2 text-black-500 text-sm">
                        <span>{{ trans_message('fee') }} {{ currency_icon() }}</span>
                        <span>{{ round($row->price,2) }}</span>
                    </button>

                    <button type="button" class="border border-[#e5e7eb] flex font-semibold gap-1 items-center px-2 py-1.5 rounded-full text-black-500 text-sm">
                        <span>{{ trans_message('expense_estimate') }} {{ currency_icon() }}</span>
                        <span>{{ round($row->expense_estimation_min,2) }}</span>
                        <span>- {{ currency_icon() }}</span>
                        <span>{{ round($row->expense_estimation_max,2) }}</span>
                    </button>

                    @if($row->status->name !== 'PENDING' && $row->status->name !== 'COMPLETED')
                        <div class="toggle-switch flex items-center">
                            <label class="relative gap-2 flex items-center cursor-pointer">
                                <input type="checkbox" value="1" name="published"
                                       class="sr-only peer visitPublished"
                                       data-id="{{ $row->id }}"
                                    {{ $row->published?'checked':'' }}>
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0073AF]">
                                </div>
                                <span class="text-[10px] sm:text-xs font-semibold text-gray-700 peer-checked:hidden">
                        {{ trans_message('draft') }}
                    </span>
                                <span class="text-[10px] sm:text-xs font-semibold text-gray-700 hidden peer-checked:block">
                        {{ trans_message('published') }}
                    </span>
                            </label>
                        </div>
                    @endif

                </div>
            </div>

            @php
                $interestedVisitors = $row->interests()->with('user')->get();
            @endphp
            @if($interestedVisitors->isNotEmpty() && ($row->status->name == 'OPEN' || $row->status->name == 'INTERESTED'))
                <div class="flex flex-col md:flex-row items-center justify-end gap-4">
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <div class="relative w-full flex md:w-auto">
                            <button type="button" onclick="rejectVisit({{$row->id}}, this)" class="flex justify-center items-center gap-2 w-full appearance-none border border-[#e5e7eb] bg-[#F56C6C] text-white rounded-full px-4 py-1.5 cursor-pointer transition-all duration-300" aria-expanded="false">
                                <span>{{ trans_message('reject') }}</span>                                <svg fill="#ffffff" width="20px" height="20px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M697.4 759.2l61.8-61.8L573.8 512l185.4-185.4-61.8-61.8L512 450.2 326.6 264.8l-61.8 61.8L450.2 512 264.8 697.4l61.8 61.8L512 573.8z"></path></g></svg>
                            </button>
                        </div>
                        <div class="relative w-full flex md:w-auto">
                            <div class="relative w-full">
                                <select id="visitor-select-{{$row->id}}" class="visitor-select w-full appearance-none border border-[#e5e7eb] bg-white rounded-full px-4 py-1.5 pr-10 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#67C23A]">
                                    <option value="">{{ trans_message('select_visitor') ?? 'Select Visitor' }}</option>
                                    @foreach($interestedVisitors as $interest)
                                        <option value="{{ $interest->user_id }}">{{ $interest->user->first_name }} {{ $interest->user->last_name }}</option>
                                    @endforeach
                                </select>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="relative w-full flex md:w-auto">
                            <button type="button" onclick="assignedVisit({{$row->id}}, this)" class="flex justify-center items-center gap-2 w-full appearance-none border border-[#e5e7eb] bg-[#67C23A] text-white rounded-full px-4 py-1.5 cursor-pointer transition-all duration-300" aria-expanded="false">
                                <span>{{ trans_message('assigned') }}</span>
                                <svg viewBox="0 0 24 24" width="20px" role="img" xmlns="http://www.w3.org/2000/svg" aria-labelledby="okIconTitle" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" color="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title id="okIconTitle">Ok</title> <polyline points="4 13 9 18 20 7"></polyline> </g></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            @if($row->status->name == 'PENDING')
                <div class="flex flex-col md:flex-row items-center justify-end gap-4 mt-3">
                    <a href="{{ route('admin.visit.report.review',$row->report->report_uid) }}"
                       class="flex items-center justify-center space-x-2 px-3 py-2 sm:px-4 sm:py-2.5 bg-[#0073AF] hover:bg-[#0068A0] cursor-pointer text-white text-xs sm:text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span>{{ trans_message('review') }}</span>                    </a>
                    <button type="button" onclick="visitReportStatus({{$row->id}}, 'approved', this)" class="questionnaire_submit flex items-center justify-center space-x-2 px-3 py-2 sm:px-4 sm:py-2.5 bg-green-400  hover:bg-[#0068A0] cursor-pointer text-white text-xs sm:text-sm font-medium rounded-lg transition-colors duration-200">
                        Approve
                    </button>
{{--                    <div class="flex items-center gap-4 w-full md:w-auto">--}}
{{--                        <div class="relative w-full flex md:w-auto">--}}
{{--                            <button type="button" onclick="visitReportStatus({{$row->id}}, 'reject', this)" class="flex justify-center items-center gap-2 w-full appearance-none border border-[#e5e7eb] bg-[#F56C6C] text-white rounded-full px-4 py-1.5 cursor-pointer transition-all duration-300" aria-expanded="false">--}}
{{--                                <span>Reject</span>--}}
{{--                                <svg fill="#ffffff" width="20px" height="20px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M697.4 759.2l61.8-61.8L573.8 512l185.4-185.4-61.8-61.8L512 450.2 326.6 264.8l-61.8 61.8L450.2 512 264.8 697.4l61.8 61.8L512 573.8z"></path></g></svg>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div class="relative w-full flex md:w-auto">--}}
{{--                            <button type="button" onclick="visitReportStatus({{$row->id}}, 'approved', this)" class="flex justify-center items-center gap-2 w-full appearance-none border border-[#e5e7eb] bg-[#67C23A] text-white rounded-full px-4 py-1.5 cursor-pointer transition-all duration-300" aria-expanded="false">--}}
{{--                                <span>Approve</span>--}}
{{--                                <svg viewBox="0 0 24 24" width="20px" role="img" xmlns="http://www.w3.org/2000/svg" aria-labelledby="okIconTitle" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" color="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title id="okIconTitle">Ok</title> <polyline points="4 13 9 18 20 7"></polyline> </g></svg>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            @endif
            @if($row->status->name == 'COMPLETED')
                <div class="flex flex-col md:flex-row items-center justify-end gap-4 mt-3">
                    <a href="{{ route('admin.visit.generate.pdf',$row->id) }}" target="_blank"
                       class="flex items-center justify-center space-x-2 px-3 py-2 sm:px-4 sm:py-2.5 bg-red-600 hover:bg-red-700 cursor-pointer text-white text-xs sm:text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3.9985 2C3.44749 2 3 2.44405 3 2.9918V21.0082C3 21.5447 3.44476 22 3.9934 22H20.0066C20.5551 22 21 21.5489 21 20.9925L20.9997 7L16 2H3.9985ZM10.5 7.5H12.5C12.5 9.98994 14.6436 12.6604 17.3162 13.5513L16.8586 15.49C13.7234 15.0421 10.4821 16.3804 7.5547 18.3321L6.3753 16.7191C7.46149 15.8502 8.50293 14.3757 9.27499 12.6534C10.0443 10.9373 10.5 9.07749 10.5 7.5ZM11.1 13.4716C11.3673 12.8752 11.6043 12.2563 11.8037 11.6285C12.2754 12.3531 12.8553 13.0182 13.5102 13.5953C12.5284 13.7711 11.5666 14.0596 10.6353 14.4276C10.8 14.1143 10.9551 13.7948 11.1 13.4716Z" />
                        </svg>
                        <span>{{ trans_message('download_report') }}</span>
                    </a>
                    <a href="{{ route('admin.visit.submissions',$row->report->report_uid) }}"
                       class="flex items-center justify-center space-x-2 px-3 py-2 sm:px-4 sm:py-2.5 bg-[#0073AF] hover:bg-[#0068A0] cursor-pointer text-white text-xs sm:text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span>{{ trans_message('view_submissions') }}</span>
                    </a>
{{--                    <div class="flex items-center gap-4 w-full md:w-auto">--}}
{{--                        <div class="relative w-full flex md:w-auto">--}}
{{--                            <button type="button" onclick="visitReportStatus({{$row->id}}, 'reject', this)" class="flex justify-center items-center gap-2 w-full appearance-none border border-[#e5e7eb] bg-[#F56C6C] text-white rounded-full px-4 py-1.5 cursor-pointer transition-all duration-300" aria-expanded="false">--}}
{{--                                <span>Reject</span>--}}
{{--                                <svg fill="#ffffff" width="20px" height="20px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M697.4 759.2l61.8-61.8L573.8 512l185.4-185.4-61.8-61.8L512 450.2 326.6 264.8l-61.8 61.8L450.2 512 264.8 697.4l61.8 61.8L512 573.8z"></path></g></svg>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div class="relative w-full flex md:w-auto">--}}
{{--                            <button type="button" onclick="visitReportStatus({{$row->id}}, 'approved', this)" class="flex justify-center items-center gap-2 w-full appearance-none border border-[#e5e7eb] bg-[#67C23A] text-white rounded-full px-4 py-1.5 cursor-pointer transition-all duration-300" aria-expanded="false">--}}
{{--                                <span>Approve</span>--}}
{{--                                <svg viewBox="0 0 24 24" width="20px" role="img" xmlns="http://www.w3.org/2000/svg" aria-labelledby="okIconTitle" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" color="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title id="okIconTitle">Ok</title> <polyline points="4 13 9 18 20 7"></polyline> </g></svg>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            @endif
            <div>
                <div class="flex items-center py-2 px-3 bg-[#F3F4F6] rounded-lg justify-between mt-3 gap-2">
                    <span class="text-sm font-medium text-gray-800 short_desc_1">{{ $row->description }}</span>
                    <button data-note="{{ $row->description }}"
                            class="visitNote rounded-full p-2 text-gray-500 hover:bg-gray-200 transition-all duration-300 cursor-pointer">
                        <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor">
                            <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@else
    <h4 class="font-medium text-[17px]">{{ trans_message('no_visits_found') }}
    </h4>
@endif
