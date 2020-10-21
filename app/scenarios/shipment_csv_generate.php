<?php

namespace App\Scenarios;
use App\Models\BYR\byr_shipment;

class shipment_csv_generate
{
    //
    public function exec($request,$sc)
    {
        // return $request;
        $cmn_scenario_id=$request->scenario_id;
        $byr_order_id=$request->order_id;
        $shipment_csv_data=byr_shipment::select('byr_shipments.*','bsd.*','bsv.*','bsi.*')
        ->join('byr_shipment_details as bsd','bsd.byr_shipment_id','=','byr_shipments.byr_shipment_id')
        ->join('byr_shipment_vouchers as bsv','bsv.byr_shipment_id','=','byr_shipments.byr_shipment_id')
        ->join('byr_shipment_items as bsi','bsi.byr_shipment_voucher_id','=','bsv.byr_shipment_voucher_id')
        ->where('byr_shipments.byr_order_id',$byr_order_id)
        ->get();
        $fileName = 'tasks.csv';
        // $tasks = Task::all();

        // $headers = array(
        //     "Content-type"        => "text/csv",
        //     "Content-Disposition" => "attachment; filename=$fileName",
        //     "Pragma"              => "no-cache",
        //     "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        //     "Expires"             => "0"
        // );

        $columns = array('Title', 'Assign', 'Description', 'Start Date', 'Due Date');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                $row['Title']  = $task->title;
                $row['Assign']    = $task->assign->name;
                $row['Description']    = $task->description;
                $row['Start Date']  = $task->start_at;
                $row['Due Date']  = $task->end_at;

                fputcsv($file, array($row['Title'], $row['Assign'], $row['Description'], $row['Start Date'], $row['Due Date']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
        return $shipment_csv_data;
    }

    
}
