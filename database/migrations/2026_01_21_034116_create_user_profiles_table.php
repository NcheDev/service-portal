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
        Schema::create('user_profiles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    $table->string('first_name');
    $table->string('last_name');
    $table->string('previous_names')->nullable();

    $table->string('primary_contact');
    $table->string('secondary_contact')->nullable();

    $table->foreignId('nationality_id')->constrained('countries');
    $table->foreignId('country_id')->constrained('countries');

    $table->string('national_id_number')->nullable();

    $table->foreignId('gender_id')->constrained();
    $table->foreignId('title_id')->constrained();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
