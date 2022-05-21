<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Illuminate\Http\Request;

class accountingController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function getUserAccounting(){
    	return view('accounting.useraccounting');
    }
    public function getNasAccounting(){
    	$zones=array();
        $id=Auth::user()->id;
        $myzones=DB::table('zonemanagers')->where('managerid',$id)->pluck('zoneid');
        if(Auth::user()->role_id==1){
            $nas=DB::table('nas')->leftJoin('naszones','naszones.nasid','=','nas.id')->join('zones','zones.id','=','naszones.zoneid')->get();
        }else{
            $nas=DB::table('nas')
            ->join('naszones','naszones.nasid','=','nas.id')->join('zones','zones.id','=','naszones.zoneid')->whereIn('naszones.zoneid',$myzones)->get();
        }
    	return view('accounting.nasaccounting',compact('nas'));
    }
    public function getIpAccounting(){
    	return view('accounting.ipaccounting');
    }
    public function returnUserAccounting(Request $request){
    	$username=$request->get('username');
        $useraccounting=DB::table('radacct')->where('username','=',$username)->get();
        $totalsessiontime=DB::table('radacct')->where('username','=',$username)->sum('acctsessiontime');
        $totaldownload=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
        $totaldownload=round($totaldownload/(1024*1024),2);
        $totalupload=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
        $totalupload=round($totalupload/(1024*1024));

        $totalbandwidth=$totalupload+$totaldownload;

        if ($totalsessiontime>=60 && $totalsessiontime<3600) {
            $totalsessiontime=($totalsessiontime/60);
            $totalsessiontime.=" Minutes";
        }else if ($totalsessiontime>=3600) {
            $totalsessiontime=$totalsessiontime/3600;
            $totalsessiontime.= " Hours";
        }else{
            $totalsessiontime.=" Seconds";
        }
        $output='<table class="table table-sm table-striped table-bordered table-sm"><thead><tr><th>ID</th><th>username</th><th>Ip Address</th><th>Start Time</th><th>End Time</th><th>Total Time</th><th>Uplaod</th><th>Download</th><th>Termination Cause</th><th>Nas IP address</th></tr></thead><tbody>';
        if (count($useraccounting)>0) {
           foreach ($useraccounting as $key => $o) {
            $timespent=$o->acctsessiontime;
            if ($timespent<60) {
                $timespent.=" Seconds";
            }
            else if ($timespent>=60 && $timespent<3600) {
                $timespent=round(($timespent/60),1);
                $timespent.=" Minutes";
            }else {
                $timespent=round(($timespent/3600),1);
                $timespent.=" Hours";
            }
            $output.='<tr><td>'.$o->radacctid.'</td><td>'.$o->username.'</td><td>'.$o->framedipaddress.'</td><td>'.$o->acctstarttime.'</td><td>'.$o->acctstoptime.'</td><td>'.$timespent.'</td><td>'.$o->acctoutputoctets.'</td><td>'.$o->acctinputoctets.'</td><td>'.$o->acctterminatecause.'</td><td>'.$o->nasipaddress.'</td></tr>';
            }
        }else{
            $output.='<tr><td colspan="10" class="alert alert-danger">No accounting records for this user</td></tr>';
        }
        
        $output.='</tbody><tfoot><tr><td colspan="4">Total Session Time '.$totalsessiontime.'</td><td colspan="2">Total Download Bandwidth '.$totaldownload.' Mbs</td><td colspan="2">Total Upload Bandwidth '.$totalupload.' Mbs</td><td colspan="2">Total Bandwidth '.$totalbandwidth.' Mbs</td></tr></tfoot></table>';
        echo $output;
    }
    public function returnIpAccounting(Request $request){
    	$ip=$request->get('ip');
        $useraccounting=DB::table('radacct')->where('framedipaddress','=',$ip)->get();
        $totalsessiontime=DB::table('radacct')->where('framedipaddress','=',$ip)->sum('acctsessiontime');
        $totaldownload=DB::table('radacct')->where('framedipaddress','=',$ip)->sum('AcctInputOctets');
        $totaldownload=round($totaldownload/(1024*1024),2);
        $totalupload=DB::table('radacct')->where('framedipaddress','=',$ip)->sum('AcctOutputOctets');
        $totalupload=round($totalupload/(1024*1024));

        $totalbandwidth=$totalupload+$totaldownload;


        if ($totalsessiontime>=60 && $totalsessiontime<3600) {
            $totalsessiontime=($totalsessiontime/60);
            $totalsessiontime.=" Minutes";
        }else if ($totalsessiontime>=3600) {
            $totalsessiontime=$totalsessiontime/3600;
            $totalsessiontime.= " Hours";
        }else{
            $totalsessiontime.=" Seconds";
        }
        $output='<table class="table table-sm table-striped table-bordered table-sm"><thead><tr><th>ID</th><th>username</th><th>Ip Address</th><th>Start Time</th><th>End Time</th><th>Total Time</th><th>Uplaod</th><th>Download</th><th>Termination Cause</th><th>Nas IP address</th></tr></thead><tbody>';
        if (count($useraccounting)>0) {
           foreach ($useraccounting as $key => $o) {
            $timespent=$o->acctsessiontime;
            if ($timespent<60) {
                $timespent.=" Seconds";
            }
            else if ($timespent>=60 && $timespent<3600) {
                $timespent=($timespent/60);
                $timespent.=" Minutes";
            }else {
                $timespent=($timespent/3600);
                $timespent.=" Hours";
            }
            
            $output.='<tr><td>'.$o->radacctid.'</td><td>'.$o->username.'</td><td>'.$o->framedipaddress.'</td><td>'.$o->acctstarttime.'</td><td>'.$o->acctstoptime.'</td><td>'.$timespent.'</td><td>'.$o->acctoutputoctets.'</td><td>'.$o->acctinputoctets.'</td><td>'.$o->acctterminatecause.'</td><td>'.$o->nasipaddress.'</td></tr>';
            }
        }else{
            $output.='<tr><td colspan="10" class="alert alert-danger">No accounting records for this ip</td></tr>';
        }
        
        $output.='</tbody><tfoot><tr><td colspan="4">Total Session Time '.$totalsessiontime.'</td><td colspan="2">Total Download Bandwidth '.$totaldownload.' Mbs</td><td colspan="2">Total Upload Bandwidth '.$totalupload.' Mbs</td><td colspan="2">Total Bandwidth '.$totalbandwidth.' Mbs</td></tr></tfoot></table>';
        echo $output;
    }
    public function returnNasAccounting(Request $request){
    	$ip=$request->get('nas');
        $useraccounting=DB::table('radacct')->where('nasipaddress','=',$ip)->get();
        $totalsessiontime=DB::table('radacct')->where('nasipaddress','=',$ip)->sum('acctsessiontime');
        $totaldownload=DB::table('radacct')->where('nasipaddress','=',$ip)->sum('AcctInputOctets');
        $totaldownload=round($totaldownload/(1024*1024),2);
        $totalupload=DB::table('radacct')->where('nasipaddress','=',$ip)->sum('AcctOutputOctets');
        $totalupload=round($totalupload/(1024*1024));

        $totalbandwidth=$totalupload+$totaldownload;

        
        if ($totalsessiontime>=60 && $totalsessiontime<3600) {
            $totalsessiontime=($totalsessiontime/60);
            $totalsessiontime.=" Minutes";
        }else if ($totalsessiontime>=3600) {
            $totalsessiontime=$totalsessiontime/3600;
            $totalsessiontime.= " Hours";
        }else{
            $totalsessiontime.=" Seconds";
        }
        $output='<table class="table table-sm table-striped table-bordered table-sm"><thead><tr><th>ID</th><th>username</th><th>Ip Address</th><th>Start Time</th><th>End Time</th><th>Total Time</th><th>Uplaod</th><th>Download</th><th>Termination Cause</th><th>Nas IP address</th></tr></thead><tbody>';
        if (count($useraccounting)>0) {
           foreach ($useraccounting as $key => $o) {
            $timespent=$o->acctsessiontime;
            if ($timespent<60) {
                $timespent.=" Seconds";
            }
            else if ($timespent>=60 && $timespent<3600) {
                $timespent=($timespent/60);
                $timespent.=" Minutes";
            }else {
                $timespent=($timespent/3600);
                $timespent.=" Hours";
            }
            
            $output.='<tr><td>'.$o->radacctid.'</td><td>'.$o->username.'</td><td>'.$o->framedipaddress.'</td><td>'.$o->acctstarttime.'</td><td>'.$o->acctstoptime.'</td><td>'.$timespent.'</td><td>'.$o->acctoutputoctets.'</td><td>'.$o->acctinputoctets.'</td><td>'.$o->acctterminatecause.'</td><td>'.$o->nasipaddress.'</td></tr>';
            }
        }else{
            $output.='<tr><td colspan="10" class="alert alert-danger">No accounting records for this ip</td></tr>';
        }
        
        $output.='</tbody><tfoot><tr><td colspan="4">Total Session Time '.$totalsessiontime.'</td><td colspan="2">Total Download Bandwidth '.$totaldownload.' Mbs</td><td colspan="2">Total Upload Bandwidth '.$totalupload.' Mbs</td><td colspan="2">Total Bandwidth '.$totalbandwidth.' Mbs</td></tr></tfoot></table>';
        echo $output;
    }
    public function deleteAccountingRec(Request $request,$username){
        $user_found = DB::table('radacct')->where('username','=',$username)->get();
        if(count($user_found)>0){
            $del_acc = DB::table('radacct')->where('username','=',$username)->delete();

            if($del_acc){
                return redirect()->back()->with("success",$username." accounting details deleted successfully");
            }

        }else{
            return redirect()->back()->with("error",$username." accounting details are not available");
        }
    }
}
