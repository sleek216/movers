<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bilty extends Model
{
    protected $table = 'tbl_bilties';
    protected $guarded = [];

    protected $casts = [
        'bilty_date' => 'date',
        'freight_total' => 'float',
        'advance_paid' => 'float',
        'balance_amount' => 'float',
        'loading_charges' => 'float',
        'weight_value' => 'float',
        'total_packages' => 'integer',
    ];
}
