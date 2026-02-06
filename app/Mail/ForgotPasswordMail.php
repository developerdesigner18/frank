<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected mixed $user,
        string $resetLink,
        $template = 'reset_password'
    ) {
        $this->resetLink = $resetLink;

        // Load template if not provided
        $this->template = EmailTemplate::where('slug', 'reset_password')->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->template
            ? $this->template->renderSubject($this->context())
            : 'Reset Password Request';

        return new Envelope(subject: $subject);
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
            markdown: 'emails.reset-password',
            with: ['user' => $this->user, 'resetLink' => $this->resetLink]
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

    /**
     * Build the context for template rendering.
     */
    protected function context(): array
    {
        $userName = trim(collect([$this->user->first_name, $this->user->last_name])->filter()->implode(' '));

        return [
            '{{user_name}}' => $userName ?: ($this->user->name??'User'),
            '{{user_email}}' => $this->user->email,
            '{{reset_link}}' => $this->resetLink,
            '{{button_url}}' => $this->resetLink,
            '{{cta_label}}' => __('Reset Password'),
            '{{expiry_time}}' => '60',
        ];
    }
}
