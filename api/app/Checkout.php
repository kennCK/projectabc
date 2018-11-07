<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends APIModel
{
    protected $table = 'checkouts';
    protected $fillable = ['account_id', 'payload', 'payload_value', 'status', 'price'];
}
