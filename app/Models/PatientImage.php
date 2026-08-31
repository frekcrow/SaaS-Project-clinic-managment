<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientImage extends Model
{
    use \App\Traits\BelongsToTenant;

    protected $fillable = [
        'patient_id',
        'tenant_id',
        'album_type',
        'image_path',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
