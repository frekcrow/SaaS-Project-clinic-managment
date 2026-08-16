<?php

namespace App\Services;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use App\Models\UsedActivationCode;

class LicenseService
{
    /**
     * Decodes and validates the activation code.
     *
     * @param string $code The activation code (e.g., ATLAS-{jwt_string})
     * @param int|string $currentTenantId The current tenant's ID
     * @return object The decoded JWT payload
     * @throws Exception If the code is invalid, expired, or tenant ID mismatches
     */
    public function decodeAndValidateCode(string $code, $currentTenantId)
    {
        // Check for and remove the "ATLAS-" prefix
        $prefix = 'ATLAS-';
        if (str_starts_with($code, $prefix)) {
            $jwt = substr($code, strlen($prefix));
        } else {
            $jwt = $code;
        }

        $secretKey = 'Atlas_Clinic_Super_Secret_Key_2026_V1';

        try {
            // Decode the JWT
            $payload = JWT::decode($jwt, new Key($secretKey, 'HS256'));
        } catch (ExpiredException $e) {
            throw new Exception("This activation code has expired");
        } catch (Exception $e) {
            throw new Exception("Invalid or corrupted activation code");
        }

        // Validate the tenant_id
        if (!isset($payload->tenant_id) || (string)$payload->tenant_id !== (string)$currentTenantId) {
            throw new Exception("Tenant ID mismatch");
        }

        // Validate that the code (jti) has not been used already
        if (isset($payload->jti) && UsedActivationCode::where('jti', $payload->jti)->exists()) {
            throw new Exception("This activation code has already been used");
        }

        return $payload;
    }

    /**
     * Marks an activation code as used by inserting its jti into the database.
     *
     * @param string $jti The JWT ID
     * @param int|string $tenantId The ID of the tenant using the code
     * @return void
     */
    public function markAsUsed(string $jti, $tenantId): void
    {
        UsedActivationCode::create([
            'jti' => $jti,
            'tenant_id' => $tenantId,
        ]);
    }
}
