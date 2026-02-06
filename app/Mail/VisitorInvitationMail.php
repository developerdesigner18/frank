<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VisitorInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cryptMail;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $cryptMail,
        protected ?EmailTemplate $template = null,
        protected ?User $visitor = null
    ) {
        $this->cryptMail = $cryptMail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->template
            ? $this->template->renderSubject($this->context())
            : 'You have been invited to ' . config('app.name');

        return new Envelope(
            from: new Address('frank@mysteryvisits.nl', env('MAIL_FROM_NAME')),

            subject: $subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->template) {
            return new Content(
                markdown: 'emails.custom-template',
                with: ['body' => $this->template->render($this->context())]
            );
        }

        return new Content(
            markdown: 'emails.visitor-invitation',
            with: ['cryptMail' => $this->cryptMail]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (!$this->template || !$this->template->hasAttachment()) {
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

    protected function context(): array
    {
        $name = trim(collect([$this->visitor?->first_name, $this->visitor?->last_name])->filter()->implode(' '));

        return [
            '{{recipient_name}}' => $name ?: 'visitor',
            '{{recipient_email}}' => $this->visitor?->email,
            '{{button_url}}' => route('check-invitation', ['cryptToken' => $this->cryptMail]),
            '{{cta_label}}' => __('Accept invitation'),
        ];
    }
}
