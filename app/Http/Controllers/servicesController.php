<?php

namespace App\Http\Controllers;
use DB;
use App\Log;
use Illuminate\Http\Request;

class servicesController extends Controller
{
    public function __construct(){
        $this->logs_enabled=0;
        $enabled=DB::table('settings')->get();
        foreach ($enabled as $key => $en) {
            $this->logs_enabled=$en->logs_enabled;
        }
        $this->middleware('auth');
    }
    public function testConnectivity(){
        return view('maintenance.testconnectivity');
    }
    public function servicesStatus(){
        return view('maintenance.servicesstatus');
    }
    public function postTestConn(Request $request){
        //radtest testing password localhost 0 testing123
        $cmd="radtest ".escapeshellarg($request->get('username'))." ".escapeshellarg($request->get('password'))." ".escapeshellarg($request->get('server'))." ".escapeshellarg($request->get('nasport'))." ".escapeshellarg($request->get('nassecret'));
        $res=system($cmd);
        if($res==" " || $res==NULL){
            echo "The command was not executed successfully";

        }else{
            echo $res;
        }
    }
    public function restartService($service){
        exec ('/usr/bin/sudo /etc/init.d/freeradius restart');
        return redirect()->back()->with("message",$service." service restarted successfully");
    }
    public function getCleanStaleConns(){
        return view('maintenance.staleconn');
    }
    public function postCleanConn(Request $request){
        $username=$request->get('username');
        $staleconn=DB::table('radacct')->where([['username','=',$username],['acctstoptime','=',NULL]])->delete();
        if ($staleconn) {
            return redirect()->back()->with("success","successfully cleaned stale connection for user ".$username);
        }else{
            return redirect()->back()->with("error","There are no stale connections for user ".$username);
        }
    }
    public function getLastConnAttempts(){
        $attempts=DB::table('radpostauth')->orderBy('id','desc')->paginate(10);
        return view('services.lastconnection',compact('attempts'));
    }
}
