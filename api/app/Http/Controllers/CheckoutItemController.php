<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CheckoutItem;
use App\Checkout;
use App\Account;
class CheckoutItemController extends APIController
{
    function __construct(){
    	$this->model = new CheckoutItem();
    }

    public function create(Request $request){
    	$data = $request->all();

    	$accountId = $data['account_id'];
    	$checkout = Checkout::where('account_id', '=', $accountId)->where('status', '=', 'added')->first();
    	if($checkout){
    		$data['checkout_id'] = $checkout->id;
    		$this->model = new CheckoutItem();
    		$this->insertDB($data);
    		return $this->response();
    	}else{
    		$checkout = new Checkout();
    		$checkout->account_id = $data['account_id'];
            $checkout->order_number = $this->getOrderNumber($data['account_id']);
    		$checkout->sub_total = 0;
    		$checkout->tax = 0;
    		$checkout->total = 0;
    		$checkout->status = 'added';
    		$checkout->save();
    		if($checkout->id){
    			$data['checkout_id'] = $checkout->id;
	    		$this->model = new CheckoutItem();
	    		$this->insertDB($data);
	    		return $this->response();
    		}else{
		    	return response()->json(array(
		    		'data'	=> null,
		    		'error' => null,
		    		'timestamps' => Carbon::now()
		    	));
    		}
    	}
    	
    }
    public function getOrderNumber($accountId){
      $account = Account::where('id', '=', $accountId)->first();
      if($account){
        $checkouts = Checkout::where('account_id', '=', $accountId)->count();
        if($checkouts){
          if($checkouts >= 1000){
            return $account->order_suffix.($checkouts + 1);
          }else if($checkouts >= 100){
            return $account->order_suffix.'0'.($checkouts + 1);
          }else if($checkouts >= 10){
            return $account->order_suffix.'00'.($checkouts + 1);
          }else if($checkouts >= 0){
            return $account->order_suffix.'000'.($checkouts + 1);
          }
        }else{
          return $account->order_suffix.'0001';
        }
      }
      return null;
    }
}
