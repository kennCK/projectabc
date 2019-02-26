<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\ResetPassword;
use App\Mail\Verification;
use App\Mail\ChangedPassword;
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

    public function verification(Request $request){
        $data = $request->all();
        $user = $this->retrieveAccountDetails($data['account_id']);
        if($user != null){
            Mail::to($user['email'])->send(new Verification($user));
            $this->response['data'] = true;
        }
        return $this->response();
    }

    public function changedPassword(Request $request){
        $data = $request->all();
        $user = $this->retrieveAccountDetails($data['account_id']);
        if($user != null){
            Mail::to($user['email'])->send(new ChangedPassword($user));
            $this->response['data'] = true;
        }
        return $this->response();
    }
}
