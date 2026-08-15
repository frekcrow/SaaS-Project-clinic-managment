<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, BelongsToTenant;

    /**
     * الحقول المسموح تعبئتها في قاعدة البيانات
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'tenant_id', 
        'role', 
        'clinic_code', 
        'secretary_name', 
        'clinic_name', 
        'bio', 
        'avatar_path', 
        'default_consultation_price', 
        'default_session_price', 
        'has_sessions_system', 
        'is_main_account', 
        'locale'
    ];

    /**
     * الحقول المخفية (مثل كلمات المرور)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}