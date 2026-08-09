<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessagingSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Get messages for a conversation.
     */
    public function messages(Request $request, Conversation $chat)
    {
        \$tenantId = \$request->user()->tenant_id;

        if (\$chat->tenant_id !== \$tenantId) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        \$messages = \$chat->messages()->oldest()->get()->map(function(\$msg) {
            return [
                'id' => \$msg->id,
                'content' => \$msg->content,
                'sender_type' => \$msg->sender_type
            ];
        });

        return response()->json(['data' => \$messages]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Conversation $chat)
    {
        \$tenantId = \$request->user()->tenant_id;

        // Ensure the conversation belongs to the user's tenant
        if (\$chat->tenant_id !== \$tenantId) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        \$validated = \$request->validate([
            'content' => 'required|string',
        ]);

        \$message = \$chat->messages()->create([
            'sender_type' => 'clinic',
            'sender_id' => auth()->id(),
            'content' => \$validated['content'],
            'type' => 'text',
            'status' => 'sent',
        ]);

        \$chat->update([
            'last_message_at' => now(),
        ]);

        \$this->dispatchMessage(\$chat, \$message);

        if (\$request->wantsJson()) {
            return response()->json([
                'message' => 'Message sent successfully',
                'data' => \$message->load('sender'),
            ]);
        }

        return redirect()->back()->with('success', 'Message sent successfully');
    }

    private function dispatchMessage(Conversation $chat, Message $message)
    {
        \$settings = MessagingSetting::where('tenant_id', \$chat->tenant_id)->first();

        if (!\$settings) {
            Log::warning("No messaging settings found for tenant {\$chat->tenant_id}");
            return;
        }

        if (\$chat->platform === 'whatsapp') {
            if (empty(\$settings->whatsapp_phone_number_id) || empty(\$settings->whatsapp_access_token)) {
                Log::warning("WhatsApp credentials missing for tenant {\$chat->tenant_id}");
                return;
            }

            \$url = "https://graph.facebook.com/v19.0/{\$settings->whatsapp_phone_number_id}/messages";

            \$payload = [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => \$chat->provider_chat_id,
                'type' => 'text',
                'text' => [
                    'preview_url' => false,
                    'body' => \$message->content,
                ],
            ];

            try {
                \$response = Http::withToken(\$settings->whatsapp_access_token)->post(\$url, \$payload);

                if (\$response->successful()) {
                    \$responseData = \$response->json();
                    if (isset(\$responseData['messages'][0]['id'])) {
                        \$message->update([
                            'provider_message_id' => \$responseData['messages'][0]['id'],
                        ]);
                    }
                } else {
                    Log::error("Failed to send WhatsApp message: " . \$response->body());
                    \$message->update(['status' => 'failed']);
                }
            } catch (\Exception \$e) {
                Log::error("Exception sending WhatsApp message: " . \$e->getMessage());
                \$message->update(['status' => 'failed']);
            }
        } elseif (\$chat->platform === 'telegram') {
            if (empty(\$settings->telegram_bot_token)) {
                Log::warning("Telegram credentials missing for tenant {\$chat->tenant_id}");
                return;
            }

            \$url = "https://api.telegram.org/bot{\$settings->telegram_bot_token}/sendMessage";

            \$payload = [
                'chat_id' => \$chat->provider_chat_id,
                'text' => \$message->content,
            ];

            try {
                \$response = Http::post(\$url, \$payload);

                if (\$response->successful()) {
                    \$responseData = \$response->json();
                    if (isset(\$responseData['result']['message_id'])) {
                        \$message->update([
                            'provider_message_id' => (string) \$responseData['result']['message_id'],
                        ]);
                    }
                } else {
                    Log::error("Failed to send Telegram message: " . \$response->body());
                    \$message->update(['status' => 'failed']);
                }
            } catch (\Exception \$e) {
                Log::error("Exception sending Telegram message: " . \$e->getMessage());
                \$message->update(['status' => 'failed']);
            }
        }
    }
}
