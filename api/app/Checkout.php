<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends APIModel
{
    protected $table = 'checkouts';
    protected $fillable = ['account_id', 'payment_method_id', 'sub_total', 'tax', 'total', 'status'];
}
