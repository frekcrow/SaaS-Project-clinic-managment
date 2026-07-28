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
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'doctor_name')) {
                $table->string('doctor_name')->nullable();
            }
            if (!Schema::hasColumn('patients', 'allergies')) {
                $table->text('allergies')->nullable();
            }
            if (!Schema::hasColumn('patients', 'chronic_diseases')) {
                $table->text('chronic_diseases')->nullable();
            }
            if (!Schema::hasColumn('patients', 'regular_medications')) {
                $table->text('regular_medications')->nullable();
            }
        });

        Schema::table('medical_records', function (Blueprint $table) {
            if (!Schema::hasColumn('medical_records', 'visit_reason')) {
                $table->text('visit_reason')->nullable();
            }
            if (!Schema::hasColumn('medical_records', 'symptoms_onset')) {
                $table->string('symptoms_onset')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'doctor_name')) {
                $table->dropColumn('doctor_name');
            }
        });

        Schema::table('medical_records', function (Blueprint $table) {
            if (Schema::hasColumn('medical_records', 'visit_reason')) {
                $table->dropColumn('visit_reason');
            }
            if (Schema::hasColumn('medical_records', 'symptoms_onset')) {
                $table->dropColumn('symptoms_onset');
            }
        });
    }
};
