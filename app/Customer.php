<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $fillable = ['username','password','phone','name','zone','type','address','created_by','email','gender','customer_type','cleartextpassword'];
}
