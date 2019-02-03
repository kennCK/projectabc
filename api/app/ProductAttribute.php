<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends APIModel
{
    protected $table = 'product_attributes';
    protected $fillable = ['account_id', 'product_id', 'payload',  'payload_value'];
}
