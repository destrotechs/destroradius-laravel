<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use PDF;
use Alert;
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
        $invoices = DB::table('invoices')->get();
    	return view('finance.invoice', compact('customers','invoices'));
    }
    public function postInvoice(Request $request){
        $request->validate([
            'invoice_no'=>'required|unique:invoices'
        ]);
        $invoice = DB::table('invoices')->insert(
            ['customer_id'=>$request->get('customer'),'amount'=>$request->get('amount'),'due_date'=>$request->get('due_date'),'invoice_date'=>$request->get('invoice_date'),'start_date'=>$request->get('start_date'),'end_date'=>$request->get('end_date'),'rate'=>$request->get('rate'),'invoice_no'=>$request->get('invoice_no')]
        );
        if ($invoice){
            toast('Invoice Generated successfully','success');
            return redirect()->back();
        }
        toast('There was an error during invoice generation','error');
        return redirect()->back();
    }
    public function invoicepdf(Request $request,$inv_no=255555){
        // return PDF::loadFile(public_path().'/templates/invoice.html')->save(public_path().'/docs/my_stored_file.pdf')->stream('download.pdf');
        $pdf = PDF::loadView('finance.invoicedoc');
        return $pdf->stream('invoice.pdf');
        $inv = $inv_no;
        return view('finance.invoicedoc',compact('inv'));
    }
}
