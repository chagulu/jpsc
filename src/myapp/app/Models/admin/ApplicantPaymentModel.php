<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantPayment extends Model
{
    use HasFactory;

    protected $table = 'applicant_payments';

    protected $fillable = [
        'applicant_id',
        'order_id',
        'transaction_id',
        'payment_status',
        'payment_amount',
        'payment_mode',
        'payment_response',
        'payment_date',
    ];

    protected $casts = [
        'payment_amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id');
    }
}
