<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Government;
class GovernmentController extends APIController
{
	function __construct(){
		$this->model = new Government();
	}
}
