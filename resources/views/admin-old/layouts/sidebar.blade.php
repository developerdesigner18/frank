<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{route('admin.dashboard')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('assets/logo/logo.jpg')}}" alt="" class="w-100">
                    </span>
            <span class="logo-lg">
                        <img src="{{asset('assets/logo/logo.jpg')}}" alt="" class="w-100">
                    </span>
        </a>
        <!-- Light Logo-->
        <a href="{{route('admin.dashboard')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('assets/logo/logo.jpg')}}" alt="" class="w-100">
                    </span>
            <span class="logo-lg">
                        <img src="{{asset('assets/logo/logo.jpg')}}" alt="" class="w-100">
                    </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}"
                       class="nav-link menu-link @if(in_array(request()->route()->getName(),['admin.dashboard'])) active @endif">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.company.index')}}"
                       class="nav-link menu-link @if(in_array(request()->route()->getName(),['admin.company.index','admin.company.branches.index'])) active @endif">
                        <i class="ri-building-2-line"></i> <span data-key="t-dashboards">Companies</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('admin.visitor.index')}}"
                       class="nav-link menu-link @if(in_array(request()->route()->getName(),['admin.visitor.index'])) active @endif">
                        <i class="ri-user-star-fill"></i> <span data-key="t-dashboards">Mystery Visitors</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('admin.questionnaire.index')}}"
                       class="nav-link menu-link @if(request()->routeIs('admin.questionnaire.*')) active @endif">
                        <i class="ri-survey-line"></i> <span data-key="t-dashboards">Questionnaire</span>
                    </a>
                </li>

{{--                <li class="nav-item">--}}
{{--                    <a href="{{route('admin.visit.index')}}"--}}
{{--                       class="nav-link menu-link @if(request()->routeIs('admin.visit.*')) active @endif">--}}
{{--                        <i class="ri-calendar-2-line"></i> <span data-key="t-dashboards">Visits</span>--}}
{{--                    </a>--}}
{{--                </li>--}}

                <li class="nav-item">
                    <a class="nav-link menu-link active" href="#sidebarVisits" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="sidebarLanding">
                        <i class="ri-calendar-2-line"></i> <span data-key="t-visits">Visits</span>
                    </a>
                    <div class="collapse menu-dropdown show" id="sidebarVisits">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.visit.available')}}" class="nav-link @if(in_array(request()->route()->getName(),['admin.visit.available'])) active @endif" data-key="t-nft-landing"> Available </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.visit.interested')}}" class="nav-link @if(in_array(request()->route()->getName(),['admin.visit.interested'])) active @endif" data-key="t-nft-landing"> Interested </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.visit.scheduled')}}" class="nav-link @if(in_array(request()->route()->getName(),['admin.visit.scheduled'])) active @endif" data-key="t-nft-landing"> Scheduled </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.visit.pending')}}" class="nav-link @if(in_array(request()->route()->getName(),['admin.visit.pending'])) active @endif" data-key="t-nft-landing"> Pending </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.visit.completed')}}" class="nav-link @if(in_array(request()->route()->getName(),['admin.visit.completed'])) active @endif" data-key="t-nft-landing"> Completed </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.visit.index')}}" class="nav-link @if(in_array(request()->route()->getName(),['admin.visit.index'])) active @endif" data-key="t-one-page"> All </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
