@extends('user.master')
@section('title','Frequently Asked Questions')
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('contact-support') }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>Contact Support</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-500">Frequently Asked Questions</span>
    </div>
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800">Frequently Asked Questions</span>
    </div>
@endpush
@section('main')
<form method="post" id="faqForm">
    @csrf
    <section class="modern-card pt-4 sm:pt-6">
        <div class="space-y-6 visitorData">
            @if($resultData)
                @foreach($resultData as $row)
                    <div class="mainDiv bg-white rounded-xl border border-gray-200 p-3 sm:p-4 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4 sm:mb-6">
                        <div class="viewQuestion hidden"></div>
                        <div class="w-full flex flex-col gap-3 sm:gap-2 updateQuestion">
                            <div class="w-full flex flex-col gap-1">
                                <label class="block text-xs sm:text-sm font-medium text-gray-700">{{ $row['question'] }}</label>
                                <textarea name="answer[{{ $row['question'] }}][]"
                                          class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          rows="3"
                                          placeholder="Answer"></textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
</form>
@endsection
@section('script')
    <script !src="">
        let autoSaveTimer;

        $('form#faqForm').on('change input', 'input, textarea', function () {
            autoSaveForm();
        });

        function autoSaveForm(callback = null) {
            const form = document.getElementById('faqForm');
            const url = "{{ route('contact-support.faq.action') }}";
            const formData = new FormData(form);

            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(function () {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        sendToast(response.message);

                        // Run callback if provided
                        if (typeof callback === 'function') {
                            callback();
                        }
                    },
                    error: function (xhr) {
                        sendToast('Data save failed:' + xhr.responseText, "danger");
                    }
                });
            }, 2000);
        }

    </script>
@endsection