<?php

use App\Enums\InterestStatus;
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
        Schema::create('visit_interests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained(
                table: 'visits',
                indexName: 'interests_visit_id'
            )->cascadeOnDelete();
            $table->foreignId('user_id')->constrained(
                table: 'users',
                indexName: 'interests_user_id'
            )->cascadeOnDelete();
            $table->string('status')->default(InterestStatus::ACTIVE->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_interests');
    }
};
