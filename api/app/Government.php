<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Government extends APIModel
{
    protected $table = 'governments';
    protected $fillable = ['profile_id', 'payload', 'payload_value'];
}
