<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pricing;
use App\Product;
class PricingController extends APIController
{
    function __construct(){
    	$this->model = new Pricing();
    }

    public function retrieve(Request $request){
    	$data = $request->all();
    	$this->retrieveDB($data);
    	$result = $this->response['data'];
    	if(sizeof($result) > 0){
    		$i = 0;

    		foreach ($result as $key) {
    			$this->response['data'][$i]['product'] = $this->getProduct($result[$i]['product_id']);
    			$i++;
    		}
    	}
    	return $this->response();
    }

    public function getProduct($productId){
    	$result = Product::where('id', '=', $productId)->first();
    	return ($result) ? $result : null;
    }
}
