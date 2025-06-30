<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveAwardFromQualificationsTable extends Migration
{
    public function up()
    {
        Schema::table('qualifications', function (Blueprint $table) {
            $table->dropColumn('award');
        });
    }

    public function down()
    {
        Schema::table('qualifications', function (Blueprint $table) {
            $table->string('award')->nullable(); // Add it back if rollback is needed
        });
    }
}
