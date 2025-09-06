<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasteDetailModel extends Model
{
    use HasFactory;

    protected $table = 'caste_details';

    protected $fillable = [
        'primary_category',
        'caste_name',
    ];

    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'caste_id', 'id');
    }
}
