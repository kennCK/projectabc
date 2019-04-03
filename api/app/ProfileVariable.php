<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileVariable extends APIModel
{
    protected $table = 'profile_variables';
    protected $fillable = ['profile_id', 'payload', 'payload_value'];
}
