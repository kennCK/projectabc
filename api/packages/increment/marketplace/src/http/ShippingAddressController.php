<?php

namespace Increment\Marketplace\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Marketplace\Models\ShippingAddress;
class ShippingAddressController extends APIController
{
    function __construct(){
      $this->model = new ShippingAddress();

      $this->notRequired = array(
      	'payload', 'payload_value', 'contact_number', 'notes'
      );
    }

}
