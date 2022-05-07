<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use PEAR2\Net\RouterOS;
// use Morris\RouterOS\Autoload;
class paymentsController extends Controller
{
    public function selectPayOption(){
        try {
            $client = new Client('ADDRESS', 'LOGIN', 'PASSWORD');
            $responses = $client->sendSync(new RouterOS\Request('/ip/hotspot/active/print'));

            foreach ($responses as $response) {
                if ($response->getType() === RouterOS\Response::TYPE_DATA) {
                    echo 'User: ', $response->getProperty('user'),
                    "\n";
                }
            }
        }
        catch (Exception $e) {
            die($e);
            // echo "failed";

        }
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
}
