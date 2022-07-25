<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class apiController extends Controller
{
    public function getHotspotPackages(Request $request){
        $packages = DB::table('packages')->join('package_prices','package_prices.packageid','=','packages.id')->select('packages.*','package_prices.amount')->get();
        return response()->json($packages);
    }
    public function getPackageCost(Request $request){
        $package=DB::table('packages')->where('packagename','=',$request->get('package'))->get();
        $id=0;
        $cost=0;
        $users = '';
        foreach ($package as $key => $p) {
            $id=$p->id;
            $users=$p->users;
        }
        $amount=DB::table('package_prices')->where('packageid','=',$id)->get();

        foreach ($amount as $key => $a) {
            $cost=$a->amount;
        }
        return array($cost,$users);
    }
    public function getAccount(Request $request,$id){
        $account = DB::table('customer_accounts')->where('id',$id)->get();
        return $account;
    }

    public function getPackages(Request $request,$id){
        dd($request->all());
        $packages =DB::table('packages')->where('users',$id)->get();
        return $packages;
    }

    public function getPackagesbyuser(Request $request){
            $packages =DB::table('packages')->where('users',$request->user)->get();
            return $packages;
        }


    public function show($id)
    {  
        $packages =DB::table('packages')->where('users',$id)->get();
        return Response::json($packages);
    }
}
