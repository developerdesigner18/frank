@extends('admin.master')
@section('title','Create Emails')
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="javascript:void(0);"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>Create Emails</span>
        </a>
    </div>
@endpush
@section('main')
    <section class="pt-4 sm:pt-6 space-y-6">
        <div class="modern-card border border-gray-100 shadow-sm">
            <div class="space-y-6">
                <form class="template-form border border-gray-100 rounded-2xl p-4 sm:p-5 space-y-4"
                      enctype="multipart/form-data">
                    @csrf
                    <select name="type"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <option value="">Select</option>
                        @if($placeholders)
                            @foreach($placeholders as $template_type => $placeholder)
                                <option value="{{ $template_type }}">{{ str_replace('_',' ',$template_type) }}</option>
                            @endforeach
                        @endif
                    </select>
                    <div class="space-y-4 template-data">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-base font-semibold text-gray-800 template-name"></p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-medium text-gray-700">Subject</label>
                            <input type="text" name="subject" value=""
                                   class="template-subject w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   placeholder="Email subject">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center justify-between">
                                Body
                                <span class="text-xs text-gray-400">HTML and Markdown supported</span>
                            </label>
                            <textarea name="body" rows="8"
                                      class="ckeditor w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm font-mono template-body"></textarea>
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
                        </div>

                        <div class="flex flex-col gap-2">
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-[0.3em]">Placeholders</p>
                            <div class="space-y-1.5">
                                {{--                        @foreach($placeholders[$template->slug] as $token => $description)--}}
                                {{--                            <div class="flex items-start gap-2">--}}
                                {{--                                <span class="text-[11px] font-semibold bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $token }}</span>--}}
                                {{--                                <p class="text-sm text-gray-500">{{ $description }}</p>--}}
                                {{--                            </div>--}}
                                {{--                        @endforeach--}}
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
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        const editorOptions = {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'underline', '|',
                'bulletedList', 'numberedList', '|',
                'link', 'blockQuote', '|',
                'undo', 'redo'
            ],
            placeholder: "Start typing...",
            height: '500px'
        };

        document.querySelectorAll('.ckeditor').forEach((el) => {
            ClassicEditor
                .create(el, editorOptions)
                .then(editor => {
                    console.log("Editor loaded:", editor);
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endsection
