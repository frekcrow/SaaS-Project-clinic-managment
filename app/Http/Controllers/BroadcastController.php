<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessagingSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BroadcastController extends Controller
{
    /**
     * Display the broadcast messages page.
     */
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;
        $messagingSettings = MessagingSetting::where('tenant_id', $tenantId)->first();

        return view('secretary.broadcast.index', [
            'messagingSettings' => $messagingSettings,
        ]);
    }

    /**
     * Update the WhatsApp and Telegram API configurations.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_access_token' => 'nullable|string',
            'whatsapp_phone_number_id' => 'nullable|string',
            'whatsapp_business_account_id' => 'nullable|string',
            'telegram_bot_token' => 'nullable|string',
            'telegram_bot_username' => 'nullable|string',
        ]);

        $tenantId = $request->user()->tenant_id;

        $messagingSettings = MessagingSetting::firstOrCreate(
            ['tenant_id' => $tenantId]
        );

        $messagingSettings->update($validated);

        if (!empty($validated['telegram_bot_token'])) {
            try {
                $webhookUrl = rtrim(config('app.url'), '/') . '/webhooks/telegram/' . $tenantId;
                $response = Http::post("https://api.telegram.org/bot{$validated['telegram_bot_token']}/setWebhook", [
                    'url' => $webhookUrl,
                ]);

                if (!$response->successful()) {
                    Log::error("Failed to register Telegram webhook: " . $response->body());
                    return redirect()->route('secretary.broadcast.index')
                        ->with('success', __('تم تحديث الإعدادات، ولكن فشل تسجيل رابط تليجرام التلقائي (تأكد من صحة رمز البوت)'));
                }
            } catch (\Exception $e) {
                Log::error("Exception registering Telegram webhook: " . $e->getMessage());
                return redirect()->route('secretary.broadcast.index')
                    ->with('success', __('تم تحديث الإعدادات، ولكن حدث خطأ أثناء تسجيل رابط تليجرام التلقائي'));
            }
        }

        return redirect()->route('secretary.broadcast.index')
            ->with('success', __('تم تحديث الإعدادات بنجاح'));
    }

    /**
     * Send a broadcast message to patients.
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        // Mock sending message
        // In a real application, you would integrate with the WhatsApp API here
        // using the configurations stored in $messagingSettings

        return redirect()->route('secretary.broadcast.index')
            ->with('success', __('تم إرسال الرسالة بنجاح'));
    }
}
