<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountGoogleSheet;
class AccountGoogleSheetController extends APIController
{
    function __construct(){
      $this->model = new AccountGoogleSheet();
    }
}
