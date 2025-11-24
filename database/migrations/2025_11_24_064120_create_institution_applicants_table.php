<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('institution_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade'); // link to main application
            $table->string('first_name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('nationality');
            $table->string('title')->nullable();
            $table->date('dob');
            $table->string('phone');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institution_applicants');
    }
};
