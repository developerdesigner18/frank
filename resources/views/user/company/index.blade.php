@extends('user.master')
@section('title', trans_message('companies'))
@push('navbar')
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">{{ trans_message('companies') }}</span>
    </div>
@endpush
@section('main')
    <section class="pt-4 sm:pt-6">
        <div class="flex flex-col md:flex-row items-center justify-end pb-6 gap-4">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative w-full md:w-auto">
                    <select id="filter-sort_by" class="filter-fields w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2 sm:py-2.5 pr-8 text-sm sm:text-base text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
{{--                        <option value="">{{ trans_message('sort_by') }}</option>--}}
                        <option value="id_desc">{{ trans_message('most_recent') }}</option>
                        <option value="id_asc">{{ trans_message('oldest') }}</option>

                        <option value="name_desc">{{ trans_message('name_desc') }}</option>
                        <option value="name_asc">{{ trans_message('name_asc') }}</option>
                        <option value="name_desc">{{ trans_message('name_desc') }}</option>
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
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 companyList">
            <!-- Company Card -->

        </div>
    </section>
@endsection

@section('script')
    <script !src="">

        function companyList(){
            var sort_by = $('#filter-sort_by').val();

            $.ajax({
                url: "{{route('company.list')}}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "sort_by": sort_by,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    $('.companyList').html(data.message)
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
        companyList();

        $(document).ready(function (){
            $('.filter-fields').on('change', function (e) {
                companyList();
            });
        });

    </script>
@endsection
