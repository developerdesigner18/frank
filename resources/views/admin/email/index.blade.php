@extends('admin.master')
@section('title','Emails')
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="javascript:void(0);"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>Emails</span>
        </a>
    </div>
@endpush

@section('main')
    <section class="pt-4 sm:pt-6 space-y-6">
        <div class="modern-card">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                <div class="flex flex-col gap-3">
                    <h2 class="text-lg font-semibold text-gray-800">Email Management</h2>
                    <p class="text-sm text-gray-600">
                        Create consistent messaging for visitors and company users. Update the subject &amp; body,
                        or send yourself a preview—no activity logs, just focused template management. You can use any
                        of the
                        placeholders listed inside each template to inject dynamic values.
                    </p>
                </div>
{{--                <a href="{{ route('admin.emails.create') }}"--}}
{{--                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-[#0073AF] rounded-lg hover:bg-[#00689D] transition-all duration-300 whitespace-nowrap">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"--}}
{{--                         stroke="currentColor" stroke-width="2">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>--}}
{{--                    </svg>--}}
{{--                    Create Template--}}
{{--                </a>--}}
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            @foreach($templates as $template)
                <div class="modern-card border border-gray-100 shadow-sm">
                    <div class="space-y-6">
                        <form class="template-form border border-gray-100 rounded-2xl p-4 sm:p-5 space-y-4"
                              data-update-url="{{ route('admin.emails.update', $template) }}"
                              data-test-url="{{ route('admin.emails.send-test', $template) }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-base font-semibold text-gray-800">{{ $template->name }}</p>
                                </div>
                                <p class="text-xs text-gray-500">Last
                                    updated {{ $template->updated_at->diffForHumans() }}</p>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-medium text-gray-700">Subject</label>
                                <input type="text" name="subject" value="{{ $template->subject }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                       placeholder="Email subject">
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-medium text-gray-700 flex items-center justify-between">
                                    Body
                                    <span class="text-xs text-gray-400">HTML and Markdown supported</span>
                                </label>
                                <textarea name="body" rows="8"
                                          class="ckeditor w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm font-mono">{{ $template->body }}</textarea>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-medium text-gray-700 flex items-center justify-between">
                                    Attachment
                                    <span class="text-xs text-gray-400">Optional · up to 5 MB</span>
                                </label>
                                <input type="file"
                                       name="attachment"
                                       class="attachment-input w-full text-sm text-gray-700 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0073AF]/10 file:text-[#0073AF] border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <input type="hidden" name="remove_attachment" value="0">
                                <p class="text-xs text-gray-500">Supported: PDF, Word, JPG, PNG.</p>

                                @if($template->hasAttachment())
                                    @php
                                        $attachmentUrl = $template->attachment_path;
                                        $attachmentName = $template->attachment_name ?? basename($template->attachment_path);
                                    @endphp
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 bg-gray-50 px-3 py-2 rounded-lg border border-gray-100">
                                        <div class="flex items-center gap-2 text-sm current-attachment">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#0073AF]"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M9 17V7a3 3 0 0 1 6 0v10a4 4 0 1 1-8 0V7"/>
                                            </svg>
                                            <a href="{{ $attachmentUrl }}" target="_blank"
                                               class="text-[#0073AF] hover:underline">{{ $attachmentName }}</a>
                                        </div>
                                        <button type="button"
                                                class="remove-attachment-btn text-xs font-semibold text-red-600 hover:text-red-700">
                                            Remove
                                        </button>
                                    </div>
                                    <p class="attachment-remove-note hidden text-xs text-amber-600 font-medium">
                                        Attachment will be removed when you save.</p>
                                @endif
                            </div>


                            @if(isset($placeholders[$template->slug]))
                                <div class="flex flex-col gap-2">
                                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-[0.3em]">
                                        Placeholders</p>
                                    <div class="space-y-1.5">
                                        @foreach($placeholders[$template->slug] as $token => $description)
                                            <div class="flex items-start gap-2">
                                                <span class="text-[11px] font-semibold bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $token }}</span>
                                                <p class="text-sm text-gray-500">{{ $description }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="flex flex-col gap-3">
                                <div class="flex flex-col gap-1">
                                    <label class="text-xs font-medium text-gray-600 uppercase tracking-[0.25em]">
                                        Send preview
                                    </label>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <input type="email" name="test_email" placeholder="you@example.com"
                                               class="test-email w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                        <button type="button"
                                                class="send-test-btn px-4 py-2.5 text-sm font-semibold text-[#0073AF] bg-[#0073AF]/10 rounded-lg hover:bg-[#0073AF]/20 transition-all duration-300">
                                            Send test
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500">We will send a sample message using placeholder
                                        data.</p>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between pt-2">
                                <button type="submit"
                                        class="save-template-btn inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-[#0073AF] rounded-lg hover:bg-[#00689D] transition-all duration-300">
                                    Save template
                                </button>
                                <p class="text-xs text-gray-500">No logs stored – updates override the active template
                                    immediately.</p>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('script')
{{--    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/super-build/ckeditor.js"></script>--}}
    <script>
        document.querySelectorAll('.ckeditor').forEach(textarea => {
            ClassicEditor.create(textarea, {
                extraPlugins: [ MyCustomUploadAdapterPlugin ],
                toolbar: [
                    'undo', 'redo', '|',
                    'heading', '|',
                    'bold', 'italic', '|',
                    'link', 'blockQuote', '|',
                    'numberedList', 'bulletedList', '|',
                    'insertTable', '|',
                    'imageUpload'
                ],
                image: {
                    toolbar: [
                        'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                        '|',
                        'imageTextAlternative'
                    ],
                    styles: ['alignLeft', 'alignCenter', 'alignRight'],
                    captions: {
                        toggleVisibility: true
                    }
                }
            })
                .then(editor => console.log("Editor ready:", editor))
                .catch(error => console.error("Editor error:", error));
        });


        // Base64 Upload Adapter Plugin
        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file
                    .then(file => {
                        return new Promise((resolve, reject) => {
                            const reader = new FileReader();
                            reader.onload = () => resolve({ default: reader.result });
                            reader.onerror = error => reject(error);
                            reader.readAsDataURL(file);
                        });
                    });
            }

            abort() {
                // Optionally implement cancel logic
            }
        }

        $(function () {
            $(document).on('submit', '.template-form', function (e) {
                e.preventDefault();
                const form = $(this);
                const url = form.data('update-url');
                const submitBtn = form.find('.save-template-btn');
                const formData = new FormData(this);

                submitBtn.prop('disabled', true).addClass('opacity-70');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        sendToast(response.message || 'Template updated successfully');
                    },
                    error: function (xhr) {
                        const message = xhr.responseJSON?.message || 'Unable to save template';
                        sendToast(message, 'danger');
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).removeClass('opacity-70');
                    }
                });
            });

            $(document).on('click', '.send-test-btn', function () {
                const form = $(this).closest('.template-form');
                const emailInput = form.find('.test-email');
                const email = emailInput.val();
                const url = form.data('test-url');
                const button = $(this);

                if (!email) {
                    sendToast('Enter an email address for the preview', 'danger');
                    return;
                }

                button.prop('disabled', true).addClass('opacity-70');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        test_email: email,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        sendToast(response.message || 'Preview email sent!');
                    },
                    error: function (xhr) {
                        const message = xhr.responseJSON?.message || 'Unable to send preview';
                        sendToast(message, 'danger');
                    },
                    complete: function () {
                        button.prop('disabled', false).removeClass('opacity-70');
                    }
                });
            });

            $(document).on('click', '.remove-attachment-btn', function () {
                const form = $(this).closest('.template-form');
                form.find('input[name="remove_attachment"]').val('1');
                $(this).addClass('hidden');
                form.find('.current-attachment').addClass('line-through text-gray-400');
                form.find('.attachment-remove-note').removeClass('hidden');
            });

            $(document).on('change', '.attachment-input', function () {
                const form = $(this).closest('.template-form');
                form.find('input[name="remove_attachment"]').val('0');
                form.find('.attachment-remove-note').addClass('hidden');
                form.find('.current-attachment').removeClass('line-through text-gray-400');
                form.find('.remove-attachment-btn').removeClass('hidden');
            });
        });
    </script>
@endsection
