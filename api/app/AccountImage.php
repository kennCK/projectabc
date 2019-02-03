<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountImage extends APIModel
{
    protected $table = 'account_images';
    protected $fillable = ['account_id', 'payload', 'payload_value', 'url', 'status'];
}
