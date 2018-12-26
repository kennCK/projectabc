<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\Checkout;
use App\CheckoutItem;
use App\StripeCard;
use App\PaymentMethod;
use App\Pricing;
use App\Client;
use App\Template;
use App\CustomObject;
use App\Attribute;
use App\PaypalTransaction;
use App\StripeWebhook;
use Carbon\Carbon;
class CheckoutController extends APIController
{
    protected $subTotal = 0;
    protected $total = 0;
    protected $tax = 0;

    function __construct(){
    	$this->model = new Checkout();

      $this->notRequired = array(
        'order_number',
        'payment_type',
        'payment_payload',
        'payment_payload_value'
      );
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
          if($result[$i]['payment_type'] == 'authorized' && $result[$i]['payment_payload'] == 'credit_card'){
            $this->response['data'][$i]['method'] = $this->getPaymentMethod('id', $result[$i]['payment_payload_value']);
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
          if(($result[$i]['payment_type'] == 'authorized' || $result[$i]['payment_type'] == 'express') && $result[$i]['payment_payload'] == 'credit_card'){
            $this->response['data'][$i]['method'] = $this->getPaymentMethod('id', $result[$i]['payment_payload_value']);
          }else if($result[$i]['payment_type'] == 'express' && $result[$i]['payment_payload'] == 'paypal'){
            $this->response['data'][$i]['method'] = $this->getPaypalTransaction($result[$i]['payment_payload_value']);
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
      $paymentType = $data['payment_type'];
      $paymentPayload = $data['payment_payload'];
      $paymentPayloadValue = $data['payment_payload_value'];
      $email = $data['email'];
      $title = 'Charge for order number'.$data['order_number'];
      $updateData = array(
        'id'  => $id,
        'tax' => $tax,
        'sub_total' => $subTotal,
        'total' => $total,
        'payment_type' => $paymentType,
        'payment_payload' => $paymentPayload,
        'status'  => 'completed',
        'updated_at'  => Carbon::now()
      );
      if(($paymentType == 'authorized' || $paymentType == 'express') && $paymentPayload == 'credit_card'){
        $paymentMethod = $this->getPaymentMethod('id', $paymentPayloadValue);
        $updateData['payment_payload_value'] = $paymentPayloadValue;
        $charge = null;
        if($paymentMethod->payload == 'credit_card'){
          $stripe = new StripeWebhook();
          $charge = $stripe->chargeCustomer($email, $paymentMethod->stripe->source, $paymentMethod->stripe->customer, $total, $title);
        }

        if($charge && $charge->status == 'succeeded'){
          $this->model = new Checkout();
          $this->updateDB($updateData);
          $this->managePurchasedTemplate($updateData['id']);
          return $this->response();
        }else{
          return response()->json(array(
            'data'  => false,
            'error' => 'Unable to charge',
            'timestamps'  => Carbon::now()
          ));
        }
      }else if($paymentType == 'express' && $paymentPayload == 'paypal'){
        $payerInfo = $paymentPayloadValue['payer']['payer_info'];
        $paypal = new PaypalTransaction();
        $paypal->account_id = $accountId;
        $paypal->paypal = $paymentPayloadValue['id'];
        $paypal->cart = $paymentPayloadValue['cart'];
        $paypal->email = $payerInfo['email'];
        $paypal->first_name = $payerInfo['first_name'];
        $paypal->middle_name = $payerInfo['middle_name'];
        $paypal->last_name = $payerInfo['last_name'];
        $paypal->payer = $payerInfo['payer_id'];
        $paypal->total = $total;
        $paypal->currency = 'PHP';
        $paypal->save();

        if($paypal->id){
          $updateData['payment_payload_value'] = $paypal->id;
          $this->model = new Checkout();
          $this->updateDB($updateData);
          $this->managePurchasedTemplate($updateData['id']);
          return $this->response();
        }else{
          return response()->json(array(
            'data'  => false,
            'error' => 'Unable to charge',
            'timestamps'  => Carbon::now()
          ));
        }
      }else{
          return response()->json(array(
            'data'  => false,
            'error' => 'Unable to charge',
            'timestamps'  => Carbon::now()
          ));
      }
    }

    public function getOrderNumber($accountId){
      $account = Account::where('id', '=', $accountId)->first();
      if($account){
        $checkouts = Checkout::where('account_id', '=', $accountId)->count();
        if($checkouts){
          if($checkouts >= 1000){
            return $account->order_suffix.$checkouts;
          }else if($checkouts >= 100){
            return $account->order_suffix.'0'.$checkouts;
          }else if($checkouts >= 10){
            return $account->order_suffix.'00'.$checkouts;
          }else if($checkouts >= 0){
            return $account->order_suffix.'000'.$checkouts;
          }
        }else{
          return $account->order_suffix.'0001';
        }
      }
      return null;
    }

    public function managePurchasedTemplate($checkoutId){
      $templates = CheckoutItem::where('checkout_id', '=', $checkoutId)->where('payload', 'template')->get();
      if(sizeof($templates) > 0){
        $i = 0;
        foreach ($templates as $key) {
          $template = $this->getTemplateDetails($templates[$i]['payload_value']);
          if($template != null){
            $pTemplate = new Template();
            $pTemplate->account_id  = $templates[$i]['account_id'];
            $pTemplate->title       = $template['title'];
            $pTemplate->settings    = $template['settings'];
            $pTemplate->height      = $template['height'];
            $pTemplate->width       = $template['width'];
            $pTemplate->status      = 'purchased';
            $pTemplate->purchased   = $template['id'];
            $pTemplate->categories  = $template['categories'];
            $pTemplate->price       = $template['price'];
            $pTemplate->created_at  = Carbon::now();
            $pTemplate->save();
            if($pTemplate->id){
              $this->managePurchasedObjects($templates[$i]['payload_value'], $pTemplate->id);
            }
          }
          $i++;
        }
      }
    }

    public function managePurchasedObjects($oldTemplateId, $newTemplateId){
       $objects = $this->getPruchasedObjects($oldTemplateId);
       if(sizeof($objects) > 0){
          $i = 0;
          foreach ($objects as $key) {
            $customObject = new CustomObject();
            $customObject->template_id = $newTemplateId;
            $customObject->name = $objects[$i]['name'];
            $customObject->type = $objects[$i]['type'];
            $customObject->content = $objects[$i]['content'];
            $customObject->settings = $objects[$i]['settings'];
            $customObject->created_at = Carbon::now();
            $customObject->save();
            if($customObject->id){
              $this->managePurchasedAttributes($objects[$i]['attributes'], $customObject->id);
            }
            $i++;
          }
       }
    }

    public function managePurchasedAttributes($attributes, $objectId){
      if(sizeof($attributes) > 0){
        $i = 0;
        foreach ($attributes as $key) {
          $attribute = new Attribute();
          $attribute->payload = 'object';
          $attribute->payload_value = $objectId;
          $attribute->attribute = $attributes[$i]['attribute'];
          $attribute->value = $attributes[$i]['value'];
          $attribute->created_at = Carbon::now();
          $attribute->save();
          $i++;
        }
      }
    }
}
