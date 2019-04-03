<?php

namespace Increment\Payment\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Payment\Models\PaypalTransaction;
class PaypalTransactionController extends APIController
{
    function __construct(){
    	$this->model = new PaypalTransaction();
    }
}
