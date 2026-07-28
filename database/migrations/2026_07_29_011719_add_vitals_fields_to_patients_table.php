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
            if (!Schema::hasColumn('patients', 'gender')) {
                $table->string('gender')->nullable();
            }
            if (!Schema::hasColumn('patients', 'smoking_status')) {
                $table->string('smoking_status')->nullable();
            }
            if (!Schema::hasColumn('patients', 'blood_type')) {
                $table->string('blood_type')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'gender')) {
                $table->dropColumn('gender');
            }
            if (Schema::hasColumn('patients', 'smoking_status')) {
                $table->dropColumn('smoking_status');
            }
            if (Schema::hasColumn('patients', 'blood_type')) {
                $table->dropColumn('blood_type');
            }
        });
    }
};
