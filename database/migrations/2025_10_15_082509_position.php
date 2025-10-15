<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_information', function (Blueprint $table) {
            $table->string('institution_position')->nullable()->after('institution_name');
        });
    }

    public function down(): void
    {
        Schema::table('personal_information', function (Blueprint $table) {
            $table->dropColumn('institution_position');
        });
    }
};
