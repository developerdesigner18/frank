<header class="el-header pb-4 lg:pb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button type="button" class="toggle-btn size-[24px] cursor-pointer">
                <svg class="size-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     fill="currentColor">
                    <path d="M3 4H21V6H3V4ZM3 11H21V13H3V11ZM3 18H21V20H3V18Z"></path>
                </svg>
            </button>
            <span class="text-3xl font-semibold text-gray-800 hidden lg:flex capitalize">@yield('title')</span>
        </div>
        <div class="flex items-center gap-2">
{{--            <div class="flex relative hidden md:flex">--}}
{{--                <input type="text"--}}
{{--                       class="pl-10 pr-4 py-2 border border-[#e5e7eb] rounded-full w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"--}}
{{--                       placeholder="Search">--}}
{{--                <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 size-[20px]"--}}
{{--                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">--}}
{{--                    <path--}}
{{--                            d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z">--}}
{{--                    </path>--}}
{{--                </svg>--}}
{{--            </div>--}}
{{--            <a href="javascript:void(0);"--}}
{{--               class="size-[46px] rounded-full bg-gray-100 flex items-center justify-center rounded-full hover:bg-gray-200 cursor-pointer transition-all duration-300">--}}
{{--                <svg class="size-[20px] text-gray-600" xmlns="http://www.w3.org/2000/svg"--}}
{{--                     viewBox="0 0 24 24" fill="currentColor">--}}
{{--                    <path d="M20 17H22V19H2V17H4V10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10V17ZM9 21H15V23H9V21Z">--}}
{{--                    </path>--}}
{{--                </svg>--}}
{{--            </a>--}}
            <div class="relative">
                <button popovertarget="desktop-menu-user"
                        class="flex items-center p-2 rounded-full bg-gray-100 gap-2 cursor-pointer">
                    <div class="size-[30px] rounded-full border-solid overflow-hidden border-gray-100 border">
                        <img src="{{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->profile_img }}" alt="" class="account_image h-full">
                    </div>
                    <p class="text-sm font-medium text-gray-700 account_name text-nowrap">{{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->name }}</p>
                    <svg class="size-[16px] text-gray-500" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                        </path>
                    </svg>
                </button>
                <el-popover id="desktop-menu-user" anchor="bottom-end" popover
                            class="overflow-visible bg-white w-[200px] shadow-[0px_0px_12px_#0000001f] mt-2 p-4 border border-[#ebeef5] rounded-[20px] transition open:flex data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in">
                    <div class="flex flex-col w-full gap-2">
                        <div class="flex flex-col justify-center">
                            <p class="text-[14px] font-semibold text-[rgb(96,98,102)] text-center account_name">
                                {{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->name }}
                            </p>
                            <p class="text-xs text-[#606266] pb-2 text-center">{{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->email }}</p>
                            <span class="px-[11px] text-[#409eff] bg-[#ecf5ff] border border-[#d9ecff] h-[32px] text-[12px] rounded-[4px] font-medium items-center flex  m-auto">
                                        <span class="el-tag__content"> Admin</span>
                                    </span>

                            <div class=" pt-3 flex flex-col gap-2">
                                <a href="{{ route('admin.settings') }}" type="button"
                                   class="btn-secondary py-2.5 flex justify-center items-center rounded-full border text-[14px] font-medium !w-full transition-all duration-300">
                                    <svg class="size-[14px] mr-2" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M5.33409 4.54491C6.3494 3.63637 7.55145 2.9322 8.87555 2.49707C9.60856 3.4128 10.7358 3.99928 12 3.99928C13.2642 3.99928 14.3914 3.4128 15.1245 2.49707C16.4486 2.9322 17.6506 3.63637 18.6659 4.54491C18.2405 5.637 18.2966 6.90531 18.9282 7.99928C19.5602 9.09388 20.6314 9.77679 21.7906 9.95392C21.9279 10.6142 22 11.2983 22 11.9993C22 12.7002 21.9279 13.3844 21.7906 14.0446C20.6314 14.2218 19.5602 14.9047 18.9282 15.9993C18.2966 17.0932 18.2405 18.3616 18.6659 19.4536C17.6506 20.3622 16.4486 21.0664 15.1245 21.5015C14.3914 20.5858 13.2642 19.9993 12 19.9993C10.7358 19.9993 9.60856 20.5858 8.87555 21.5015C7.55145 21.0664 6.3494 20.3622 5.33409 19.4536C5.75952 18.3616 5.7034 17.0932 5.0718 15.9993C4.43983 14.9047 3.36862 14.2218 2.20935 14.0446C2.07212 13.3844 2 12.7002 2 11.9993C2 11.2983 2.07212 10.6142 2.20935 9.95392C3.36862 9.77679 4.43983 9.09388 5.0718 7.99928C5.7034 6.90531 5.75952 5.637 5.33409 4.54491ZM13.5 14.5974C14.9349 13.7689 15.4265 11.9342 14.5981 10.4993C13.7696 9.0644 11.9349 8.57277 10.5 9.4012C9.06512 10.2296 8.5735 12.0644 9.40192 13.4993C10.2304 14.9342 12.0651 15.4258 13.5 14.5974Z">
                                        </path>
                                    </svg>
                                    <span class=""> Settings</span>
                                </a>
                                <a href="{{route('admin.logout')}}"
                                        class="btn-primary py-2.5 flex justify-center items-center rounded-full border text-[14px] font-medium !w-full transition-all duration-300">
                                    <svg class="size-[14px] mr-2" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                                d="M5 22C4.44772 22 4 21.5523 4 21V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V6H18V4H6V20H18V18H20V21C20 21.5523 19.5523 22 19 22H5ZM18 16V13H11V11H18V8L23 12L18 16Z">
                                        </path>
                                    </svg>
                                    <span class=""> Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </el-popover>
            </div>
        </div>
    </div>
    @stack('navbar')
</header>