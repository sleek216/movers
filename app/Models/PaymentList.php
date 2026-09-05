<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentList extends Model
{
    protected $table = 'tbl_payment_list';
    public $timestamps = false;
    protected $guarded = [];
}