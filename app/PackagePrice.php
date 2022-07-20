<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagePrice extends Model
{
    protected $fillable = ['packageid','currency','amount','rate','packageid'];
}
