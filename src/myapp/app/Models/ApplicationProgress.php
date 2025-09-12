<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationProgress extends Model
{
    protected $table = 'progress_status';

    protected $fillable = [
        'application_id',
        'step_name',
        'status',
        'percentage',
    ];

    public function application()
    {
        return $this->belongsTo(JetApplicationModel::class, 'application_id');
    }
}
