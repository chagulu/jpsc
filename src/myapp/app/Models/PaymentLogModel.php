<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentLogModel extends Model
{
    use HasFactory;

    protected $table = 'payment_logs';

    protected $fillable = [
        'application_id',
        'gateway_order_id',
        'request_payload',      // JSON sent to gateway
        'response_payload',     // JSON response from gateway
        'webhook_payload',      // JSON received from webhook
        'amount',
        'currency',
        'status',               // pending / success / failed
        'transaction_id',
        'payment_mode',
    ];

    protected $casts = [
        'request_payload'  => 'array',
        'response_payload' => 'array',
        'webhook_payload'  => 'array',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
