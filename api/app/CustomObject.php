<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomObject extends APIModel
{
    protected $table = 'objects';
    protected $fillable = ['template_id', 'name', 'type', 'content', 'settings'];
}
