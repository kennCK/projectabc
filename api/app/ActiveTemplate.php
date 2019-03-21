<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveTemplate extends APIModel
{
    protected $table = 'active_templates';
    protected $fillable = ['account_id', 'front', 'back'];
}
