<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NotificationSetting;
use Carbon\Carbon;
class NotificationSettingController extends APIController
{
    function __construct(){
      $this->model = new NotificationSetting();
      $this->notRequired = array('code');
    }

    public function manageNotification($id){
    	$result = NotificationSetting::where('account_id', '=', $id)->get();
    	if(sizeof($result) > 0){
    		$result = $result[0];

    		if(intval($result['email_login'] == 1)){
    			app('App\Http\Controllers\EmailController')->loginEmail($id);
    		}
    		if(intval($result['email_otp'] == 1)){
    			$code = $this->otpCodeGenerator();
    			app('App\Http\Controllers\EmailController')->otpEmail($id, $code);
    			NotificationSetting::where('account_id', '=', $id)->update(array(
    				'code'	=> $code,
    				'updated_at' => Carbon::now()
    			));
    		}
    		return true;
    	}
    	return false;
    }

    public function otpCodeGenerator(){
      $code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
      $codeExist = NotificationSetting::where('id', '=', $code)->get();
      if(sizeof($codeExist) > 0){
        $this->generateCode();
      }else{
        return $code;
      }
    }
}
