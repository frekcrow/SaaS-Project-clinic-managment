<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TenantSubscriptionController extends Controller
{
    /**
     * Update the tenant's subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'is_active' => 'required|boolean',
            'subscription_plan' => 'nullable|string',
            'subscription_expires_at' => 'nullable|date',
            'active_features' => 'nullable|array',
        ]);

        $tenant = Tenant::findOrFail($validated['tenant_id']);

        $tenant->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Tenant subscription updated successfully',
            'data' => $tenant,
        ]);
    }
}
