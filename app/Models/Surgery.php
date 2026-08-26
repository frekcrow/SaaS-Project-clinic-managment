<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use App\Traits\SyncsToExcel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Surgery extends Model
{
    use BelongsToTenant, SyncsToExcel, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'patient_id',
        'surgery_type_id',
        'surgery_date',
        'status',
        'hospital_name',
        'surgeon_name',
        'disease_name',
        'assistant_name',
        'anesthesiologist_name',
        'anesthesia_type',
        'cost',
        'notes',
        'doctor_notes',
        'created_by',
    ];

    protected $casts = [
        'surgery_date' => 'date:Y-m-d',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function surgeryType(): BelongsTo
    {
        return $this->belongsTo(SurgeryType::class);
    }
}
