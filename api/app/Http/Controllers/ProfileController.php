<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
class ProfileController extends APIController
{
    function __construct(){
    	$this->model = new Profile();
      $this->validation = array(  
        "email" => "unique:profiles"
      );
      $this->notRequired = array(
        'profile', 'employment_code', 'first_name', 'last_name', 'middle_name',
        'birth_date', 'sex', 'contact_number', 'address', 'position',
        'department', 'emergency_contact_name', 'emergency_contact_number', 'signature', 'status'
      );
    }

    public function checkIfExist($accountId, $email, $firstName, $lastName){
      $result = Profile::where('account_id', '=', $accountId)->where('email', '=', $email)->where('first_name', '=', $firstName)->where('last_name', '=', $lastName)->get();
      return (sizeof($result) > 0) ? $result[0] : null;
    }

    public function updateFromController($data){
      $this->model = new Profile();
      $this->updateDB($data);
      return $this->response['data'];
    }

    public function createFromController($data){
      $this->model = new Profile();
      $this->insertDB($data);
      return $this->response;
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $accountId = $data['condition'][0]['value'];
      $this->model = new Profile();
      $this->retrieveDB($data);
      if(sizeof($this->response['data']) > 0){
        $i = 0;
        $counter = 0;
        foreach ($this->response['data'] as $key) {
          $id = $this->response['data'][$i]['id'];
          $this->response['data'][$i]['total_comments'] = $this->getComments('profiles', $id);
          $this->response['data'][$i]['active'] = false;
          $this->response['data'][$i]['checkout'] = $this->getCheckout('profile', $id, $accountId);
          $this->response['data'][$i]['counter'] = $counter;
          $counter++;
          $i++;
          if($counter == 2){
            $counter = 0;
          }
        }
      }
      $this->response['active_templates'] = app('App\Http\Controllers\ActiveTemplateController')->retrieveByAccountId($accountId);
      return $this->response();
    }

    public function retrieveById($id){
      $result = Profile::where('id', '=', $id)->get();
      if(sizeof($result) > 0){
        $i = 0;
        $result[0]['variables'] =  app('App\Http\Controllers\GovernmentController')->retrieveById($id);
        return $result[0];
      }else{
        return null;
      }
    }
}
