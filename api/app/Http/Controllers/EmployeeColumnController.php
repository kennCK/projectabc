<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmployeeColumn;
class EmployeeColumnController extends APIController
{
    function __construct(){
      $this->model = new EmployeeColumn();
    }
}
