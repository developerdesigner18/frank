<?php

use App\Enums\VisitStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('unioqid')->unique()->nullable();
            $table->foreignId('branch_id')->constrained(
                table: 'branches',
                indexName: 'visits_branch_id'
            )->cascadeOnDelete();
            $table->foreignId('questionnaire_id')->constrained(
                table: 'questionnaires',
                indexName: 'visits_questionnaire_id'
            )->cascadeOnDelete();
            $table->foreignId('visitor_id')->nullable()->constrained(
                table: 'users',
                indexName: 'visits_visitor_id'
            )->cascadeOnDelete();
            $table->timestamp('start_datetime');
            $table->timestamp('end_datetime');
            $table->decimal('price', 10, 2);
            $table->decimal('expense_estimation_min', 10, 2);
            $table->decimal('expense_estimation_max', 10, 2);
            $table->text('description')->nullable();
            $table->string('status')->default(VisitStatus::PENDING->value);
            $table->tinyInteger('published')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
