<?php

namespace App\Scenarios;

use Illuminate\Database\Eloquent\Model;
use App\Byr_order_detail;
use App\Byr_order;
use App\byr_shop;

class ouk_canvas extends Model
{
    //
    public function exec($request,$sc)
    {
        $byr_order_id=$request->byr_order_id;
        $can_info_query=Byr_order_detail::select('byr_order_details.item_name','byr_order_details.jan','byr_order_details.color','byr_order_details.voucher_number')
        ->join('byr_orders','byr_order_details.byr_order_id','=','byr_orders.byr_order_id')
        ->where('byr_orders.byr_order_id',$byr_order_id)
        ->get();
        $collection = collect($can_info_query);
        $grouped = $collection->groupBy('voucher_number');
        $can_info=$grouped->toArray();
        $can_info_array=array();
        foreach ($can_info as $key => $value) {
            $can_info_array[]=$value;
        }
        return $can_info_array;
    }

    
}
