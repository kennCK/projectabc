<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeColumn extends APIModel
{
    protected $table = 'employee_columns';
    protected $fillable = ['employee_id', 'type', 'column', 'value'];
}
