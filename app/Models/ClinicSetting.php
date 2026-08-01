<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToTenant;

class ClinicSetting extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'clinic_name',
        'doctor_name',
        'logo_1_path',
        'logo_2_path',
    ];
}
