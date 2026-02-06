@extends('user.master')
@section('title', trans_message('dashboard'))

@section('main')
    <section class="pt-4 sm:pt-6">
        <!-- Activity Timeline -->
        <div class="max-w-4xl mx-auto">
            <!-- Today Section -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-3 h-3 bg-blue-600 rounded-full"></div>
                    <h2 class="text-xl font-semibold text-gray-800">{{ trans_message('today') }}</h2>
                </div>

                <!-- No Activities Today -->
                <div class="bg-gray-50 rounded-2xl p-8 text-center">
                    <div
                        class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                    </div>
                    <p class="text-gray-600 font-medium">{{ trans_message('no_activities_today') }}</p>
                </div>
            </div>

            <!-- Last Week Section -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                    <h2 class="text-xl font-semibold text-gray-800">{{ trans_message('last_week') }}</h2>
                </div>

                <!-- Activity Timeline -->
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                    <!-- Activity Entries -->
                    <div class="space-y-6">
                        <!-- Activity 1 - Login -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12H4v-2h16v2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">{{ trans_message('logged_in') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Sep 29 2025, 09:39:53</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 2 - Login -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12H4v-2h16v2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">{{ trans_message('logged_in') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Aug 22 2025, 17:28:32</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 3 - Logout -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">{{ trans_message('logged_out') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Aug 22 2025, 16:37:40</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 4 - Login -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12H4v-2h16v2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">{{ trans_message('logged_in') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Aug 22 2025, 16:26:46</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 5 - Login -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12H4v-2h16v2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">{{ trans_message('logged_in') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Aug 06 2025, 16:18:19</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 6 - Login -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12H4v-2h16v2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">{{ trans_message('logged_in') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Jul 25 2025, 09:39:11</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 7 - Login -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12H4v-2h16v2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">{{ trans_message('logged_in') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Jul 19 2025, 10:00:19</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 8 - Completed Visit -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">    {{ trans_message('completed_visit') }} Sligro

                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">Jul 08 2025, 15:04:06</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 9 - Completed Visit -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">{{ trans_message('completed_visit') }} Sligro
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">Jun 25 2025, 10:25:45</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 10 - Completed Visit -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">{{ trans_message('completed_visit') }} DDS Test</p>
                                    <p class="text-sm text-gray-500 mt-1">Jun 25 2025, 10:23:23</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 11 - Login -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12H4v-2h16v2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">{{ trans_message('logged_in') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Jun 24 2025, 11:14:31</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 12 - Completed Visit -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium"> {{ trans_message('completed_visit') }} DDS Test</p>
                                    <p class="text-sm text-gray-500 mt-1">Jun 24 2025, 10:27:46</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 13 - Login -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12H4v-2h16v2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">{{ trans_message('logged_in') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Jun 24 2025, 10:15:36</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 14 - Logout -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center relative z-10">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                                    <p class="text-gray-800 font-medium">{{ trans_message('logged_out') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Jun 05 2025, 18:02:44</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-8">
                <button
                    class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors duration-200">
                    {{ trans_message('load_more_activities') }}
                </button>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script !src="">

    </script>
@endsection
