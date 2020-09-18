<?php

namespace App\Scenarios;

use Illuminate\Database\Eloquent\Model;
use App\Models\BYR\byr_order_detail;
use App\Models\BYR\byr_order;
use App\Models\BYR\byr_shop;

class ouk_pdf_platform
{
    //
    public function exec($request,$sc)
    {
        $byr_order_id=$request->byr_order_id;
        $path = public_path() . "/json_files/delivery_report_array.json"; // ie: /var/www/laravel/app/storage/json/filename.json

        $json = json_decode(file_get_contents($path), true); 
        $report_array=$json['report_array'];
        $report_format=$json['report_format'];

        $report_arr_count=count($report_array);
        $report_arr_final=array();
        $temp_array=array();
        if ($report_format=="shipping_notice") {
            // Shipping_notice
            for ($i=0; $i < $report_arr_count; $i++) { 
                $step0=array_keys($report_array)[$i];
                $step0_data_array=$report_array[$step0];
    
                $step0_data_count=count($step0_data_array);
                for ($j=0; $j <$step0_data_count ; $j++) { 
                    $step1=array_keys($step0_data_array)[$j];
                    $temp_array[]=$step0_data_array[$step1]; 
                    
                }
                $report_arr_final[]=$temp_array;
                $temp_array=array(); 
            }
            // Shipping Notice
        }else if($report_format=="delivery_statement"){
            // Delivery Statement
            for ($i=0; $i < $report_arr_count; $i++) { 
                $step0=array_keys($report_array)[$i];
                $step0_data_array=$report_array[$step0];
                $report_arr_final[]=$step0_data_array;
                // Delivery Statement
            }
        }
        $new_report_array=array();
        // ----------
            $line_per_page=26;
            $today=date("Y/m/d h:s");
    //    ---------------
        foreach ($report_arr_final as $key => $value) {
            $total_item=count($value);
            $total_page=ceil($total_item / $line_per_page); 

            $collection = collect($value);
            $chunks = $collection->chunk($line_per_page);
            $chunked_arrays=$chunks->toArray();

            for ($j=0; $j < count($chunked_arrays); $j++) { 
                    $tmpp["page"]=($j+1)."/".$total_page;
                    $tmpp["data"]=array_values($chunked_arrays[$j]);
                    $new_report_array[]=$tmpp;
                }
            
        }
        return $new_report_array;



        $can_info_query=byr_order_detail::select('byr_order_details.*','byr_shops.shop_name_kana','byr_shops.shop_code',
        'cmn_connects.partner_code','byr_shipment_details.confirm_quantity','byr_shipment_details.revised_cost_price',
        'byr_shipment_details.revised_selling_price')
        ->join('byr_orders','byr_order_details.byr_order_id','=','byr_orders.byr_order_id')
        ->join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_orders.cmn_connect_id')
        ->join('byr_shops','byr_shops.byr_shop_id','=','byr_order_details.byr_shop_id')
        ->join('byr_shipment_details','byr_shipment_details.byr_order_detail_id','=','byr_order_details.byr_order_detail_id')
        ->where('byr_orders.byr_order_id',$byr_order_id)
        ->get();
        $collection = collect($can_info_query);
        $grouped = $collection->groupBy('voucher_number');
        $can_info=$grouped->toArray();

        $can_info_array=array();
        $total_order_qty=0;
        $total_selling_price=0;
        $total_cost_price=0;
        $total_confirm_quantity=0;
        foreach ($can_info as $key => $single_info) {
            foreach ($single_info as $key1 => $sum_val_array) {
                $total_order_qty+=$sum_val_array['order_unit_quantity'];
                $total_selling_price+=$sum_val_array['selling_price'];
                $total_cost_price+=$sum_val_array['cost_price'];
                if ($sum_val_array['order_unit_quantity']!=$sum_val_array['confirm_quantity']) {
                    $total_confirm_quantity+=$sum_val_array['confirm_quantity'];
                }
                // intval()order_unit_quantity
            }
            foreach ($single_info as $key2 => $nested_value) {
                $nested_value['total_order_qty']=$total_order_qty;
                $nested_value['total_selling_price']=$total_selling_price;
                $nested_value['total_cost_price']=$total_cost_price;
                $nested_value['total_confirm_quantity']=$total_confirm_quantity;
                $nested_value['order_unit_quantity']=intval($nested_value['order_unit_quantity']);
                $nested_value['cost_unit_price']=intval($nested_value['cost_unit_price']);
                if ($nested_value['order_unit_quantity']!=$nested_value['confirm_quantity']) {
                    $nested_value['confirm_quantity']=intval($nested_value['confirm_quantity']);
                    if ($nested_value['confirm_quantity']==0) {
                        $nested_value['confirm_quantity']="";
                    }
                }else{
                    $nested_value['confirm_quantity']="";
                }
                $nested_value['center_code']="";
                $nested_value['center_name']="";
                $other_info=\json_decode($nested_value['other_info']);
                if (!empty($other_info)) {
                    if ($other_info->center_flg==1) {
                        $nested_value['center_code']=$other_info->center_code;
                        $nested_value['center_name']=$other_info->center_name;
                    }
                }
                $nested_value['other_info']=$other_info;
                $single_info[$key2]=$nested_value;
            }
            $can_info_array[]=$single_info;
            $total_order_qty=0;
            $total_selling_price=0;
            $total_cost_price=0;
            $total_confirm_quantity=0;
        }
        return $can_info_array;
    }

    
}
