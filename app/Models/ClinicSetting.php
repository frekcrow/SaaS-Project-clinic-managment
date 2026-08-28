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
        'doctor_specialization',
        'logo_1_path',
        'logo_2_path',
        'whatsapp_api_token',
        'whatsapp_phone_number_id',
        'whatsapp_business_account_id',
    ];
}
