<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountInformation;
use App\BillingInformation;
use App\AccountProfile;
use App\Checkout;
use App\Product;
use App\CheckoutItem;
use App\Plan;
use App\Rating;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Jobs\Email;
class AccountController extends APIController
{
    function __construct(){  
      $this->model = new Account();
      $this->validation = array(  
        "email" => "unique:accounts",
        "username"  => "unique:accounts"
      );
      $this->notRequired = array(
        'order_suffix'
      );
    }

    public function create(Request $request){
     $request = $request->all();
     $dataAccount = array(
      'code'  => $this->generateCode(),
      'password'        => Hash::make($request['password']),
      'status'          => 'NOT_VERIFIED',
      'email'           => $request['email'],
      'username'        => $request['username'],
      'account_type'    => $request['account_type'],
      'order_suffix'    => 'IDF-',
      'created_at'      => Carbon::now()
     );
     $this->model = new Account();
     $this->insertDB($dataAccount);
     $accountId = $this->response['data'];

     if($accountId){
       $this->createDetails($accountId, $request['account_type']);
     }
    
     return $this->response();
    }

    public function createDetails($accountId, $type){
      $info = new AccountInformation();
      $info->account_id = $accountId;
      $info->created_at = Carbon::now();
      $info->save();

      $billing = new BillingInformation();
      $billing->account_id = $accountId;
      $billing->created_at = Carbon::now();
      $billing->save();

      if($type == 'PARTNER' || $type == 'partner'){
        $product = new Product();
        $product->account_id = $accountId;
        $product->title = 'id_printing';
        $product->created_at = Carbon::now();
        $product->save();
      }
    }

    public function generateCode(){
      $code = 'IDF-'.substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 28);
      $codeExist = Account::where('id', '=', $code)->get();
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

    public function retrieve(Request $request){
      $data = $request->all();
      $this->model = new Account();
      $result = $this->retrieveDB($data);

      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $accountId = $result[$i]['id'];
          $result[$i]['account_information_flag'] = false;
          $result[$i]['account_profile_flag'] = false;
          $accountInfoResult = AccountInformation::where('account_id', '=', $accountId)->get();
          $accountProfileResult = AccountProfile::where('account_id', '=', $accountId)->orderBy('created_at', 'DESC')->get();
          $result[$i]['account_information'] = (sizeof($accountInfoResult) > 0) ? $accountInfoResult[0] : null;
          $result[$i]['account_profile'] = (sizeof($accountProfileResult) > 0) ? $accountProfileResult[0] : null;
          $result[$i]['checkout'] = $this->getCheckoutItem($accountId);
          $result[$i]['plan'] = $this->getCurrentPlan($accountId, $result[$i]['created_at']);
          $i++;
        }
        return response()->json(array('data' => $result));
      }else{
        return $this->response();
      }
    }

    public function retrievePartners(Request $request){
      $data = $request->all();
      $this->model = new Account();
      $result = $this->retrieveDB($data);

      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $accountId = $result[$i]['id'];
          $this->response['data'][$i]['account'] = $this->retrieveAccountDetails($accountId);
          $this->response['data'][$i]['rating'] = $this->getRatingsPartners($accountId);
          $i++;
        }
      }
      return $this->response();
    }

    public function getRatingsPartners($accountId){
      $rating = Rating::where('payload', '=', 'partner')->where('payload_value', '=', $accountId)->get();
      $avg = 0;
      $totalRating = 0;
      $size = sizeof($rating);
      if(sizeof($rating) > 0){
        $i = 0;
        foreach ($rating as $key) {
          $totalRating += intval($rating[$i]['value']);
          $i++;
        }
      }
      $avg = ($size > 0) ? floatval($totalRating / $size) : $totalRating;
      return array(
        'total' => $totalRating,
        'size'  => $size,
        'avg'   => $avg
      );
    }

    public function getCheckoutItem($accountId){
      $checkout = Checkout::where('account_id', '=', $accountId)->where('status', '=', 'added')->first();
      if($checkout){
        return CheckoutItem::where('checkout_id', '=', $checkout->id)->count();
      }else{
        return 0;
      }
    }

    public function getCurrentPlan($accountId, $createdAt){
      $current = Carbon::now();
      $accountDate = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt);
      $diff = $accountDate->diffInDays($current, false);
      if($diff >= 30){
        $result = Plan::where('account_id', '=', $accountId)->whereDate('end', '>=', Carbon::now())->where('status', '=', 'completed')->orderBy('created_at', 'asc')->first();
        if($result){
          return array(
            'title' => $result->title,
            'end_human' => Carbon::createFromFormat('Y-m-d H:i:s', $result->end)->copy()->tz('Asia/Manila')->format('F j, Y')
          );
        }else{
          return array(
            'title' => 'Expired',
            'end_human' => null
          );
        }
      }else{
        return array(
          'title' => 'Trial',
          'end_human' => Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->copy()->tz('Asia/Manila')->format('F j, Y')
        );
      }
    }

}