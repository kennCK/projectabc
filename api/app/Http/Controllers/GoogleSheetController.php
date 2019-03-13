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

    public function setAccessToken($code, $data){
      if($code != null){
        $this->client->authenticate($code);
        $access_token = $this->client->getAccessToken();
        $this->client->setAccessToken($access_token['access_token']);
        if($this->client->isAccessTokenExpired()){
          $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
        }
        Report::where('id', '=', $data['id'])->update(array('token' => $access_token['access_token']));
      }else{
        echo 'Emty code';
      }
    }

    public function generate(Request $request){
      $url =  $request->fullUrl();
      $code = $this->extractCode($url);
      $this->getConfigByExecute($url);
      $code = str_replace('%', '/', $code);
    }

    public function extractCode($url){
      $parameter = $this->extract($url);
      $code = explode('=', $parameter[1]);
      return $code[1];
    }

    public function getConfigByExecute($url){
      $array = explode('/', $url);
      if($array[2] == 'classworx.co' || $array[2] == 'www.classworx.co'){
        $this->redirectUrl = 'http://classworx.co/#/reports/ft';
      }else{
        $this->redirectUrl = 'http://localhost:8080/#/reports/ft';
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

   
}
