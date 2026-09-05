<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoadPost extends Model
{
    protected $table = 'tbl_load';
    public $timestamps = false;
    protected $guarded = [];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function responses()
    {
        return $this->hasMany(LoadResponse::class, 'load_id');
    }
}