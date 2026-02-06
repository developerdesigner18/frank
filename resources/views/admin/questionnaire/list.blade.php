@if($resultData->all())

    @foreach($resultData as $key => $row)
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
            <!-- Top Section -->
            <div class="p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Left Side - Title and ID -->
                    <div class="flex-1">
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2">{{ $row->name }}</h3>
                        <p class="text-sm text-gray-500">ID: {{ $row->id }}</p>
                    </div>

                    <!-- Right Side - Toggles and Actions -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <!-- Toggle Switches -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- Active Toggle -->
                            <div class="toggle-switch flex items-center">
                                <label class="relative gap-2 flex items-center cursor-pointer">
                                    <input type="checkbox" value="1" class="sr-only peer statusUpdate" data-id="{{ $row->id }}" {{ ($row->status->value=='ACTIVE')?'checked':'' }}>
                                    <span class="text-[10px] sm:text-xs font-semibold text-gray-700 peer-checked:hidden">Draft</span>
                                    <span class="text-[10px] sm:text-xs font-semibold text-gray-700 hidden peer-checked:block">active</span>
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0073AF]">
                                    </div>
                                </label>
                            </div>
{{--                 @dd($row->status);--}}
                            @if($row->is_published==1 AND $row->status->value=='ACTIVE')
                                <span class="inline-flex items-center px-3 py-1.5 leading-none rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    Published
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 leading-none rounded-full text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-200">
                                    Draft
                                </span>
                            @endif
                        </div>

                        <!-- Action Icons -->
                        <div class="flex items-center gap-2">
                            <!-- Settings Icon with notification dot -->
                            <a href="{{ $row->quid? route('admin.questionnaire.form',['quid' => $row->quid]):'javascript:void(0);' }}"
                                    class="cursor-pointer relative p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 15.5A3.5 3.5 0 0 1 8.5 12A3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5a3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97c0-.33-.03-.66-.07-1l2.11-1.63c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.31-.61-.22l-2.49 1c-.52-.39-1.06-.73-1.69-.98l-.37-2.65A.506.506 0 0 0 14 2h-4c-.25 0-.46.18-.5.42l-.37 2.65c-.63.25-1.17.59-1.69.98l-2.49-1c-.22-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64L4.57 11c-.04.34-.07.67-.07 1c0 .33.03.65.07.97l-2.11 1.66c-.19.15-.25.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1.01c.52.4 1.06.74 1.69.99l.37 2.65c.04.24.25.42.5.42h4c.25 0 .46-.18.5-.42l.37-2.65c.63-.26 1.17-.59 1.69-.99l2.49 1.01c.22.08.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.66Z" />
                                </svg>
                                <!-- Notification dot -->
                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-orange-500 rounded-full"></span>
                            </a>

                            <!-- View Icon -->
                            <a href="{{ $row->quid? route('admin.questionnaire.view',['quid' => $row->quid]):'javascript:void(0);' }}"
                               class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                </svg>
                            </a>

                            <!-- Copy Icon -->
                            <button onclick="duplicateQuestionnaire({{$row->id}},'{{$row->name}}',this);"
                                    class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z" />
                                </svg>
                            </button>

                            <!-- Delete Icon -->
                            <button onclick="removeQuestionnaire({{$row->id}},this);"
                                    class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section - Creation Date -->
            <div class="border-t border-gray-200 px-4 sm:px-6 py-3">
                <div class="text-center">
                    <span class="text-sm text-gray-500">Created: {{ date('d-m-Y H:i', strtotime($row->created_at)) }}</span>
                </div>
            </div>
        </div>
    @endforeach
@else
    <h4 class="font-medium text-[17px]">No Questionnaire Found!</h4>
@endif
