@extends('admin.master')
@section('title','Questionnaires')
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('admin.questionnaire.index') }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>Questionnaires</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-500 navbar-name">{{ $questionnaire->name }}</span>
    </div>
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">Questionnaires</span>
    </div>
@endpush
@push('modal')
@endpush
@section('main')
    <section class="pt-4 sm:pt-6">
        <div class="w-full">
            <div class="flex gap-4 items-center justify-end mb-8 md:w-auto w-full">
                <div class="relative w-full flex md:w-auto">
                    <a href="{{ route('admin.questionnaire.form',['quid' => $questionnaire->quid]) }}"
                       class="btn-secondary flex gap-2 w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2.5 text-gray-700 cursor-pointer transition-all duration-300"
                       aria-expanded="false">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 15.5A3.5 3.5 0 0 1 8.5 12A3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5a3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97c0-.33-.03-.66-.07-1l2.11-1.63c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.31-.61-.22l-2.49 1c-.52-.39-1.06-.73-1.69-.98l-.37-2.65A.506.506 0 0 0 14 2h-4c-.25 0-.46.18-.5.42l-.37 2.65c-.63.25-1.17.59-1.69.98l-2.49-1c-.22-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64L4.57 11c-.04.34-.07.67-.07 1c0 .33.03.65.07.97l-2.11 1.66c-.19.15-.25.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1.01c.52.4 1.06.74 1.69.99l.37 2.65c.04.24.25.42.5.42h4c.25 0 .46-.18.5-.42l.37-2.65c.63-.26 1.17-.59 1.69-.99l2.49 1.01c.22.08.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.66Z"></path>
                        </svg>
                        <span>Exit to Builder</span>
                    </a>
                </div>
            </div>

            @if($payload['categories'] && count($payload['categories']) > 0)
                @foreach($payload['categories'] as $cat_k => $category)
                    <!-- Niho! View 1 -->
                    <div class="view-content {{ $cat_k>0?'hidden':'' }}" id="niho-view-{{$cat_k}}">
                        <div class="text-center mb-6 relative">
                            <div class="flex items-center justify-center gap-2 mb-4">
                                @if($cat_k>0)
                                    <!-- Arrow prevView -->
                                    <button onclick="showPrevView()"
                                            class="cursor-pointer absolute left-0 bg-gray-100 hover:bg-gray-200 rounded-lg p-2 transition-colors">
                                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                  d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                @endif
                                <span class="text-2xl font-semibold text-gray-800">
                                    {!! (isset($category['imageUrl']) && $category['imageUrl']) ? '<img src="'.$category['imageUrl'].'" alt="'.$category['name'].'" class="size-[20px] object-contain" />' : '' !!}
                                    {{ $category['name'] }}
                                </span>
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                @if((count($payload['categories'])-1)!==$cat_k)
                                    <!-- Arrow next -->
                                    <button onclick="showNextView()"
                                            class="cursor-pointer absolute right-0 bg-gray-100 hover:bg-gray-200 rounded-lg p-2 transition-colors">
                                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                            <div class="w-full h-1 bg-green-400 rounded-full mb-6"></div>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            @if(isset($category['questions']))
                                @foreach($category['questions'] as $question)
                                    @php
                                        // Get all option texts
                                        $allOptionTexts = array_map(function($opt) {
                                            return $opt['text'];
                                        }, $question['options']??[]);

                                        // Get all option scores
                                        $allOptionScores = array_map(function($opt) {
                                            return $opt['score'];
                                        }, $question['options']??[]);

                                        $min = $allOptionScores? min($allOptionScores):0;
                                        $max = $allOptionScores? max($allOptionScores):0;
                                        $step = count($allOptionScores) > 1 ? ($max - $min) / (count($allOptionScores) - 1) : 1;
                                    @endphp
                                    <div class="w-full p-[20px] border border-gray-300 rounded-lg">
                                        <span class="font-semibold">{{ $question['title'] }}</span>
                                        @if ($question['type']==='RADIO' || $question['type']==='SELECT')
                                            <div class="w-full mt-4 flex justify-center gap-3">
                                                @if($allOptionTexts)
                                                    @foreach($allOptionTexts as $optKey => $optVal)
                                                        <div>
                                                            <input type="radio"
                                                                   id="opt-{{ $question['id'] }}-{{ $optKey }}"
                                                                   name="opt-{{ $question['id'] }}"
                                                                   class="hidden peer">
                                                            <label for="opt-{{ $question['id'] }}-{{ $optKey }}" class="inline-block cursor-pointer transition-all duration-200 hover:scale-105 peer-checked:ring-4 peer-checked:ring-blue-500 peer-checked:scale-110 rounded-full">
                                                                @if($question['type'] === 'RADIO')
                                                                    <img src="{{ asset('assets/emojis/glossy') }}/{{ ['00.png', '01.png'][$optKey] ?? '00.png' }}" alt="{{ $optVal??'' }}" class="w-12 h-12 object-contain rounded-full">
                                                                @else
                                                                    {{ $optVal??'' }}
                                                                @endif
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                        @if ($question['type']==='SLIDER')
                                            <div class="mt-4">
                                                <!-- Score Display -->
                                                <!-- <div class="text-center mb-4">
                                                    <span class="d-none inline-block bg-gray-100 border border-gray-300 px-3 py-1 rounded-full text-sm font-medium text-gray-700 slider-score-display-{{ $question['id'] }}">
                                                        Score: {{ $min }}
                                                    </span>
                                                </div> -->

                                                <!-- Emoji Radio Buttons Preview -->
                                                <div class="flex justify-center items-center gap-3 flex-wrap">
                                                    @foreach($allOptionTexts as $index => $emoji)
                                                        @php
                                                            $score = $allOptionScores[$index];
                                                        @endphp
                                                        <div class="flex flex-col items-center">
                                                            <!-- Hidden radio input -->
                                                            <input type="radio"
                                                                   id="slider-opt-{{ $question['id'] }}-{{ $index }}"
                                                                   name="opt-slider-{{ $question['id'] }}"
                                                                   value="{{ $score }}"
                                                                   class="hidden emoji-radio-preview emoji-radio-{{ $question['id'] }}"
                                                                   data-question-id="{{ $question['id'] }}"
                                                                   data-score="{{ $score }}">
                                                            
                                                            <!-- Emoji button label -->
                                                            <label for="slider-opt-{{ $question['id'] }}-{{ $index }}"
                                                                   class="cursor-pointer emoji-btn-{{ $question['id'] }} transition-all duration-200 hover:scale-105 rounded-full">
                                                                <img src="{{ asset('assets/emojis/glossy') }}/{{ ['00.png', '04.png', '03.png', '02.png', '01.png'][$index] ?? '00.png' }}" alt="{{ $emoji }}" class="w-12 h-12 object-contain rounded-full">
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        @if ($question['type']==='AMOUNT')
                                            <div class="relative mt-4">
                                                <input type="text" id="hs-leading-icon"
                                                       class="block border border-gray-200 disabled:opacity-50 disabled:pointer-events-none focus:border-blue-500 focus:outline-none focus:ring-blue-500 focus:z-10 ps-11 px-4 py-2.5 rounded-lg sm:py-3 sm:text-sm w-full"
                                                       placeholder="0">
                                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                    {{ currency_icon() }}
                                                </div>
                                            </div>
                                            <div class="image-container mt-3">
                                                <!-- Remove button -->
                                                <button type="button"
                                                        class="absolute top-1 right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center hidden"
                                                        id="removeImageBtn">&times;
                                                </button>
                                                <label class="flex items-center gap-4 mb-3 cursor-pointer">
                                                    <div class="image-preview size-[100px] bg-gray-100 border flex items-center justify-center border-dashed border-gray-300 rounded-lg overflow-hidden relative">
                                                        <svg class="size-[24px] text-gray-400"
                                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                             fill="currentColor">
                                                            <path d="M4 5V19H20V7H11.5858L9.58579 5H4ZM12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM10 10.5C10 11.3284 9.32843 12 8.5 12C7.67157 12 7 11.3284 7 10.5C7 9.67157 7.67157 9 8.5 9C9.32843 9 10 9.67157 10 10.5ZM18 17L14 11L7 17H18Z"></path>
                                                        </svg>
                                                        <img class="absolute inset-0 w-full h-full object-cover hidden"
                                                             alt="preview">
                                                    </div>
                                                    <input type="file" accept="image/*" class="hidden question_image">
                                                </label>
                                            </div>
                                        @endif
                                        @if ($question['type']==='TEXT')
                                            <div class="mt-4">
                                                <input type="text" placeholder="Enter Text"
                                                       class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>
                                        @endif
                                        @if ($question['type']==='COMMENT')
                                            <div class="mt-4">
                                                <textarea rows="3" placeholder="Enter Comment"
                                                          class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                            @if((count($payload['categories'])-1)===$cat_k)
                                <div class="w-full p-[20px] border border-gray-300 rounded-lg mt-8 mb-3">
                                    <h2 class="text-xl font-semibold text-gray-800 text-center mb-6">Visits
                                        Conducted</h2>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Started</label>
                                            <div class="cursor-no-drop bg-gray-100 border border-gray-200 rounded-lg p-3 flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                          clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-gray-500">Started</span>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Completed</label>
                                            <div class="cursor-no-drop bg-gray-100 border border-gray-200 rounded-lg p-3 flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                          clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-gray-500">Completed</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="flex {{ $cat_k==0?'justify-end':'justify-between' }}">
                                @if($cat_k>0)
                                    <button onclick="showPrevView()"
                                            class="cursor-pointer bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-medium transition-colors">
                                        Previous
                                    </button>
                                @endif
                                @if((count($payload['categories'])-1)!==$cat_k)
                                    <button onclick="showNextView()"
                                            class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                        Next
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
@endsection
@section('script')
    <script>
        const views = document.querySelectorAll('.view-content');
        let currentView = 0;

        function scrollCurrentViewToTop() {
            // Scroll to the current view element
            const activeView = views[currentView];
            if (activeView) {
                // Scroll the view into the viewport at the top
                activeView.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        function showNextView() {
            if (currentView < views.length - 1) {
                views[currentView].classList.add('hidden');
                currentView++;
                views[currentView].classList.remove('hidden');

                scrollCurrentViewToTop();
            }
        }

        function showPrevView() {
            if (currentView > 0) {
                views[currentView].classList.add('hidden');
                currentView--;
                views[currentView].classList.remove('hidden');

                scrollCurrentViewToTop();
            }
        }

        setTimeout(() => {
            $('.slider-range').on('input', function () {
                $(this).closest('div').find('.slider-value').text(this.value);
            });

            // Emoji radio button click handler for preview
            $('.emoji-radio-preview').on('change', function() {
                const questionId = $(this).data('question-id');
                const score = $(this).data('score');
                
                // Update score display
                $(`.slider-score-display-${questionId}`).text(`Score: ${score}`);
                
                // Update visual styling - remove selection from all buttons
                $(`.emoji-btn-${questionId}`).removeClass('bg-blue-100 ring-4 ring-blue-500 scale-110').addClass('bg-gray-100');
                
                // Add selection to clicked button
                $(this).next('label').removeClass('bg-gray-100').addClass('bg-blue-100 ring-4 ring-blue-500 scale-110');
            });
        }, 10);


        $(document).delegate('.question_image', 'change', function (e) {
            const file = e.target.files[0];
            const input = this; // reference to current input element
            const container = $(input).closest('.image-container');
            const previewDiv = container.find('.image-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (ev) {
                    previewDiv.html(`
                        <img src="${ev.target.result}" alt="Preview" class="size-[100px] object-cover rounded-lg">
                        <button type="button" class="remove-image-btn absolute top-1 right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">&times;</button>
                    `);
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove image button functionality
        $(document).delegate('.remove-image-btn', 'click', function (e) {
            e.stopPropagation(); // prevent triggering file input
            const container = $(this).closest('.image-container');
            const input = container.find('.question_image');

            container.find('.image-preview').html(`
                <svg class="size-[24px] text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4 5V19H20V7H11.5858L9.58579 5H4ZM12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM10 10.5C10 11.3284 9.32843 12 8.5 12C7.67157 12 7 11.3284 7 10.5C7 9.67157 7.67157 9 8.5 9C9.32843 9 10 9.67157 10 10.5ZM18 17L14 11L7 17H18Z"></path>
                </svg>
            `);

            input.val(''); // reset file input
        });


    </script>
@endsection
