<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('email_templates')->updateOrInsert(
        // WHERE condition (must match the UNIQUE key)
            ['slug' => 'new_visit'],

            // Values to insert or update
            [
                'type' => 'new_visit',
                'name' => 'New Visit Created',
                'subject' => 'New Visit Available - {{branch_name}}',
                'body' => "<h2>New Visit Opportunity!</h2>
<p>A new visit has been created and is now available.</p>

<h3>Visit Details:</h3>
<ul>
    <li><strong>Branch:</strong> {{branch_name}}</li>
    <li><strong>Company:</strong> {{company_name}}</li>
    <li><strong>Questionnaire:</strong> {{questionnaire_name}}</li>
    <li><strong>Start Date:</strong> {{start_datetime}}</li>
    <li><strong>End Date:</strong> {{end_datetime}}</li>
    <li><strong>Price:</strong> {{price}}</li>
    <li><strong>Expense Estimate:</strong> {{expense_estimation}}</li>
</ul>

<p>{{description}}</p>

<p><a href=\"{{button_url}}\" style=\"background:#0073AF;color:#ffffff;padding:10px 18px;border-radius:999px;text-decoration:none;display:inline-block;\">{{cta_label}}</a></p>

<p>This is a great opportunity to participate in a mystery visit!</p>

<p>Best regards,<br>{{app_name}}</p>",
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('email_templates')->where('slug', 'new_visit')->delete();
    }
};
