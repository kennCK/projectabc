<?php

namespace Increment\Marketplace\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Marketplace\Models\Coupon;
class CouponController extends APIController
{
   	function __construct(){
   		$this->model = new Coupon();
   	}
}
