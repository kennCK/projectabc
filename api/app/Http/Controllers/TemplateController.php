<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
class TemplateController extends APIController
{
    function __construct(){
    	$this->model = new Template();
    }
}
