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

        Schema::table('admins', function (Blueprint $table) {
            $table->index(['name']);
            $table->index(['email']);
            $table->index(['password', 'created_at']);
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->index(['company_id', 'branch_name']); // likely queried together
            $table->index(['locality']);                  // separate for filtering
            $table->index(['status']);                    // commonly filtered
            $table->index(['created_at']);                // for sorting/filtering
        });

        Schema::table('branch_contacts', function (Blueprint $table) {
            $table->index(['branch_id']);                 // relation lookup
            $table->index(['email']);                     // usually searched
            $table->index(['mobile_number']);             // same as above
            $table->index(['status']);                    // for filtering
            $table->index(['created_at']);                // for sorting
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->index(['company_name']);              // for search
            $table->index(['status']);                    // filtering
            $table->index(['created_at']);                // sorting
        });

        Schema::table('company_users', function (Blueprint $table) {
            $table->index(['company_id']);                // foreign key
            $table->index(['email']);                     // for login/lookup
            $table->index(['status']);                    // filtering
            $table->index(['created_at']);                // sorting
        });

        Schema::table('questionnaires', function (Blueprint $table) {
            $table->index(['name']);                      // lookup
            $table->index(['status']);                    // filtering
            $table->index(['created_at']);                // sorting
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index(['email']);                     // login
            $table->index(['mobile_number']);             // search
            $table->index(['status']);                    // filter
            $table->index(['created_at']);                // sort
        });

        Schema::table('visits', function (Blueprint $table) {
            $table->index(['branch_id']);                 // lookup
            $table->index(['questionnaire_id']);          // lookup
            $table->index(['visitor_id']);                // lookup
            $table->index(['status']);                    // filtering
            $table->index(['created_at']);                // sorting
        });

        Schema::table('visit_assignments', function (Blueprint $table) {
            $table->index(['visit_id']);                  // lookup
            $table->index(['user_id']);                   // lookup
            $table->index(['status']);                    // filtering
            $table->index(['created_at']);                // sorting
        });

        Schema::table('visit_interests', function (Blueprint $table) {
            $table->index(['visit_id']);                  // lookup
            $table->index(['user_id']);                   // lookup
            $table->index(['status']);                    // filtering
            $table->index(['created_at']);                // sorting
        });

        Schema::table('visit_reports', function (Blueprint $table) {
            $table->index(['visit_id']);                  // lookup
            $table->index(['user_id']);                   // lookup
            $table->index(['status']);                    // filtering
            $table->index(['created_at']);                // sorting
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            //
        });
        Schema::table('branches', function (Blueprint $table) {
            //
        });
        Schema::table('branch_contacts', function (Blueprint $table) {
            //
        });
        Schema::table('companies', function (Blueprint $table) {
            //
        });
        Schema::table('company_users', function (Blueprint $table) {
            //
        });
        Schema::table('questionnaires', function (Blueprint $table) {
            //
        });
        Schema::table('users', function (Blueprint $table) {
            //
        });
        Schema::table('visits', function (Blueprint $table) {
            //
        });
        Schema::table('visit_assignments', function (Blueprint $table) {
            //
        });
        Schema::table('visit_interests', function (Blueprint $table) {
            //
        });
        Schema::table('visit_reports', function (Blueprint $table) {
            //
        });
    }
};
