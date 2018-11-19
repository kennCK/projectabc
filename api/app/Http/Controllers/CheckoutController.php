<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkout;
use App\CheckoutItem;
use App\StripeCard;
use App\PaymentMethod;
class CheckoutController extends APIController
{
    protected $subTotal = 0;
    protected $total = 0;
    protected $tax = 0;

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
          $this->response['data'][$i]['items'] = $this->getItems($result[$i]['id']);
          $i++;
        }
      }else{
        $this->response['data'][0]['items'] = null;
      }
      $this->response['data'][0]['sub_total'] = $this->subTotal;
      $this->response['data'][0]['tax'] = $this->tax;
      $this->response['data'][0]['total'] = $this->subTotal - $this->tax;
      $this->response['method'] = $cards;
      return $this->response();
    }

    public function getItems($checkoutId){
      $result = CheckoutItem::where('checkout_id', '=', $checkoutId)->get();
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $payload = $result[$i]['payload'];
          $payloadValue = $result[$i]['payload_value'];
          if($payload == 'template'){
            $result[$i]['template'] = $this->getTemplateDetails($payloadValue);
            $result[$i]['objects'] = $this->getObjects($payloadValue);
          }else if($payload == 'employee'){
            $result[$i]['employee'] = $this->getEmployee($payloadValue);
          }
          $this->subTotal += $result[$i]['price'];
          $i++;
        }
        return $result;
      }else{
        return null;
      }
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
