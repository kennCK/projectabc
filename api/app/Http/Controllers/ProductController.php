<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
class ProductController extends APIController
{
    function __construct(){
    	$this->model = new Product();
    }
}
