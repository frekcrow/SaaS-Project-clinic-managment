<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class SessionType extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'name',
        'tenant_id',
    ];
}
