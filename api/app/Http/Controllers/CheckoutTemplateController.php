<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CheckoutTemplate;
class CheckoutTemplateController extends APIController
{

    function __construct(){
    	$this->model = new CheckoutTemplate();
      $this->notRequired = array(
        'front',
        'back'
      );
    }

    public function retrieveById($column, $value){
    	$result = CheckoutTemplate::where($column, '=', $value)->get();
    	if(sizeof($result) > 0){
    		$result[0]['front'] = ($result[0]['front'] != null) ? app('App\Http\Controllers\TemplateController')->retrieveById($result[0]['front'] ) : null;

    		$result[0]['back'] = ($result[0]['back'] != null) ? app('App\Http\Controllers\TemplateController')->retrieveById($result[0]['back'] ) : null;
    	}
    	return (sizeof($result) > 0) ? $result[0] : null;
    }
}
