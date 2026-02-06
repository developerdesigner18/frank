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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('branch_uid')->nullable();
            $table->foreignId('company_id')->nullable()->constrained(
                table: 'companies', indexName: 'branch_company_id'
            )->cascadeOnDelete();
            $table->string('branch_name');
            $table->string('image')->nullable();
            $table->text('address_1')->nullable();
            $table->string('locality')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('upselling_input_url')->nullable();
            $table->text('upselling_report_url')->nullable();
            $table->text('input_url_46')->nullable();
            $table->text('report_url_46')->nullable();
            $table->string('route')->nullable();
            $table->string('status')->default(\App\Enums\BranchStatus::ACTIVE->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
