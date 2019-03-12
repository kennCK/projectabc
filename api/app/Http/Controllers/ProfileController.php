<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
class ProfileController extends APIController
{
    function __construct(){
    	$this->model = new Profile();
    	$this->validation = array(  
        "email" => "unique:accounts"
      );
      $this->notRequired = array(
        'email', 'profile', 'employment_code', 'first_name', 'last_name', 'middle_name',
        'birth_date', 'sex', 'contact_number', 'address', 'position',
        'department', 'emergency_contact_name', 'emergency_contact_number', 'signature'
      );
    }
}
