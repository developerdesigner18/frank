@extends('user.master')
@section('title','Dashboard')
@section('main')

             <section class="pt-4 sm:pt-6">
                    <!-- Settings Cards Grid -->
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Account Settings Card -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="p-4 sm:p-6">
                                <!-- Account Header -->
                                <h2 class="text-base leading-none font-semibold text-gray-800 pb-4">{{ trans_message('account') }}</h2>
                                <!-- Account Settings Items -->
                                <div class="space-y-1">
                                    <!-- Edit Profile -->
                                    <a href="{{ route('profile') }}"
                                        class="w-full flex items-center justify-between sm:py-4 sm:px-4 px-2 py-2 hover:bg-gray-50 rounded-lg transition-colors duration-200 group">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-gray-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 text-gray-600" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                                </svg>
                                            </div>
                                            <span class="text-sm sm:text-base lg:text-lg text-gray-700 font-medium">{{ trans_message('edit_profile') }}</span>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors duration-200"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8.59 16.59L13.17 12L8.59 7.41L10 6l6 6-6 6-1.41-1.41z" />
                                        </svg>
                                    </a>

                                    <!-- Language Selection -->
{{--                                    <div class="sm:py-4 sm:px-4 px-2 py-2">--}}
{{--                                        <div class="flex items-center justify-between">--}}
{{--                                            <div class="flex items-center gap-3">--}}
{{--                                                <div--}}
{{--                                                    class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">--}}
{{--                                                    <svg class="w-4 h-4 text-gray-600" fill="currentColor"--}}
{{--                                                        viewBox="0 0 24 24">--}}
{{--                                                        <path--}}
{{--                                                            d="M12.87 15.07l-2.54-2.51.03-.03c1.74-1.94 2.98-4.17 3.71-6.53H17V4h-7V2H8v2H1v1.99h11.17C11.5 7.92 10.44 9.75 9 11.35 8.07 10.32 7.3 9.19 6.69 8h-2c.73 1.63 1.73 3.17 2.98 4.56l-5.09 5.02L4 19l5-5 3.11 3.11.76-2.04zM18.5 10h-2L12 22h2l1.12-3h4.75L21 22h2l-4.5-12zm-2.62 7l1.62-4.33L19.12 17h-3.24z" />--}}
{{--                                                    </svg>--}}
{{--                                                </div>--}}
{{--                                                <span--}}
{{--                                                    class="text-sm sm:text-base lg:text-lg text-gray-700 font-medium">Language</span>--}}
{{--                                            </div>--}}

{{--                                            <!-- Language Toggle -->--}}
{{--                                            <div class="flex gap-2">--}}
{{--                                                <button--}}
{{--                                                    class="px-2 sm:px-4 sm:py-2 py-1.5 bg-[#0073AF] text-sm sm:text-base lg:text-lg text-white rounded-lg font-medium transition-colors"--}}
{{--                                                    onclick="selectLanguage('en')">--}}
{{--                                                    EN--}}
{{--                                                </button>--}}
{{--                                                <button--}}
{{--                                                    class="px-2 sm:px-4 sm:py-2 py-1.5 bg-gray-100 text-sm sm:text-base lg:text-lg text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors"--}}
{{--                                                    onclick="selectLanguage('nl')">--}}
{{--                                                    NL--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <!-- End language selection -->

                                </div>
                            </div>
                        </div>
                        <!-- Security Settings Card -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="p-4 sm:p-6">
                                <!-- Security Header -->
                                <h2 class="text-base leading-none font-semibold text-gray-800 pb-4">{{ trans_message('security') }}</h2>

                                <!-- Security Options -->
                                <div class="space-y-4">
                                    <a href="{{route('change-password')}}"
                                        class="w-full flex items-center justify-between sm:py-3 sm:px-4 px-2 py-2 hover:bg-gray-50 rounded-lg transition-colors duration-200 group">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-gray-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 text-gray-600" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                                                </svg>
                                            </div>
                                            <div class="text-left">
                                                <span
                                                    class="text-sm sm:text-base lg:text-lg text-gray-700 font-medium">{{ trans_message('change_password') }}</span>
                                                <p class="text-xs text-gray-500">{{ trans_message('last_changed', ['time' => '3 months ago']) }}</p>
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors duration-200"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8.59 16.59L13.17 12L8.59 7.41L10 6l6 6-6 6-1.41-1.41z" />
                                        </svg>
                                    </a>

                                    <!-- Two-Factor Authentication -->
{{--                                    <button--}}
{{--                                        class="w-full flex items-center justify-between sm:py-3 sm:px-4 px-2 py-2 hover:bg-gray-50 rounded-lg transition-colors duration-200 group">--}}
{{--                                        <div class="flex items-center gap-3">--}}
{{--                                            <div--}}
{{--                                                class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-gray-200 transition-colors duration-200">--}}
{{--                                                <svg class="w-4 h-4 text-gray-600" fill="currentColor"--}}
{{--                                                    viewBox="0 0 24 24">--}}
{{--                                                    <path--}}
{{--                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />--}}
{{--                                                </svg>--}}
{{--                                            </div>--}}
{{--                                            <div class="text-left">--}}
{{--                                                <span--}}
{{--                                                    class="text-sm sm:text-base lg:text-lg text-gray-700 font-medium">Two-Factor--}}
{{--                                                    Authentication</span>--}}
{{--                                                <p class="text-xs text-gray-500">Add an extra layer of security</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="flex items-center">--}}
{{--                                            <div class="w-10 h-6 bg-gray-200 rounded-full relative">--}}
{{--                                                <div--}}
{{--                                                    class="w-4 h-4 bg-white rounded-full absolute top-1 left-1 transition-transform duration-200">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </button>--}}

                                </div>
                            </div>
                        </div>

                        <!-- Security Settings Card -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="p-4 sm:p-6">
                                <!-- Security Header -->
                                <h2 class="text-base leading-none font-semibold text-gray-800 pb-4">{{ trans_message('language') }}</h2>

                                <!-- Language Selection -->
                                <div class="w-full flex flex-col gap-2">
                                    <label class="block text-sm font-medium text-gray-700">{{ trans_message('language') }}</label>
{{--                                    <div class="flex gap-2">--}}
{{--                                        <button type="button" class="cursor-pointer px-4 py-2 bg-[#0073AF] text-white rounded-lg font-medium transition-colors" onclick="selectLanguage('en')">--}}
{{--                                            EN--}}
{{--                                        </button>--}}
{{--                                        <button type="button" class="cursor-pointer px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors" onclick="selectLanguage('nl')">--}}
{{--                                            NL--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                    <div class="flex gap-2">--}}
{{--                                        <a href="{{ route('admin.lang.switch', 'en') }}"--}}
{{--                                           class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg border transition-all duration-200 text-center--}}
{{--                                              {{ get_current_locale() === 'en'--}}
{{--                                                  ? 'bg-[#0073AF] text-white border-[#0073AF] shadow-sm'--}}
{{--                                                  : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 hover:border-[#0073AF]' }}">--}}
{{--                                            🇬🇧 {{ trans_message('english') }}--}}
{{--                                        </a>--}}
{{--                                        <a href="{{ route('admin.lang.switch', 'nl') }}"--}}
{{--                                           class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg border transition-all duration-200 text-center--}}
{{--                                              {{ get_current_locale() === 'nl'--}}
{{--                                                  ? 'bg-[#0073AF] text-white border-[#0073AF] shadow-sm'--}}
{{--                                                  : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 hover:border-[#0073AF]' }}">--}}
{{--                                            🇳🇱 {{ trans_message('dutch') }}--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.lang.switch', 'en') }}"
                                           class="cursor-pointer px-4 py-2 rounded-lg font-medium transition-colors
       {{ get_current_locale() === 'en'
            ? 'bg-[#0073AF] text-white'
            : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                            EN
                                        </a>

                                        <a href="{{ route('admin.lang.switch', 'nl') }}"
                                           class="cursor-pointer px-4 py-2 rounded-lg font-medium transition-colcolors
       {{ get_current_locale() === 'nl'
            ? 'bg-[#0073AF] text-white'
            : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                            NL
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endsection
@section('script')
<script !src="">

</script>
@endsection
