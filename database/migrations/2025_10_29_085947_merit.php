<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('qualifications', function (Blueprint $table) {
            $table->string('merit')->nullable()->after('country');
        });
    }

    public function down(): void
    {
        Schema::table('qualifications', function (Blueprint $table) {
            $table->dropColumn('merit');
        });
    }
};
