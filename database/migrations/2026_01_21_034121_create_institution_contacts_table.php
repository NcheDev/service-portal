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
        Schema::create('institution_contacts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('institution_application_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->string('first_name');
    $table->string('last_name');
    $table->string('phone');
    $table->foreignId('nationality_id')->constrained('countries');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institution_contacts');
    }
};
