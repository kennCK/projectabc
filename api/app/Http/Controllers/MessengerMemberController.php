<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MessengerMember;

class MessengerMemberController extends APIController
{
    function __construct(){
      $this->model = new MessengerMember();
    }
}
