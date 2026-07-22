<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AtlasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a Tenant
        $tenant = Tenant::create([
            'name' => 'Demo Clinic',
            'domain' => 'demo-clinic-' . Str::random(5),
        ]);

        // Create a Doctor
        $doctor = User::create([
            'name' => 'Dr. John Doe',
            'email' => 'doctor@example.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant->id,
            'role' => 'Doctor',
            'clinic_code' => 'DEMO123',
        ]);

        // Create a Secretary
        $secretary = User::create([
            'name' => 'Jane Smith',
            'email' => 'secretary@example.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant->id,
            'role' => 'Secretary',
            'clinic_code' => null,
        ]);

        // Create a Patient for this tenant
        Patient::create([
            'tenant_id' => $tenant->id,
            'name' => 'Test Patient',
            'phone' => '123456789',
            'doctor_id' => $doctor->id,
        ]);
    }
}
