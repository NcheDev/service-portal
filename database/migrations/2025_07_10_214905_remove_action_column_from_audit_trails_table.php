<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveActionColumnFromAuditTrailsTable extends Migration
{
    public function up()
    {
        Schema::table('audit_trails', function (Blueprint $table) {
            $table->dropColumn('action');
        });
    }

    public function down()
    {
        Schema::table('audit_trails', function (Blueprint $table) {
            $table->string('action')->nullable(); // or make it required if needed
        });
    }
}
