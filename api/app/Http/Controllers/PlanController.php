<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;
class PlanController extends APIController
{
    function __construct(){
    	$this->model = new Plan();

    	$this->notRequired = array(
    		'start', 'end'
    	);
    }
}
