<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountImage;
class AccountImageController extends APIController
{
    function __construct(){
      $this->model = new AccountImage();
    }
}
