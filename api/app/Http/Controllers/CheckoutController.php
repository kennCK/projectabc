<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkout;
use App\StripeCard;
use App\PaymentMethod;
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
      $cards = $this->getPaymentMethod($data['account_id']);
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

    public function getPaymentMethod($accountId){
      $result = PaymentMethod::where('account_id', '=', $accountId)->where('status', '=', 'active')->get();
      if(sizeof($result) > 0){
        $payload = $result[0]['payload'];
        $payloadValue = $result[0]['payload_value'];
        $result[0]['stripe'] = null;
        $result[0]['paypal'] = null;
        if($payload == 'credit_card'){
          // stripe
          $cards = StripeCard::where('id', '=', $payloadValue)->first();
          $result[0]['stripe'] = ($cards) ? $cards : null;
        }else if($payload == 'paypal'){
          // paypal
        }else if($payload == 'cod'){
          // cod
        }
      }
      return (sizeof($result) > 0) ? $result[0] : null;
    }
}
