<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JetApplicationModel extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'application_no',
        'aadhaar_card_number',
        'confirm_name',
        'roll_number',
        'rd_is_changed_name',
        'have_you_ever_changed_name',
        'changed_name',
        'verify_changed_name',
        'upload_supported_document',
        'date_of_birth',
        'father_name',
        'mother_name',
        'candidate_id',       // foreign key
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
        'application_no',
        'form_json',
        'submission_stage',
        'submitted_at',
        'last_edit_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'form_json'         => 'array',
        'date_of_birth'     => 'date',
        'submitted_at'      => 'datetime',
        'last_edit_at'      => 'datetime',
        'domicile_bihar'    => 'boolean',
        'non_creamy_layer'  => 'boolean',
        'is_pwd'            => 'boolean',
        'pwd_40_percent'    => 'boolean',
        'ex_serviceman'     => 'boolean',
        'worked_after_ncc'  => 'boolean',
        'bihar_govt_employee'=> 'boolean',
        'govt_service_years'=> 'decimal:1',
        'age'               => 'integer',
    ];

    // Relationship: each application belongs to a candidate
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }
}
