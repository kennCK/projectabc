<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends APIModel
{
  protected $table = 'profiles';
  protected $fillable = ['account_id', 'email', 'profile', 'employment_code', 'first_name', 'last_name', 'middle_name', 'birth_date', 'sex', 'contact_number', 'address', 'position', 'department', 'emergency_contact_name', 'emergency_contact_number', 'signature', 'status'];
}
