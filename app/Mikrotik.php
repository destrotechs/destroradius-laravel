<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PEAR2\Net\RouterOS;

require_once app_path().'/PEAR2_Net_RouterOS-1.0.0b6/src/PEAR2/Autoload.php';
class Mikrotik extends Model
{
	/*
	This class is responsible for mikrotik connection and operations

	#viewing live online users, available customers,changing pppoe settings
	*/


	public static function connectToNas($nasid){
		try {
			$nas = DB::table('nas')->where('id','=',$nasid)->first();

		    $client = new RouterOS\Client($nas->nasname, 'admin', $nas->secret);
		    $responses = $client->sendSync(new RouterOS\Request('/ip/hotspot/active/print'));
		    $users = array();
			foreach ($responses as $response) {
			    if ($response->getType() === RouterOS\Response::TYPE_DATA) {
			    	$user = $response->getProperty('user');
			    	$ip = $response->getProperty('address');
			    	$uptime=$response->getProperty('uptime');
			    	$download = $response->getProperty('bytes-in');
			    	$upload = $response->getProperty('bytes-out');

			    	$user_details = array($user,$ip,$uptime,$download,$upload);

			    	array_push($users,$user_details);
			        // echo 'User: ', $response->getProperty('user'),
			        // "\n";

			    }
			}
			return $users;
		}
		catch (Exception $e) {
		    // die($e);
		    return [];
		}

	}


}
