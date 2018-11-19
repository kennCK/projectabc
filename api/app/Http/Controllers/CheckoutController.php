<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkout;
use App\StripeCard;
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
      $cards = $this->getStripeCards($data['account_id']);
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $payload = $result[$i]['payload'];
          $payloadValue = $result[$i]['payload_value'];
          if($payload == 'template'){
            $this->response['data'][$i]['template'] = $this->getTemplateDetails($payloadValue);
            $this->response['data'][$i]['objects'] = $this->getObjects($payloadValue);
          }else if($payload == 'employee'){
            $this->response['data'][$i]['employee'] = $this->getEmployee($payloadValue);
          }
          $subTotal += $result[$i]['price'];
          $i++;
        }
      }
      $this->response['data'][0]['sub_total'] = $subTotal;
      $this->response['data'][0]['tax'] = $tax;
      $this->response['data'][0]['total'] = $subTotal - $tax;
      $this->response['method'] = $cards;
      return $this->response();
    }

    public function getStripeCards($accountId){
      $result = StripeCard::where('account_id', '=', $accountId)->get();
      return (sizeof($result) > 0) ? $result[0] : null;
    }
}
