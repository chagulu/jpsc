<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'candidates';

    // Fields that can be mass-assigned
    protected $fillable = [
        'email',
        'mobile_number',
        'otr_no',
        'otp',
        'otp_expires_at',
        'remember_token',
    ];

    // Hidden fields (not exposed in arrays or JSON)
    protected $hidden = [
        'otp',
        'remember_token',
    ];

    // Attribute casting
    protected $casts = [
        'otp_expires_at' => 'datetime',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
    ];

    // Relationships
    public function applications()
    {
        return $this->hasMany(JetApplicationModel::class, 'candidate_id');
    }

    /**
     * Override username for authentication (if using mobile_number)
     */
    public function getAuthIdentifierName()
    {
        return 'mobile_number'; // or 'email' if login via email
    }
}
