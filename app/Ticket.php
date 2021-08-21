<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['customer_username','assignedto','status','group','priority','type','message','location','subject'];
}
