<?php

namespace App\Http\Controllers;
use App\Zone;
use App\Manager;
use Hash;
use App\Log;
use DB;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class managerController extends Controller
{
    public function __construct(){
        $this->logs_enabled=0;
        $enabled=DB::table('settings')->get();
        foreach ($enabled as $key => $en) {
            $this->logs_enabled=$en->logs_enabled;
        }
    	$this->middleware('auth');
    }
    public function newManager(){
    	$zones=Zone::all();
    	return view('managers.newmanager',compact('zones'));
    }
    public function  postNewManager(Request $request){
    	$request->validate([
            'fullname' => 'required|max:50',
            'email'=>'required|unique:managers,email',
            'password'=>'required|max:30|min:8',
            'city'=>'required',
            'phone'=>'required|unique:users',
            'address'=>'required',
        ]);

        	$manager=new User;
        	$manager->name=$request->get('fullname');
        	$manager->email=$request->get('email');
        	$manager->password=Hash::make($request->get('password'));
            $manager->role_id=2;
            $manager->city=$request->get('city');
            $manager->address=$request->get('address');
            $manager->phone=$request->get('phone');
        	$manager->save();
        	$manager_id=$manager->id;

        	return redirect()->route('zone.new')->with('success','A new manager has been added, assign a zone to the manager');

    }
    public function getAllManagers(){
        $managers=DB::table('users')->get();
        return view('managers.all',compact('managers'));
    }
    public function getManagerEdit($id){
        $manager=DB::table('users')->where('id','=',$id)->get();
        return view('managers.edit',compact('manager'));
    }
    public function deleteManager($id){
        $del=DB::table('users')->where('id','=',$id)->delete();
        $delzon=DB::table('zonemanagers')->where('managerid','=',$id)->delete();
        $delzon=DB::table('managercommissionrates')->where('managerid','=',$id)->delete();

        return redirect()->back()->with('success',"manager removed successfully");
    }
    public function saveManagerChanges(Request $request){
        $request->validate([
            'fullname' => 'required|max:50',
            'email'=>'required|unique:managers,email',
            'password'=>'required|max:30|min:8',
            'city'=>'required',
            'phone'=>'required|unique:users',
            'address'=>'required',
        ]);

            $manager=User::find($request->get('id'));
            $manager->name=$request->get('fullname');
            $manager->email=$request->get('email');
            $manager->password=Hash::make($request->get('password'));
            $manager->role_id=2;
            $manager->city=$request->get('city');
            $manager->address=$request->get('address');
            $manager->phone=$request->get('phone');
            $manager->update();

            return redirect()->back()->with("success","manager details updated successfully");


    }
    public function managersPayment(){
        $managers=DB::table('users')->get();
        return view('finance.managerpayments',compact('managers'));
    }
    public function getManagerTransactions(Request $request){
        $id=$request->get('managerid');
        $transactions=DB::table('managertransactions')->join('users','users.id','=','managertransactions.managerid')->where([['managertransactions.status','=','unpaid'],['managertransactions.managerid','=',$id]])->get();
        $totalPaye=DB::table('managertransactions')->join('users','users.id','=','managertransactions.managerid')->where([['managertransactions.status','=','unpaid'],['managertransactions.managerid','=',$id]])->sum('managertransactions.commission');
        $output="";
        $num=0;
        foreach ($transactions as $key => $t) {
            $num++;
            $output.="<tr><td>".$num."</td><td>".$t->name."</td><td>".$t->commission."</td></tr>";
        }
        $output.="<tr><td colspan='3'>Total Due ".$totalPaye."</td></tr>";
        return $output;
        
    }
    public function payManager(Request $request){
        $id=$request->get('managerid');
        $update=DB::table('managertransactions')->where('managerid','=',$id)->update(['status'=>'paid']);
        if ($update) {
            return redirect()->back()->with('success','manager commissions paid successfully');
        }else{
            return redirect()->back()->with('error','manager commissions could not be paid, try again');
        }
    }
}
