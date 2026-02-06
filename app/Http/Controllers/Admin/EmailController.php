<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Mail\EmailTemplatePreviewMail;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $templates = EmailTemplate::get();

        $placeholders = EmailTemplate::placeholderDescriptions();

        return view('admin.email.index', compact('templates', 'placeholders'));
    }

    public function create()
    {
        $placeholders = EmailTemplate::placeholderDescriptions();

        return view('admin.email.create', compact( 'placeholders'));
    }

    public function update(Request $request, EmailTemplate $template)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'remove_attachment' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $data = [
            'subject' => $request->subject,
            'body' => $request->body,
        ];
        if ($request->boolean('remove_attachment') && $template->attachment_path) {
            // Remove the old file
            if (file_exists(public_path($template->attachment_path))) {
                @unlink(public_path($template->attachment_path));
            }
            $data['attachment_path'] = null;
            $data['attachment_name'] = null;
        }

        if ($request->hasFile('attachment')) {
            // Remove the old file if exists
            if ($template->attachment_path && file_exists(public_path($template->attachment_path))) {
                @unlink(public_path($template->attachment_path));
            }

            if (!File::exists(public_path(EMAIL_TEMPLATE_ATTACHMENTS_PATH))) {
                File::makeDirectory(public_path(EMAIL_TEMPLATE_ATTACHMENTS_PATH), 0755, true);
            }

            $file = $request->file('attachment');
            // Use uploadFile helper
            $fileName = uploadFile($file, EMAIL_TEMPLATE_ATTACHMENTS_PATH, 'attachment_');
            $data['attachment_path'] = EMAIL_TEMPLATE_ATTACHMENTS_PATH . $fileName;
            $data['attachment_name'] = $file->getClientOriginalName();
        }

        $template->update($data);

        return $this->sendSuccess('Template updated successfully.');
    }

    public function sendTest(Request $request, EmailTemplate $template)
    {
        $validator = Validator::make($request->all(), [
            'test_email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $context = $this->sampleContext($template->slug);
        Mail::to($request->test_email)->send(new EmailTemplatePreviewMail($template, $context));

        return $this->sendSuccess('Preview email sent successfully!');
    }

    protected function sampleContext(string $slug): array
    {
        $defaults = [
            '{{recipient_name}}' => 'Preview User',
            '{{recipient_email}}' => 'preview@example.com',
            '{{button_url}}' => config('app.url') . '/preview-link',
            '{{cta_label}}' => 'Preview Button',
            '{{company_name}}' => 'Acme Inc.',
        ];

        if ($slug === 'visitor_invitation') {
            $defaults['{{company_name}}'] = config('app.name');
        }

        return $defaults;
    }
//    public function upload(Request $request)
//    {
//        if ($request->hasFile('upload')) {
//
//            $file = $request->file('upload'); // correct key
//            $fileName = uploadFile($file, EMAIL_TEMPLATE_IMG_ATTACHMENTS_PATH, 'ckeditor_');
//
//            return response()->json([
//                'url' => asset(EMAIL_TEMPLATE_IMG_ATTACHMENTS_PATH . $fileName)
//            ]);
//        }
//
//        return response()->json(['error' => 'No file uploaded'], 400);
//    }
}
