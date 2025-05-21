<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfilePicturePathToPersonalInformationTable extends Migration
{
    public function up()
    {
        Schema::table('personal_information', function (Blueprint $table) {
            $table->string('profile_picture_path')->nullable()->after('personal_statement'); 
            // Replace 'some_column' with the name of a column after which you want to add this field, 
            // or just remove "->after()" if position doesn’t matter
        });
    }

    public function down()
    {
        Schema::table('personal_information', function (Blueprint $table) {
            $table->dropColumn('profile_picture_path');
        });
    }
}
