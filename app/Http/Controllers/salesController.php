<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use Illuminate\Http\Request;

class salesController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}
    public function allSales(){
    	$sales=DB::table('managertransactions')->leftJoin('users','users.id','=','managertransactions.managerid')->paginate(10);
    	$totalCommDue=DB::table('managertransactions')->where('status','=','unpaid')->sum('commission');

        return view('finance.sales',compact('sales','totalCommDue'));
    }
}
