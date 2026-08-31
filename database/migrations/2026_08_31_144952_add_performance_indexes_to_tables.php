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
            $table->index(['tenant_id', 'status']);
            $table->index(['tenant_id', 'appointment_date']);
            $table->index(['tenant_id', 'doctor_id', 'appointment_date']);
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->index(['tenant_id', 'name']);
            $table->index(['tenant_id', 'phone']);
        });

        Schema::table('surgeries', function (Blueprint $table) {
            $table->index(['tenant_id', 'surgery_date']);
            $table->index(['tenant_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex(['tenant_id', 'status']);
            $table->dropIndex(['tenant_id', 'appointment_date']);
            $table->dropIndex(['tenant_id', 'doctor_id', 'appointment_date']);
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->dropIndex(['tenant_id', 'name']);
            $table->dropIndex(['tenant_id', 'phone']);
        });

        Schema::table('surgeries', function (Blueprint $table) {
            $table->dropIndex(['tenant_id', 'surgery_date']);
            $table->dropIndex(['tenant_id', 'status']);
        });
    }
};
