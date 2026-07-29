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
            if (!Schema::hasColumn('appointments', 'queue_number')) {
                $table->integer('queue_number')->nullable();
            }
            if (!Schema::hasColumn('appointments', 'is_session')) {
                $table->boolean('is_session')->default(false);
            }
            if (!Schema::hasColumn('appointments', 'session_type_id')) {
                $table->foreignId('session_type_id')->nullable()->constrained('session_types')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'session_type_id')) {
                $table->dropForeign(['session_type_id']);
                $table->dropColumn('session_type_id');
            }
            if (Schema::hasColumn('appointments', 'is_session')) {
                $table->dropColumn('is_session');
            }
            if (Schema::hasColumn('appointments', 'queue_number')) {
                $table->dropColumn('queue_number');
            }
        });
    }
};
