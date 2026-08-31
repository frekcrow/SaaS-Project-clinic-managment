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

class ProcessWhatsAppMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [10, 30, 60];

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
        $entry = Arr::get($this->payload, 'entry.0.changes.0.value.messages.0');

        if (!$entry || Arr::get($entry, 'type') !== 'text') {
            return; // Ignore status updates or non-text messages
        }

        $senderPhone = Arr::get($entry, 'from');
        $messageText = Arr::get($entry, 'text.body');
        $providerMessageId = Arr::get($entry, 'id');

        if (!$senderPhone || !$messageText || !$providerMessageId) {
            return;
        }

        $conversation = Conversation::firstOrCreate(
            [
                'tenant_id' => $this->tenantId,
                'platform' => 'whatsapp',
                'provider_chat_id' => $senderPhone,
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
