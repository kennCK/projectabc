<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends APIModel
{
    protected $table = 'templates';
    protected $fillable = ['account_id', 'title', 'settings', 'width', 'height', 'status', 'categories', 'price'];
}
