<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckoutTemplate extends APIModel
{
    protected $table = 'checkout_templates';
    protected $fillable = ['checkout_id', 'front', 'back'];
}
