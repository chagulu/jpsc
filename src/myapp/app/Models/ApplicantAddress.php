<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantAddress extends Model
{
    use HasFactory;

    protected $table = 'applicant_addresses';

    protected $fillable = [
        'application_id',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'district',
        'pincode',
        'country',
        'address_type',
    ];

    // Relationship: belongs to application
    public function application()
    {
        return $this->belongsTo(JetApplicationModel::class, 'application_id');
    }
}
