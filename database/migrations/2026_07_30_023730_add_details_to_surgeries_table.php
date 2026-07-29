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
            if (!Schema::hasColumn('surgeries', 'hospital_name')) {
                $table->string('hospital_name')->nullable();
            }
            if (!Schema::hasColumn('surgeries', 'surgeon_name')) {
                $table->string('surgeon_name')->nullable();
            }
            if (!Schema::hasColumn('surgeries', 'disease_name')) {
                $table->string('disease_name')->nullable();
            }
            if (!Schema::hasColumn('surgeries', 'assistant_name')) {
                $table->string('assistant_name')->nullable();
            }
            if (!Schema::hasColumn('surgeries', 'anesthesiologist_name')) {
                $table->string('anesthesiologist_name')->nullable();
            }
            if (!Schema::hasColumn('surgeries', 'anesthesia_type')) {
                $table->string('anesthesia_type')->nullable(); // تخدير عام, تخدير موضعي, تخدير قطني, أخرى
            }
            if (!Schema::hasColumn('surgeries', 'cost')) {
                $table->decimal('cost', 15, 2)->nullable();
            }
            if (!Schema::hasColumn('surgeries', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surgeries', function (Blueprint $table) {
            $columns = [
                'hospital_name',
                'surgeon_name',
                'disease_name',
                'assistant_name',
                'anesthesiologist_name',
                'anesthesia_type',
                'cost',
                'notes'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('surgeries', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
