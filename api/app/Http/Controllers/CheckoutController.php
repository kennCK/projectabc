<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkout;
class CheckoutController extends APIController
{
    function __construct(){
    	$this->model = new Checkout();
    }
}
