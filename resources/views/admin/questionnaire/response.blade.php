<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MV | CheckMijnZaak.nl</title>
    <link rel="shortcut icon" href="../../../src/image/favicon.png" type="image/x-icon">
    <!-- <link rel="stylesheet" href="/src/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../../../src/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
</head>

<body>
    <section class="el-container">
        <aside class="el-aside shadow-lg">
            <div class="el-aside-logo p-6 flex items-center justify-center relative border-b border-[#e5e7eb]">
                <img src="../../../src/image/logo.png" alt="logo">
                <div class="el-aside-logo-close absolute hidden right-3 top-3 text-gray-500 size-[30px] cursor-pointer">
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
                        <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent"
                            href="/index.html">
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
                                    href="/pages/other-page/visits-pages/available.html">Available<span>(0)</span></a>
                                <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100"
                                    href="/pages/other-page/visits-pages/interested.html">Interested<span>(0)</span></a>
                                <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100"
                                    href="/pages/other-page/visits-pages/scheduled.html">Scheduled<span>(0)</span></a>
                                <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100"
                                    href="/pages/other-page/visits-pages/in-progress.html">In
                                    Progress<span>(1)</span></a>
                                <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100"
                                    href="/pages/other-page/visits-pages/pending.html">Pending<span>(0)</span></a>
                                <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100"
                                    href="/pages/other-page/visits-pages/completed.html">Completed<span>(11)</span></a>
                                <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100"
                                    href="/pages/other-page/visits-pages/all.html">All<span>(11)</span></a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF]"
                            href="/pages/other-page/companies/companies.html">
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
                            href="/pages/other-page/mystery-visitors/mystery-visitors.html">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 14V22H4C4 17.5817 7.58172 14 12 14ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM21.4462 20.032L22.9497 21.5355L21.5355 22.9497L20.032 21.4462C19.4365 21.7981 18.7418 22 18 22C15.7909 22 14 20.2091 14 18C14 15.7909 15.7909 14 18 14C20.2091 14 22 15.7909 22 18C22 18.7418 21.7981 19.4365 21.4462 20.032ZM18 20C19.1046 20 20 19.1046 20 18C20 16.8954 19.1046 16 18 16C16.8954 16 16 16.8954 16 18C16 19.1046 16.8954 20 18 20Z">
                                </path>
                            </svg>
                            <span>Mystery Visitors</span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF]"
                            href="/pages/other-page/questionnaires/questionnaires.html">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 9.5C12.8284 9.5 13.5 8.82843 13.5 8C13.5 7.17157 12.8284 6.5 12 6.5C11.1716 6.5 10.5 7.17157 10.5 8C10.5 8.82843 11.1716 9.5 12 9.5ZM14 15H13V10.5H10V12.5H11V15H10V17H14V15Z">
                                </path>
                            </svg>
                            <span>Questionnaires</span>
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
                        <span class="text-3xl font-semibold text-gray-800 hidden lg:flex">Visit Form
                        </span>
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
                                    <img src="../../../src/image/user.png" alt="">
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
                                            <a href="/pages/other-page/settings.html" type="button"
                                                class="btn-secondary py-2.5 flex justify-center items-center rounded-full border text-[14px] font-medium !w-full transition-all duration-300">
                                                <svg class="size-[14px] mr-2" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24" fill="currentColor">
                                                    <path
                                                        d="M5.33409 4.54491C6.3494 3.63637 7.55145 2.9322 8.87555 2.49707C9.60856 3.4128 10.7358 3.99928 12 3.99928C13.2642 3.99928 14.3914 3.4128 15.1245 2.49707C16.4486 2.9322 17.6506 3.63637 18.6659 4.54491C18.2405 5.637 18.2966 6.90531 18.9282 7.99928C19.5602 9.09388 20.6314 9.77679 21.7906 9.95392C21.9279 10.6142 22 11.2983 22 11.9993C22 12.7002 21.9279 13.3844 21.7906 14.0446C20.6314 14.2218 19.5602 14.9047 18.9282 15.9993C18.2966 17.0932 18.2405 18.3616 18.6659 19.4536C17.6506 20.3622 16.4486 21.0664 15.1245 21.5015C14.3914 20.5858 13.2642 19.9993 12 19.9993C10.7358 19.9993 9.60856 20.5858 8.87555 21.5015C7.55145 21.0664 6.3494 20.3622 5.33409 19.4536C5.75952 18.3616 5.7034 17.0932 5.0718 15.9993C4.43983 14.9047 3.36862 14.2218 2.20935 14.0446C2.07212 13.3844 2 12.7002 2 11.9993C2 11.2983 2.07212 10.6142 2.20935 9.95392C3.36862 9.77679 4.43983 9.09388 5.0718 7.99928C5.7034 6.90531 5.75952 5.637 5.33409 4.54491ZM13.5 14.5974C14.9349 13.7689 15.4265 11.9342 14.5981 10.4993C13.7696 9.0644 11.9349 8.57277 10.5 9.4012C9.06512 10.2296 8.5735 12.0644 9.40192 13.4993C10.2304 14.9342 12.0651 15.4258 13.5 14.5974Z">
                                                    </path>
                                                </svg>
                                                <span class=""> Settings</span>
                                            </a>
                                            <button type="button"
                                                class="btn-primary py-2.5 flex justify-center items-center rounded-full border text-[14px] font-medium !w-full transition-all duration-300">
                                                <svg class="size-[14px] mr-2" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24" fill="currentColor">
                                                    <path
                                                        d="M5 22C4.44772 22 4 21.5523 4 21V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V6H18V4H6V20H18V18H20V21C20 21.5523 19.5523 22 19 22H5ZM18 16V13H11V11H18V8L23 12L18 16Z">
                                                    </path>
                                                </svg>
                                                <span class=""> Logout</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </el-popover>
                        </div>
                    </div>
                </div>
                <div class="pt-6 flex lg:hidden">
                    <span class="text-2xl font-semibold text-gray-800">Visit Form
                    </span>
                </div>
            </header>
            <main class="el-main flex-1">
                <section class="pt-4 sm:pt-6">
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

                    <!-- Header Section -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200 p-4 mb-6 shadow-sm">
                        <!-- Title with Enhanced Styling -->
                        <div class="text-center mb-4">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">test branch 1</h1>
                            <p class="text-gray-600 text-lg">Questionnaire Response Form</p>
                        </div>

                        <!-- Enhanced Status Cards -->
                        <div class="flex flex-wrap items-center justify-center gap-4 mb-4">
                            <div
                                class="flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm text-gray-700 rounded-full text-sm font-medium shadow-sm">
                                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                test questionnaire
                            </div>
                            <div
                                class="flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-medium shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                </svg>
                                Active
                            </div>
                            <div
                                class="flex items-center gap-2 px-4 py-2 bg-orange-100 text-orange-700 rounded-full text-sm font-medium shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                                </svg>
                                In Progress
                            </div>
                        </div>

                        <!-- Enhanced Breadcrumb -->
                        <div class="text-center">
                            <div
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white/60 backdrop-blur-sm rounded-lg text-sm text-gray-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                                </svg>
                                test branch 1, 543 test branch 1
                            </div>
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
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
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
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
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
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
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
            </main>
        </section>
    </section>
</body>
<!-- <script src="/src/js/bootstrap.bundle.min.js"></script> -->
<script src="../../../src/js/app.js"></script>

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

</html>