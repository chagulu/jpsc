<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass-assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_2fa_enabled',   // tinyint(1) in table
        'otp',              // varchar(6)
        'otp_expires_at',   // timestamp
    ];

    /**
     * Hidden for arrays / JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp', // hide OTP in API responses
    ];

    /**
     * Casts for attributes.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at'    => 'datetime',
        'is_2fa_enabled'    => 'boolean',
    ];

    /**
     * Automatically hash passwords when set.
     */
    protected function setPasswordAttribute($value): void
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
