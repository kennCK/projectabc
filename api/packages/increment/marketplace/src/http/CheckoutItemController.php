<?php

namespace Increment\Marketplace\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Marketplace\Models\CheckoutItem;
use Increment\Marketplace\Models\Checkout;
use App\CheckoutTemplate;
use App\Account;
use Carbon\Carbon;
class CheckoutItemController extends APIController
{
    function __construct(){
    	$this->model = new CheckoutItem();
    }

    public function create(Request $request){
    	$data = $request->all();
      $insertData = array(
        'account_id' => $data['account_id'],
        'payload' => $data['payload'],
        'payload_value' => $data['payload_value'],
        'price' => $data['price'],
        'qty' => $data['qty'],
        'status' => 'printing'
      );
    	$accountId = $data['account_id'];
    	$checkout = Checkout::where('account_id', '=', $accountId)->where('status', '=', 'added')->first();
    	if($checkout){
    		$insertData['checkout_id'] = $checkout->id;
    		$this->model = new CheckoutItem();
    		$this->insertDB($insertData);
    		return $this->response();
    	}else{
    		$checkout = new Checkout();
        $checkout->payload = $data['type'];
    		$checkout->account_id = $data['account_id'];
        $checkout->order_number = $this->getOrderNumber($data['account_id']);
    		$checkout->sub_total = 0;
    		$checkout->tax = 0;
    		$checkout->total = 0;
    		$checkout->status = 'added';
        $checkout->printing_status = 'added';
    		$checkout->save();
    		if($checkout->id){
          if($data['payload'] == 'profile'){
            // save checkout template for profiles checkout
            $checkoutTemplate = new CheckoutTemplate();
            $checkoutTemplate->checkout_id = $checkout->id;
            $checkoutTemplate->front = $data['front'];
            $checkoutTemplate->back = $data['back'];
            $checkoutTemplate->created_at = Carbon::now();
            $checkoutTemplate->save();
          }
          
    			$insertData['checkout_id'] = $checkout->id;
	    		$this->model = new CheckoutItem();
	    		$this->insertDB($insertData);
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
