<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'domain',
        'is_active',
        'subscription_plan',
        'subscription_expires_at',
        'active_features',
        'excel_export_path',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'subscription_expires_at' => 'datetime',
            'active_features' => 'array',
        ];
    }

    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->active_features ?? []);
    }

    public function hasValidSubscription(): bool
    {
        // 1. إذا تم إيقاف العيادة يدوياً، امنع الدخول
        if (!$this->is_active) {
            return false;
        }

        // 2. إذا كان الاشتراك مدى الحياة، أو لم يتم تحديد خطة بعد (عيادة جديدة)، اسمح بالدخول
        if ($this->subscription_plan === 'lifetime' || $this->subscription_plan === null) {
            return true;
        }

        // 3. التحقق من تاريخ الانتهاء للاشتراكات الشهرية/السنوية
        return $this->subscription_expires_at && $this->subscription_expires_at->isFuture();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }
}
