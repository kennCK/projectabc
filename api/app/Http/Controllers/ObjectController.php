<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomObject;
use App\Attribute;
use App\AccountImage;
use Carbon\Carbon;
class ObjectController extends APIController
{
    function __construct(){
      $this->model = new CustomObject();

      $this->notRequired = array(
        'name', 'content'
      );
    }

    private $completeName = array('c_name', 'complete_name');
    private $syncColumns = [];

    public function create(Request $request){
      $data = $request->all();
      $objects = $data['objects'];
      if(sizeof($objects) > 0){
        for ($i = 0; $i < sizeof($objects); $i++) {
          if($objects[$i]['new'] == 'false'){
            // update

            $this->model = new CustomObject();
            $objectId = $objects[$i]['id'];
            $objectUpdate = array(
              'id'  => $objectId,
              'name'        => $objects[$i]['name'],
              'content'     => $objects[$i]['content'],
              'type'        => $objects[$i]['type'],
              'settings'    => $objects[$i]['settings']
            );
            $this->updateDB($objectUpdate);

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

            $objModel = new CustomObject();
            $objModel->template_id = $objects[$i]['template_id'];
            $objModel->name = $objects[$i]['name'];
            $objModel->content = $objects[$i]['content'];
            $objModel->type = $objects[$i]['type'];
            $objModel->settings = $objects[$i]['settings'];
            $objModel->created_at = Carbon::now();
            $objModel->save();
            if($objModel->id > 0){
              $attributes = $objects[$i]['attributes'];
              foreach ($attributes as $key => $value) {
                $attrbModel = new Attribute();
                $attrbModel->payload = 'object';
                $attrbModel->payload_value = $objModel->id;
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

    public function upload(Request $request){

      $data = $request->all();
      
      $url = null;
      if(isset($data['file_url'])){
        $date = Carbon::now()->toDateString();
        $time = str_replace(':', '_',Carbon::now()->toTimeString());
        $ext = $request->file('file')->extension();
        $filename = $data['template_id'].'_'.$data['account_id'].'_'.$date.'_'.$time.'.'.$ext;
        $result = $request->file('file')->storeAs('images', $filename);
        $url = '/storage/image/'.$filename;
        $account = new AccountImage();
        $account->account_id = $data['account_id'];
        $account->url = $url;
        $account->created_at = Carbon::now();
        $account->save();
      }else{
        $url = null;
      }

      return response()->json(array(
        'data'  => $url,
        'error' => null,
        'timestamps' => Carbon::now()
      ));
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $this->model = new CustomObject();
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

    public function retrieveDynamicWithoutAttributes(Request $request){
      $data = $request->all();
      $front = $data['front'];
      $back = $data['back'];
      $frontResult = CustomObject::where('template_id', '=', $front)->where('settings', '=', 'dynamic')->orderBy('name', 'asc')->get();
      $backResult = CustomObject::where('template_id', '=', $back)->where('settings', '=', 'dynamic')->orderBy('name', 'asc')->get();
      
      if(sizeof($frontResult) > 0){
        $i = 0;
        foreach ($frontResult as $key) {
          $this->getColumnDecoder($frontResult[$i]);
          $i++; 
        }
      }
      if(sizeof($backResult) > 0){
        $i = 0;
        foreach ($backResult as $key) {
          $this->getColumnDecoder($backResult[$i]);
          $i++; 
        }
      }
      return response()->json(array(
        'data'  => $this->syncColumns,
        'error' => null,
        'timestamps'  => Carbon::now()
      ));
    }

    public function getColumnDecoder($object){
      if(in_array($object['name'], $this->completeName)){
        $array = array(
          'template_id' => null,
          'type'        => $object['type'],
          'column'      => 'first_name',
          'value'       => null,
          'delete'      => false
        );
        $this->syncColumns[] = $array; 

        $array = array(
          'template_id' => null,
          'type'        => $object['type'],
          'column'      => 'middle_name',
          'value'       => null,
          'delete'      => false
        );
        $this->syncColumns[] = $array; 

        $array = array(
          'template_id' => null,
          'type'        => $object['type'],
          'column'      => 'last_name',
          'value'       => null,
          'delete'      => false
        );
        $this->syncColumns[] = $array; 

      }else{
        $array = array(
          'template_id' => null,
          'type'        => $object['type'],
          'column'      => $object['name'],
          'value'       => null,
          'delete'      => false
        );

        $this->syncColumns[] = $array; 
      }
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
