<?php

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
        Schema::table('visit_reports', function (Blueprint $table) {
            $table->boolean('price_paid')->default(false)->after('report_pdf_url');
            $table->boolean('reimbursement_paid')->default(false)->after('price_paid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visit_reports', function (Blueprint $table) {
            $table->dropColumn(['price_paid', 'reimbursement_paid']);
        });
    }
};
