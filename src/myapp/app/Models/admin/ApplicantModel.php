<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ApplicantAddress;

class ApplicantModel extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'full_name',
        'gender',
        'date_of_birth',
        'age',
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
        'date_of_birth' => 'date',
        'age' => 'integer',
        'govt_service_years' => 'decimal:1',
        'defence_service_year' => 'integer',
        'defence_service_month' => 'integer',
        'defence_service_day' => 'integer',
        'pwd_40_percent' => 'boolean',
        'domicile_bihar' => 'boolean',
        'is_pwd' => 'boolean',
        'worked_after_ncc' => 'boolean',
        'submitted_at' => 'datetime',
        'last_edit_at' => 'datetime',
        'form_json' => 'array',
    ];

    // 🔗 Relation: One Application has many addresses
    public function addresses()
    {
        return $this->hasMany(ApplicantAddress::class, 'application_id', 'id');
    }

    // If you want payments relation
    public function payments()
    {
        return $this->hasMany(Payment::class, 'application_id', 'id');
    }
}
