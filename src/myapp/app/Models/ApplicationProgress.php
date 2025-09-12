<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationProgress extends Model
{
    protected $table = 'application_progress';

    protected $fillable = [
        'application_id',
        'step',
        'status',
        'percentage',
    ];

    public function application()
    {
        return $this->belongsTo(JetApplicationModel::class, 'application_id');
    }
}
