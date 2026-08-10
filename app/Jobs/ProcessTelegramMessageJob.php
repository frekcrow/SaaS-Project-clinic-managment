<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use App\Models\Conversation;
use App\Models\Message;

class ProcessTelegramMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payload;
    protected $tenantId;

    /**
     * Create a new job instance.
     */
    public function __construct(array $payload, $tenantId)
    {
        $this->payload = $payload;
        $this->tenantId = $tenantId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $message = Arr::get($this->payload, 'message');

        if (!$message || !Arr::has($message, 'text')) {
            return; // Ignore non-text messages
        }

        $chatId = Arr::get($message, 'chat.id');
        $messageText = Arr::get($message, 'text');
        $providerMessageId = (string) Arr::get($message, 'message_id');

        if (!$chatId || !$messageText || !$providerMessageId) {
            return;
        }

        $contactName = trim(Arr::get($message, 'from.first_name', '') . ' ' . Arr::get($message, 'from.last_name', '')) ?: Arr::get($message, 'from.username');

        $conversation = Conversation::firstOrCreate(
            [
                'tenant_id' => $this->tenantId,
                'platform' => 'telegram',
                'provider_chat_id' => $chatId,
            ],
            [
                'contact_name' => $contactName ?: null,
            ]
        );

        Message::firstOrCreate(
            ['provider_message_id' => $providerMessageId],
            [
                'conversation_id' => $conversation->id,
                'sender_type' => 'patient',
                'content' => $messageText,
                'type' => 'text',
                'status' => 'delivered',
            ]
        );

        $conversation->update(['last_message_at' => now()]);
    }
}
