<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductAttribute;
class ProductAttributeController extends APIController
{
    function __construct(){
    	$this->model = new ProductAttribute();
    }
}
