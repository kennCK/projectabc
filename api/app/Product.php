<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Product extends APIModel
{
    protected $table = 'products';
    protected $fillable = ['code', 'account_id', 'title',  'description', 'tags', 'status'];
}
