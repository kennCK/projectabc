<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountDegree;
use App\AccountInformation;
use App\AccountProfile;
use App\AccountSchool;
use App\AccountSemester;
use App\NotificationSetting;
use App\Semester;
use App\School;
use App\AccountWorkExperience;
use App\Notification;
use App\EnrolledAccount;
use App\AttendanceAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Jobs\Email;
class AccountController extends ClassWorxController
{
     function __construct(){  
        $this->model = new Account();
        $this->validation = array(  
          "email" => "unique:accounts",
          "username"  => "unique:accounts"
        );
        $this->notRequired = array(
          'status',
          'active_semester',
          'active_organization',
          'active_course'
        );
    }

    public function create(Request $request){
     $request = $request->all();
     $dataAccount = array(
      'code'              => $this->generateCode(),
      'password'        => Hash::make($request['password']),
      'status'          => 'NOT_VERIFIED',
      'email'           => $request['email'],
      'username'        => $request['username'],
      'account_type'    => $request['account_type'],
      'active_semester' => null,
      'created_at'      => Carbon::now()
     );
     $this->model = new Account();
     $this->insertDB($dataAccount);
     if($this->response['data'] != null ){
        // $dataSchoolAccount = array(
        //   'account_id'  => $this->response['data'],
        //   'school_id'   => $request['school_id']
        // );
        // $accountSchool = new AccountSchool();
        // $accountSChoolResult = $accountSchool->insert($dataSchoolAccount);
        $emailFlag = ($request['config']['IS_DEV'] == true) ? 'OFF' : 'ON';
        $notifData = array(
          'account_id'  => $this->response['data'],
          'email'       => 'OFF',
          'sms'         => 'OFF',
          'fb_messenger'=> 'OFF',
          'otp'         => 'OFF',
          'created_at'  => Carbon::now()
        );
        $notifModel = new NotificationSetting();
        $notifResult = $notifModel->insert($notifData);
        $this->insertNotifications($this->response['data']);
        if($request['account_type'] == 'STUDENT'){
          $this->addTestCourse($this->response['data']);
          $this->addAttendance($this->response['data']);
        }else{
          //
        }
        return $this->response();
     }else{
        return $this->response();
     }
    }
    public function generateCode(){
      $code = 'A-'.substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 126);
      $codeExist = Account::where('code', '=', $code)->get();
      if(sizeof($codeExist) > 0){
        $this->generateCode();
      }else{
        return $code;
      }
    }


    public function verify(Request $request){
      $data = $request->all();
      $this->model = new Account();
      $this->retrieveDB($data);
      dispatch(new Email($this->response['data'][0], 'verification')); // Send Email
      return $this->response();
    }

    public function updateByVerification(Request $request){
      $data = $request->all();
      $this->model = new Account();
      $this->updateDB($data);
      return $this->response();
    }

    public function updateAction(Request $request){
      $data = $request->all();
      $this->model = new Account();
      $this->updateDB($data);
      return $this->response();
    }

    public function updateActiveSemester(Request $request){
      $data = $request->all();
      $this->model = new Account();
      $this->updateDB($data);
      return $this->response();
    }

    public function update(Request $request){ 
      $data = $request->all();
      $result = Account::where('code', '=', $data['code'])->where('username', '=', $data['username'])->get();
      if(sizeof($result) > 0){
        $updateData = array(
          'id'        => $result[0]['id'],
          'password'  => Hash::make($data['password'])
        );
        $this->model = new Account();
        $this->updateDB($updateData);
        if($this->response['data'] == true){
          dispatch(new Email($result[0], 'reset_password'));
          return $this->response();
        }else{
          return response()->json(array('data' => false));
        }
      }else{
        return response()->json(array('data' => false));
      }
    }
    public function hashPassword($password){
      $data['password'] = Hash::make($password);
      return $data;
    }
    public function customValidate($text){
      $validation = array('email' => 'required|email'); 
      return $this->validateReply($text, $validation);
    }

    public function validateReply($text, $validation){
      $validator = Validator::make($text, $validation);
      if($validator->fails()){
        return false;
      }
      else
        return true;
    }


}