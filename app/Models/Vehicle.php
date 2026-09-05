<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'tbl_vehicle';
    public $timestamps = false;
    protected $guarded = [];
}