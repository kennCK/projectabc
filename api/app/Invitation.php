<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends APIModel
{
    protected $table = 'invitations';
    protected $fillable = ['account_id', 'address', 'status'];
}
