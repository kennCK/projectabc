<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
class ContentController extends APIController
{
    function __construct(){
      $this->model = new Content();
    }
}
