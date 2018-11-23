<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkout;
use App\CheckoutItem;
use App\StripeCard;
use App\PaymentMethod;
use App\Pricing;
use App\Client;
use App\StripeWebhook;
use Carbon\Carbon;
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
          $price = $this->getPrice($result[$i]['id'], $data['account_id']);
          $this->response['data'][$i]['items'] = $this->getItems($result[$i]['id'], $price);
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
          $price = $this->getPrice($result[$i]['id'], $data['account_id']);
          $this->response['data'][$i]['templates'] = $this->getItemBy($result[$i]['id'], 'template', null);
          $this->response['data'][$i]['employees'] = $this->getItemBy($result[$i]['id'], 'employee', $price);
          // $this->response['data'][$i]['sub_total'] = $this->subTotal;
          // $this->response['data'][$i]['tax'] = $this->tax;
          // $this->response['data'][$i]['total'] = $this->subTotal - $this->tax;
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

    public function getPrice($checkoutId, $accountId){
      $total = $this->getItemSize($checkoutId, 'employee');
      $partner = Client::where('client', '=', $accountId)->first();
      $price = 0;
      if($partner){
        $result = Pricing::where('account_id', '=', $partner->partner)->Where('minimum', '<=', $total)->where('maximum', '>=', $total)->first();
        return ($result) ? $result->price : 0;
      }else{
        return 0;
      }
    }

    public function getItemSize($checkoutId, $payload){
      return CheckoutItem::where('checkout_id', '=', $checkoutId)->where('payload', '=', $payload)->count();
    }

    public function getItemBy($checkoutId, $payload, $price = null){
      $result = CheckoutItem::where('checkout_id', '=', $checkoutId)->where('payload', '=', $payload)->get();
      $this->subTotal = 0;
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $payload = $result[$i]['payload'];
          $payloadValue = $result[$i]['payload_value'];
          if($payload == 'template'){
            $result[$i]['template'] = $this->getTemplateDetails($payloadValue);
            $result[$i]['objects'] = $this->getObjects($payloadValue);
            $this->subTotal += $result[$i]['price'];
          }else if($payload == 'employee'){
            $result[$i]['employee'] = $this->getEmployee($payloadValue);
            if($result[$i]['employee']){
              $result[$i]['employee']['price'] = $price;
              $this->subTotal += $price;
            }
          }
          $i++;
        }
        return $result;
      }else{
        return null;
      }
    }

    public function getItems($checkoutId, $price){
      $result = CheckoutItem::where('checkout_id', '=', $checkoutId)->get();
      $this->subTotal = 0;
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $payload = $result[$i]['payload'];
          $payloadValue = $result[$i]['payload_value'];
          if($payload == 'template'){
            $result[$i]['template'] = $this->getTemplateDetails($payloadValue);
            $result[$i]['objects'] = $this->getObjects($payloadValue);
            $this->subTotal += $result[$i]['price'];
          }else if($payload == 'employee'){
            $result[$i]['employee'] = $this->getEmployee($payloadValue);
            if($result[$i]['employee']){
              $result[$i]['employee']['price'] = $price;
              $this->subTotal += $price;
            }
          }
          $i++;
        }
        return $result;
      }else{
        return null;
      }
    }


    public function update(Request $request){
      $data = $request->all();
      $accountId = $data['account_id'];
      $id = $data['id'];
      $tax = $data['tax'];
      $subTotal = $data['sub_total'];
      $total = $data['total'];
      $paymentMethodId = $data['payment_method_id'];
      $email = $data['email'];
      $title = 'Charge for order number'.$data['order_number'];
      $updateData = array(
        'id'  => $id,
        'tax' => $tax,
        'sub_total' => $subTotal,
        'total' => $total,
        'payment_method_id' => $paymentMethodId,
        'status'  => 'completed',
        'updated_at'  => Carbon::now()
      );
      $paymentMethod = $this->getPaymentMethod('id', $paymentMethodId);
      $charge = null;
      if($paymentMethod->payload == 'credit_card'){
        $stripe = new StripeWebhook();
        $charge = $stripe->chargeCustomer($email, $paymentMethod->stripe->source, $paymentMethod->stripe->customer, $total, $title);
      }

      if($charge && $charge->status == 'succeeded'){
        $this->model = new Checkout();
        $this->updateDB($updateData);
        return $this->response();
      }else{
        return response()->json(array(
          'data'  => false,
          'error' => 'Unable to charge',
          'timestamps'  => Carbon::now()
        ));
      }
    }
}
