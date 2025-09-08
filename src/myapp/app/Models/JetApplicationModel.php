<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JetApplicationModel extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'applications';

    // Mass-assignable columns
    protected $fillable = [
        // Applicant fields
        'full_name',
        'gender',
        'domicile_bihar',
        'category',
        'caste',
        'non_creamy_layer',
        'is_pwd',
        'disability_nature',
        'pwd_40_percent',
        'ex_serviceman',
        'defence_service_year',
        'defence_service_month',
        'defence_service_day',
        'worked_after_ncc',
        'bihar_govt_employee',
        'govt_service_years',
        'attempts_after_emp',
        'mobile_no',
        'email',
        'date_of_birth',
        'age',
        'status',

        // Application fields
        'application_no',
        'form_json',
        'submission_stage',
        'submitted_at',
        'last_edit_at',
        'ip_address',
        'user_agent',
    ];

    // Attribute casting
    protected $casts = [
        'form_json'       => 'array',
        'date_of_birth'   => 'date',
        'submitted_at'    => 'datetime',
        'last_edit_at'    => 'datetime',
        'domicile_bihar'  => 'boolean',
        'non_creamy_layer'=> 'boolean',
        'is_pwd'          => 'boolean',
        'pwd_40_percent'  => 'boolean',
        'ex_serviceman'   => 'boolean',
        'worked_after_ncc'=> 'boolean',
        'bihar_govt_employee' => 'boolean',
        'govt_service_years'=> 'decimal:1',
        'age'             => 'integer',
    ];

    // Example relationship to payments table
    public function payments()
    {
        return $this->hasMany(PaymentLog::class, 'application_id');
    }
}
