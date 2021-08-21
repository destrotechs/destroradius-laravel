<?php

namespace App\Http\Controllers;
use App\Setting;
use DB;
use App\User;
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
    	$logging=$this->logs_enabled;
    	$managers=User::all();
    	$managerrates=DB::table('users')->join('managercommissionrates','managercommissionrates.managerid','=','users.id')->get();
    	return view('settings.systemsettings',compact('logging','managerrates','managers'));
    }
    public function Logging($en){
    	$ef=DB::table('settings')->update(['logs_enabled'=>$en]);
    	if ($ef) {
    		return redirect()->back()->with('success','settings applied successfully');
    	}else{
    		return redirect()->back()->with('error','settings could not be effected, try again');
    	}
    }
    public function addManagerCommission(Request $request){
    	$request->validate([
    		'managerid'=>'required',
    		'rate'=>'required'
    	]);
    	$rate=DB::table('managercommissionrates')->updateOrInsert(
    		['managerid'=>$request->get('managerid')],
    		['rate'=>$request->get('rate')]
    	);
    	if ($rate) {
    		return redirect()->back()->with('success','manager commission rate updated successfully');
    	}else{
    		return redirect()->back()->with('error','There was an error updating the manager commission rate, please try again');
    	}
    }
}
