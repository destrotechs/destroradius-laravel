<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomLimit extends Model
{
    protected $fillable = ['limitname','limitmeasure','pref_table','op','eng_name'];
}
