@extends('admin.master')
@section('title',' Visit Reports')
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('admin.company.branches.index',['companyId'=>$branch->company->company_id]) }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>{{ $branch->company->company_name }}</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-800">{{ $branch->branch_name }}</span>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-500">visit Reports</span>
    </div>
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">visit Reports</span>
    </div>
@endpush
@section('main')

    <section class="pt-4 sm:pt-6">
        <div class="flex flex-col md:flex-row items-center justify-end pb-6 gap-4">
            <div class="flex items-center justify-end gap-4 w-full md:w-auto">
                <div class="relative w-auto">
                    <select id="filter-sort_by"
                            class="filter-fields w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2 sm:py-2.5 pr-8 text-sm sm:text-base text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="desc">Most Recent</option>
                        <option value="asc">Oldest</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px] pointer-events-none"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                                d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-4 tableListData">
        </div>
    </section>

@endsection


@section('script')
    <script>
        var branchId = "{{ $branch->id }}";

        function tableListData() {
            var sort_by = $('#filter-sort_by').val();
            $.ajax({
                url: "{{ route("admin.company.branch.visit.report.list",["branchId" => $branch->id]) }}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "sort_by": sort_by,
                    "branchId": branchId,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    $('.tableListData').html(data.message)
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data.hasOwnProperty('message')) {
                        actionError(xhr, data.message)
                    } else {
                        actionError(xhr);
                    }
                }
            });
        }

        tableListData();

        $('.filter-fields').on('change', function (e) {
            tableListData();
        });

        $(document).ready(function () {
        });
    </script>
@endsection
