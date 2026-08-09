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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;

        $conversations = Conversation::where('tenant_id', $tenantId)
            ->with(['patient', 'messages' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->orderByDesc('last_message_at')
            ->get();

        return view('chat.index', compact('conversations'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Conversation $chat)
    {
        $tenantId = $request->user()->tenant_id;

        // Ensure the conversation belongs to the user's tenant
        if ($chat->tenant_id !== $tenantId) {
            abort(403);
        }

        $conversations = Conversation::where('tenant_id', $tenantId)
            ->with(['patient', 'messages' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->orderByDesc('last_message_at')
            ->get();

        $messages = $chat->messages()->with('sender')->oldest()->get();

        return view('chat.index', compact('conversations', 'chat', 'messages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Conversation $chat)
    {
        $tenantId = $request->user()->tenant_id;

        // Ensure the conversation belongs to the user's tenant
        if ($chat->tenant_id !== $tenantId) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $message = $chat->messages()->create([
            'sender_type' => 'clinic',
            'sender_id' => auth()->id(),
            'content' => $validated['content'],
            'type' => 'text',
            'status' => 'sent',
        ]);

        $chat->update([
            'last_message_at' => now(),
        ]);

        $this->dispatchMessage($chat, $message);

        return redirect()->route('chat.show', $chat->id);
    }

    private function dispatchMessage(Conversation $chat, Message $message)
    {
        $settings = MessagingSetting::where('tenant_id', $chat->tenant_id)->first();

        if (!$settings) {
            Log::warning("No messaging settings found for tenant {$chat->tenant_id}");
            return;
        }

        if ($chat->platform === 'whatsapp') {
            if (empty($settings->whatsapp_phone_number_id) || empty($settings->whatsapp_access_token)) {
                Log::warning("WhatsApp credentials missing for tenant {$chat->tenant_id}");
                return;
            }

            $url = "https://graph.facebook.com/v19.0/{$settings->whatsapp_phone_number_id}/messages";

            $payload = [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $chat->provider_chat_id,
                'type' => 'text',
                'text' => [
                    'preview_url' => false,
                    'body' => $message->content,
                ],
            ];

            try {
                $response = Http::withToken($settings->whatsapp_access_token)->post($url, $payload);

                if ($response->successful()) {
                    $responseData = $response->json();
                    if (isset($responseData['messages'][0]['id'])) {
                        $message->update([
                            'provider_message_id' => $responseData['messages'][0]['id'],
                        ]);
                    }
                } else {
                    Log::error("Failed to send WhatsApp message: " . $response->body());
                    $message->update(['status' => 'failed']);
                }
            } catch (\Exception $e) {
                Log::error("Exception sending WhatsApp message: " . $e->getMessage());
                $message->update(['status' => 'failed']);
            }
        } elseif ($chat->platform === 'telegram') {
            if (empty($settings->telegram_bot_token)) {
                Log::warning("Telegram credentials missing for tenant {$chat->tenant_id}");
                return;
            }

            $url = "https://api.telegram.org/bot{$settings->telegram_bot_token}/sendMessage";

            $payload = [
                'chat_id' => $chat->provider_chat_id,
                'text' => $message->content,
            ];

            try {
                $response = Http::post($url, $payload);

                if ($response->successful()) {
                    $responseData = $response->json();
                    if (isset($responseData['result']['message_id'])) {
                        $message->update([
                            'provider_message_id' => (string) $responseData['result']['message_id'],
                        ]);
                    }
                } else {
                    Log::error("Failed to send Telegram message: " . $response->body());
                    $message->update(['status' => 'failed']);
                }
            } catch (\Exception $e) {
                Log::error("Exception sending Telegram message: " . $e->getMessage());
                $message->update(['status' => 'failed']);
            }
        }
    }
}
