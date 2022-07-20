<?php

namespace App\Http\Controllers;
use App\Manager;
use App\Zone;
use DB;
use App\Log;
use Auth;
use App\User;
use Illuminate\Http\Request;

class zonesController extends Controller
{
    public function __construct(){
        $this->logs_enabled=0;
        $enabled=DB::table('settings')->get();
        foreach ($enabled as $key => $en) {
            $this->logs_enabled=$en->logs_enabled;
        }
    	$this->middleware('auth');
    }
    public function newZone(){
    	$zonemanagers=DB::table('zonemanagers')->pluck('managerid');
    	$zoneswithmanagers=DB::table('zonemanagers')->pluck('zoneid');
    	//dd($zonemanagers);
    	$managers=User::all();
    	$zones=DB::table('zones')
    		->whereNotIn('id',$zoneswithmanagers)->get();
    	return view('zones.newzone',compact('managers','zones'));
    }
    public function allZones(){
        if (Auth::user()->role_id==1) {
            $zones=DB::table('zones')
                ->leftjoin('zonemanagers','zones.id','=','zonemanagers.zoneid')
                ->leftjoin('users','users.id','=','zonemanagers.managerid')
                ->select('zones.*','users.name')
                ->paginate(10);
        }else{
            $myzones=DB::table('zonemanagers')->where('managerid',Auth::user()->id)->pluck('zoneid');
           $zones=DB::table('zones')
                ->leftjoin('zonemanagers','zones.id','=','zonemanagers.zoneid')
                ->leftjoin('users','users.id','=','zonemanagers.managerid')
                ->whereIn('zonemanagers.zoneid',$myzones)
                ->select('zones.*','users.name')
                ->paginate(10); 
        }
    	
    	return view('zones.allzones',compact('zones'));
    }
    public function addZone(Request $request){
    	$request->validate([
    		'zonename'=>'required|unique:zones',
    		'networktype'=>'required',
    	]);
    	$z= new Zone;
    	$z->zonename=$request->get('zonename');
    	$z->networktype=$request->get('networktype');
    	$z->save();


    	if ($z) {
            return redirect()->route('zone.all')->with("success","A new zone has been added, add the zone manager");
    	}else{
            toast('There was a problem adding a new zone, try again','error');
    		return redirect()->back()->with('error','There was a problem adding a new zone, try again');
    	}
    }
    public function zoneManager(Request $request){
    	
    	$request->validate([
    		'zoneid'=>'required|unique:zonemanagers',
    		'managerid'=>'required',
    	]);

    	$zm=DB::table('zonemanagers')->insert(['managerid'=>$request->get('managerid'),'zoneid'=>$request->get('zoneid')]);

    	if ($zm) {
            toast('a new zone manager has been added','success');

    		return redirect()->back()->with('success','a new zone manager has been added');
    	}else{
            toast('There was an error adding zone manager, try again','error');

    		return redirect()->back()->with('error','There was an error adding zone manager, try again');
    	}
    }
    public function transferZone($id){
    	$zone=Zone::find($id);
        $managers=User::all();
    	return view('zones.zonetransfer',compact('zone','managers'));
    }
    public function transferZoneSave(Request $request){
    	$request->validate([
    		'managerid'=>'required',
    	]);
        //dd($request->all());
    	$zm=DB::table('zonemanagers')->updateOrInsert(
            ['zoneid'=>$request->get('id')],
            ['managerid'=>$request->get('managerid')]
        );

        // where('zoneid','=',$request->get('id'))->update();

    	if ($zm) {
            toast('Zone transfer success','success');

    		return redirect()->route('zone.all')->with('success','Zone transfer success');
    	}else{
            toast('zone transfer failed, try again','error');

    		return redirect()->back()->with('error','zone transfer failed, try again');
    	}
    }
    public function editZone($id){
        $zone=Zone::find($id);
        return view('zones.editzone',compact('zone'));
    }
    public function saveEditedZone(Request $request){
        $request->validate([
            'zonename'=>'required',
            'networktype'=>'required',
        ]);
        $id=$request->get('id');
        $z=Zone::find($id);
        $z->zonename=$request->get('zonename');
        $z->networktype=$request->get('networktype');

        $z->save();


        if ($z) {

            //log the action
            if ($this->logs_enabled==1) {
                $log=" edited zone to ".$z->zonename." ".$z->networktype;
                $log_write=Log::createTxtLog(Auth::user()->email,$log);
            }
            toast('The zone has been updated','success');

            return redirect()->back()->with('success','The zone has been updated');
        }else{
            toast('There was a problem updating the zone, try again','error');

            return redirect()->back()->with('error','There was a problem updating the zone, try again');
        }
    }
    public function deleteZone($id){
        $zone=Zone::find($id);

        $zone->delete();
        DB::table('zonemanagers')->where('zoneid','=',$id)->delete();
            toast('Zone has been removed successfully','success');

        return redirect()->route('zone.all')->with("success","Zone has been removed successfully");
    }
}
