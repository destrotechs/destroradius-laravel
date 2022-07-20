<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use DB;
class PackageSalesChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan

    {
        $package_names = array();
        $packages = DB::table('packages')->get();

        $sales = array();

        foreach($packages as $p){
            array_push($package_names,$p->packagename);
            $times_bought = DB::table('payments')->where('packagebought','=',$p->packagename)->count();
            array_push($sales,$times_bought);
        }
        return Chartisan::build()
        ->labels($package_names)
        ->dataset('Number of Purchases', $sales);
    }
}
