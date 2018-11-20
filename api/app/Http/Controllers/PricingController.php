<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pricing;
class PricingController extends APIController
{
    function __construct(){
    	$this->model = new Pricing();
    }
}
