<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Candidate extends Authenticatable
{
    protected $table = 'candidates';      // your candidates table
    protected $fillable = ['email', 'otp', 'mobile_number', 'otp_expires_at'];

    protected $hidden = ['otp'];
}
