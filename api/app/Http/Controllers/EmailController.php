<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\ResetPassword;
use App\Mail\Verification;
use App\Mail\ChangedPassword;
use App\Mail\Referral;
use App\Mail\LoginEmail;
use App\Mail\OtpEmail;
use Illuminate\Http\Request;

class EmailController extends APIController
{
    function __construct(){  
    }

    public function resetPassword($id){
    	$user = $this->retrieveAccountDetails($id);
    	if($user != null){
    		Mail::to($user['email'])->send(new ResetPassword($user));
    		return true;
    	}
    	return false;
    }

    public function verification($id){
        $user = $this->retrieveAccountDetails($id);
        if($user != null){
            Mail::to($user['email'])->send(new Verification($user));
            return true;
        }
        return false;
    }

    public function changedPassword($id){
        $user = $this->retrieveAccountDetails($id);
        if($user != null){
            Mail::to($user['email'])->send(new ChangedPassword($user));
            return true;
        }
        return false;
    }

    public function loginEmail($id){
        $user = $this->retrieveAccountDetails($id);
        if($user != null){
            Mail::to($user['email'])->send(new LoginEmail($user));
            return true;
        }
        return false;
    }

    public function otpEmail($id, $otpCode){
        $user = $this->retrieveAccountDetails($id);
        if($user != null){
            Mail::to($user['email'])->send(new OtpEmail($user, $otpCode));
            return true;
        }
        return false;
    }

    public function referral(Request $request){
        $data = $request->all();
        $user = $this->retrieveAccountDetails($data['account_id']);
        if($user != null){
            Mail::to($data['to_email'])->send(new Referral($user, $data['content'], $data['to_email']));
            $this->response['data'] = true;
        }
        return $this->response();
    }

    public function trial(Request $request){
        $data = $request->all();
        $user = $this->retrieveAccountDetails($data['account_id']);
        if($user != null){
            Mail::to($user['email'])->send(new ResetPassword($user));
            $this->response['data'] = true;
        }
        return $this->response();
    }
}
