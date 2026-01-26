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
    Schema::table('individual_applications', function (Blueprint $table) {
        $table->string('awarding_institution')->after('qualification_name');
    });
}

public function down()
{
    Schema::table('individual_applications', function (Blueprint $table) {
        $table->dropColumn('awarding_institution');
    });
}

};
