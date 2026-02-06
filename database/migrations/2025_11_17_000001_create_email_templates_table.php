<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('subject');
            $table->longText('body');
            $table->text('attachment_path')->nullable();
            $table->text('attachment_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('email_templates')->insert([
            [
                'type' => 'visitor_invitation',
                'slug' => 'visitor_invitation',
                'name' => 'Visitor Invitation',
                'subject' => 'You have been invited to {{app_name}}',
                'body' => "<h2>Hello {{recipient_name}}!</h2>
<p>You have been invited to join {{app_name}}.</p>
<p><a href=\"{{button_url}}\" style=\"background:#0073AF;color:#ffffff;padding:10px 18px;border-radius:999px;text-decoration:none;display:inline-block;\">{{cta_label}}</a></p>
<p>Need help? Reply to this email.</p>
<p>Thanks,<br>{{app_name}}</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'company_invitation',
                'slug' => 'company_invitation',
                'name' => 'Company User Invitation',
                'subject' => 'You have been invited to {{company_name}} on {{app_name}}',
                'body' => "<h2>Hello {{recipient_name}}!</h2>
<p>{{company_name}} has invited you to collaborate inside {{app_name}}.</p>
<p><a href=\"{{button_url}}\" style=\"background:#0073AF;color:#ffffff;padding:10px 18px;border-radius:999px;text-decoration:none;display:inline-block;\">{{cta_label}}</a></p>
<p>If you were not expecting this email please ignore it.</p>
<p>Regards,<br>{{company_name}} &amp; {{app_name}}</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};



