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
        Schema::create('invoices', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('invoice_number')->unique();
    $table->enum('processing_type', ['normal', 'express']);
    $table->enum('nationality', ['local', 'foreigner']);
    $table->integer('qualification_count');
    $table->decimal('total_amount', 10, 2);
    $table->enum('currency', ['MWK', 'USD']);
    $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
