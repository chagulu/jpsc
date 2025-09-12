<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationEducation extends Model
{
    use HasFactory;

    protected $table = 'application_educations';

    protected $fillable = [
        'application_id',
        'exam_name',
        'degree',
        'subject',
        'school_college',
        'board_university',
        'status',
        'passing_month',
        'passing_year',
        'marks_obtained',
        'total_marks',
        'division',
        'certificate_number',
        'certificate_file',
    ];

    public function application()
    {
        return $this->belongsTo(JetApplicationModel::class, 'application_id');
    }
}
