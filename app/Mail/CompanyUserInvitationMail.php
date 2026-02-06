<?php

namespace App\Mail;

use App\Models\CompanyUser;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class CompanyUserInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cryptMail;
    public $company;
    public $template;

    /**
     * Create a new message instance.
     */
    public function __construct(
        $cryptMail,
        $company,
        protected ?CompanyUser $user = null
    ) {
        $this->cryptMail = $cryptMail;
        $this->company = $company;

        // Load the company_invitation template if not provided
        $this->template = EmailTemplate::where('slug', 'company_invitation')->first();
    }

    /**
     * Get the message envelope.
     */
//    public function envelope(): Envelope
//    {
//        $subject = $this->template
//            ? $this->template->renderSubject($this->context())
//            : 'You have been invited to ' . ucfirst($this->company->company_name);
//
//        return new Envelope(
//            subject: $subject,
//        );
//    }
    public function envelope(): Envelope
    {
        $subject = $this->template
            ? $this->template->renderSubject($this->context())
            : 'You have been invited to ' . ucfirst($this->company->company_name);

        return new Envelope(
            from: new Address('frank@mysteryvisits.nl', 'MysteryVisits.nl | Frank Laumen'),
            subject: $subject,
        );
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

        // Fallback to old view if template not found
        return new Content(
            markdown: 'emails.company-user-invitation',
            with: ['cryptMail' => $this->cryptMail, 'company' => $this->company]
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

        $path = public_path($this->template->attachment_path);

        if (!file_exists($path)) {
            return [];
        }

        $name = $this->template->attachment_name ?: basename($this->template->attachment_path);

        return [
            Attachment::fromPath($path)->as($name),
        ];
    }

    /**
     * Get the context for template rendering.
     */
    protected function context(): array
    {
        return [
            '{{company_name}}' => $this->company->company_name ?? 'Company',
            '{{recipient_name}}' => $this->user?->name ?: 'there',
            '{{recipient_email}}' => $this->user?->email ?? '',
            '{{button_url}}' => route('company.check-invitation', ['cryptToken' => $this->cryptMail]),
            '{{cta_label}}' => __('Accept Invitation'),
        ];
    }
}
