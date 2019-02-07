<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jobs\MailChimpEmailHandler;
class EmailController extends APIController
{
    public function test(){
			dispatch(new MailChimpEmailHandler());
    }
}
