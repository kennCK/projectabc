<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Object;
use App\Attribute;
use Carbon\Carbon;
class ObjectController extends APIController
{
    function __construct(){
      $this->model = new Object();

      $this->notRequired = array(
        'name', 'content'
      );
    }


    public function create(Request $request){
      $data = $request->all();
      $objects = $data['objects'];
      if(sizeof($objects) > 0){
        for ($i = 0; $i < sizeof($objects); $i++) {
          if($objects[$i]['new'] == false){
            // update
            $this->model = new Object();
            $objectId = $objects[$i]['id'];
            $objectUpdate = array(
              'id'  => $objectId,
              'name'        => $objects[$i]['name'],
              'content'     => $objects[$i]['content'],
              'type'        => $objects[$i]['type']
            );
            $this->updatDB($objectUpdate);

            if($this->response['data'] == true){
              $j = 0;
              $attributes = $objects[$i]['attributes'];
              foreach ($attributes as $key => $value) {
                $attribUpdate = array(
                  'value'     => $value,
                  'updated_at'  => Carbon::now()
                );

                Attribute::where('payload', '=', 'object')->where('payload_value', '=', $objectId)->where('attribute', '=', $key)->update($attribUpdate);
              }
            }else{
              // return error
            }
          }else{
            // create
            $this->model = new Object();
            $objectInsert = array(
              'template_id' => $objects[$i]['template_id'],
              'name'        => $objects[$i]['name'],
              'content'     => $objects[$i]['content'],
              'type'        => $objects[$i]['type']
            );
            $this->insertDB($objectInsert);
            if($this->response['data'] > 0){
              $attributes = $objects[$i]['attributes'];
              foreach ($attributes as $key => $value) {
                $attrbModel = new Attribute();
                $attrbModel->payload = 'object';
                $attrbModel->payload_value = $this->response['data'];
                $attrbModel->attribute = $key;
                $attrbModel->value = $value;
                $attrbModel->created_at = Carbon::now();
                $attrbModel->save();

                if($attrbModel->id > 0){
                }else{
                  // return error
                }
              }
            }else{
              // return error
            }
          }
        }
        return response()->json(
          array(
            'data'  => true,
            'error' => 'Empty',
            'timestamps' => Carbon::now()
          )
        );
      }else{
        return response()->json(
          array(
            'data'  => null,
            'error' => 'Empty',
            'timestamps' => Carbon::now()
          )
        );
      }
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $this->model = new Object();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $this->response['data'][$i]['attributes'] = $this->getAttributes($result[$i]['id']);
          $this->response['data'][$i]['new'] = false;
         $i++; 
        }
      }
      return $this->response();
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
