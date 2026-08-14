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
        if (!$this->is_active) {
            return false;
        }

        if ($this->subscription_plan === 'lifetime') {
            return true;
        }

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
