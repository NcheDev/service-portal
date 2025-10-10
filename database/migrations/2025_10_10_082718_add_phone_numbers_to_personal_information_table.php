<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_information', function (Blueprint $table) {
            $table->string('primary_phone', 20)->after('email')->nullable();
            $table->string('secondary_phone', 20)->after('primary_phone')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('personal_information', function (Blueprint $table) {
            $table->dropColumn(['primary_phone', 'secondary_phone']);
        });
    }
};

 
