<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name','model','category_code','sub_category_code','quantity','serial','type','description','cost'];
}
