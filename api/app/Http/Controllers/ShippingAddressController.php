<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShippingAddress;
class ShippingAddressController extends APIController
{
    function __construct(){
      $this->model = new ShippingAddress();

      $this->notRequired = array(
      	'payload', 'payload_value', 'contact_number', 'notes'
      );
    }

}
