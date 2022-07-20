<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use DB;

class ItemsChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     * 
     */
    public ?string $name = 'items_chart';

    public function handler(Request $request): Chartisan
    {
        $cat = array();
        $c = DB::table('item_categories')->get();

        $items = array();

        foreach($c as $ct){
            $num = DB::table('items')->where('category_code','=',$ct->category_code)->get();
            $total = 0;
            foreach($num as $n){
                $total = $total+$n->quantity;
            }

            array_push($cat,$ct->description);
            array_push($items,$total);
        }
        // echo (array)$sub_cat;


        return Chartisan::build()
            ->labels($cat)
            ->dataset('Total Items', $items);
    }
}