<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('personal_information', function (Blueprint $table) {
        $table->date('date_of_birth')->nullable()->after('country');
        $table->string('next_of_kin')->nullable()->after('date_of_birth');
    });
}

public function down()
{
    Schema::table('personal_information', function (Blueprint $table) {
        $table->dropColumn(['date_of_birth', 'next_of_kin']);
    });
}


   
};
