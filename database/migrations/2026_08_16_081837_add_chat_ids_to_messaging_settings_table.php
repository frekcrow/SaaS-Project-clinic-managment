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
        Schema::table('messaging_settings', function (Blueprint $table) {
            $table->string('doctor_chat_id')->nullable();
            $table->string('secretary_chat_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messaging_settings', function (Blueprint $table) {
            $table->dropColumn(['doctor_chat_id', 'secretary_chat_id']);
        });
    }
};
