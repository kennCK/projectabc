<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends APIModel
{
    protected $table = 'employees';
    protected $fillable = ['front_template', 'back_template'];
}
