<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountGoogleSheet extends APIModel
{
    protected $table = 'account_gsheets';
    protected $fillable = ['account_id', 'sheet'];
}
