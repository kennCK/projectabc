<?php

namespace Increment\Messenger\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Messenger\Models\MessengerGroup;
use Increment\Messenger\Models\MessengerMember;
use Increment\Messenger\Models\MessengerMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class MessengerGroupController extends APIController
{
    function __construct(){
      $this->model = new MessengerGroup();
    }

    public function retrieve(Request $request){
      $data = $request->all();

      $this->retrieveDB($data);

      if(sizeof($this->response['data']) > 0){
        $i = 0;

        foreach ($variable as $key => $value) {
          $this->response['data'][$i]['account'] = $this->retrieveAccountDetails($this->response['data'][$i]['account_id']);
          $i++;
        }
      }

      return $this->response();
    }

}
