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
        $table->string('profile_picture')->nullable()->after('personal_statement');
        $table->string('gender')->nullable()->after('physical_address');
    });
}

public function down()
{
    Schema::table('personal_information', function (Blueprint $table) {
        $table->dropColumn(['profile_picture', 'gender']);
    });
}


    /**
     * Reverse the migrations.
     */
   
    
};
