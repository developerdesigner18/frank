<aside class="el-aside">
    <div class="el-aside-logo p-6 flex items-center justify-center relative">
        <img src="{{asset('assets/admin_new/image/logo-removebg-preview.png')}}" alt="logo">
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
                <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent @if(in_array(request()->route()->getName(),['admin.dashboard'])) active @endif"
                   href="{{ route('admin.dashboard') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 12C3 12.5523 3.44772 13 4 13H10C10.5523 13 11 12.5523 11 12V4C11 3.44772 10.5523 3 10 3H4C3.44772 3 3 3.44772 3 4V12ZM3 20C3 20.5523 3.44772 21 4 21H10C10.5523 21 11 20.5523 11 20V16C11 15.4477 10.5523 15 10 15H4C3.44772 15 3 15.4477 3 16V20ZM13 20C13 20.5523 13.4477 21 14 21H20C20.5523 21 21 20.5523 21 20V12C21 11.4477 20.5523 11 20 11H14C13.4477 11 13 11.4477 13 12V20ZM14 3C13.4477 3 13 3.44772 13 4V8C13 8.55228 13.4477 9 14 9H20C20.5523 9 21 8.55228 21 8V4C21 3.44772 20.5523 3 20 3H14Z">
                        </path>
                    </svg>
                    <span>{{ trans_message('dashboard') }}</span>
                </a>
            </li>
            <li class="">
                <div class="px-6 py-3">
                    <h6 class="flex gap-3 text-gray-500 text-sm font-bold">
                        <svg class="w-[12px]" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 610.398 610.398" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M159.567,0h-15.329c-1.956,0-3.811,0.411-5.608,0.995c-8.979,2.912-15.616,12.498-15.616,23.997v10.552v27.009v14.052 c0,2.611,0.435,5.078,1.066,7.44c2.702,10.146,10.653,17.552,20.158,17.552h15.329c11.724,0,21.224-11.188,21.224-24.992V62.553 V35.544V24.992C180.791,11.188,171.291,0,159.567,0z"></path> <path d="M461.288,0h-15.329c-11.724,0-21.224,11.188-21.224,24.992v10.552v27.009v14.052c0,13.804,9.5,24.992,21.224,24.992 h15.329c11.724,0,21.224-11.188,21.224-24.992V62.553V35.544V24.992C482.507,11.188,473.007,0,461.288,0z"></path> <path d="M539.586,62.553h-37.954v14.052c0,24.327-18.102,44.117-40.349,44.117h-15.329c-22.247,0-40.349-19.79-40.349-44.117 V62.553H199.916v14.052c0,24.327-18.102,44.117-40.349,44.117h-15.329c-22.248,0-40.349-19.79-40.349-44.117V62.553H70.818 c-21.066,0-38.15,16.017-38.15,35.764v476.318c0,19.784,17.083,35.764,38.15,35.764h468.763c21.085,0,38.149-15.984,38.149-35.764 V98.322C577.735,78.575,560.671,62.553,539.586,62.553z M527.757,557.9l-446.502-0.172V173.717h446.502V557.9z"></path> <path d="M353.017,266.258h117.428c10.193,0,18.437-10.179,18.437-22.759s-8.248-22.759-18.437-22.759H353.017 c-10.193,0-18.437,10.179-18.437,22.759C334.58,256.074,342.823,266.258,353.017,266.258z"></path> <path d="M353.017,348.467h117.428c10.193,0,18.437-10.179,18.437-22.759c0-12.579-8.248-22.758-18.437-22.758H353.017 c-10.193,0-18.437,10.179-18.437,22.758C334.58,338.288,342.823,348.467,353.017,348.467z"></path> <path d="M353.017,430.676h117.428c10.193,0,18.437-10.18,18.437-22.759s-8.248-22.759-18.437-22.759H353.017 c-10.193,0-18.437,10.18-18.437,22.759S342.823,430.676,353.017,430.676z"></path> <path d="M353.017,512.89h117.428c10.193,0,18.437-10.18,18.437-22.759c0-12.58-8.248-22.759-18.437-22.759H353.017 c-10.193,0-18.437,10.179-18.437,22.759C334.58,502.71,342.823,512.89,353.017,512.89z"></path> <path d="M145.032,266.258H262.46c10.193,0,18.436-10.179,18.436-22.759s-8.248-22.759-18.436-22.759H145.032 c-10.194,0-18.437,10.179-18.437,22.759C126.596,256.074,134.838,266.258,145.032,266.258z"></path> <path d="M145.032,348.467H262.46c10.193,0,18.436-10.179,18.436-22.759c0-12.579-8.248-22.758-18.436-22.758H145.032 c-10.194,0-18.437,10.179-18.437,22.758C126.596,338.288,134.838,348.467,145.032,348.467z"></path> <path d="M145.032,430.676H262.46c10.193,0,18.436-10.18,18.436-22.759s-8.248-22.759-18.436-22.759H145.032 c-10.194,0-18.437,10.18-18.437,22.759S134.838,430.676,145.032,430.676z"></path> <path d="M145.032,512.89H262.46c10.193,0,18.436-10.18,18.436-22.759c0-12.58-8.248-22.759-18.436-22.759H145.032 c-10.194,0-18.437,10.179-18.437,22.759C126.596,502.71,134.838,512.89,145.032,512.89z"></path> </g> </g> </g></svg>
                        <span>{{ trans_message('visits') }}</span>
                    </h6>
                    <div class="el-aside-menu-item-sub">
                        <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100 {{ request()->routeIs('admin.visit.index') && request('page') == 'available' ? 'active' : '' }}"
                           href="{{ route('admin.visit.index',['page'=>'available']) }}">{{ trans_message('available') }}(<span class="available_count">{{ $visitCounts['available'] ?? 0 }}</span>)</a>
                        <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100 {{ request()->routeIs('admin.visit.index') && request('page') == 'interested' ? 'active' : '' }}"
                           href="{{ route('admin.visit.index',['page'=>'interested']) }}">{{ trans_message('interested') }}(<span class="interested_count">{{ $visitCounts['interested'] ?? 0 }}</span>)</a>
                        <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100 {{ request()->routeIs('admin.visit.index') && request('page') == 'scheduled' ? 'active' : '' }}"
                           href="{{ route('admin.visit.index',['page'=>'scheduled']) }}">{{ trans_message('scheduled') }}(<span class="scheduled_count" >{{ $visitCounts['scheduled'] ?? 0 }}</span>)</a>
                        <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100 {{ request()->routeIs('admin.visit.index') && request('page') == 'pending' ? 'active' : '' }}"
                           href="{{ route('admin.visit.index',['page'=>'pending']) }}">{{ trans_message('pending') }}(<span class="pending_count" >{{ $visitCounts['pending'] ?? 0 }}</span>)</a>
                        <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100 {{ request()->routeIs('admin.visit.index') && request('page') == 'completed' ? 'active' : '' }}"
                           href="{{ route('admin.visit.index',['page'=>'completed']) }}">{{ trans_message('completed') }}(<span class="completed_count" >{{ $visitCounts['completed'] ?? 0 }}</span>)</a>
                        <a class="flex items-center text-[14px] font-medium px-3 py-1.5 text-[#000] gap-3 opacity-60 hover:opacity-100 {{ request()->routeIs('admin.visit.index') && request('page') == 'all' ? 'active' : '' }}"
                           href="{{ route('admin.visit.index',['page'=>'all']) }}">{{ trans_message('all') }}(<span>{{ $visitCounts['all'] ?? 0 }}</span>)</a>
                    </div>
                </div>
            </li>
            <li>
                <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] @if(in_array(request()->route()->getName(),['admin.company.index','admin.company.branches.index','admin.company.branch.visits.index'])) active @endif"
                   href="{{route('admin.company.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21 13V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V13H2V11L3 6H21L22 11V13H21ZM5 13V19H19V13H5ZM6 14H14V17H6V14ZM3 3H21V5H3V3Z">
                        </path>
                    </svg>
                    <span>{{ trans_message('companies') }}</span>
                </a>
            </li>
            <li>
                <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] @if(in_array(request()->route()->getName(),['admin.visitor.index','admin.visitor.visits'])) active @endif"
                   href="{{ route('admin.visitor.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                                d="M12 14V22H4C4 17.5817 7.58172 14 12 14ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM21.4462 20.032L22.9497 21.5355L21.5355 22.9497L20.032 21.4462C19.4365 21.7981 18.7418 22 18 22C15.7909 22 14 20.2091 14 18C14 15.7909 15.7909 14 18 14C20.2091 14 22 15.7909 22 18C22 18.7418 21.7981 19.4365 21.4462 20.032ZM18 20C19.1046 20 20 19.1046 20 18C20 16.8954 19.1046 16 18 16C16.8954 16 16 16.8954 16 18C16 19.1046 16.8954 20 18 20Z">
                        </path>
                    </svg>
                    <span>{{ trans_message('mystery_visitors') }}</span>
                </a>
            </li>
            <li>
                <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] @if(in_array(request()->route()->getName(),['admin.questionnaire.index','admin.questionnaire.form','admin.questionnaire.view'])) active @endif"
                   href="{{ route('admin.questionnaire.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 9.5C12.8284 9.5 13.5 8.82843 13.5 8C13.5 7.17157 12.8284 6.5 12 6.5C11.1716 6.5 10.5 7.17157 10.5 8C10.5 8.82843 11.1716 9.5 12 9.5ZM14 15H13V10.5H10V12.5H11V15H10V17H14V15Z">
                        </path>
                    </svg>
                    <span>{{ trans_message('questionnaires') }}</span>
                </a>
            </li>
            <li>
                <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] @if(in_array(request()->route()->getName(),['admin.subdealers.index'])) active @endif"
                   href="{{ route('admin.subdealer.index') }}">

                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                        <path d="M16 11c1.66 0 3-1.79 3-4s-1.34-4-3-4-3 1.79-3 4 1.34 4 3 4zm-8 0c1.66 0 3-1.79 3-4S9.66 3 8 3 5 4.79 5 7s1.34 4 3 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45v2h6v-2c0-2.66-5.33-4-7-4z"/>
                    </svg>

                    <span>SubDealers</span>
                </a>
            </li>
            <li>
                <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] @if(in_array(request()->route()->getName(),['admin.emails.index'])) active @endif"
                   href="{{ route('admin.emails.index') }}">
                    <svg viewBox="0 -2.5 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>email [#1572]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-340.000000, -922.000000)" fill="#000000"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M294,774.474 L284,765.649 L284,777 L304,777 L304,765.649 L294,774.474 Z M294.001,771.812 L284,762.981 L284,762 L304,762 L304,762.981 L294.001,771.812 Z" id="email-[#1572]"> </path> </g> </g> </g> </g></svg>
                    <span>{{ trans_message('emails') }}</span>
                </a>
            </li>
            <li>
                <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] @if(in_array(request()->route()->getName(),['admin.admin-users.index'])) active @endif"
                   href="{{ route('admin.admin-users.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 14V16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM14.5946 18.8115C14.5327 18.5511 14.5 18.2794 14.5 18C14.5 17.7207 14.5327 17.449 14.5945 17.1886L13.6029 16.6161L14.6029 14.884L15.5952 15.4569C15.9883 15.0851 16.4676 14.8034 17 14.6449V13.5H19V14.6449C19.5324 14.8034 20.0116 15.0851 20.4047 15.4569L21.3971 14.8839L22.3972 16.616L21.4055 17.1885C21.4673 17.449 21.5 17.7207 21.5 18C21.5 18.2793 21.4673 18.551 21.4055 18.8114L22.3972 19.3839L21.3972 21.116L20.4048 20.543C20.0117 20.9149 19.5325 21.1966 19.0001 21.355V22.5H17.0001V21.3551C16.4677 21.1967 15.9884 20.915 15.5953 20.5431L14.603 21.1161L13.6029 19.384L14.5946 18.8115ZM18 19.5C18.8284 19.5 19.5 18.8284 19.5 18C19.5 17.1716 18.8284 16.5 18 16.5C17.1716 16.5 16.5 17.1716 16.5 18C16.5 18.8284 17.1716 19.5 18 19.5Z"></path>
                    </svg>
                    <span>{{ trans_message('admin_users') }}</span>
                </a>
            </li>
            <li>
                <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF] @if(in_array(request()->route()->getName(),['admin.settings'])) active @endif"
                   href="{{ route('admin.settings') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2 11.9998C2 11.1353 2.1097 10.2964 2.31595 9.49631C3.40622 9.55283 4.48848 9.01015 5.0718 7.99982C5.65467 6.99025 5.58406 5.78271 4.99121 4.86701C6.18354 3.69529 7.66832 2.82022 9.32603 2.36133C9.8222 3.33385 10.8333 3.99982 12 3.99982C13.1667 3.99982 14.1778 3.33385 14.674 2.36133C16.3317 2.82022 17.8165 3.69529 19.0088 4.86701C18.4159 5.78271 18.3453 6.99025 18.9282 7.99982C19.5115 9.01015 20.5938 9.55283 21.6841 9.49631C21.8903 10.2964 22 11.1353 22 11.9998C22 12.8643 21.8903 13.7032 21.6841 14.5033C20.5938 14.4468 19.5115 14.9895 18.9282 15.9998C18.3453 17.0094 18.4159 18.2169 19.0088 19.1326C17.8165 20.3043 16.3317 21.1794 14.674 21.6383C14.1778 20.6658 13.1667 19.9998 12 19.9998C10.8333 19.9998 9.8222 20.6658 9.32603 21.6383C7.66832 21.1794 6.18354 20.3043 4.99121 19.1326C5.58406 18.2169 5.65467 17.0094 5.0718 15.9998C4.48848 14.9895 3.40622 14.4468 2.31595 14.5033C2.1097 13.7032 2 12.8643 2 11.9998ZM6.80385 14.9998C7.43395 16.0912 7.61458 17.3459 7.36818 18.5236C7.77597 18.8138 8.21005 19.0652 8.66489 19.2741C9.56176 18.4712 10.7392 17.9998 12 17.9998C13.2608 17.9998 14.4382 18.4712 15.3351 19.2741C15.7899 19.0652 16.224 18.8138 16.6318 18.5236C16.3854 17.3459 16.566 16.0912 17.1962 14.9998C17.8262 13.9085 18.8225 13.1248 19.9655 12.7493C19.9884 12.5015 20 12.2516 20 11.9998C20 11.7481 19.9884 11.4981 19.9655 11.2504C18.8225 10.8749 17.8262 10.0912 17.1962 8.99982C16.566 7.90845 16.3854 6.65378 16.6318 5.47605C16.224 5.18588 15.7899 4.93447 15.3351 4.72552C14.4382 5.52844 13.2608 5.99982 12 5.99982C10.7392 5.99982 9.56176 5.52844 8.66489 4.72552C8.21005 4.93447 7.77597 5.18588 7.36818 5.47605C7.61458 6.65378 7.43395 7.90845 6.80385 8.99982C6.17376 10.0912 5.17754 10.8749 4.03451 11.2504C4.01157 11.4981 4 11.7481 4 11.9998C4 12.2516 4.01157 12.5015 4.03451 12.7493C5.17754 13.1248 6.17376 13.9085 6.80385 14.9998ZM12 14.9998C10.3431 14.9998 9 13.6567 9 11.9998C9 10.343 10.3431 8.99982 12 8.99982C13.6569 8.99982 15 10.343 15 11.9998C15 13.6567 13.6569 14.9998 12 14.9998ZM12 12.9998C12.5523 12.9998 13 12.5521 13 11.9998C13 11.4475 12.5523 10.9998 12 10.9998C11.4477 10.9998 11 11.4475 11 11.9998C11 12.5521 11.4477 12.9998 12 12.9998Z">
                        </path>
                    </svg>
                    <span>{{ trans_message('settings') }}</span>
                </a>
            </li>
            <li>
                <a class="flex items-center text-[14px] font-medium px-6 py-3 text-[#000]/70 border-l-4 gap-3 border-transparent hover:bg-[#EFF6FF]"
                   href="{{ route('admin.logout') }}">
                    <svg class="w-[12px]" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" transform="matrix(-1, 0, 0, 1, 0, 0)rotate(0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M14 4L17.5 4C20.5577 4 20.5 8 20.5 12C20.5 16 20.5577 20 17.5 20H14M3 12L15 12M3 12L7 8M3 12L7 16" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    <span>{{ trans_message('logout') }}</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
