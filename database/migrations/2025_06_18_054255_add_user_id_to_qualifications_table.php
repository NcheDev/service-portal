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
        $table->unsignedBigInteger('user_id')->after('id');

        // If user table has foreign keys
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

};
