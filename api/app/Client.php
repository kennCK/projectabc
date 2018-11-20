<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends APIModel
{
    protected $table = 'clients';
    protected $fillable = ['client', 'partner'];
}
