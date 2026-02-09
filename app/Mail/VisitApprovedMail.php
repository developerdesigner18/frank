<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class VisitApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $visit;
    public $recipientType; // 'admin' or 'visitor'
    public $pdfPath; // store file path
    protected $template;

    /**
     * Create a new message instance.
     */
    public function __construct($visit, $recipientType = 'visitor', $pdfPath)
    {
        $this->visit = $visit;
        $this->recipientType = $recipientType;
        $this->pdfPath = $pdfPath;

        // Load template based on recipient type
        $templateSlug = $this->recipientType === 'admin'
            ? 'visit_approved_admin'
            : 'visit_approved_visitor';

        $this->template = EmailTemplate::where('slug', $templateSlug)->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Use template subject if available, otherwise use default
        if ($this->template) {
            $subject = $this->template->renderSubject($this->context());
        } else {

            $subject = $this->recipientType === 'admin'
                ? "A Visit Was Approved — #{$this->visit->id}"
                : "Your Visit Has Been Approved — ".($this->visit->branch->branch_name ?? 'Visit');
        }

        return new Envelope(
            from: new Address('frank@mysteryvisits.nl', env('MAIL_FROM_NAME')),
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Use custom template if available
        if ($this->template) {
            return new Content(
                markdown: 'emails.custom-template',
                with: ['body' => $this->template->render($this->context())]
            );
        }

        // Fallback to existing views
        $view = $this->recipientType === 'admin'
            ? 'emails.visit_approved_admin'
            : 'emails.visit_approved_visitor';

        return new Content(
            markdown: $view,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        // Add PDF attachment if exists
        if ($this->pdfPath && file_exists($this->pdfPath)) {
            $attachments[] = Attachment::fromPath($this->pdfPath)
                ->as('visit-'.$this->visit->id.'.pdf')
                ->withMime('application/pdf');
        }

        // Add template attachment if exists
        if ($this->template && $this->template->hasAttachment()) {
            $name = $this->template->attachment_name ?: basename($this->template->attachment_path);
            $path = public_path($this->template->attachment_path);

            if (file_exists($path)) {
                $attachments[] = Attachment::fromPath($path)->as($name);
            }
        }

        return $attachments;
    }

    /**
     * Build the context for template rendering.
     */
    protected function context(): array
    {
        $locale = ($this->recipientType === 'admin') ? 'nl' : app()->getLocale();
        $expenseEstimation = currency_icon() . $this->visit->expense_estimation_min . ' - ' .
            currency_icon() . $this->visit->expense_estimation_max;
        return [
            '{{visit_id}}' => $this->visit->id,

            '{{visitor_name}}' =>trim($this->visit->visitor->first_name ?? ''),
//                trim(($this->visit->visitor->first_name ?? '') . ' ' . ($this->visit->visitor->last_name ?? '')),

            '{{visitor_email}}' => $this->visit->visitor->email ?? '',
            '{{visitor_phone}}' => $this->visit->visitor->mobile_number ?? '',

            '{{company_name}}' => $this->visit->branch->company->company_name ?? '',
            '{{branch_name}}' => $this->visit->branch->branch_name ?? '',
            '{{branch_address}}' => $this->visit->branch->address_1 ?? '',
            '{{branch_zipcode}}' => $this->visit->branch->postal_code ?? '',
            '{{branch_place}}' => $this->visit->branch->locality ?? '',

            '{{start_datetime}}' => format_visit_date($this->visit->start_datetime, 'd F', $locale),
            '{{end_datetime}}' => format_visit_date($this->visit->end_datetime, 'd F Y', $locale),
            '{{visit_date}}' => format_visit_date_range($this->visit->start_datetime, $this->visit->end_datetime, $locale),

            '{{price}}' => $this->visit->price ?? '',
            '{{expense_estimation}}' => $expenseEstimation,

            '{{description}}' => $this->visit->description ?? '',

            '{{status}}' => 'Approved',
            '{{approved_by}}' => $this->visit->approved_by_name ?? 'Admin',
            '{{approver_name}}' => $this->visit->approved_by_name ?? 'Admin',
            '{{notes}}' => $this->visit->admin_notes ?? '-',
        ];
    }}
