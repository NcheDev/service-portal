<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('institution_applicants', function (Blueprint $table) {
            if (Schema::hasColumn('institution_applicants', 'dob')) {
                $table->dropColumn('dob');
            }
            if (Schema::hasColumn('institution_applicants', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('institution_applicants', 'title')) {
                $table->dropColumn('title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('institution_applicants', function (Blueprint $table) {
            // Add columns back if migration is rolled back
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('title')->nullable();
        });
    }
};
