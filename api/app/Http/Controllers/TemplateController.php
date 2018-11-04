<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
use App\Object;
use App\Attribute;
class TemplateController extends APIController
{
    function __construct(){
    	$this->model = new Template();
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $this->model = new Template();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $this->response['data'][$i]['objects'] = $this->getObjects($result[$i]['id']);
          $this->response['data'][$i]['active'] = false;
         $i++; 
        }
      }
      return $this->response();
    }

    public function getObjects($id){
      $result = Object::where('template_id', '=', $id)->get();
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $result[$i]['attributes'] = $this->getAttributes($result[$i]['id']);
          $result[$i]['new'] = false;
         $i++; 
        }
      }
      return (sizeof($result) > 0) ? $result : null;
    }

    public function getAttributes($id){
      $result = Attribute::where('payload', '=', 'object')->where('payload_value', '=', $id)->get();
      $response = array();
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $response[$result[$i]['attribute']] = $result[$i]['value'];
          $i++;
        }
        return $response;
      }
      return null;
    }
}
