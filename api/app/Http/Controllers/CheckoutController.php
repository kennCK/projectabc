<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkout;
use App\CheckoutItem;
use App\StripeCard;
use App\PaymentMethod;
use App\Pricing;
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
      $cards = $this->getPaymentMethod('account_id', $data['account_id']);
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $this->response['data'][$i]['items'] = $this->getItems($result[$i]['id']);
          $this->response['data'][$i]['sub_total'] = $this->subTotal;
          $this->response['data'][$i]['tax'] = $this->tax;
          $this->response['data'][$i]['total'] = $this->subTotal - $this->tax;
          if($result[$i]['payment_method_id'] != null){
            $this->response['data'][$i]['method'] = $this->getPaymentMethod('id', $result[$i]['payment_method_id']);
          }else{
            $this->response['data'][$i]['method'] = null;
          }
          $i++;
        }
      }
      
      $this->response['method'] = $cards;
      return $this->response();
    }

    public function retrieveSummary(Request $request){
      $data = $request->all();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      $cards = $this->getPaymentMethod('account_id', $data['account_id']);
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $this->response['data'][$i]['templates'] = $this->getItemBy($result[$i]['id'], 'template');
          $this->response['data'][$i]['employees'] = $this->getItemBy($result[$i]['id'], 'template');
          $this->response['data'][$i]['sub_total'] = $this->subTotal;
          $this->response['data'][$i]['tax'] = $this->tax;
          $this->response['data'][$i]['total'] = $this->subTotal - $this->tax;
          if($result[$i]['payment_method_id'] != null){
            $this->response['data'][$i]['method'] = $this->getPaymentMethod('id', $result[$i]['payment_method_id']);
          }else{
            $this->response['data'][$i]['method'] = null;
          }
          $i++;
        }
      }
      
      $this->response['method'] = $cards;
      return $this->response();
    }

    public function getItemBy($checkoutId, $payload){
      $result = CheckoutItem::where('checkout_id', '=', $checkoutId)->where('payload', '=', $payload)->get();
      $this->subTotal = 0;
      $this->total = 0;
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

    public function getItems($checkoutId){
      $result = CheckoutItem::where('checkout_id', '=', $checkoutId)->get();
      $this->subTotal = 0;
      $this->total = 0;
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

    public function getPaymentMethod($column, $value){
      $result = PaymentMethod::where($column, '=', $value)->where('status', '=', 'active')->get();
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
