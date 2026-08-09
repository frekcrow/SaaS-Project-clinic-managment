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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->string('sender_type'); // 'patient', 'clinic'
            $table->foreignId('sender_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('provider_message_id')->nullable()->unique();
            $table->text('content');
            $table->string('type'); // 'text', 'image', 'document'
            $table->string('status')->nullable(); // 'sent', 'delivered', 'read', 'failed'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
