<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryCode extends Model
{
    protected $table = 'tbl_code';
    public $timestamps = false;
    protected $guarded = [];
}