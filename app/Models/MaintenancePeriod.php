<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenancePeriod extends Model
{
    protected $table = 'maintenance_periods';

    protected $fillable = [
        'resource_id',
        'start_date',
        'end_date',
        'description'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    // Relations
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
