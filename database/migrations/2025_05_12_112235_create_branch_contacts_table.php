<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('branch_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained(
                table: 'branches', indexName: 'branch_contact_id'
            )->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('mobile_number');
            $table->string('status')->default(\App\Enums\BranchContactStatus::ACTIVE->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_contacts');
    }
};
