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
    public function decodeAndValidateCode(string $code, $currentTenantId, bool $isRegistration = false, string $username = null)
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
        if (!$isRegistration) {
            if (!isset($payload->tenant_id) || (string)$payload->tenant_id !== (string)$currentTenantId) {
                throw new Exception("Tenant ID mismatch");
            }
        }

        // Validate that the code (jti) has not been used already
        if (isset($payload->jti)) {
            $usedCode = UsedActivationCode::where('jti', $payload->jti)->first();
            if ($usedCode) {
                if ($isRegistration) {
                    if ($usedCode->usage_count >= 2) {
                        throw new Exception("Invalid or already consumed code");
                    }
                    if ($usedCode->bound_username !== $username) {
                        throw new Exception("Invalid or already consumed code");
                    }
                } else {
                    // For regular activation (e.g. renewal), if it exists and wasn't just created, it might be already used for renewal once.
                    // Assuming regular activation codes are one-time use. The requirement is about Two-Use for registration.
                    throw new Exception("This activation code has already been used");
                }
            }
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
    public function markAsUsed(string $jti, $tenantId, string $username = null): void
    {
        $usedCode = UsedActivationCode::where('jti', $jti)->first();

        if ($usedCode) {
            $usedCode->usage_count += 1;
            $usedCode->save();
        } else {
            UsedActivationCode::create([
                'jti' => $jti,
                'tenant_id' => $tenantId,
                'usage_count' => 1,
                'bound_username' => $username,
            ]);
        }
    }
}
