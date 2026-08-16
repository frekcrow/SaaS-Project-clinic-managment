<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('used_activation_codes', function (Blueprint $table) {
            $table->integer('usage_count')->default(0)->after('jti');
            $table->string('bound_username')->nullable()->after('usage_count');
        });
    }

    public function down(): void
    {
        Schema::table('used_activation_codes', function (Blueprint $table) {
            $table->dropColumn(['usage_count', 'bound_username']);
        });
    }
};
