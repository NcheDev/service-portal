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
        $table->year('year_obtained')->after('award');
    });
}

public function down()
{
    Schema::table('individual_applications', function (Blueprint $table) {
        $table->dropColumn('year_obtained');
    });
}
    
};
