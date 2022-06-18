<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable=['packagename','uploadspeed','downloadspeed','numberofdevices','validdays','users','quota','packagezone','package','durationmeasure','description','burstup','burstdown','poolname','profile'];
}
