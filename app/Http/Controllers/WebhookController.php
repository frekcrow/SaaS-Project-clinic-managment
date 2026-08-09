<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessagingSetting;
use App\Jobs\ProcessWhatsAppMessageJob;
use App\Jobs\ProcessTelegramMessageJob;

class WebhookController extends Controller
{
    public function verifyWhatsApp(Request $request)
    {
        $hubVerifyToken = config('services.whatsapp.verify_token');

        if (
            $request->query('hub_mode') === 'subscribe' &&
            $request->query('hub_verify_token') === $hubVerifyToken
        ) {
            return response((string) $request->query('hub_challenge'), 200)
                ->header('Content-Type', 'text/plain');
        }

        return response('Forbidden', 403);
    }

    public function handleWhatsApp(Request $request)
    {
        $payload = $request->all();

        // Extract phone_number_id
        $phoneNumberId = $request->input('entry.0.changes.0.value.metadata.phone_number_id');

        if ($phoneNumberId) {
            $messagingSetting = MessagingSetting::where('whatsapp_phone_number_id', $phoneNumberId)->first();

            if ($messagingSetting) {
                ProcessWhatsAppMessageJob::dispatch($payload, $messagingSetting->tenant_id);
            }
        }

        return response('OK', 200);
    }

    public function handleTelegram(Request $request, $tenant_id)
    {
        $payload = $request->all();

        ProcessTelegramMessageJob::dispatch($payload, $tenant_id);

        return response('OK', 200);
    }
}
