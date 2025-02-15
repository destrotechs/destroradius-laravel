<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use DB;

class MonthlySales extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $monthsw = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];

        $month_sales = array();
        $total_sale = 0;
        for($i=0;$i<12;$i++){
            $sale = DB::table('payments')->get();
            if(count($sale)>0){
                foreach($sale as $s){
                    if(explode("/",$s->transactiondate)[1]==$months[$i]){
                        $total_sale+=$s->amount;
                    }else{
                        $total_sale=0;
                    }
                }
            }
            
            array_push($month_sales,$total_sale);
        }
        return Chartisan::build()
            ->labels($monthsw)
            ->dataset('Amount on Sales', $month_sales);
    }
}
