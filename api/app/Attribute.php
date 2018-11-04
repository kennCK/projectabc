<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends APIModel
{
    protected $table = 'attributes';
    protected $fillable = ['payload', 'payload_value', 'attribute', 'value'];
}
