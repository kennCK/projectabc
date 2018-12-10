<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
class ClientController extends Controller
{
    function __construct(){
    	$this->model = new Client();
    }
}
