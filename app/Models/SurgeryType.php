<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurgeryType extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
    ];

    public function surgeries(): HasMany
    {
        return $this->hasMany(Surgery::class);
    }
}
