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
        $today=date("Y/m/d h:s"); 
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
                    // $tmpp["page"]=($j+1)."/".$total_page;
                    // $tmpp["data"]=array_values($chunked_arrays[$j]);
                    $chunked_arrays_reorder=array_values($chunked_arrays[$j]);
                    $tmpp=array();
                    foreach ($chunked_arrays_reorder as $key3 => $aaa) {
                        $aaa['page']=($j+1)."/".$total_page;
                        $aaa['scheduled_delivery_date']=date("Y/m/d",strtotime($aaa['scheduled_delivery_date']));
                        $aaa['today']=$today;
                        $aaa['delivery_location_code']=substr($aaa['delivery_location_code'],-4);
                        $tmpp[]=$aaa;
                    }
                    $new_report_array[]=$tmpp;
                }
            
        }
        return $new_report_array;
    }

    
}
