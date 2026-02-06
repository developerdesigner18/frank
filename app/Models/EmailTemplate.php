<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'slug',
        'name',
        'subject',
        'body',
        'attachment_path',
        'attachment_name',
    ];

    public function hasAttachment(): bool
    {
        return !empty($this->attachment_path);
    }

    /**
     * Render the template body with the provided context.
     */
    public function render(array $context = []): string
    {
        $tokens = array_merge($this->defaultTokens(), $context);

        return str_replace(array_keys($tokens), array_values($tokens), $this->body);
    }

    /**
     * Render the template subject with the provided context.
     */
    public function renderSubject(array $context = []): string
    {
        $tokens = array_merge($this->defaultTokens(), $context);

        return str_replace(array_keys($tokens), array_values($tokens), $this->subject);
    }

    /**
     * Default tokens available for every template.
     */
    protected function defaultTokens(): array
    {
        return [
            '{{app_name}}' => config('app.name'),
            '{{current_year}}' => now()->year,
        ];
    }

    /**
     * Placeholder descriptions for the UI.
     */
    public static function placeholderDescriptions(): array
    {
        return [
            'visitor_invitation' => [
                '{{app_name}}' => trans_message('placeholder_app_name'),
                '{{current_year}}' => trans_message('placeholder_current_year'),
                '{{recipient_name}}' => trans_message('placeholder_recipient_name'),
                '{{recipient_email}}' => trans_message('placeholder_recipient_email'),
                '{{button_url}}' => trans_message('placeholder_button_url'),
                '{{cta_label}}' => trans_message('placeholder_cta_label'),
            ],
            'company_invitation' => [
                '{{app_name}}' => trans_message('placeholder_app_name'),
                '{{current_year}}' => trans_message('placeholder_current_year'),
                '{{company_name}}' => trans_message('placeholder_inviting_company'),
                '{{recipient_name}}' => trans_message('placeholder_company_user_name'),
                '{{recipient_email}}' => trans_message('placeholder_company_user_email'),
                '{{button_url}}' => trans_message('placeholder_button_url'),
                '{{cta_label}}' => trans_message('placeholder_cta_label'),
            ],
            'visit_approved_visitor' => [
                '{{app_name}}' => trans_message('placeholder_app_name'),
                '{{visitor_name}}' => trans_message('placeholder_visitor_name'),
                '{{company_name}}' => trans_message('placeholder_company_name'),
                '{{branch_name}}' => trans_message('placeholder_branch_name'),
                '{{visit_date}}' => trans_message('placeholder_visit_date'),
                // '{{additional_message}}' => 'Additional message',
                // '{{cta_label}}' => 'Button label',
                // '{{button_url}}' => 'Button URL',
            ],
            'visit_approved_admin' => [
                '{{app_name}}' => trans_message('placeholder_app_name'),
                '{{approved_by}}' => trans_message('placeholder_approved_by'),
                '{{visitor_name}}' => trans_message('placeholder_visitor_name'),
                '{{visitor_email}}' => trans_message('placeholder_visitor_email'),
                '{{company_name}}' => trans_message('placeholder_company_name'),
                '{{branch_name}}' => trans_message('placeholder_branch_name'),
                '{{visit_date}}' => trans_message('placeholder_visit_date'),
                // '{{cta_label}}' => 'Button label',
                // '{{button_url}}' => 'Button URL',
                '{{notes}}' => trans_message('placeholder_notes'),
            ],
            'reset_password' => [
                '{{app_name}}' => trans_message('placeholder_app_name'),
                '{{user_name}}' => trans_message('placeholder_user_name'),
                '{{expiry_time}}' => trans_message('placeholder_expiry_time'),
                '{{cta_label}}' => trans_message('placeholder_button_label'),
                '{{button_url}}' => trans_message('placeholder_reset_link'),
            ],
            'new_visit' => [
                '{{app_name}}' => trans_message('placeholder_app_name'),
                '{{visitor_name}}' => trans_message('placeholder_visitor_name'),
                '{{current_year}}' => trans_message('placeholder_current_year'),
                '{{branch_name}}' => trans_message('placeholder_branch_name'),
                '{{branch_address}}' => trans_message('placeholder_branch_address'),
                '{{branch_place}}'=> trans_message('placeholder_branch_place'),
                '{{branch_zipcode}}' => trans_message('placeholder_branch_zipcode'),
                '{{company_name}}' => trans_message('placeholder_company_name'),
                '{{questionnaire_name}}' => trans_message('placeholder_questionnaire_name'),
                '{{start_datetime}}' => trans_message('placeholder_start_datetime'),
                '{{end_datetime}}' => trans_message('placeholder_end_datetime'),
                '{{price}}' => trans_message('placeholder_price'),
                '{{expense_estimation}}' => trans_message('placeholder_expense_estimation'),
                '{{description}}' => trans_message('placeholder_description'),
                '{{cta_label}}' => trans_message('placeholder_view_visit'),
                '{{button_url}}' => trans_message('visit_details_url'),
            ],
        ];
    }
}
