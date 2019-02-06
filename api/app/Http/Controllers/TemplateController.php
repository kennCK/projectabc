<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
use App\Guide;
class TemplateController extends APIController
{
    function __construct(){
    	$this->model = new Template();
      $this->notRequired = array(
        'purchased'
      );
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
          $this->response['data'][$i]['guide'] = ($result[$i]['status'] == 'purchased') ? $this->getGuide($result[$i]['purchased']) : $this->getGuide($result[$i]['id']);
          $this->response['data'][$i]['active'] = false;
         $i++; 
        }
      }
      return $this->response();
    }

    public function retriveTemplateOnly(Request $request){
      $data = $request->all();
      $this->model = new Template();
      $this->retrieveDB($data);
      return $this->response();
    }

    public function getGuide($id){
      $result = Guide::where('payload_value', '=', $id)->where('payload', '=', 'template')->get();
      return (sizeof($result) > 0) ? $result[0] : null;
    }
}
