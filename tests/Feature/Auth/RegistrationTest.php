<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $this->mock(\App\Services\LicenseService::class, function ($mock) {
            $mock->shouldReceive('decodeAndValidateCode')->andReturn((object) ['plan' => 'lifetime']);
            $mock->shouldReceive('markAsUsed')->andReturnNull();
        });
        $response = $this->post('/register', [
            'role' => 'Doctor',
            'clinic_code' => 'CLINIC-123',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'activation_code' => 'ATLAS-dummycode',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
