<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MV | mysteryvisits.nl</title>
    <link rel="shortcut icon" href="{{ asset('assets/user/image/favicon.png')}}" type="image/x-icon">
    <!-- <link rel="stylesheet" href="/src/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="{{ asset('assets/user/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
</head>

<body>
<section class="el-container">
    <aside class="el-aside">
        <div class="el-aside-logo p-6 flex items-center justify-center relative">
            <img src="{{ asset('assets/user/image/logo.png')}}" alt="logo">
            <div class="el-aside-logo-close absolute hidden right-3 top-3 size-[30px] cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                    </path>
                </svg>
            </div>
        </div>
        <div class="el-aside-menu pt-6">
            <ul>
                <li>
                    <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent active"
                       href="checkmijnzaak/user/index.html">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                    d="M3 12C3 12.5523 3.44772 13 4 13H10C10.5523 13 11 12.5523 11 12V4C11 3.44772 10.5523 3 10 3H4C3.44772 3 3 3.44772 3 4V12ZM3 20C3 20.5523 3.44772 21 4 21H10C10.5523 21 11 20.5523 11 20V16C11 15.4477 10.5523 15 10 15H4C3.44772 15 3 15.4477 3 16V20ZM13 20C13 20.5523 13.4477 21 14 21H20C20.5523 21 21 20.5523 21 20V12C21 11.4477 20.5523 11 20 11H14C13.4477 11 13 11.4477 13 12V20ZM14 3C13.4477 3 13 3.44772 13 4V8C13 8.55228 13.4477 9 14 9H20C20.5523 9 21 8.55228 21 8V4C21 3.44772 20.5523 3 20 3H14Z">
                            </path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="">
                    <div class="px-6 py-3">
                        <h6 class="text-gray-500 text-sm font-semibold">Visits</h6>
                        <div class="el-aside-menu-item-sub">
                            <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100"
                               href="checkmijnzaak/user/pages/other-page/visits-pages/available.html">Available<span>(0)</span></a>
                            <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100"
                               href="checkmijnzaak/user/pages/other-page/visits-pages/interested.html">Interested<span>(0)</span></a>
                            <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100"
                               href="checkmijnzaak/user/pages/other-page/visits-pages/scheduled.html">Scheduled<span>(0)</span></a>
                            <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100"
                               href="checkmijnzaak/user/pages/other-page/visits-pages/in-progress.html">In
                                Progress<span>(1)</span></a>
                            <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100"
                               href="checkmijnzaak/user/pages/other-page/visits-pages/pending.html">Pending<span>(0)</span></a>
                            <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100"
                               href="checkmijnzaak/user/pages/other-page/visits-pages/completed.html">Completed<span>(11)</span></a>
                        </div>
                    </div>
                </li>
                <li>
                    <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF]"
                       href="checkmijnzaak/user/pages/other-page/activity-logs.html">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                    d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12H4C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C9.53614 4 7.33243 5.11383 5.86492 6.86543L8 9H2V3L4.44656 5.44648C6.28002 3.33509 8.9841 2 12 2ZM13 7L12.9998 11.585L16.2426 14.8284L14.8284 16.2426L10.9998 12.413L11 7H13Z">
                            </path>
                        </svg>
                        <span>Acitivty Logs</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF]"
                       href="checkmijnzaak/user/pages/other-page/companies/companies.html">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                    d="M21 13V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V13H2V11L3 6H21L22 11V13H21ZM5 13V19H19V13H5ZM6 14H14V17H6V14ZM3 3H21V5H3V3Z">
                            </path>
                        </svg>
                        <span>Companies</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF]"
                       href="checkmijnzaak/user/pages/other-page/settings.html">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                    d="M2 11.9998C2 11.1353 2.1097 10.2964 2.31595 9.49631C3.40622 9.55283 4.48848 9.01015 5.0718 7.99982C5.65467 6.99025 5.58406 5.78271 4.99121 4.86701C6.18354 3.69529 7.66832 2.82022 9.32603 2.36133C9.8222 3.33385 10.8333 3.99982 12 3.99982C13.1667 3.99982 14.1778 3.33385 14.674 2.36133C16.3317 2.82022 17.8165 3.69529 19.0088 4.86701C18.4159 5.78271 18.3453 6.99025 18.9282 7.99982C19.5115 9.01015 20.5938 9.55283 21.6841 9.49631C21.8903 10.2964 22 11.1353 22 11.9998C22 12.8643 21.8903 13.7032 21.6841 14.5033C20.5938 14.4468 19.5115 14.9895 18.9282 15.9998C18.3453 17.0094 18.4159 18.2169 19.0088 19.1326C17.8165 20.3043 16.3317 21.1794 14.674 21.6383C14.1778 20.6658 13.1667 19.9998 12 19.9998C10.8333 19.9998 9.8222 20.6658 9.32603 21.6383C7.66832 21.1794 6.18354 20.3043 4.99121 19.1326C5.58406 18.2169 5.65467 17.0094 5.0718 15.9998C4.48848 14.9895 3.40622 14.4468 2.31595 14.5033C2.1097 13.7032 2 12.8643 2 11.9998ZM6.80385 14.9998C7.43395 16.0912 7.61458 17.3459 7.36818 18.5236C7.77597 18.8138 8.21005 19.0652 8.66489 19.2741C9.56176 18.4712 10.7392 17.9998 12 17.9998C13.2608 17.9998 14.4382 18.4712 15.3351 19.2741C15.7899 19.0652 16.224 18.8138 16.6318 18.5236C16.3854 17.3459 16.566 16.0912 17.1962 14.9998C17.8262 13.9085 18.8225 13.1248 19.9655 12.7493C19.9884 12.5015 20 12.2516 20 11.9998C20 11.7481 19.9884 11.4981 19.9655 11.2504C18.8225 10.8749 17.8262 10.0912 17.1962 8.99982C16.566 7.90845 16.3854 6.65378 16.6318 5.47605C16.224 5.18588 15.7899 4.93447 15.3351 4.72552C14.4382 5.52844 13.2608 5.99982 12 5.99982C10.7392 5.99982 9.56176 5.52844 8.66489 4.72552C8.21005 4.93447 7.77597 5.18588 7.36818 5.47605C7.61458 6.65378 7.43395 7.90845 6.80385 8.99982C6.17376 10.0912 5.17754 10.8749 4.03451 11.2504C4.01157 11.4981 4 11.7481 4 11.9998C4 12.2516 4.01157 12.5015 4.03451 12.7493C5.17754 13.1248 6.17376 13.9085 6.80385 14.9998ZM12 14.9998C10.3431 14.9998 9 13.6567 9 11.9998C9 10.343 10.3431 8.99982 12 8.99982C13.6569 8.99982 15 10.343 15 11.9998C15 13.6567 13.6569 14.9998 12 14.9998ZM12 12.9998C12.5523 12.9998 13 12.5521 13 11.9998C13 11.4475 12.5523 10.9998 12 10.9998C11.4477 10.9998 11 11.4475 11 11.9998C11 12.5521 11.4477 12.9998 12 12.9998Z">
                            </path>
                        </svg>
                        <span>Settings</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF]"
                       href="checkmijnzaak/user/pages/other-page/contact-support.html">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                    d="M21 8C22.1046 8 23 8.89543 23 10V14C23 15.1046 22.1046 16 21 16H19.9381C19.446 19.9463 16.0796 23 12 23V21C15.3137 21 18 18.3137 18 15V9C18 5.68629 15.3137 3 12 3C8.68629 3 6 5.68629 6 9V16H3C1.89543 16 1 15.1046 1 14V10C1 8.89543 1.89543 8 3 8H4.06189C4.55399 4.05369 7.92038 1 12 1C16.0796 1 19.446 4.05369 19.9381 8H21ZM7.75944 15.7849L8.81958 14.0887C9.74161 14.6662 10.8318 15 12 15C13.1682 15 14.2584 14.6662 15.1804 14.0887L16.2406 15.7849C15.0112 16.5549 13.5576 17 12 17C10.4424 17 8.98882 16.5549 7.75944 15.7849Z">
                            </path>
                        </svg>
                        <span>Contact Support</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <section class="el-content p-4 lg:p-6">
        <header class="el-header pb-4 lg:pb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button type="button" class="toggle-btn size-[24px] cursor-pointer">
                        <svg class="size-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor">
                            <path d="M3 4H21V6H3V4ZM3 11H21V13H3V11ZM3 18H21V20H3V18Z"></path>
                        </svg>
                    </button>
                    <span class="text-3xl font-semibold text-gray-800 hidden lg:flex">Dashboard</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex relative hidden md:flex">
                        <input type="text"
                               class="pl-10 pr-4 py-2 border border-[#e5e7eb] rounded-full w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Search">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 size-[20px]"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                    d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z">
                            </path>
                        </svg>
                    </div>
                    <a href="pages/other-page/notification.html"
                       class="size-[46px] rounded-full bg-gray-100 flex items-center justify-center rounded-full hover:bg-gray-200 cursor-pointer transition-all duration-300">
                        <svg class="size-[20px] text-gray-600" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path
                                    d="M20 17H22V19H2V17H4V10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10V17ZM9 21H15V23H9V21Z">
                            </path>
                        </svg>
                    </a>
                    <div class="relative">
                        <button popovertarget="desktop-menu-user"
                                class="flex items-center p-2 rounded-full bg-gray-100 gap-2 cursor-pointer">
                            <div
                                    class="size-[30px] rounded-full border-solid overflow-hidden border-gray-100 border">
                                <img src="{{asset('assets/user/image/user.png')}}" alt="">
                            </div>
                            <p class="text-sm font-medium text-gray-700">Test Visitor</p>
                            <svg class="size-[16px] text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path
                                        d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                </path>
                            </svg>
                        </button>
                        <el-popover id="desktop-menu-user" anchor="bottom-end" popover
                                    class="overflow-visible bg-white w-[200px] shadow-[0px_0px_12px_#0000001f] mt-2 p-4 border border-[#ebeef5] rounded-[20px] transition open:flex data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in">
                            <div class="flex flex-col w-full gap-2">
                                <div class="flex flex-col justify-center">
                                    <p class="text-[14px] font-semibold text-[rgb(96,98,102)] text-center">
                                        Test Visitor
                                    </p>
                                    <p class="text-xs text-[#606266] pb-2 text-center">test@visitor.com</p>
                                    <span
                                            class="px-[11px] text-[#409eff] bg-[#ecf5ff] border border-[#d9ecff] h-[32px] text-[12px] rounded-[4px] font-medium items-center flex  m-auto">
                                            <span class="el-tag__content"> Admin</span>
                                        </span>

                                    <div class=" pt-3 flex flex-col gap-2">
                                        <a href="checkmijnzaak/user/pages/other-page/settings.html" type="button"
                                           class="btn-secondary py-2.5 flex justify-center items-center rounded-full border text-[14px] font-medium !w-full transition-all duration-300">
                                            <svg class="size-[14px] mr-2" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                        d="M5.33409 4.54491C6.3494 3.63637 7.55145 2.9322 8.87555 2.49707C9.60856 3.4128 10.7358 3.99928 12 3.99928C13.2642 3.99928 14.3914 3.4128 15.1245 2.49707C16.4486 2.9322 17.6506 3.63637 18.6659 4.54491C18.2405 5.637 18.2966 6.90531 18.9282 7.99928C19.5602 9.09388 20.6314 9.77679 21.7906 9.95392C21.9279 10.6142 22 11.2983 22 11.9993C22 12.7002 21.9279 13.3844 21.7906 14.0446C20.6314 14.2218 19.5602 14.9047 18.9282 15.9993C18.2966 17.0932 18.2405 18.3616 18.6659 19.4536C17.6506 20.3622 16.4486 21.0664 15.1245 21.5015C14.3914 20.5858 13.2642 19.9993 12 19.9993C10.7358 19.9993 9.60856 20.5858 8.87555 21.5015C7.55145 21.0664 6.3494 20.3622 5.33409 19.4536C5.75952 18.3616 5.7034 17.0932 5.0718 15.9993C4.43983 14.9047 3.36862 14.2218 2.20935 14.0446C2.07212 13.3844 2 12.7002 2 11.9993C2 11.2983 2.07212 10.6142 2.20935 9.95392C3.36862 9.77679 4.43983 9.09388 5.0718 7.99928C5.7034 6.90531 5.75952 5.637 5.33409 4.54491ZM13.5 14.5974C14.9349 13.7689 15.4265 11.9342 14.5981 10.4993C13.7696 9.0644 11.9349 8.57277 10.5 9.4012C9.06512 10.2296 8.5735 12.0644 9.40192 13.4993C10.2304 14.9342 12.0651 15.4258 13.5 14.5974Z">
                                                </path>
                                            </svg>
                                            <span class=""> Settings</span>
                                        </a>
                                        <a href="{{ route('company.logout') }}"
                                           class="btn-primary py-2.5 flex justify-center items-center rounded-full border text-[14px] font-medium !w-full transition-all duration-300">
                                            <svg class="size-[14px] mr-2" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                        d="M5 22C4.44772 22 4 21.5523 4 21V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V6H18V4H6V20H18V18H20V21C20 21.5523 19.5523 22 19 22H5ZM18 16V13H11V11H18V8L23 12L18 16Z">
                                                </path>
                                            </svg>
                                            <span>Logout</span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </el-popover>
                    </div>
                </div>
            </div>
            <div class="pt-6 flex lg:hidden">
                <span class="text-2xl font-semibold text-gray-800">Dashboard</span>
            </div>
        </header>
        <main class="el-main flex-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-6">
                <div
                        class="gradient-blue h-full text-white p-4 md:p-6 rounded-2xl shadow-lg flex flex-col justify-between">
                    <div class="group flex justify-between items-start flex-col h-full">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/30 p-2 md:p-3 rounded-full">
                                <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path
                                            d="M7 4V2H17V4H20.0066C20.5552 4 21 4.44495 21 4.9934V21.0066C21 21.5552 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5551 3 21.0066V4.9934C3 4.44476 3.44495 4 3.9934 4H7ZM7 6H5V20H19V6H17V8H7V6ZM9 4V6H15V4H9Z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold">Available Visits</h3>
                        </div>
                        <div class="pt-10 md:pt-6 flex justify-between items-end w-full">
                            <p class="text-5xl font-bold">10</p>
                            <a class="bg-white/30 p-2 md:p-3 rounded-full group-hover:bg-white/40 transition-colors"
                               href="#">
                                <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path
                                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div
                        class="gradient-green h-full text-white p-4 md:p-6 rounded-2xl shadow-lg flex flex-col justify-between">
                    <div class="group flex justify-between items-start flex-col h-full">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/30 p-2 md:p-3 rounded-full">
                                <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path
                                            d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12H4C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C9.25022 4 6.82447 5.38734 5.38451 7.50024L8 7.5V9.5H2V3.5H4L3.99989 5.99918C5.82434 3.57075 8.72873 2 12 2ZM13 7L12.9998 11.585L16.2426 14.8284L14.8284 16.2426L10.9998 12.413L11 7H13Z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold">In Progress Visits</h3>
                        </div>
                        <div class="pt-10 md:pt-6 flex justify-between items-end w-full">
                            <p class="text-5xl font-bold">01</p>
                            <a class="bg-white/30 p-2 md:p-3 rounded-full group-hover:bg-white/40 transition-colors"
                               href="#">
                                <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path
                                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div
                        class="gradient-orange h-full text-white p-4 md:p-6 rounded-2xl shadow-lg flex flex-col justify-between">
                    <div class="group flex justify-between items-start flex-col h-full">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/30 p-2 md:p-3 rounded-full">
                                <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path
                                            d="M4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12ZM12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM17.4571 9.45711L16.0429 8.04289L11 13.0858L8.20711 10.2929L6.79289 11.7071L11 15.9142L17.4571 9.45711Z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold">Pending</h3>
                        </div>
                        <div class="pt-10 md:pt-6 flex justify-between items-end w-full">
                            <p class="text-5xl font-bold">10</p>
                            <a class="bg-white/30 p-2 md:p-3 rounded-full group-hover:bg-white/40 transition-colors"
                               href="#">
                                <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path
                                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div
                        class="gradient-purple h-full text-white p-4 md:p-6 rounded-2xl shadow-lg flex flex-col justify-between">
                    <div class="group flex justify-between items-start flex-col h-full">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/30 p-2 md:p-3 rounded-full">
                                <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path
                                            d="M12 20V22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9998 7V14H19V8H15V4H5V20H12ZM14.4646 19.4647L18.0001 23.0002L22.9498 18.0505L21.5356 16.6362L18.0001 20.1718L15.8788 18.0505L14.4646 19.4647Z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold">Completed</h3>
                        </div>
                        <div class="pt-10 md:pt-6 flex justify-between items-end w-full">
                            <p class="text-5xl font-bold">01</p>
                            <a class="bg-white/30 p-2 md:p-3 rounded-full group-hover:bg-white/40 transition-colors"
                               href="#">
                                <svg class="size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path
                                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-5 gap-6 pt-6">
                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg xl:col-span-3 flex flex-col gap-6">
                    <h3 class="text-lg font-semibold text-gray-800">Scheduled Visits</h3>
                    <div class="flex-1 flex justify-center items-center">
                        <div class="flex flex-col items-center justify-center py-10 gap-2">
                            <svg class="size-[40px] text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path
                                        d="M9 3V1H7V3H3C2.44772 3 2 3.44772 2 4V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V4C22 3.44772 21.5523 3 21 3H17V1H15V3H9ZM4 10H20V19H4V10ZM4 5H7V6H9V5H15V6H17V5H20V8H4V5ZM9.87862 10.9644L12 13.0858L14.1212 10.9644L15.5355 12.3785L13.4142 14.5001L15.5354 16.6212L14.1213 18.0354L12 15.9143L9.87855 18.0354L8.46442 16.6211L10.5857 14.5001L8.46436 12.3785L9.87862 10.9644Z">
                                </path>
                            </svg>
                            <p class="text-base font-medium text-gray-500">No scheduled visits</p>
                        </div>
                    </div>
                </div>
                <div class="xl:col-span-2 flex flex-col gap-6">
                    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg flex flex-col gap-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800">Company Scores</h3>
                            <a class="text-[#0073AF] text-sm font-semibold items-center flex" href="#">
                                See More
                            </a>
                        </div>
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img alt="DDS Test logo" class="h-8 w-8 rounded-full object-cover mr-3"
                                         src="{{asset('assets/user/image/user.png')}}">
                                    <div>
                                        <p class=" text-lg font-semibold text-gray-600">DDS Test</p>
                                        <p class="text-xs text-gray-500">NaN%</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                        </path>
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                        </path>
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                                d="M12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502V15.968ZM12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                        </path>
                                    </svg>
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                        </path>
                                    </svg>
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img alt="DDS Test logo" class="h-8 w-8 rounded-full object-cover mr-3"
                                         src="{{asset('assets/user/image/user.png')}}">
                                    <div>
                                        <p class=" text-lg font-semibold text-gray-600">Sligro</p>
                                        <p class="text-xs text-gray-500">24%</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                        </path>
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                        </path>
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                                d="M12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502V15.968ZM12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                        </path>
                                    </svg>
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                        </path>
                                    </svg>
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                                d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                            class="bg-[#F3E8FF] p-4 sm:p-6 rounded-2xl shadow-lg flex items-center justify-between gap-6">
                        <div>
                            <h4 class="font-semibold text-purple-800">Video Tutorials</h4>
                            <p class="text-sm text-purple-600">Learn how to use the platform</p>
                        </div>
                        <div class="flex items-center justify-center">
                            <svg class="size-[24px] text-purple-600" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path
                                        d="M6 20.1957V3.80421C6 3.01878 6.86395 2.53993 7.53 2.95621L20.6432 11.152C21.2699 11.5436 21.2699 12.4563 20.6432 12.848L7.53 21.0437C6.86395 21.46 6 20.9812 6 20.1957Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div
                            class="bg-[#E0E7FF] p-4 sm:p-6 rounded-2xl shadow-lg flex items-center justify-between gap-6">
                        <div>
                            <h4 class="font-semibold text-indigo-800">Manuals</h4>
                            <p class="text-sm text-indigo-600">Read the documentation</p>
                        </div>
                        <div class="flex items-center justify-center">
                            <svg class="size-[24px] text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path
                                        d="M13 21V23H11V21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H9C10.1947 3 11.2671 3.52375 12 4.35418C12.7329 3.52375 13.8053 3 15 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H13ZM20 19V5H15C13.8954 5 13 5.89543 13 7V19H20ZM11 19V7C11 5.89543 10.1046 5 9 5H4V19H11Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div
                            class="bg-[#E0E7FF] p-4 sm:p-6 rounded-2xl shadow-lg flex items-center justify-between gap-6">
                        <div>
                            <h4 class="font-semibold text-indigo-800">Frequently Asked Questions</h4>
                            <p class="text-sm text-indigo-600">Find answers to common questions</p>
                        </div>
                        <div class="flex items-center justify-center">
                            <svg class="size-[24px] text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="currentColor">
                                <path
                                        d="M5.76282 17H20V5H4V18.3851L5.76282 17ZM6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM11 14H13V16H11V14ZM8.56731 8.81346C8.88637 7.20919 10.302 6 12 6C13.933 6 15.5 7.567 15.5 9.5C15.5 11.433 13.933 13 12 13H11V11H12C12.8284 11 13.5 10.3284 13.5 9.5C13.5 8.67157 12.8284 8 12 8C11.2723 8 10.6656 8.51823 10.5288 9.20577L8.56731 8.81346Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>
</section>
</body>
<!-- <script src="/src/js/bootstrap.bundle.min.js"></script> -->
<script src="src/js/app.js"></script>

</html>