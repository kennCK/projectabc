<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
class CouponController extends APIController
{
   	function __construct(){
   		$this->model = new Coupon();
   	}
}
