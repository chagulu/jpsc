<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ApplicantModel;

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
        'address_type', // e.g. permanent / correspondence
    ];

    // 🔗 Relation: Each address belongs to one application
    public function application()
    {
        return $this->belongsTo(ApplicantModel::class, 'application_id', 'id');
    }
}
