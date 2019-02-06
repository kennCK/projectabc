<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guide;
class GuideController extends APIController
{
    function __construct(){
      $this->model = new Guide();
    }
}
