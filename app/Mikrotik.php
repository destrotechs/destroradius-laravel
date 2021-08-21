<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mikrotik extends Model
{
	/*
	This class is responsible for mikrotik connection and operations

	#viewing live online users, available customers,changing pppoe settings
	*/
	public $nasip;
	public $username;
	public $password;


    public function __construct(){
    	$this->middleware('auth');
    }

    public static function performFetchQuery($nasip,$user,$pass,$query){
    	$cmd= "curl -k -u ".$user.": -X POST https://".$nasip."/rest/".$query;
    	$output=shell_exec($cmd);
    	return $output;

    }
}
