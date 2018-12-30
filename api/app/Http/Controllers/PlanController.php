<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;
class PlanController extends APIController
{
		protected $subTotal = 0;
    protected $total = 0;
    protected $tax = 0;

    function __construct(){
    	$this->model = new Plan();

    	$this->notRequired = array(
    		'start', 'end'
    	);
    }

    public function retrieve(Request $request){
    	$data = $request->all();
    	$cards = $this->getPaymentMethod('account_id', $data['account_id']);
    	$this->retrieveDB($data);
      $result = $this->response['data'];

      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $this->subTotal += $result[$i]['total_amount'];
          $this->response['data'][$i]['months'] = intval($result[$i]['total_amount']) / intval($result[$i]['price']);
          $i++;
        }
      }
      
      $this->response['method'] = $cards;
      $this->response['sub_total'] = $this->subTotal;
      $this->response['tax'] = $this->tax;
      $this->response['total'] = $this->subTotal - $this->tax;
      return $this->response();
    }
}
