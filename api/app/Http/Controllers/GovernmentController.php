<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Government;
class GovernmentController extends APIController
{
	function __construct(){
		$this->model = new Government();
	}

  public function checkIfExist($profileId, $payload){
    $result = Government::where('profile_id', '=', $profileId)->where('payload', '=', $payload)->get();
    return (sizeof($result) > 0) ? $result[0] : null;
  }

  public function updateFromController($data){
    $this->model = new Government();
    $this->updateDB($data);
    return $this->response['data'];
  }

  public function createFromController($data){
    $this->model = new Government();
    $this->insertDB($data);
    return $this->response['data'];
  }
}
