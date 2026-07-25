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
        Schema::table('users', function (Blueprint $table) {
            $table->string('secretary_name')->nullable();
            $table->string('clinic_name')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar_path')->nullable();
            $table->decimal('default_consultation_price', 10, 2)->default(0);
            $table->decimal('default_session_price', 10, 2)->nullable();
            $table->boolean('has_sessions_system')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'secretary_name',
                'clinic_name',
                'bio',
                'avatar_path',
                'default_consultation_price',
                'default_session_price',
                'has_sessions_system'
            ]);
        });
    }
};
