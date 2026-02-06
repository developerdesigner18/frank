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
        Schema::create('company_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained(
                table: 'companies', indexName: 'company_user_company_id'
            )->cascadeOnDelete();
            $table->string('cuid')->nullable();
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('mobile_number')->nullable();
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default(\App\Enums\CompanyUserStatus::ACTIVE->value);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_users');
    }
};
