<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attribute;
class AttributeController extends APIController
{
    function __construct(){
      $this->model = new Attribute();
    }
}
