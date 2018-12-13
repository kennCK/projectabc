<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MessengerGroup;
use App\MessengerMember;
use Carbon\Carbon;
use App\Account;
use Illuminate\Support\Facades\DB;
class MessengerGroupController extends APIController
{
    function __construct(){
      $this->model = new MessengerGroup();
    }


    public function retrieve(Request $request){
      $data = $request->all();
      $accountType = $data['account_type'];
      $accountId = $data['account_id'];
      $existed = array();


      $result = null;

      if($accountType == 'partner' || $accountType == 'PARTNER'){
        $result = DB::table('messenger_members as T1')
          ->join('messenger_groups as T2', 'T2.id', '=', 'T1.messenger_group_id')
          ->where('T1.account_id', '=', $accountId)
          ->select('T2.*')
          ->get();
        $result = json_decode($result, true);
        // echo json_encode($result);
        if(sizeof($result) > 0){
          $i = 0;
          foreach ($result as $key) {
            $result[$i]['account_details'] = $this->retrieveAccountDetails($result[$i]['account_id']);
            $result[$i]['members'] = $this->getMembers($result[$i]['id']);
            $result[$i]['title'] = $this->retrieveAccountDetails($result[$i]['account_id']);
            $existed[] = $result[$i]['account_id'];
            $i++;
          }
        }

      }else if($accountType == 'user' || $accountType == 'USER'){
        $result = MessengerGroup::where('account_id', '=', $accountId)->get();

        if(sizeof($result) > 0){
          $i = 0;
          foreach ($result as $key) {
            $result[$i]['account_details'] = $this->retrieveAccountDetails($result[$i]['account_id']);
            $result[$i]['members'] = $this->getMembers($result[$i]['id']);
            $result[$i]['title'] = $this->getTitle($result[$i]['id']);
            $existed[] = $result[$i]['account_id'];
            $i++;
          }
        }
      }


      $accounts = null;
      if($accountType == 'user'){
        $accounts = $this->getPartners($existed);
      }

      return response()->json(array(
        'data'  => $result,
        'accounts'  => $accounts,
        'error' => null,
        'timestamps'  => Carbon::now()
      ));
    }

    public function getMembers($messengerGroupId){
      $result = MessengerMember::where('messenger_group_id', '=', $messengerGroupId)->get();

      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $result[$i]['account_details'] = $this->retrieveAccountDetails($result[$i]['account_id']);
          $i++;
        }
      }
      return (sizeof($result) > 0) ? $result : null;
    }


    public function getTitle($messengerGroupId){
      $result = MessengerMember::where('messenger_group_id', '=', $messengerGroupId)->where('status', '=', 'member')->get();
      $title = null;
      if(sizeof($result) > 0){
          $title = $this->retrieveAccountDetails($result[0]['account_id']);
      }
      return ($title) ? $title : null;
    }

    public function getPartners($array){
      $accounts = Account::whereNotIn('id', $array)->where('account_type', '=', 'partner')->get();
      if(sizeof($accounts) > 0){
        $i = 0;
        foreach ($result as $key) {
          $accounts[$i]['account_details'] = $this->retrieveAccountDetails($result[$i]['account_id']);
          $i++;
        }
      }
      return (sizeof($result) > 0) ? $result : null;
    }

}
