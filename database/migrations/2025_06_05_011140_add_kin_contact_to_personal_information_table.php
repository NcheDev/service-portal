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
        $table->string('kin_contact')->nullable()->after('next_of_kin');
    });
}

public function down()
{
    Schema::table('personal_information', function (Blueprint $table) {
        $table->dropColumn('kin_contact');
    });
}
    
};
