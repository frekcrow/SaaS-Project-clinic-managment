<?php

namespace App\Services;

use App\Models\SystemNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationSyncService
{
    public function sync()
    {
        $url = config('app.central_api_url', 'http://127.0.0.1:5000') . '/api/broadcasts';

        try {
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                $broadcasts = $response->json();

                if (is_array($broadcasts)) {
                    foreach ($broadcasts as $broadcast) {
                        if (isset($broadcast['id']) && isset($broadcast['message'])) {
                            SystemNotification::updateOrCreate(
                                ['external_id' => $broadcast['id']],
                                [
                                    'title' => $broadcast['title'] ?? null,
                                    'message' => $broadcast['message'],
                                    'image_url' => $broadcast['image_url'] ?? null,
                                    // if API provides created_at we could map it, but relying on our own timestamps is fine
                                ]
                            );
                        }
                    }
                }
            } else {
                Log::warning('Failed to sync notifications. Status: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Error syncing notifications: ' . $e->getMessage());
        }
    }
}
