<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guide extends APIModel
{
    protected $table = 'guides';
    protected $fillable = ['account_id', 'payload', 'payload_value', 'text'];
}
