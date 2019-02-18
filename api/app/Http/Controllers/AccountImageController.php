<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountImage;
class AccountImageController extends APIController
{
    function __construct(){
      $this->model = new AccountImage();

      $this->notRequired = array(
      	'payload', 'payload_value', 'status'
      );
    }

    public function retrieve(Request $request){
    	$data = $request->all();
    	$this->model = new AccountImage();
    	$this->retrieveDB($data);
    	if(sizeof($this->response['data']) > 0){
    		$i = 0;
    		foreach ($this->response['data'] as $key) {
    			$this->response['data'][$i]['active'] = false;
    			$i++;
    		}
    	}
    	return $this->response();
    }
}
