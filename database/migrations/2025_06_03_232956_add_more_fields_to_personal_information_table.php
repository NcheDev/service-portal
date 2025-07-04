<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('personal_information', function (Blueprint $table) {
           
            $table->string('title')->nullable();
            $table->string('previous_surnames')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('personal_information', function (Blueprint $table) {
            $table->dropColumn([   'title', 'previous_surnames']);
        });
    }
};