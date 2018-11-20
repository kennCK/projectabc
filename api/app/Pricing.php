<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pricing extends APIModel
{
    protected $table = 'pricings';
    protected $fillable = ['account_id', 'product_id', 'minimum', 'maximum', 'price'];
}
