<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class EmailTemplatePreviewMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected EmailTemplate $template,
        protected array $context = []
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('frank@mysteryvisits.nl', env('MAIL_FROM_NAME')),
            subject: $this->template->renderSubject($this->context),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.custom-template',
            with: [
                'body' => $this->template->render($this->context),
            ]
        );
    }

    public function attachments(): array
    {
        if (!$this->template->hasAttachment()) {
            return [];
        }

        $name = $this->template->attachment_name ?: basename($this->template->attachment_path);

        $path = public_path($this->template->attachment_path);

        if (!file_exists($path)) {
            return [];
        }

        return [
            Attachment::fromPath($path)->as($name),
        ];
    }
}



