<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends APIModel
{
    protected $table = 'contents';
    protected $fillable = ['object_id', 'content'];
}
