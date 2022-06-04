<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use PDF;
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
    public function newInvoice(Request $request){
        $customers = DB::table('customers')->get();
    	return view('finance.invoice', compact('customers'));
    }
    public function invoicepdf(Request $request,$inv_no=255555){
        // return PDF::loadFile(public_path().'/templates/invoice.html')->save(public_path().'/docs/my_stored_file.pdf')->stream('download.pdf');
        $pdf = PDF::loadView('finance.invoicedoc');
        return $pdf->stream('invoice.pdf');
        $inv = $inv_no;
        return view('finance.invoicedoc',compact('inv'));
    }
}
