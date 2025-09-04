<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
{
    Schema::create('additional_info_requests', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('application_id');
        $table->unsignedBigInteger('requested_by'); // admin
        $table->text('message');
        $table->string('status')->default('pending'); // pending, responded, closed
        $table->text('response')->nullable();
        $table->string('response_file_path')->nullable(); // <-- file uploaded by applicant
        $table->timestamps();

        $table->foreign('application_id')
              ->references('id')->on('applications')
              ->onDelete('cascade');

        $table->foreign('requested_by')
              ->references('id')->on('users')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_info_requests');
    }
};
