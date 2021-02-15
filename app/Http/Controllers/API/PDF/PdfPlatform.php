<?php

namespace App\Http\Controllers\API\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AllUsedFunction;
use App\Models\BYR\byr_buyer;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_pdf_platform_canvas;
use App\Models\DATA\ORD\data_order;
use App\Http\Controllers\API\Cmn_ScenarioController;

class PdfPlatform extends Controller
{
    private $all_used_func;

    public function __construct(){
        $this->all_used_func = new AllUsedFunction();
    }
    public function pdfPlatformAllData(Request $request){
        $data_order_id=$request->data_order_id;
        $canvas_data=data_order::select('cmn_pdf_platform_canvas.*','data_orders.data_order_id')
        ->join('cmn_connects','cmn_connects.cmn_connect_id','=','data_orders.cmn_connect_id')
        ->join('cmn_pdf_platform_canvas','cmn_pdf_platform_canvas.byr_buyer_id','=','cmn_connects.byr_buyer_id')
        ->where('data_orders.data_order_id',$data_order_id)
        ->get();
        $line_per_page=26;
        if (!empty(json_decode($canvas_data))) {
            $line_per_page=$canvas_data[0]->line_per_page;
        }
        // $request=$request->all();
        $request->request->add(['line_per_page' => $line_per_page]);
        // return $request->all();
        // $request['line_per_page']=$line_per_page;
        // return $request;
        $cs = new Cmn_ScenarioController();
        $ret = $cs->exec($request);
        // array_pop(,)
        // return $request->all();
        \Log::debug($ret->getContent());
        $ret = json_decode($ret->getContent(), true);
        if (1 === $ret['status']) {
            // sceanario exec error
            \Log::error($ret['message']);
            return $ret;
        }
        return response()->json($ret);

        // $sc=cmn_scenario::where('cmn_scenario_id',$cmn_scenario_id)->first();
        // // scenario call
        // if (!file_exists(app_path().'/'.$sc->file_path.'.php')) {
        //     \Log::error('Scenario file is not exist!:'.$sc->file_path);
        //     return ['status'=>'1','message'=>'Scenario file is not exist!'.$sc->file_path];
        // }
        // // ファイル読み込み
        // $customClassPath = "\\App\\";
        // $nw_f_pth = explode('/',$sc->file_path);
        // foreach($nw_f_pth as $p){
        //     $customClassPath .= $p.'\\';
        // }
        // $customClassPath = rtrim($customClassPath,"\\");
        // $sc_obj = new $customClassPath;
        // if (!method_exists($sc_obj, 'exec')) {
        //     \Log::error('scenario exec error');
        //     return ['status'=>'1','message'=>'Scenario exec function is not exist!'];
        // }
        // $ret = $sc_obj->exec($request,$sc,$line_per_page);
        // if ($ret !== 0) {
        //     // error
        //     \Log::debug('scenario exec error');
        // } else {
        //     // success
        //     \Log::debug('scenario exec success');
        // }
        // return $ret;
        return response()->json(['canvas_data'=>$canvas_data,'can_info'=>$ret]);
    }
}
