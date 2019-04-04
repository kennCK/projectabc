<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
class PartnerController extends APIController
{
    public function retrieve(Request $request){
      // retrieve all partners
      // check plan
      // check trial plan
      $data = $request->all();
      $filter = $data['filter'];
      $search = $data['search'].'%';
      $result = null;

      if($filter == 'name'){
        $result = DB::table('accounts as T1')
              ->leftJoin('billing_informations as T2', 'T2.account_id', '=', 'T1.id')
              ->where('T2.company', 'like', $search)
              ->where('T1.account_type', '=', 'PARTNER')
              ->where('T1.status', '=', 'VERIFIED')
              ->orderBy('T2.company', 'asc')
              ->get(['T1.*']);
      }else{
        $result = DB::table('accounts as T1')
              ->leftJoin('billing_informations as T2', 'T2.account_id', '=', 'T1.id')
              ->where('T2.city', 'like', $search)
              ->where('T1.account_type', '=', 'PARTNER')
              ->where('T1.status', '=', 'VERIFIED')
              ->orderBy('T2.city', 'asc')
              ->get(['T1.*']);
      }

      $response = array(
        'data'  => array(),
        'error' => null,
        'timestamp' => Carbon::now()
      );

      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $accountId = $result[$i]->id;
          $accountDate = Carbon::createFromFormat('Y-m-d H:i:s', $result[$i]->created_at);
          $current = Carbon::now();
          $diff = $accountDate->diffInDays($current, false);
          if($diff < 30){
            $temp = array(
              'account' => $this->retrieveAccountDetails($accountId),
              'rating'  => app('Increment\Common\Rating\Http\PlanController')->getRatingByPayload('partner', $accountId)
            );
            $response['data'][] = $temp;            
          }else if(app('Increment\Plan\Http\PlanController')->checkPlan($accountId) == true){
            $temp = array(
              'account' => $this->retrieveAccountDetails($accountId),
              'rating'  => app('Increment\Common\Rating\Http\PlanController')->getRatingByPayload('partner', $accountId)
            );
            $response['data'][] = $temp;
          }else{
            //
          }
          $i++;
        }
      }
      return response()->json($response);
    }
}
