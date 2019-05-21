<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CheckoutPartner;
class CheckoutPartnerController extends APIController
{
    function __construct(){
    	$this->model = new CheckoutPartner();
    }

    public function create(Request $request){
    	$data = $request->all();
    	$exist = CheckoutPartner::where('checkout_id', '=', $data['checkout_id'])->get();

    	if(sizeof($exist) > 0){
    		// update
    		$this->model = new CheckoutPartner();
    		$data['id'] = $exist[0]['id'];
    		$this->updateDB($data);
    		return $this->response();
    	}else{
    		$this->model = new CheckoutPartner();
    		$this->insertDB($data);
    		return $this->response();
    	}
    }
}
