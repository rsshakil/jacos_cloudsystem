<?php

namespace App\Scenarios;

use Illuminate\Database\Eloquent\Model;
use App\Byr_order_detail;
use App\Byr_order;
use App\byr_shop;

class ouk_order_voucher extends Model
{
    //
    public function exec($request,$sc)
    {
        $byr_order_id=$request->byr_order_id;
        // $can_info_query=Byr_order_detail::select('byr_order_details.item_name','byr_order_details.jan','byr_order_details.color','byr_order_details.voucher_number')
        $can_info_query=Byr_order_detail::select('byr_order_details.*')
        ->join('byr_orders','byr_order_details.byr_order_id','=','byr_orders.byr_order_id')
        ->where('byr_orders.byr_order_id',$byr_order_id)
        ->get();
        $collection = collect($can_info_query);
        $grouped = $collection->groupBy('voucher_number');
        $can_info=$grouped->toArray();

        $can_info_array=array();
        $total_order_qty=0;
        $total_selling_price=0;
        $total_cost_price=0;
        foreach ($can_info as $key => $single_info) {
            foreach ($single_info as $key1 => $sum_val_array) {
                $total_order_qty+=$sum_val_array['order_quantity'];
                $total_selling_price+=$sum_val_array['selling_price'];
                $total_cost_price+=$sum_val_array['cost_price'];
            }
            foreach ($single_info as $key2 => $nested_value) {
                $nested_value['total_order_qty']=$total_order_qty;
                $nested_value['total_selling_price']=$total_selling_price;
                $nested_value['total_cost_price']=$total_cost_price;
                $single_info[$key2]=$nested_value;
            }
            $can_info_array[]=$single_info;
            $total_order_qty=0;
            $total_selling_price=0;
            $total_cost_price=0;
        }
        return $can_info_array;
    }

    
}
