<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkout;
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
    	$cart = Checkout::where('account_id', '=', $accountId)->where('status', '=', 'added')->get();
			$array = [];
    	if(sizeof($cart) > 0){
      	$i = 0;
      	foreach ($cart as $key) {
      		$array[] = $cart[$i]['payload_value'];
      		$i++;
      	}
      }
      return (sizeof($array) > 0) ? $array : null;
    }
}
