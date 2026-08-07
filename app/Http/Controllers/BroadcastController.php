<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClinicSetting;

class BroadcastController extends Controller
{
    /**
     * Display the broadcast messages page.
     */
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;
        $clinicSettings = ClinicSetting::where('tenant_id', $tenantId)->first();

        return view('secretary.broadcast.index', [
            'clinicSettings' => $clinicSettings,
        ]);
    }

    /**
     * Update the WhatsApp API configurations.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_api_token' => 'nullable|string',
            'whatsapp_phone_number_id' => 'nullable|string',
            'whatsapp_business_account_id' => 'nullable|string',
        ]);

        $tenantId = $request->user()->tenant_id;

        $clinicSettings = ClinicSetting::firstOrCreate(
            ['tenant_id' => $tenantId]
        );

        $clinicSettings->update($validated);

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
        // using the configurations stored in $clinicSettings

        return redirect()->route('secretary.broadcast.index')
            ->with('success', __('تم إرسال الرسالة بنجاح'));
    }
}
