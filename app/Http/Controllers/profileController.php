<?php

namespace App\Http\Controllers;
use DB;
use Auth;

use Illuminate\Http\Request;

class profileController extends Controller
{
    public function __construct(){
    	return $this->middleware('auth');
    }
    public function getProfile(){
    	$id=Auth::user()->id;
    	$transactions=DB::table('users')
    	->join('managertransactions','managertransactions.managerid','=','users.id')->where('users.id','=',$id)->get();
    	$earnings=0;
    	foreach ($transactions as $key => $t) {
    		$earnings+=$t->commission;
    	}
    	return view('managers.profile',compact('transactions','earnings'));
    }
}
