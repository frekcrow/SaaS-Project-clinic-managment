<?php

namespace Tests\Feature\Api;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantSubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_subscription_requires_api_key(): void
    {
        $response = $this->postJson('/api/tenant/update-subscription', []);

        $response->assertStatus(401)
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_update_subscription_validates_data(): void
    {
        $response = $this->withHeaders([
            'X-API-KEY' => config('app.api_secret_key', 'atlas-secret-token-2026'),
        ])->postJson('/api/tenant/update-subscription', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['tenant_id', 'is_active']);
    }

    public function test_update_subscription_successfully_updates_tenant(): void
    {
        $tenant = Tenant::create([
            'name' => 'Test Tenant',
            'domain' => 'test-tenant',
            'is_active' => false,
            'subscription_plan' => null,
            'subscription_expires_at' => null,
            'active_features' => [],
        ]);

        $expiresAt = now()->addYear()->toDateTimeString();

        $response = $this->withHeaders([
            'X-API-KEY' => config('app.api_secret_key', 'atlas-secret-token-2026'),
        ])->postJson('/api/tenant/update-subscription', [
            'tenant_id' => $tenant->id,
            'is_active' => true,
            'subscription_plan' => 'premium',
            'subscription_expires_at' => $expiresAt,
            'active_features' => ['feature_a', 'feature_b'],
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'is_active',
                    'subscription_plan',
                    'subscription_expires_at',
                    'active_features',
                ]
            ]);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'is_active' => 1,
            'subscription_plan' => 'premium',
            'subscription_expires_at' => $expiresAt,
        ]);

        $updatedTenant = $tenant->fresh();
        $this->assertEquals(['feature_a', 'feature_b'], $updatedTenant->active_features);
    }
}
