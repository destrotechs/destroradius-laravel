<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
	/* this model only called when creating a log, the function createDBLog generates a log and saves it in the database*/
    public static function createDBLog($user,$log){
    	DB::table('logs')->insert(['user'=>$user,'action'=>$log,'time'=>date("Y-m-d h:i:s")]);
    	return true;
    }
    public static function createTxtLog($user,$log){
    	$path=__DIR__.".logs";
    	$logfile=fopen($path,'a');
    	fwrite($logfile,$user.$log." on ".date("Y:m:d h:i:s").'\n');
    	fclose($logfile);
    	return true;
    }
}
