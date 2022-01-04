<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class MonthlySales extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $months = array('1','2','3','4','5','6','7','8','9','10','11','12');

        $month_sales = array();
        $total_sale = 0;
        for($i=0;$i<count($months);$i++){
            $sale = DB::table('payments')->whereMonth('created_at',$months[$i])->get();
            if (count($sale)>0){
                foreach($sale as $s){
                    $total_sale+=$s->amount;
                }
            }else{
                $total_sale = 0;
            }

            array_push($month_sales,$total_sale);
        }
        return Chartisan::build()
            ->labels($months)
            ->dataset('SaleTotals', $month_sales);
    }
}
