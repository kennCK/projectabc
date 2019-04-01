<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
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

    public function upload(Request $request){

      $data = $request->all();

      $url = null;
      if(isset($data['file_url'])){
        $date = Carbon::now()->toDateString();
        $time = str_replace(':', '_',Carbon::now()->toTimeString());
        $ext = $request->file('file')->extension();
        $filename = $data['account_id'].'_'.$date.'_'.$time.'.'.$ext;
        $result = $request->file('file')->storeAs('images', $filename);
        $url = '/storage/image/'.$filename;
        if($data['status'] == 'others'){
          $this->model = new AccountImage();
          $insertData = array(
          'account_id'=>$data['account_id'],
          'url'=>$url,
          'payload'=>'product',
          'payload_value'=>$data['payload_value'],
          'status'=>$data['status']
          );
          $this->insertDB($insertData);
          return $this->response();
        }
        $exist = $this->checkIfExist('product', $data['payload_value'], 'featured');
        
        if($exist == null){
          $this->model = new AccountImage();
          $insertData = array(
          'account_id'=>$data['account_id'],
          'url'=>$url,
          'payload'=>'product',
          'payload_value'=>$data['payload_value'],
          'status'=>$data['status']
          );
          $this->insertDB($insertData);
        }else{
          $this->model = new AccountImage();
          $uploadData = array(
            'id' => $exist['id'],
            'url' => $url
          );
          $this->updateDB($uploadData);
        }
        return $this->response();
      }else{
        $url = null;
      }

      return response()->json(array(
        'data'  => null,
        'error' => null,
        'timestamps' => Carbon::now()
      ));
    }

    public function checkIfExist($payload, $payloadValue, $status){
      $result = AccountImage::where('payload','=', $payload)->where('payload_value','=', $payloadValue)->where('status','=',$status)->get();
      return (sizeof($result) > 0) ? $result[0] : null;
    }


}
