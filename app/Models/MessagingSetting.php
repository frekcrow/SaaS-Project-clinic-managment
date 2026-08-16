<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToTenant;

class MessagingSetting extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'whatsapp_phone_number_id',
        'whatsapp_business_account_id',
        'whatsapp_access_token',
        'telegram_bot_token',
        'telegram_bot_username',
        'doctor_chat_id',
        'secretary_chat_id',
    ];
}
