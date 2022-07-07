<?php

namespace App\Http\Controllers;
use App\Log;
use DB;
use App\Message;
use Illuminate\Http\Request;
// use App\Charts\SalesChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()

    {
        $this->logs_enabled=0;
        $enabled=DB::table('settings')->get();
        foreach ($enabled as $key => $en) {
            $this->logs_enabled=$en->logs_enabled;
        }
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $month = date('m');
       $total_users = DB::table('customers')->whereMonth('created_at', $month)->count();
       $total_online_users = DB::table('radacct')->where('acctstoptime','=',NULL)->count();
       $total_sales = DB::table('payments')->count();



       return view('home',compact('total_users','total_online_users','total_sales'));
    }
    public function getManagerDashboard(){
        return view('managers.dashboard');
    }
    public function getCompanyDetails(Request $request){
        $details = DB::table('company_details')->first();
        return view('company.companydetails',compact('details'));
    }
    public function postCompanyDetails(Request $request){
        $company = DB::table('company_details')->updateOrInsert(
            ['id'=>1],['name'=>$request->get('name'),'phone'=>$request->get('phone'),'address'=>$request->get('address'),'address2'=>$request->get('address2'),'city'=>$request->get('city'),'building'=>$request->get('building'),'phone2'=>$request->get('phone2')]
        );
        if($company){
            alert()->success("Company details updated successfully");
            return redirect()->back();
        }else{
            alert()->error("There was an error updating company details");
            return redirect()->back();
        }
    }
    public function getSMSBalance(Request $request){
        $message = new Message;
        $balance = $message->smsBalance();
        return $balance;
    }
}
