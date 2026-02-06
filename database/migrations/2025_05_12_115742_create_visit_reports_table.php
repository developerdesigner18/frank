<?php

use App\Enums\ReportStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visit_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_uid')->unique()->nullable();
            $table->foreignId('visit_id')->constrained(
                table: 'visits',
                indexName: 'reports_visit_id'
            )->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained(
                table: 'users',
                indexName: 'reports_user_id'
            )->cascadeOnDelete();
            $table->json('response_data');
            $table->json('photos')->nullable();
            $table->decimal('total_score', 5, 2)->nullable();
            $table->string('status')->default(ReportStatus::DRAFT->value);
            $table->string('report_pdf_url')->nullable();
            $table->text('admin_notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_reports');
    }
};
