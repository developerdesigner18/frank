<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{route('company.dashboard')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{Auth::user()->company->image ? Auth::user()->company->image : asset('assets/logo/logo.jpg')}}" alt="" class="w-100">
                    </span>
            <span class="logo-lg">
                        <img src="{{Auth::user()->company->image ? Auth::user()->company->image : asset('assets/logo/logo.jpg')}}" alt="" class="w-100">
                    </span>
        </a>
        <!-- Light Logo-->
        <a href="{{route('company.dashboard')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{Auth::user()->company->image ? Auth::user()->company->image : asset('assets/logo/logo.jpg')}}" alt="" class="w-100">
                    </span>
            <span class="logo-lg">
                        <img src="{{Auth::user()->company->image ? Auth::user()->company->image : asset('assets/logo/logo.jpg')}}" alt="" class="w-100">
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
                    <a href="{{route('company.dashboard')}}" class="nav-link menu-link @if(in_array(request()->route()->getName(),['company.dashboard'])) active @endif">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('company.branch')}}" class="nav-link menu-link @if(in_array(request()->route()->getName(),['company.branch','company.branches.visits'])) active @endif">
                        <i class="ri-git-merge-line"></i> <span data-key="t-dashboards">Branch</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
