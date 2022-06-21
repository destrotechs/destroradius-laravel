<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class apiController extends Controller
{
    public function getHotspotPackages(Request $request){
        $packages = DB::table('packages')->join('package_prices','package_prices.packageid','=','packages.id')->select('packages.*','package_prices.amount')->get();
        return response()->json($packages);
    }
}
