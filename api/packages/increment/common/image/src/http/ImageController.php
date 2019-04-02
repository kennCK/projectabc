<?php

namespace Increment\Common\Image\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Increment\Common\Image\Models\Image;
use App\Http\Controllers\APIController;
class ImageController extends APIController
{
    function __construct(){
      $this->model = new Image();

      $this->notRequired = array(
        'payload', 'payload_value', 'status'
      );
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $this->model = new Image();
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
      if(isset($data['file_url'])){
        $date = Carbon::now()->toDateString();
        $time = str_replace(':', '_',Carbon::now()->toTimeString());
        $ext = $request->file('file')->extension();
        $filename = $data['account_id'].'_'.$date.'_'.$time.'.'.$ext;
        $result = $request->file('file')->storeAs('images', $filename);
        $url = '/storage/image/'.$filename;
        $this->model = new Image();
        $insertData = array(
          'account_id'    => $data['account_id'],
          'url'           => $url,
          'payload'       => $data['payload'],
          'payload_value' => $data['payload_value'],
          'status'        => $data['status']
        );
        $this->insertDB($insertData);
        return $this->response();
      }
      return response()->json(array(
        'data'  => null,
        'error' => null,
        'timestamps' => Carbon::now()
      ));
    }

    public function checkIfExist($payload, $payloadValue, $status){
      $result = Image::where('payload','=', $payload)->where('payload_value','=', $payloadValue)->where('status','=',$status)->get();
      return (sizeof($result) > 0) ? $result[0] : null;
    }

}
