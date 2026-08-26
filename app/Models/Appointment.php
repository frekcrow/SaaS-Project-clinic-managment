<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\BelongsToTenant;
use App\Traits\SyncsToExcel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use BelongsToTenant, SyncsToExcel, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'patient_id',
        'patient_name',
        'phone',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'price',
        'status',
        'queue_number',
        'is_session',
        'session_type_id',
        'session_started_at',
        'created_by',
    ];

    protected $casts = [
        'appointment_date' => 'date:Y-m-d',
        'is_session' => 'boolean',
        'session_started_at' => 'datetime',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function sessionType(): BelongsTo
    {
        return $this->belongsTo(SessionType::class, 'session_type_id');
    }
}
