<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkout;
use App\CheckoutItem;
use App\Template;
use App\CustomObject;
use App\Attribute;
use Carbon\Carbon;
class MarketplaceController extends APIController
{
    public function retrieve(Request $request){
      $data = $request->all();
      $accountId = $data['account_id'];
      $cart = $this->getCart($accountId);
      $result = null;
      if($cart !== null){
      	$result = Template::whereNotIn('id', $cart)->where('status', '=', 'marketplace')->get();
      }else{
      	$result = Template::where('status', '=', 'marketplace')->get();
      }
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $result[$i]['objects'] = $this->getObjects($result[$i]['id']);
          $result[$i]['active'] = false;
         $i++; 
        }
      }
      return response()->json(array(
      	'data'	=> $result,
      	'error'	=> null,
      	'timestamps'	=> Carbon::now()
      ));
    }

    public function getCart($accountId){
    	$checkout = Checkout::where('account_id', '=', $accountId)->where('status', '=', 'added')->first();
			$array = [];
      if($checkout){
        $items = CheckoutItem::where('checkout_id', '=', $checkout->id)->get();
        if(sizeof($items) > 0){
          $i = 0;
          foreach ($items as $key) {
            $array[] = $items[$i]['payload_value'];
            $i++;
          }
        }
      }
      return (sizeof($array) > 0) ? $array : null;
    }
}
