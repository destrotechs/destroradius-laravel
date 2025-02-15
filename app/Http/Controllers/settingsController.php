<?php

namespace App\Http\Controllers;
use App\Setting;
use DB;
use App\User;
use Auth;
use Alert;
USE App\Log;
use App\Manager;
use Illuminate\Http\Request;

class settingsController extends Controller
{
	public function __construct(){
		$this->logs_enabled=0;
        $enabled=DB::table('settings')->get();
        foreach ($enabled as $key => $en) {
            $this->logs_enabled=$en->logs_enabled;
        }
		$this->middleware('auth');
	}

    public function getManagerCommission(){
    	return view('settings.managercommissionrates');
    }
    public function getindex(){
        $logging = 0;
    	$settings=DB::table('settings')->count();
        if($settings>0){
        $logging=DB::table('settings')->pluck('logs_enabled')[0];
        }
    	$managers=User::all();
        $packages = DB::table('packages')->get();
    	$managerrates=DB::table('users')->join('managercommissionrates','managercommissionrates.managerid','=','users.id')->get();
        $package_risk_fees = DB::table('package_risk_fees')->join('packages','packages.id','=','package_risk_fees.packageid')->get();
    	return view('settings.systemsettings',compact('logging','managerrates','managers','package_risk_fees','packages'));
    }
    public function Logging($en){
        $log = DB::table('settings')->count();
        $ef=false;
        if (Auth::user()->role_id==1){
            if ($log>0){
            $ef=DB::table('settings')->update(['logs_enabled'=>$en]);
            }else{
                $ef=DB::table('settings')->insert(['logs_enabled'=>$en]);

            }
            $user=Auth::user()->email;
            $enable = $en==1? " Enabled logging":" Disabled logging";
            $log=$enable;
            $logwrite=Log::createTxtLog($user,$log);
            if ($ef) {
                toast('settings applied successfully','success');

                return redirect()->back();
            }else{
                toast('settings could not be effected, try again','error');
                return redirect()->back();
            }
        }else{
                alert()->warning('Disallowed','you are not allowed to change settings');

                return redirect()->back();

        }
        
    }
    public function addManagerCommission(Request $request){
    	$request->validate([
    		'managerid'=>'required',
    		'rate'=>'required'
    	]);
    	$rate=DB::table('managercommissionrates')->updateOrInsert(
    		['managerid'=>$request->get('managerid')],
    		['rate'=>$request->get('rate'),'type'=>'ticket']
    	);
    	if ($rate) {
            toast('manager commission rate updated successfully','success');
    		return redirect()->back();
    	}else{
            toast("There was an error updating the manager commission rate, please try again","error");
    		return redirect()->back();
    	}
    }
    public function postRiskFee(Request $request){
        $feeposted = DB::table('package_risk_fees')->updateOrInsert(
            ['packageid'=>$request->packageid],['amount'=>$request->get('amount')]
        );
        if($feeposted){
            alert()->success("Risk fee posted successfully");
            return redirect()->back();
        }else{
            alert()->success("Risk fee could not be posted");
            return redirect()->back();
        }
    }
}
