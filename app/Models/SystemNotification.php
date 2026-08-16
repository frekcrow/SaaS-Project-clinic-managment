<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemNotification extends Model
{
    protected $fillable = [
        'external_id',
        'title',
        'message',
        'image_url',
    ];
}
