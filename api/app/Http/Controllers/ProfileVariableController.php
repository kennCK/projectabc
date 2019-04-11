<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProfileVariable;
class ProfileVariableController extends APIController
{
	function __construct(){
		$this->model = new ProfileVariable();
	}

  public function checkIfExist($profileId, $payload){
    $result = ProfileVariable::where('profile_id', '=', $profileId)->where('payload', '=', $payload)->get();
    return (sizeof($result) > 0) ? $result[0] : null;
  }

  public function updateFromController($data){
    $this->model = new ProfileVariable();
    $this->updateDB($data);
    return $this->response['data'];
  }

  public function createFromController($data){
    $this->model = new ProfileVariable();
    $this->insertDB($data);
    return $this->response['data'];
  }

  public function retrieveById($id){
    $result = ProfileVariable::where('id', '=', $id)->get();
    return (sizeof($result) > 0) ? $result : null;
  }

  public function retrieveByColumn($column, $value){
    $result = ProfileVariable::where($column, '=', $value)->get();
    return (sizeof($result) > 0) ? $result : null;
  }
}
