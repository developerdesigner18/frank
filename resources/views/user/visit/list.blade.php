@if($resultData->all())
    @foreach($resultData as $key => $row)
        <div class="bg-white rounded-2xl p-5 shadow-[0_2px_15px_rgb(0,0,0,0.05)] border border-gray-100 flex flex-col gap-3 relative mb-4 transition-all hover:shadow-lg">
            <!-- Top Row: Logo & Date Range -->
            <div class="flex justify-between items-center w-full gap-4">
                <!-- Logo (Left) -->
                <div class="w-12 h-12 rounded-full border border-gray-200 bg-white shadow-sm flex items-center justify-center overflow-hidden shrink-0 p-1">
                    <!-- Use Branch Image -->
                    <img src="{{ $row->branch->image }}"
                         class="w-full h-full object-contain rounded-full"
                         onerror="this.src='{{ $row->branch->company->image ?? asset('assets/logo/logo.png') }}'"
                         alt="Branch Logo">
                </div>
                <!-- Date Range (Right) -->
                <div class="text-[11px] sm:text-xs text-black font-semibold tracking-wide text-right whitespace-nowrap">
                    {{ \Carbon\Carbon::parse($row->start_datetime)->locale('nl')->translatedFormat('d/m/y (D)') }} - {{ \Carbon\Carbon::parse($row->end_datetime)->locale('nl')->translatedFormat('d/m/y (D)') }}
                </div>
            </div>

            <!-- Title & Address -->
            <div class="-mt-1">
                <h3 class="text-base sm:text-lg font-bold text-gray-800 leading-tight">
                    {{ $row->branch->branch_name ?? 'Branch Name' }} - {{ date('M Y', strtotime($row->start_datetime)) }}
                </h3>

                <div class="mt-2 inline-flex items-center px-3 py-1.5 bg-gray-100 rounded-lg max-w-full">
                    <svg class="w-3.5 h-3.5 text-gray-500 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="text-xs sm:text-sm text-gray-600 truncate">
                        {{ $row->branch->address_1 ?? $row->branch->locality ?? 'Locatie niet eigen speciaal bier voorzien van een lekker hapje' }}
                        @if(isset($row->branch->postal_code) && $row->branch->postal_code), {{ $row->branch->postal_code }} @endif
                        @if(isset($row->branch->locality) && $row->branch->locality) {{ $row->branch->locality }} @endif
                     </span>
                </div>
            </div>
            <!-- Description / Note Box -->
            @if($row->description)
                <div data-note="{{ $row->description }}" class="visitNote cursor-pointer bg-[#FDF4FF] p-3.5 rounded-xl border border-pink-50 text-sm text-gray-600 relative flex justify-between items-start gap-2 hover:bg-[#fae8ff] transition-colors">
                    <p class="line-clamp-2 text-xs sm:text-sm text-gray-700 font-medium leading-relaxed pointer-events-none">{{ $row->description }}</p>
                    <div class="shrink-0 pt-0.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 4l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                    </div>
                </div>
            @endif

            <!-- Bottom Row: Financials + Action -->
            <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between mt-1 gap-3">
                <div class="flex flex-col gap-2.5 w-full sm:w-auto">
                    <!-- Fee Pill -->
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-[#EBF5FF] text-xs sm:text-sm font-bold w-fit shadow-sm gap-1">
                        <span class="text-[#0073AF]">{{ trans_message('fee') }} </span>
                        <span class="text-gray-800">{{ currency_icon() }} {{ number_format($row->price, 2) }}</span>
                    </span>
                    <!-- Expense Pill -->
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-[#EBF5FF] text-xs sm:text-sm font-bold w-fit shadow-sm gap-1">
                        <span class="text-[#0073AF]">{{ trans_message('expense_estimate') }}</span>
                         <span class="text-gray-800">
                             {{ currency_icon() }} {{ number_format($row->expense_estimation_min, 2) }} - {{ currency_icon() }} {{ number_format($row->expense_estimation_max, 2) }}
                         </span>
                    </span>
                </div>
                <!-- Request / Action Button -->
                <div class="w-full sm:w-auto sm:shrink-0">
                    @if($row->status->name == 'OPEN' && $row->interests->isEmpty())
                        <button onclick="requestVisit({{$row->id}},this)" class="group p-2.5 rounded-full hover:bg-red-50 transition-all active:scale-95 border border-transparent hover:border-red-100">
                            <!-- Heart Outline -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#0073AF] group-hover:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    @elseif(($row->status->name == 'SCHEDULED' || $row->status->name == 'IN_PROGRESS' || $row->status->name == 'ASSIGNED') && isset($page) && $page !== 'interested')
                        <!-- Open Questionnaire Action -->
                        @if($row->questionnaire_id)
                            <a href="{{ $row->unioqid? route('visit.survey',$row->unioqid):'javascript:void(0);' }}" class="text-[#0073AF] font-semibold text-sm flex items-center gap-1">
                                {{ trans_message('open_questionnaire') }}
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        @else
                            <span class="text-gray-400 font-semibold text-sm flex items-center gap-1 cursor-not-allowed" title="Questionnaire Unavailable">
                                {{ trans_message('open_questionnaire') }}
                                 <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                             </span>
                        @endif
                    @elseif(($row->status->name != 'OPEN' || !$row->interests->isEmpty()) && (!isset($page) || $page !== 'pending'))
                        <!-- Selected / Interested State (Filled Heart) -->
                        <div class="p-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="flex flex-col items-center justify-center py-10 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h4 class="font-medium text-lg text-gray-600">{{ trans_message('no_visits_found') }}</h4>
        <p class="text-gray-400 text-sm mt-1">Check back later for new opportunities.</p>
    </div>
@endif