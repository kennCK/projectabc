<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attribute;
use Carbon\Carbon;
class AttributeController extends APIController
{
    function __construct(){
      $this->model = new Attribute();
    }

    public function updateTableView(Request $request){
    	$data = $request->all();
    	$attribute = $data['attribute'];
    	$payloadValue = $data['payload_value'];
    	$value = $data['value'];

    	$result = Attribute::where('attribute', '=', $attribute)->where('payload_value', '=', $payloadValue)->where('payload', '=', 'object')->update(array(
    		'value'	=> $value,
    		'updated_at' => Carbon::now()
    	));
    	return response()->json(array(
    		'data' => true,
    		'timestamps' => Carbon::now()
    	));
    }
}
