<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
class paymentsController extends Controller
{
    public function selectPayOption(){
    	return view('payments.selectoption');
    }
    public function payoption(Request $request){
        $payoption=$request->get('paytype');
        if($payoption=='paypal'){
            return redirect()->route('paypal.payment');
        }else if($payoption=='stripe'){
            return redirect()->route('stripe.payment');
        }else if($payoption=='mpesa'){
            return redirect()->route('mpesa.payment');
        }
        else{
            return redirect()->back()->with("error","This method is not supported yet");
        }
    }
    public function getPaypal(Request $request){
        return view('payments.paypal');
    }
    public function getStripe(Request $request){
        return view('payments.stripe');
    }
    public function getMpesa(Request $request){
        $packages = DB::table('packages')->get();
        return view('payments.mpesa',compact('packages'));
    }
    public function getAllPayments(Request $request){
        $payments = DB::table('payments')->paginate(10);
        return view('finance.payments',compact('payments'));
    }
}
