<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;

class WishlistController extends APIController
{
    function __construct(){
    	$this->model = new Wishlist();
    }
}
