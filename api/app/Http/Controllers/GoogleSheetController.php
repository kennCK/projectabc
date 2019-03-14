<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_Request;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_BatchUpdateValuesRequest;
use Carbon\Carbon;
use App\AccountGoogleSheet;
class GoogleSheetController extends APIController
{

		protected $clientId;
    protected $clientSecret;
    protected $client;

    protected $response = array(
      'data'      => null,
      'redirect'  => null,
      'timestamp' => null
    );

    protected $redirectUrl = null;

    function __construct(){
    	$this->clientId = env('GOOGLE_CLIENT_ID', '501790273381-90ii644bc32va996b12uh5u9jpm1uli7.apps.googleusercontent.com');
    	$this->clientSecret = env('GOOGLE_CLIENT_SECRET', 'B7NOVHTYeOTcbkXpHNEImnmB');
      $credentials = storage_path().'/credentials/credentials.json';
      $this->client = new Google_Client();
      $this->client->setApplicationName('ClassWorx Generated Reports');
      $this->client->setScopes(Google_Service_Sheets::SPREADSHEETS);
      $this->client->setAuthConfig($credentials);
      $this->client->setAccessType("offline");
    }

    public function response(){
      $this->response['timestamp'] = Carbon::now();
      return response()->json($this->response);
    }

    public function getAuthUrl(Request $request){
      $data = $request->all();
      $this->client->setRedirectUri($data['GOOGLE_URL']);
      $this->response['redirect'] = $this->client->createAuthUrl();
      return $this->response();
    }

    public function setAccessToken($code){
      if($code != null){
        $this->client->authenticate($code);
        $access_token = $this->client->getAccessToken();
        $this->client->setAccessToken($access_token);
        if($this->client->isAccessTokenExpired()){
          $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
        }
      }else{
        echo 'Emty code';
      }
    }

    public function generate(Request $request){
      $url =  $request->fullUrl();
      $code = null;
      $scope = null;
      
      $this->getConfigByExecute($url);
      

      $parameter = $this->extract($url);
     	if(strpos($parameter[1], '&')){
        $parameter = explode('&', $parameter[1]);
      }
      
      if(strpos($parameter[0], '=')){
        $temp = explode('=', $parameter[0]);
        // $code = str_replace('%', '/', $temp[1]);
        $code = $temp[1];
      }

			if(strpos($parameter[1], '=')){
        $temp = explode('=', $parameter[1]);
        // $scope = str_replace('%', '/', $temp[1]);
        $scope = $temp[1];
      }

     	echo $code.'/'.$scope;
      return redirect($this->redirectUrl.$code.'/'.$scope);
    }

    public function extractCode($url){
      $parameter = $this->extract($url);
     	if(strpos($parameter[1], '&')){
        $parameter = explode('&', $parameter[1]);
      }
      echo json_encode($parameter);
    }

    public function getConfigByExecute($url){
      $array = explode('/', $url);
      if($array[2] == 'idfactory.ph' || $array[2] == 'www.idfactory.ph'){
        $this->redirectUrl = 'https://idfactory.ph/#/profiles/';
      }else{
        $this->redirectUrl = 'http://localhost:8080/#/profiles/';
      }
    }

    public function extract($url){
      $array = explode('/', $url);
      $parameter = null;
      $i = 0;
      foreach ($array as $key) {
        if(strpos($array[$i], '?')){
          $parameter = explode('?', $array[$i]);
        }
        $i++;
      }
      return $parameter;
    }

    public function createNewGoogleSheet(Request $request){
    	$data = $request->all();
    	$accountId = $data['account_id'];
    	$this->setAccessToken($data['code']);
      $service = new Google_Service_Sheets($this->client);
      $requestBody = new Google_Service_Sheets_Spreadsheet();
      $spreadsheet = $service->spreadsheets->create($requestBody);


      $date = Carbon::now();
      $title = 'IDF-'.$accountId.' - '.$date->format('F j, Y');
      $updateTitle = [
        // Change the spreadsheet's title.
        new Google_Service_Sheets_Request([
            'updateSpreadsheetProperties' => [
                'properties' => [
                    'title' => $title
                ],
                'fields' => 'title'
            ]
        ])
      ];
			$batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
          'requests' => $updateTitle
      ]);

      $response = $service->spreadsheets->batchUpdate($spreadsheet['spreadsheetId'], $batchUpdateRequest);

      $rowValues = array(
      	['email', 'employment_code', 'first_name', 'last_name',
      	'middle_name', 'birth_date', 'sex', 'contact_number', 'address',
      	'position', 'department', 'emergency_contact_name', 'emergency_contact_number',
      	'profile', 'signature']
      );

      // $rowValues = array(
      // 	['email'], ['employment_code'], ['first_name']
      // );

			$data = [];
			$data[] = new Google_Service_Sheets_ValueRange([
			    'values' => $rowValues,
			    'range'  => 'A1'
			]);

			$body = new Google_Service_Sheets_BatchUpdateValuesRequest([
			    'valueInputOption' => 'USER_ENTERED',
			    'data' => $data
			]);

			$result = $service->spreadsheets_values->batchUpdate($spreadsheet['spreadsheetId'], $body);

      $id = $this->checkIfExist($accountId);
      if($id == null){
      	$this->model = new AccountGoogleSheet();
	      $insertData = array(
	      	'account_id'	=> $accountId,
	      	'sheet'				=> $spreadsheet['spreadsheetId']
	      );
	      $this->insertDB($insertData);
      }else{
      	$this->model = new AccountGoogleSheet();
	      $updateData = array(
	      	'id'	=> $id,
	      	'sheet'				=> $spreadsheet['spreadsheetId']
	      );
	      $this->updateDB($updateData);
      }
      
      return $this->response();
    }

    public function checkIfExist($accountId){
    	$result = AccountGoogleSheet::where('account_id', '=', $accountId)->get();
    	return (sizeof($result) > 0) ? $result[0]['id'] : null;
    }
}
