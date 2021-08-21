<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['phonenumber','transactionid','packagebought','amount','username','transactiondate'];
}
