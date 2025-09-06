<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantModel extends Model
{
    use HasFactory;

    protected $table = 'applicants';

    // Mass assignable fields
    protected $fillable = [
        // Personal Info
        'full_name',
        'gender',
        'date_of_birth',
        'age_on_date',
        'domicile_state',

        // Category Info
        'primary_category',
        'caste_id',
        'non_creamy_layer',

        // Disability / PWD Info
        'is_pwd',
        'nature_of_disability',
        'minimum_40_disability',

        // Ex-serviceman / Govt Service
        'ex_serviceman',
        'defence_service_years',
        'defence_service_months',
        'defence_service_days',
        'ncc_service',
        'bihar_gov_employee',
        'attempts_after_gov_employee',

        // Contact Info
        'mobile_no',
        'confirm_mobile_no',
        'email',
        'confirm_email',

        // Captcha
        'captcha_code',
    ];

    // Optional: Casts
    protected $casts = [
        'date_of_birth' => 'date',
        'age_on_date' => 'integer',
        'defence_service_years' => 'integer',
        'defence_service_months' => 'integer',
        'defence_service_days' => 'integer',
        'attempts_after_gov_employee' => 'integer',
    ];

    // Relationship with caste_details
    public function caste()
    {
        return $this->belongsTo(CasteDetail::class, 'caste_id', 'id');
    }
}
