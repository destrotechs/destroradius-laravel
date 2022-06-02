<?php

namespace App\Http\Controllers;
use Validator;
use DB;
use Auth;
use App\Zone;
use Route;
use App\Log;
use Illuminate\Http\Request;

class nasController extends Controller
{
  
    public function __construct(){
        $this->logs_enabled=0;
        $enabled=DB::table('settings')->get();
        foreach ($enabled as $key => $en) {
            $this->logs_enabled=$en->logs_enabled;
        }
        $this->middleware('auth');
    }
    public function viewNas(Request $request){
        $zones=array();
        $id=Auth::user()->id;
        $myzones=DB::table('zonemanagers')->where('managerid',$id)->pluck('zoneid');
        if(Auth::user()->role_id==1){
            $nas=DB::table('nas')->leftJoin('naszones','naszones.nasid','=','nas.id')->join('zones','zones.id','=','naszones.zoneid')
            ->select('nas.*','zones.zonename')
            ->get();
        }else{
            $nas=DB::table('nas')
            ->join('naszones','naszones.nasid','=','nas.id')->join('zones','zones.id','=','naszones.zoneid')->whereIn('naszones.zoneid',$myzones)->get();
        }
        
        return view('nas.view',compact('nas'));
    }
    public function newNas(Request $request){
        $zones=Zone::all();
        return view('nas.newnas',compact('zones'));
    }
    public function editNas(Request $request,$id){
        $nas=DB::table('nas')->where('id','=',$id)->get();
        $zones=Zone::all();
        return view('nas.editnas',compact('nas','zones'));
    }
    public function addNewNas(Request $request){
        $request->validate([
            'nassecret'=>['required'],
            'nasname'=>['required','unique:nas'],
            'nasshortname'=>['required'],
        ]);
        $nasid=DB::table('nas')->insertGetId([
            'secret'=>$request->get('nassecret'),'nasname'=>$request->get('nasname'),'shortname'=>$request->get('nasshortname'),'type'=>$request->get('nastype'),'description'=>$request->get('nasdescription'),
        ]);
        
        //associate nas with zone
        $naszone=DB::table('naszones')->insert(['nasid'=>$nasid,'zoneid'=>$request->get('nasshortname')]);

        //log query
        if ($this->logs_enabled==1) {
                $log=" added a new nas at ";
                $log_write=Log::createTxtLog(Auth::user()->email,$log);
        }

        if($request->get('restartserver')=='yes'){
            self::restartServer();
        }
        toast('Nas saved successfully','success');
        return redirect()->back()->with("success","Nas saved successfully");
    }
    public function removeNas(Request $request,$id){
        $nas=DB::table('nas')->where('id',$id)->delete();
        if ($this->logs_enabled==1) {
                $log=" deleted nas ";
                $log_write=Log::createTxtLog(Auth::user()->email,$log);
        }

        if($nas==true){
            toast('Nas has been removed successfully','success');

            return redirect()->back()->with("success","Nas has been removed successfully");
        }else{
        toast('There was an error removing the requested nas, try again later','error');

            return redirect()->back()->with("error","There was an error removing the requested nas, try again later");
        }
    }
    public function editNasSave(Request $request){
        $request->validate([
            'nassecret'=>['required'],
            'nasname'=>['required'],
            'nasshortname'=>['required'],
        ]);
        $naschange=DB::table('nas')->where('id',$request->get('id'))->update([
            'secret'=>$request->get('nassecret'),'nasname'=>$request->get('nasname'),'shortname'=>$request->get('nasshortname'),'type'=>$request->get('nastype'),'description'=>$request->get('nasdescription'),
        ]);
        if($naschange==true){
            //log query
            if ($this->logs_enabled==1) {
                $log=" edited nas id ".$request->get('id');
                $log_write=Log::createTxtLog(Auth::user()->email,$log);
            }

            if($request->get('restartserver')=='yes'){
                self::restartServer();
            }
            toast('changes have been made successfully','success');

            return redirect()->route('nas.view')->with("success","changes have been made successfully");
        }else{
            toast('There was an error saving the changes, try again later','error');

            return redirect()->back()->with("error","There was an error saving the changes, try again later");
        }
       
    }
    public static function restartServer(){
        system("systemctl restart freeradius.service");
        return true;
    }
    public static function restartMysql(){
        system("systemctl restart mysql.service");
        return true;
    }
    public static function restartApache(){
        system("systemctl restart apache2.service");
        return true;
    }
}
