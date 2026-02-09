<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class NewVisitMail extends Mailable
{
    use Queueable, SerializesModels;

    public $visit;
    public $visitor_name;
    protected $template;

    /**
     * Create a new message instance.
     */
    public function __construct(Visit $visit,$visitor_name)
    {
        $this->visit = $visit;
$this->visitor_name=$visitor_name;
        // Load the new_visit template
        $this->template = EmailTemplate::where('slug', 'new_visit')->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->template
            ? $this->template->renderSubject($this->context())
            : "New Visit Available - " . ($this->visit->branch->branch_name ?? 'Visit');

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

        // Fallback to a default view (you can create this later if needed)
        return new Content(
            markdown: 'emails.new-visit',
            with: $this->bladeContext()
        );
    }

    protected function bladeContext(): array
    {
        $ctx = [];
        foreach ($this->context() as $key => $value) {
            $cleanKey = str_replace(['{{', '}}'], '', $key);
            $ctx[$cleanKey] = $value;
        }
        return $ctx;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

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
        $locale = app()->getLocale();
        $expenseEstimation = currency_icon() . $this->visit->expense_estimation_min . ' - ' .
                           currency_icon() . $this->visit->expense_estimation_max;

        return [

            '{{visit_id}}' => $this->visit->id,
            '{{visitor_name}}' => $this->visitor_name,
            '{{branch_name}}' => $this->visit->branch->branch_name ?? 'N/A',
            '{{branch_address}}' => $this->visit->branch->address_1 ?? 'N/A',
            '{{branch_place}}' => $this->visit->branch->locality ?? 'N/A',

            '{{branch_zipcode}}' => $this->visit->branch->postal_code ?? 'N/A',
            '{{company_name}}' => $this->visit->branch->company->company_name ?? 'N/A',
            '{{questionnaire_name}}' => $this->visit->questionnaire->name ?? 'N/A',
            '{{start_datetime}}' => format_visit_date($this->visit->start_datetime, 'd F', $locale),
            '{{end_datetime}}' => format_visit_date($this->visit->end_datetime, 'd F Y', $locale),
            '{{visit_period}}' => format_visit_date_range($this->visit->start_datetime, $this->visit->end_datetime, $locale),
            '{{price}}' => currency_icon() . $this->visit->price,
            '{{expense_estimation}}' => $expenseEstimation,
            '{{description}}' => $this->visit->description ?? 'No description provided.',
            '{{cta_label}}' => 'View Available Visits',
            '{{button_url}}' => route('visit.available'),
        ];
    }
}
