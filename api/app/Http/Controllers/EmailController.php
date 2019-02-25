<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;

class EmailController extends APIController
{
    public function test(){
    	Mail::send('email.welcome', ['user' => null], function ($m){
          $m->from('support@idfactory.ph', 'ID Factory');

          $m->to('kennettecanales@gmail.com', 'Kennette Canales')->subject('Your Reminder!');
      });
    }
}
