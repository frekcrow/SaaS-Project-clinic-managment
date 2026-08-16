<?php

namespace Tests\Unit\Services;

use App\Services\LicenseService;
use Exception;
use Firebase\JWT\JWT;
use PHPUnit\Framework\TestCase;

class LicenseServiceTest extends TestCase
{
    protected LicenseService $licenseService;
    protected string $secretKey = 'Atlas_Clinic_Super_Secret_Key_2026_V1';

    protected function setUp(): void
    {
        parent::setUp();
        $this->licenseService = new LicenseService();
    }

    public function test_it_decodes_and_validates_a_valid_code()
    {
        $tenantId = 123;
        $payload = [
            'tenant_id' => $tenantId,
            'plan' => 'yearly',
            'jti' => 'some-uuid',
            'exp' => time() + 3600 // 1 hour from now
        ];

        $jwt = JWT::encode($payload, $this->secretKey, 'HS256');
        $code = 'ATLAS-' . $jwt;

        $decoded = $this->licenseService->decodeAndValidateCode($code, $tenantId);

        $this->assertEquals($tenantId, $decoded->tenant_id);
        $this->assertEquals('yearly', $decoded->plan);
    }

    public function test_it_throws_exception_if_code_is_expired()
    {
        $tenantId = 123;
        $payload = [
            'tenant_id' => $tenantId,
            'plan' => 'monthly',
            'jti' => 'some-uuid',
            'exp' => time() - 3600 // 1 hour ago
        ];

        $jwt = JWT::encode($payload, $this->secretKey, 'HS256');
        $code = 'ATLAS-' . $jwt;

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("This activation code has expired");

        $this->licenseService->decodeAndValidateCode($code, $tenantId);
    }

    public function test_it_throws_exception_if_code_is_corrupted()
    {
        $tenantId = 123;
        $code = 'ATLAS-invalid.jwt.string';

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Invalid or corrupted activation code");

        $this->licenseService->decodeAndValidateCode($code, $tenantId);
    }

    public function test_it_throws_exception_if_tenant_id_mismatches()
    {
        $tenantId = 123;
        $wrongTenantId = 456;
        $payload = [
            'tenant_id' => $tenantId,
            'plan' => 'lifetime',
            'jti' => 'some-uuid',
            'exp' => time() + 3600 // 1 hour from now
        ];

        $jwt = JWT::encode($payload, $this->secretKey, 'HS256');
        $code = 'ATLAS-' . $jwt;

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Tenant ID mismatch");

        $this->licenseService->decodeAndValidateCode($code, $wrongTenantId);
    }

    public function test_it_handles_code_without_prefix()
    {
        $tenantId = 123;
        $payload = [
            'tenant_id' => $tenantId,
            'plan' => 'yearly',
            'jti' => 'some-uuid',
            'exp' => time() + 3600
        ];

        $jwt = JWT::encode($payload, $this->secretKey, 'HS256');

        $decoded = $this->licenseService->decodeAndValidateCode($jwt, $tenantId);

        $this->assertEquals($tenantId, $decoded->tenant_id);
    }
}
