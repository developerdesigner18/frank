@extends('admin.master')
@section('title','Visit Form')
@push('navbar')
    <div class="pt-6 flex lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">Visit Form</span>
    </div>
@endpush
@push('modal')
@endpush
@section('main')
    <section class="pt-4 sm:pt-6">

        <!-- Header Section -->
        <div
                class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200 p-4 mb-6 shadow-sm">
            <!-- Title with Enhanced Styling -->
            <div class="text-center mb-4">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    {{--                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">--}}
                    {{--                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />--}}
                    {{--                    </svg>--}}
                    <img src="{{ $visit->branch->image }}" class="h-[100%] rounded-full">
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $visit->branch->branch_name }}</h1>
                <p class="text-gray-600 text-lg">Questionnaire Response Form</p>
            </div>

            <!-- Enhanced Status Cards -->
            <div class="flex flex-wrap items-center justify-center gap-4 mb-4">
                <div
                        class="flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm text-gray-700 rounded-full text-sm font-medium shadow-sm">
                    <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                    {{ $visit->questionnaire->name }}
                </div>
                @if($visit->published == 1)
                    <div class="flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-medium shadow-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        Active
                    </div>
                @else
                    <div class="flex items-center gap-2 px-4 py-2 bg-red-100 text-red-700 rounded-full text-sm font-medium shadow-sm">
                        <svg class="w-3 h-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g id="inactive">
                                <path d="M13.6,23.9c-7.8,1-14.5-5.6-13.5-13.5c0.7-5.3,5-9.7,10.3-10.3c7.8-1,14.5,5.6,13.5,13.5C23.2,18.9,18.9,23.2,13.6,23.9z M13.7,2.1C6.9,1,1,6.9,2.1,13.7c0.7,4.1,4,7.5,8.2,8.2C17.1,23,23,17.1,21.9,10.3C21.2,6.2,17.8,2.8,13.7,2.1z"/>
                                <polyline points="5.6,4.2 19.8,18.3 18.4,19.8 4.2,5.6"/>
                            </g>
                        </svg>
                        Inactive
                    </div>
                @endif
                @if($visit->status->name !== 'PENDING' && $visit->status->name !== 'COMPLETED')
                    <div class="flex items-center gap-2 px-2 py-2 bg-orange-100 text-orange-700 rounded-full text-sm font-medium shadow-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                        {{--                        In Progress--}}
                    </div>
                @endif
            </div>

            <!-- Enhanced Breadcrumb -->
            <div class="text-center">
                <div
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/60 backdrop-blur-sm rounded-lg text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                    {{ $visit->branch->branch_name }}, {{ $visit->branch->address_1 }}
                    , {{ $visit->branch->postal_code }} {{ $visit->branch->locality }}
                </div>
            </div>
        </div>

        <!-- Progress Indicator -->
        <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-base font-semibold text-gray-800">Form Progress</h2>
                <span class="text-sm font-medium text-blue-600">2 of 3 questions completed</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-300"
                     style="width: 67%"></div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="space-y-6">
            <!-- Category Section -->
            <div
                    class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl border border-orange-200 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="size-[24px] text-orange-600" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path
                                    d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 9.5C12.8284 9.5 13.5 8.82843 13.5 8C13.5 7.17157 12.8284 6.5 12 6.5C11.1716 6.5 10.5 7.17157 10.5 8C10.5 8.82843 11.1716 9.5 12 9.5ZM14 15H13V10.5H10V12.5H11V15H10V17H14V15Z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base leading-none font-semibold text-gray-800">test category</h2>
                        <p class="text-sm text-gray-500">Please answer the following questions</p>
                    </div>
                </div>
            </div>

            <!-- Radio Question Card -->
            <div
                    class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start gap-4 mb-6">
                    <div class="flex-1">
                        <h3 class="text-base leading-none font-semibold text-gray-800">test radio Question
                        </h3>
                        <p class="text-sm text-gray-500">Select the most appropriate option from the choices
                            below</p>
                    </div>
                </div>

                <!-- Enhanced Radio Options -->
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                    <label
                            class="group relative flex items-center py-2 px-3 border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200">
                        <input type="radio" name="radioQuestion" value="first" class="sr-only peer">
                        <div
                                class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center peer-checked:border-[#0073AF] peer-checked:bg-[#0073AF] group-hover:border-[#0073AF] transition-all duration-200">
                            <div
                                    class="w-2 h-2 bg-white rounded-full opacity-100 transition-opacity duration-200">
                            </div>
                        </div>
                        <span
                                class="text-gray-700 font-medium group-hover:text-[#0073AF] transition-colors duration-200">first</span>
                    </label>

                    <label
                            class="group relative flex items-center py-2 px-3 border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200">
                        <input type="radio" name="radioQuestion" value="second" class="sr-only peer">
                        <div
                                class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center peer-checked:border-[#0073AF] peer-checked:bg-[#0073AF] group-hover:border-[#0073AF] transition-all duration-200">
                            <div
                                    class="w-2 h-2 bg-white rounded-full opacity-100 transition-opacity duration-200">
                            </div>
                        </div>
                        <span
                                class="text-gray-700 font-medium group-hover:text-[#0073AF] transition-colors duration-200">second</span>
                    </label>

                    <label
                            class="group relative flex items-center py-2 px-3 border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200">
                        <input type="radio" name="radioQuestion" value="third" class="sr-only peer">
                        <div
                                class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center peer-checked:border-[#0073AF] peer-checked:bg-[#0073AF] group-hover:border-[#0073AF] transition-all duration-200">
                            <div
                                    class="w-2 h-2 bg-white rounded-full opacity-100 transition-opacity duration-200">
                            </div>
                        </div>
                        <span
                                class="text-gray-700 font-medium group-hover:text-[#0073AF] transition-colors duration-200">third</span>
                    </label>

                    <label
                            class="group relative flex items-center py-2 px-3 border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200">
                        <input type="radio" name="radioQuestion" value="fourth" class="sr-only peer">
                        <div
                                class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center peer-checked:border-[#0073AF] peer-checked:bg-[#0073AF] group-hover:border-[#0073AF] transition-all duration-200">
                            <div
                                    class="w-2 h-2 bg-white rounded-full opacity-100 transition-opacity duration-200">
                            </div>
                        </div>
                        <span
                                class="text-gray-700 font-medium group-hover:text-[#0073AF] transition-colors duration-200">fourth</span>
                    </label>

                    <label
                            class="group relative flex items-center py-2 px-3 border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200">
                        <input type="radio" name="radioQuestion" value="fifth" class="sr-only peer">
                        <div
                                class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center peer-checked:border-[#0073AF] peer-checked:bg-[#0073AF] group-hover:border-[#0073AF] transition-all duration-200">
                            <div
                                    class="w-2 h-2 bg-white rounded-full opacity-100 transition-opacity duration-200">
                            </div>
                        </div>
                        <span
                                class="text-gray-700 font-medium group-hover:text-[#0073AF] transition-colors duration-200">fifth</span>
                    </label>
                </div>
            </div>

            <!-- Slider Question Card -->
            <div
                    class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start gap-4 mb-6">
                    <div class="flex-1">
                        <h3 class="text-base leading-none font-semibold text-gray-800"">test slider Question
                        </h3>
                        <p class=" text-sm text-gray-500">Use the slider to indicate your preference level
                        </p>
                    </div>
                </div>

                <!-- Enhanced Slider Container -->
                <div class="relative px-4">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-600">zero</span>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-[#0073AF]" id="sliderValue">0</div>
                            <div class="text-xs text-gray-500">Current Value</div>
                        </div>
                        <span class="text-sm font-medium text-gray-600">100</span>
                    </div>

                    <div class="relative">
                        <input type="range" min="0" max="100" value="0" id="slider"
                               class="w-full h-3 bg-gradient-to-r from-gray-200 to-gray-300 rounded-lg appearance-none cursor-pointer slider">
                    </div>

                    <!-- Value indicators -->
                    <div class="flex justify-between mt-2 text-xs text-gray-400">
                        <span>0%</span>
                        <span>25%</span>
                        <span>50%</span>
                        <span>75%</span>
                        <span>100%</span>
                    </div>
                </div>
            </div>

            <!-- Visits Conducted Card -->
            <div
                    class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-base leading-none font-semibold text-gray-800">Visits Conducted</h3>
                        <p class="text-sm text-gray-500">Current status of your visits</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Started Date/Time Input -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">

                                <div>
                                    <h4 class="text-base leading-none font-semibold text-gray-800">Started
                                    </h4>
                                    <p class="text-sm text-gray-500">When did the visit begin?</p>
                                </div>
                            </div>
                            <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                        </div>

                        <div class="relative">
                            <div
                                    class="flex items-center gap-3 p-4 border border-gray-300 rounded-lg bg-gray-50 focus-within:border-blue-500 focus-within:bg-white transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                <input type="datetime-local"
                                       class="flex-1 bg-transparent text-gray-700 font-medium focus:outline-none"
                                       value="2025-09-15T00:00" id="startedDateTime">
                            </div>
                        </div>
                    </div>

                    <!-- Completed Date/Time Input -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">

                                <div>
                                    <h4 class="text-base leading-none font-semibold text-gray-800">Completed
                                    </h4>
                                    <p class="text-sm text-gray-500">When was the visit finished?</p>
                                </div>
                            </div>
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>

                        <div class="relative">
                            <div
                                    class="flex items-center gap-3 p-4 border border-gray-300 rounded-lg bg-gray-50 focus-within:border-green-500 focus-within:bg-white transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                <input type="datetime-local"
                                       class="flex-1 bg-transparent text-gray-700 font-medium focus:outline-none"
                                       value="2025-09-30T00:00" id="completedDateTime">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm mt-8">
            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <span>All required fields must be completed</span>
                </div>
                <div class="flex gap-3">
                    <button type="button"
                            class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Save Draft
                    </button>
                    <button type="button"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg hover:shadow-xl">
                        Submit Response
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        // Slider functionality
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.getElementById('slider');
            const sliderValue = document.getElementById('sliderValue');

            if (slider && sliderValue) {
                slider.addEventListener('input', function () {
                    sliderValue.textContent = this.value;
                });
            }

            // Radio button selection feedback
            const radioButtons = document.querySelectorAll('input[name="radioQuestion"]');
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function () {
                    // Remove previous selections
                    document.querySelectorAll('label[for*="radioQuestion"]').forEach(label => {
                        label.classList.remove('ring-1', 'ring-[#0073AF]', 'bg-[#0073AF]/5');
                    });

                    // Add selection styling to current label
                    if (this.checked) {
                        const label = this.closest('label');
                        label.classList.add('ring-1', 'ring-[#0073AF]', 'bg-[#0073AF]/5');
                    }
                });
            });

            // DateTime input functionality
            const startedDateTime = document.getElementById('startedDateTime');
            const completedDateTime = document.getElementById('completedDateTime');

            if (startedDateTime && completedDateTime) {
                // Set default values
                const today = new Date();
                const futureDate = new Date(today.getTime() + (15 * 24 * 60 * 60 * 1000)); // 15 days from now

                startedDateTime.value = today.toISOString().slice(0, 16);
                completedDateTime.value = futureDate.toISOString().slice(0, 16);

                // Add change event listeners
                startedDateTime.addEventListener('change', function () {
                    const startDate = new Date(this.value);
                    const endDate = new Date(completedDateTime.value);

                    if (startDate >= endDate) {
                        // If start date is after or equal to end date, set end date to start date + 1 day
                        const newEndDate = new Date(startDate.getTime() + (24 * 60 * 60 * 1000));
                        completedDateTime.value = newEndDate.toISOString().slice(0, 16);
                    }
                });

                completedDateTime.addEventListener('change', function () {
                    const startDate = new Date(startedDateTime.value);
                    const endDate = new Date(this.value);

                    if (endDate <= startDate) {
                        alert('Completed date must be after the started date.');
                        this.value = new Date(startDate.getTime() + (24 * 60 * 60 * 1000)).toISOString().slice(0, 16);
                    }
                });
            }

            // Form validation
            const submitButton = document.querySelector('button[type="button"]:last-child');
            if (submitButton) {
                submitButton.addEventListener('click', function () {
                    const radioSelected = document.querySelector('input[name="radioQuestion"]:checked');
                    const sliderValue = document.getElementById('slider').value;
                    const startedValue = document.getElementById('startedDateTime').value;
                    const completedValue = document.getElementById('completedDateTime').value;

                    if (!radioSelected) {
                        alert('Please select an option for the radio question.');
                        return;
                    }

                    if (sliderValue === '0') {
                        alert('Please adjust the slider to indicate your preference.');
                        return;
                    }

                    if (!startedValue || !completedValue) {
                        alert('Please select both start and completion dates.');
                        return;
                    }

                    const startDate = new Date(startedValue);
                    const endDate = new Date(completedValue);

                    if (endDate <= startDate) {
                        alert('Completion date must be after the start date.');
                        return;
                    }

                    // Form is valid, show success message
                    alert('Form submitted successfully!');
                });
            }
        });
    </script>
@endsection
