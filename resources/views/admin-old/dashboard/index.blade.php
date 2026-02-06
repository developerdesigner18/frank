@extends('admin.master')
@section('title', 'Dashboard')

@section('main')
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">Welcome Abord, {{Auth::guard('admin')->user()->name}}!</h4>
                            </div>
                            <div class="mt-3 mt-lg-0">
                                <form action="javascript:void(0);">
                                    <div class="row g-3 mb-0 align-items-center">
                                        <div class="col-sm-auto">
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control border-0 dash-filter-picker shadow"
                                                       data-provider="flatpickr" data-range-date="true"
                                                       data-date-format="d M, Y"
                                                       data-deafult-date="01 Jan 2022 to 31 Jan 2022"/>
                                                <div class="input-group-text bg-primary border-primary text-white">
                                                    <i class="ri-calendar-2-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div>
                        <!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            Companies
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value" data-target="{{$companyCount}}">0</span>
                                        </h4>
                                        <a href="{{route('admin.company.index')}}" class="text-decoration-underline">View
                                            Companies</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                            <i class="ri-building-2-line text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            Mystery Visitors
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value" data-target="{{$visitorCount}}">0</span>
                                        </h4>
                                        <a href="{{route('admin.visitor.index')}}" class="text-decoration-underline">View
                                            all Mystery Visitors</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <i class="ri-user-star-fill text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                    {{-- <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            Completed Visits
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value" data-target="{{ $completed }}">0</span>
                                        </h4>
                                        <a href="{{route('admin.visit.completed')}}" class="text-decoration-underline">See
                                            details</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                            <i class="ri-crosshair-line text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div> --}}
                    <!-- end col -->
                    {{--
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            All Visits
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value" data-target="{{ $totalVisits }}">0</span>
                                        </h4>
                                        <a href="{{route('admin.visit.index')}}" class="text-decoration-underline">See
                                            Details</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                                            <i class="ri-crosshair-fill text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div> --}}
                    <!-- end col -->

                    <div class="col-xl-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#week1" role="tab">
                                            This Week
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#month1" role="tab">
                                            This Month
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#year1" role="tab">
                                            This Year
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content text-muted">
                                    <div class="tab-pane active" id="week1" role="tabpanel">
                                        <div class="d-flex">
                                            <div class="card card-animate card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            Completed Visits
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <span class="counter-value"
                                                                  data-target="{{ $completedWeek }}">0</span>
                                                        </h4>
                                                        <a href="{{route('admin.visit.completed')}}"
                                                           class="text-decoration-underline">See details</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card card-animate card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            All Visits
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <span class="counter-value"
                                                                  data-target="{{ $totalVisitsWeek }}">0</span>
                                                        </h4>
                                                        <a href="{{route('admin.visit.index')}}"
                                                           class="text-decoration-underline">See
                                                            Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="month1" role="tabpanel">
                                        <div class="d-flex">
                                            <div class="card card-animate card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            Completed Visits
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <span class="counter-value"
                                                                  data-target="{{ $completedMonth }}">0</span>
                                                        </h4>
                                                        <a href="{{route('admin.visit.completed')}}"
                                                           class="text-decoration-underline">See details</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card card-animate card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            All Visits
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <span class="counter-value"
                                                                  data-target="{{ $totalVisitsMonth }}">0</span>
                                                        </h4>
                                                        <a href="{{route('admin.visit.index')}}"
                                                           class="text-decoration-underline">See
                                                            Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="year1" role="tabpanel">
                                        <div class="d-flex">
                                            <div class="card card-animate card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            Completed Visits
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <span class="counter-value"
                                                                  data-target="{{ $completedYear }}">0</span>
                                                        </h4>
                                                        <a href="{{route('admin.visit.completed')}}"
                                                           class="text-decoration-underline">See details</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card card-animate card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            All Visits
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <span class="counter-value"
                                                                  data-target="{{ $totalVisitsYear }}">0</span>
                                                        </h4>
                                                        <a href="{{route('admin.visit.index')}}"
                                                           class="text-decoration-underline">See
                                                            Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div>
                </div>
                <!-- end row-->

            </div>
            <!-- end .h-100-->
        </div>
        <!-- end col -->
    </div>
@endsection
@section('script')
    <script !src="">
        $(document).ready(function () {
            sendToast('Welcome abord captain!', 'primary');
        });
    </script>
@endsection
