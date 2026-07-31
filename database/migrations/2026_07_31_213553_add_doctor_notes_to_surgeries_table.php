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
        Schema::table('surgeries', function (Blueprint $table) {
            if (!Schema::hasColumn('surgeries', 'doctor_notes')) {
                $table->text('doctor_notes')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surgeries', function (Blueprint $table) {
            if (Schema::hasColumn('surgeries', 'doctor_notes')) {
                $table->dropColumn('doctor_notes');
            }
        });
    }
};
