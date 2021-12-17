<?php

namespace App\Http\Controllers;
use App\Log;
use DB;
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
       $total_sales = DB::table('transactions')->count();



       return view('home',compact('total_users','total_online_users','total_sales'));
    }
    public function getManagerDashboard(){
        return view('managers.dashboard');
    }
}
