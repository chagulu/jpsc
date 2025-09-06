<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeModel extends Model
{
    use HasFactory;
     protected $table = 'fees'; // table name in DB

    protected $fillable = [
        'exam_name',
        'exam_type',
        'base_fee',
        'gst',
        'total_payable',
    ];
}
