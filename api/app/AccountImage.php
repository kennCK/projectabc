<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountImage extends APIModel
{
    protected $table = 'account_images';
    protected $fillable = ['account_id', 'url'];
}
