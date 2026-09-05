<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoadResponse extends Model
{
    protected $table = 'tbl_load_response';
    public $timestamps = false;
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(LorryOwner::class, 'owner_id');
    }

    public function lorry()
    {
        return $this->belongsTo(Lorry::class, 'lorry_id');
    }
}