<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('institution_applicants', function (Blueprint $table) {
            if (Schema::hasColumn('institution_applicants', 'email')) {
                $table->dropColumn('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('institution_applicants', function (Blueprint $table) {
            // Restore the column if rollback happens
            $table->string('email')->unique()->nullable();
        });
    }
};
