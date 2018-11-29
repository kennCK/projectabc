<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaypalTransaction;
class PaypalTransactionController extends APIController
{
    function __construct(){
    	$this->model = new PaypalTransaction();
    }
}
