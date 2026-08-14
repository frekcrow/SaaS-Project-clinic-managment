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
        Schema::table('tenants', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->string('subscription_plan')->nullable();
            $table->timestamp('subscription_expires_at')->nullable();
            $table->json('active_features')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'subscription_plan',
                'subscription_expires_at',
                'active_features',
            ]);
        });
    }
};
