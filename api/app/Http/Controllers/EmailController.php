<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;

class EmailController extends APIController
{
    function __construct(){  
    }

    public function resetPassword(Request $request){
    	$data = $request->all();
    	$user = $this->retrieveAccountDetails($data['account_id']);
    	if($user != null){
    		Mail::to($user['email'])->send(new ResetPassword($user));
    		$this->response['data'] = true;
    	}
    	return $this->response();
    }
}
