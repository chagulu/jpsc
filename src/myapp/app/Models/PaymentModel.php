<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    use HasFactory;

    protected $table = 'payments'; // table name in DB

    protected $fillable = [
        'application_id',
        'amount',
        'status',
        'order_id',
        'gateway_txn_id',
        'raw_response'
    ];

    // If you are using timestamps
    public $timestamps = true;

    // Relationships (optional)
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
