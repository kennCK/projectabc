<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stripe;
use Carbon\Carbon;
class StripeController extends APIController
{

    protected $stripe;
    public function authorize(Request $request){
      $data = $request->all();
      $this->stripe = new Stripe();
      $checkout = $data['checkout'];
      $source = $data['source'];
      $account = $data['account'];
      $customer = $this->stripe->createCustomer($account['email'], $source['id'], $account['name']);
      if($customer->id){
        $charge = $this->stripe->chargeCustomer($account['email'], $source['id'], $customer->id, (floatval($checkout['total']) * 100), "ID FACTORY BILLING FOR ID PRINTING ");
        if($charge->status == 'succeeded'){
          // update checkout
          // get templates if template


          return response()->json(
            'data'  => true,
            'error' => null,
            'timestamps'  => Carbon::now()
          );
        }else{
          return response()->json(
            'data'  => true,
            'error' => 'Unable to charge.',
            'timestamps'  => Carbon::now()
          );
        }
      }else{
        return response()->json(
          'data'  => null,
          'error' => 'Card is invalid',
          'timestamps'  => Carbon::now()
        );
      }
    }



}
