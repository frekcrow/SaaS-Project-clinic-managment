<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\BelongsToTenant;
use App\Traits\SyncsToExcel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use BelongsToTenant, SyncsToExcel, SoftDeletes;

    protected $casts = [
        'dob' => 'date',
    ];

    protected $fillable = [
        'tenant_id',
        'name',
        'dob',
        'phone',
        'allergies',
        'chronic_diseases',
        'regular_medications',
        'doctor_id',
        'doctor_name',
        'reason_for_visit',
        'symptoms_onset',
        'gender',
        'smoking_status',
        'blood_type',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function surgeries(): HasMany
    {
        return $this->hasMany(Surgery::class);
    }

    public function patientImages(): HasMany
    {
        return $this->hasMany(PatientImage::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }
}
