<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable=['supplier_name','address','contact','phone','email','description'];
}
