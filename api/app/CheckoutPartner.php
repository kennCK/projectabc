<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckoutPartner extends APIModel
{
    protected $table = 'checkout_partners';
    protected $fillable = ['checkout_id', 'account_id'];
}
