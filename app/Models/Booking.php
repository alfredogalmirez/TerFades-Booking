<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'service_id',
        'customer_name',
        'phone',
        'scheduled_at',
        'status',
        'notes'
    ];

    public function service(){
        return $this->belongsTo(\App\Models\Service::class);
    }
}
