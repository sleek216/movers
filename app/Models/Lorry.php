<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lorry extends Model
{
    protected $table = 'tbl_lorry';
    public $timestamps = false;
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(LorryOwner::class, 'owner_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}