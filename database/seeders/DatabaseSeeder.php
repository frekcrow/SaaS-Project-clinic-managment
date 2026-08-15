<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant; // إضافة موديل العيادة هنا
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 1. تشغيل ملف التوليد الأساسي للنظام
        $this->call([
            AtlasSeeder::class,
        ]);

        // 2. التعديل الدقيق: ترقية العيادة الأولى (عيادتك) لتكون فعالة ومدى الحياة 
        $tenant = Tenant::first();
        
        if ($tenant) {
            $tenant->update([
                'is_active' => true,
                'subscription_plan' => 'lifetime',
                'subscription_expires_at' => null,
            ]);
        }
    }
}