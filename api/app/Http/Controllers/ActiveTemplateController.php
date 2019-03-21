<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActiveTemplate;
class ActiveTemplateController extends APIController
{
    function __construct(){
      $this->model = new ActiveTemplate();
      $this->notRequired = array(
        'front', 'back'
      );
    }

    public function create(Request $request){
    	$data = $request->all();
    	$result = null;
    	$updateData = array();
    	$inserData = array(
    		'account_id' => $data['account_id']
    	);
    	$result = ActiveTemplate::where('account_id', '=', $data['account_id'])->get();

    	if(sizeof($result) > 0){
    		$updateData['id'] = $result[0]['id'];
    		if($data['settings'] == 'front'){
    			$updateData['front'] = $data['front'];
    		}else{
    			$updateData['back'] = $data['back'];
    		}

    		$this->model = new ActiveTemplate();
    		$this->updateDB($updateData);
    		return $this->response();
    	}else{
    		if($data['settings'] == 'front'){
    			$inserData['front'] = $data['front'];
    		}else{
    			$inserData['back'] = $data['back'];
    		}

    		$this->model = new ActiveTemplate();
    		$this->insertDB($inserData);
    		return $this->response();
    	}
    }
}
