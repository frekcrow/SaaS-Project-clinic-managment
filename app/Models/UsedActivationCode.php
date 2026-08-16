<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsedActivationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'jti',
        'usage_count',
        'bound_username',
    ];

    /**
     * Get the tenant that owns the used activation code.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
