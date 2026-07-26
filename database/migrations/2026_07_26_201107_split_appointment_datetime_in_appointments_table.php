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
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('appointment_datetime');
            $table->date('appointment_date')->after('doctor_id');
            $table->time('appointment_time')->after('appointment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('appointment_date');
            $table->dropColumn('appointment_time');
            $table->dateTime('appointment_datetime')->after('doctor_id');
        });
    }
};
