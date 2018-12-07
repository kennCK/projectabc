<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends APIModel
{
    protected $table = 'checkouts';
    protected $fillable = ['account_id', 'order_number', 'payment_type', 'payment_payload', 'payment_payload_value', 'sub_total', 'tax', 'total', 'status'];
}
