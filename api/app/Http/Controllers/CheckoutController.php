<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkout;
class CheckoutController extends APIController
{
    function __construct(){
    	$this->model = new Checkout();
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      $subTotal = 0;
      $tax = 0;
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $this->response['data'][$i]['template'] = $this->getTemplateDetails($result[$i]['payload_value']);
          $this->response['data'][$i]['objects'] = $this->getObjects($result[$i]['payload_value']);
          $subTotal += $result[$i]['price'];
          $i++;
        }
      }
      $this->response['data'][0]['sub_total'] = $subTotal;
      $this->response['data'][0]['tax'] = $tax;
      $this->response['data'][0]['total'] = $subTotal - $tax;
      return $this->response();
    }
}
