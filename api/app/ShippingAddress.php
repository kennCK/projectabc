<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends APIModel
{
    protected $table = 'shipping_addresses';
    protected $fillable = ['checkout_id', 'payload', 'payload_value', 'contact_number', 'notes'];
}
