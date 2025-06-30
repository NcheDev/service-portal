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
    Schema::table('qualifications', function (Blueprint $table) {
        $table->string('award')->nullable()->after('id'); // adjust 'after' as needed
    });
}

public function down()
{
    Schema::table('qualifications', function (Blueprint $table) {
        $table->dropColumn('award');
    });
}

};
