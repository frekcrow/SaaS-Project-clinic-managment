<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToTenant;

class Medication extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'indications',
        'dosages',
        'usage_times',
    ];

    protected $casts = [
        'dosages' => 'array',
        'usage_times' => 'array',
    ];
}
