<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActiveTemplate;
class ActiveTemplateController extends APIController
{
    function __construct(){
      $this->model = new ActiveTemplate();
      $this->notRequired = array(
        'front', 'back'
      );
    }
}
