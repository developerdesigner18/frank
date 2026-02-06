@extends('user.master')
@section('title', trans_message('contact_support'))
@push('navbar')
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">{{ trans_message('contact_support') }}</span>
    </div>
@endpush
@section('main')
<section class="pt-4 sm:pt-6">
                    <!-- Hero Section -->
                    <div class="text-center pt-4 pb-8 sm:pb-12 flex flex-col items-center justify-center">
                        <div class="inline-flex items-center justify-center size-[60px] bg-[#0073AF] rounded-full">
                            <svg class="size-[34px] text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
                            </svg>
                        </div>
                        <div class="pt-4">
                            <h1 class="text-xl font-bold text-gray-900 pb-0.5 capitalize">  {{ trans_message('contact_greeting') }}</h1>
                            <p class="text-gray-700 text-sm font-medium">{{ trans_message('contact_subtitle') }}</p>
                        </div>
                    </div>

                    <!-- Support Options Grid -->
                    <div class="">
                        <div class="grid grid-cols-1 sm:grid-cols-2 max-w-[767px] mx-auto gap-4 sm:gap-6">
                            <!-- Frequently Asked Questions -->
                            <div class="group">
                                <button
                                    class="group/btn relative w-full flex items-center justify-center gap-2 px-4 py-4 bg-[#0073AF] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl col-span-2">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
                                    </svg>
                                    <span class="text-sm sm:text-base lg:text-lg">Frequently Asked Questions</span>
                                </button>
                            </div>

                            <!-- Video Tutorials and Guides -->
                            <div class="group">
                                <button
                                    class="group/btn relative w-full flex items-center justify-center gap-2 px-4 py-4 bg-[#6B21A8] text-white font-medium rounded-xl text-sm transition-all duration-300 shadow-lg hover:shadow-xl col-span-2">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                    <span class="text-sm sm:text-base lg:text-lg">{{ trans_message('video_tutorials_guides') }}</span>
                                </button>
                            </div>

                            <!-- Send an Email -->
                            <div class="group">
                                <button
                                    class="group/btn flex items-center justify-center gap-2 px-4 w-full py-4 bg-white border border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition-all duration-300 shadow-sm hover:shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                    </svg>
                                    <span class="text-sm sm:text-base lg:text-lg">{{ trans_message('send_an_email') }}</span>
                                </button>
                            </div>

                            <!-- Chat on WhatsApp -->
                            <div class="group">
                                <button
                                    class="group/btn flex items-center justify-center gap-2 px-4 w-full py-4 bg-white border border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition-all duration-300 shadow-sm hover:shadow-md">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                    </svg>
                                    <span class="text-sm sm:text-base lg:text-lg">{{ trans_message('chat_on_whatsapp') }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Additional Help Section -->
                        <div class="mt-8 sm:mt-12">
                            <div class="p-6 sm:p-8">
                                <div class="text-center pb-10">
                                    <h3 class="text-xl font-bold text-gray-900 pb-0.5 capitalize">{{ trans_message('need_more_help') }}</h3>
                                    <p class="text-gray-700 text-sm font-medium">{{ trans_message('check_support_resources') }}</p>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                                    <!-- Documentation -->
                                    <div class="text-center group">
                                        <div
                                            class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <svg class="size-[24px] text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M11 7H13V17H11V7ZM15 11H17V17H15V11ZM7 13H9V17H7V13ZM15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-800 text-sm sm:text-base mb-1">{{ trans_message('documentation') }}
                                        </h4>
                                        <p class="text-gray-600 text-xs sm:text-sm">{{ trans_message('documentation_desc') }}
                                        </p>
                                    </div>

                                    <!-- Community -->
                                    <div class="text-center group">
                                        <div
                                            class="w-12 h-12 sm:w-14 sm:h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <svg class="size-[24px] text-green-600" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M21 21H3C2.44772 21 2 20.5523 2 20V12.4868C2 12.1978 2.12501 11.9229 2.34282 11.733L6 8.54435V4C6 3.44772 6.44772 3 7 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21ZM9 19H12V12.9416L8 9.45402L4 12.9416V19H7V15H9V19ZM14 19H20V5H8V7.12729C8.23444 7.12729 8.46888 7.20938 8.65718 7.37355L13.6572 11.733C13.875 11.9229 14 12.1978 14 12.4868V19ZM16 11H18V13H16V11ZM16 15H18V17H16V15ZM16 7H18V9H16V7ZM12 7H14V9H12V7Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-800 text-sm sm:text-base mb-1">{{ trans_message('community') }}</h4>
                                        <p class="text-gray-600 text-xs sm:text-sm">{{ trans_message('community_desc') }}</p>
                                    </div>

                                    <!-- Status -->
                                    <div class="text-center group">
                                        <div
                                            class="w-12 h-12 sm:w-14 sm:h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <svg class="size-[24px] text-orange-600" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M12 2L16.292 6.292L17.353 5.232L16.1207 3.99968L20 4L19.9997 7.87868L18.767 6.646L17.707 7.707L22 12L17.708 16.293L18.767 17.352L19.9997 16.1207L20 20L16.1207 19.9997L17.352 18.767L16.293 17.707L12 22L7.707 17.707L6.646 18.767L7.87868 19.9997L4 20L3.99968 16.1207L5.231 17.352L6.292 16.292L2 12L6.293 7.707L5.231 6.646L3.99968 7.87868L4 4L7.87868 3.99968L6.646 5.231L7.708 6.293L12 2ZM12 13.4128L9.12 16.292L12 19.1716L14.879 16.292L12 13.4128ZM7.707 9.121L4.82843 12L7.706 14.878L10.5858 11.9986L7.707 9.121ZM16.292 9.121L13.4149 11.9993L16.293 14.878L19.1716 12L16.292 9.121ZM12 4.82843L9.122 7.707L12.0007 10.5851L14.878 7.706L12 4.82843Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-800 text-sm sm:text-base mb-1">{{ trans_message('system_status') }}
                                        </h4>
                                        <p class="text-gray-600 text-xs sm:text-sm">{{ trans_message('system_status_desc') }}
                                        </p>
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
