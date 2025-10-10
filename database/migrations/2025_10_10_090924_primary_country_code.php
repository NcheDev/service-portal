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
        Schema::table('personal_information', function (Blueprint $table) {
            $table->string('primary_country_code', 5)->default('+265')->after('primary_phone');
            $table->string('secondary_country_code', 5)->nullable()->after('secondary_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_information', function (Blueprint $table) {
            $table->dropColumn(['primary_country_code', 'secondary_country_code']);
        });
    }
};
