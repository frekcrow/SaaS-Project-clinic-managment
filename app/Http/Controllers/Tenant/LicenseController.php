<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LicenseService;

class LicenseController extends Controller
{
    /**
     * Activate the tenant's subscription.
     */
    public function activate(Request $request, LicenseService $licenseService)
    {
        $request->validate([
            'activation_code' => 'required|string',
        ]);

        $tenant = $request->user()->tenant;

        try {
            $payload = $licenseService->decodeAndValidateCode($request->activation_code, $tenant->id);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        $plan = $payload->plan ?? 'lifetime';

        if ($plan === 'monthly') {
            $tenant->subscription_expires_at = now()->addDays(30);
        } elseif ($plan === 'yearly') {
            $tenant->subscription_expires_at = now()->addDays(365);
        } elseif ($plan === 'lifetime') {
            $tenant->subscription_expires_at = null;
        }

        $tenant->subscription_plan = $plan;
        $tenant->is_active = true;
        $tenant->save();

        if (isset($payload->jti)) {
            $licenseService->markAsUsed($payload->jti, $tenant->id);
        }

        return back()->with('success', __('Subscription activated successfully!'));
    }
}
