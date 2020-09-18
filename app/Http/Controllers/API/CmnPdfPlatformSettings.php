<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AllUsedFunction;
use App\Models\BYR\byr_order_detail;
use App\Models\BYR\byr_order;
use App\Models\BYR\byr_buyer;
use App\Models\BYR\byr_shipment;
use App\Models\BYR\byr_shipment_detail;
use App\Models\BYR\byr_shop;
use App\Models\CMN\cmn_pdf_platform_canvas;
use App\Models\CMN\cmn_tbl_col_setting;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_connect;
use App\Models\CMN\cmn_company;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
use DB;

class CmnPdfPlatformSettings extends Controller
{
    private $all_used_func;

    public function __construct(){
        $this->all_used_func = new AllUsedFunction();
    }
    public function pdfPlatformAllData(Request $request, $cmn_scenario_id){
        // return $request->all();
        $sc=cmn_scenario::where('cmn_scenario_id',$cmn_scenario_id)->first();
        // return app_path().'/'.$sc->file_path.'.php';
        // scenario call
        if (!file_exists(app_path().'/'.$sc->file_path.'.php')) {
            \Log::error('Scenario file is not exist!:'.$sc->file_path);
            return ['status'=>'1','message'=>'Scenario file is not exist!'.$sc->file_path];
        }
        // ファイル読み込み
        
        // $sc_obj = new ouk_order_toj();//$sc->file_path;
        $customClassPath = "\\App\\";
        $nw_f_pth = explode('/',$sc->file_path);
        foreach($nw_f_pth as $p){
            $customClassPath .= $p.'\\';
        }
        $customClassPath = rtrim($customClassPath,"\\");
        $sc_obj = new $customClassPath;
        if (!method_exists($sc_obj, 'exec')) {
            \Log::error('scenario exec error');
            return ['status'=>'1','message'=>'Scenario exec function is not exist!'];
        }
        $ret = $sc_obj->exec($request,$sc);
        // if ($ret !== 0) {
        //     // error
        //     \Log::debug('scenario exec error');
        // } else {
        //     // success
        //     \Log::debug('scenario exec success');
        // }
        // return $ret;

        $byr_order_id=$request->byr_order_id;
        $canvas_data=byr_order::select('cmn_pdf_platform_canvas.*','byr_orders.byr_order_id')
        ->join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_orders.cmn_connect_id')
        ->join('cmn_pdf_platform_canvas','cmn_pdf_platform_canvas.byr_buyer_id','=','cmn_connects.byr_buyer_id')
        ->where('byr_orders.byr_order_id',$byr_order_id)
        ->get();
        return response()->json(['canvas_data'=>$canvas_data,'can_info'=>$ret]);
    }
    public function canvasSettingData(){
        $all_buyer=byr_buyer::select('byr_buyers.byr_buyer_id','cmn_companies.company_name')
        ->join('cmn_companies','byr_buyers.cmn_company_id','=','cmn_companies.cmn_company_id')
        ->orderBy('byr_buyers.byr_buyer_id','ASC')
        ->get();
        // $canvas_info = cmn_pdf_canvas::orderBy('created_at','DESC')->get();
        $canvas_info = cmn_pdf_platform_canvas::select('cmn_pdf_platform_canvas.*','cmn_companies.company_name')
        ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_pdf_platform_canvas.byr_buyer_id')
        ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')
        ->orderBy('cmn_pdf_platform_canvas.updated_at','DESC')->get();
        $canvas_array=array();
        if (!empty($canvas_info)) {
            foreach ($canvas_info as $key => $canvas) {
                $tmp['cmn_pdf_platform_canvas_id']=$canvas->cmn_pdf_platform_canvas_id;
                $tmp['byr_buyer_id']=$canvas->byr_buyer_id;
                $tmp['company_name']=$canvas->company_name;
                $tmp['canvas_name']=$canvas->canvas_name;
                $tmp['canvas_image']=$canvas->canvas_image;
                $tmp['canvas_bg_image']=$canvas->canvas_bg_image;
                $tmp['canvas_objects']=\json_decode($canvas->canvas_objects);
                // $tmp['canvas_objects']=$canvas->canvas_objects;
                // $tmp['canvas_objects']=$this->UnserializedCanvasData($canvas->canvas_objects);;
                $tmp['created_at']=$canvas->created_at;
                $tmp['updated_at']=$canvas->updated_at;
                $canvas_array[]=$tmp;
            }
        }
        return response()->json(['canvas_info'=>$canvas_array,'all_buyer'=>$all_buyer]);
    }
    public function canvasDataSave(Request $request){
        // return $request->all();
        $canvas_id = $request->canvas_id;
        $update_image_info = $request->update_image_info;
        $byr_id = $request->byr_id;
        $canvas_name = $request->canvas_name;
        $base64_canvas_image = $request->canvasImage;
        $canData = $request->canData;
        // $objPosArray = $request->objPosArray;

        $canvasRawBgImg = $canData['backgroundImage']['src'];
        if (!empty($update_image_info)) {
            $canvasBgImg = $this->all_used_func->save_base64_image($canvasRawBgImg, 'canvas_bg_image_'. time().'_'.$byr_id, $path_with_end_slash = "storage/app/public/backend/images/canvas/pdf_platform/Background/");
        } else {
            $canvasBgImgTmp = explode('/', $canvasRawBgImg);
            $canvasBgImg = $canvasBgImgTmp[count($canvasBgImgTmp) - 1];
        }
        // return $canvasBgImg;
        $canvas_image = $this->all_used_func->save_base64_image($base64_canvas_image, 'canvas_image_'. time().'_'.$byr_id, $path_with_end_slash = "storage/app/public/backend/images/canvas/pdf_platform/Canvas_screenshoot/");
        // Serialize the above data
        // $canData_string = serialize($canData);
        $canvas_array = array(
            'byr_buyer_id' => $byr_id,
            'canvas_name' => $canvas_name,
            'canvas_image' => $canvas_image,
            'canvas_bg_image' => $canvasBgImg,
            'canvas_objects' => json_encode($canData),
            // 'canvas_objects' => $canData_string,
            // 'position_values' => \json_encode($objPosArray),
        );
        $file_path = \storage_path() . '/app/public/backend/images/canvas/pdf_platform/';
        if (!empty($canvas_id)) {
            $can_exist=cmn_pdf_platform_canvas::where('cmn_pdf_platform_canvas_id', $canvas_id)->first();
            if ($can_exist['byr_buyer_id']!=$byr_id) {
                if (cmn_pdf_platform_canvas::where('byr_buyer_id', $byr_id)->exists()) {
                    if (file_exists($file_path .'Canvas_screenshoot/'. $canvas_image)) {
                        @unlink($file_path .'Canvas_screenshoot/'. $canvas_image);
                    }
                    if (!empty($update_image_info)) {
                        if (file_exists($file_path .'Background/'. $canvasBgImg)) {
                            @unlink($file_path .'Background/'. $canvasBgImg);
                        }
                    }
                    return response()->json(['message' =>'duplicated', 'class_name' => 'error','title'=>'Not Updated!']);
                }
            }

            $canvas_image_info = cmn_pdf_platform_canvas::select('canvas_image','canvas_bg_image')->where('cmn_pdf_platform_canvas_id', $canvas_id)->first();
            // $file_path = \storage_path() . '/app/public/backend/images/canvas/pdf_platform/';
            \Log::info('file_name_new=' . $file_path);
            if (file_exists($file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image'])) {
                @unlink($file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image']);
            }
            if (!empty($update_image_info)) {
                if ($canvas_image_info['canvas_bg_image']!="bg_image.png") {
                    if (file_exists($file_path.'Background/' . $canvas_image_info['canvas_bg_image'])) {
                        @unlink($file_path.'Background/' . $canvas_image_info['canvas_bg_image']);
                    }
                }
            }
            cmn_pdf_platform_canvas::where('cmn_pdf_platform_canvas_id', $canvas_id)->update($canvas_array);
            return response()->json(['message' =>'updated', 'class_name' => 'success','title'=>'Updated!']);
        } else {
            if (!(cmn_pdf_platform_canvas::where('byr_buyer_id', $byr_id)->exists())) {
                cmn_pdf_platform_canvas::insert($canvas_array);
                return response()->json(['message' =>'created', 'class_name' => 'success','title'=>'Created!']);
            }else{
                if (file_exists($file_path .'Canvas_screenshoot/'. $canvas_image)) {
                    @unlink($file_path .'Canvas_screenshoot/'. $canvas_image);
                }
                if (!empty($update_image_info)) {
                    if (file_exists($file_path .'Background/'. $canvasBgImg)) {
                        @unlink($file_path .'Background/'. $canvasBgImg);
                    }
                }
                return response()->json(['message' =>'duplicated', 'class_name' => 'error','title'=>'Not Created!']);
            }
        }
    }
    public function deleteCanvasData(Request $request){
        $canvas_id=$request->cmn_pdf_canvas_id;
        $canvas_image_info = cmn_pdf_platform_canvas::select('canvas_image','canvas_bg_image')->where('cmn_pdf_platform_canvas_id', $canvas_id)->first();
            $file_path = storage_path() . '/app/public/backend/images/canvas/pdf_platform/';
            \Log::info('file_name_new=' . $file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image']);
            if (file_exists($file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image'])) {
                @unlink($file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image']);
            }
            if ($canvas_image_info['canvas_bg_image']!="bg_image.png") {
                if (file_exists($file_path .'Background/'. $canvas_image_info['canvas_bg_image'])) {
                    @unlink($file_path .'Background/'. $canvas_image_info['canvas_bg_image']);
                }
            }
            $canvas_del=cmn_pdf_platform_canvas::where('cmn_pdf_platform_canvas_id', $canvas_id)->delete();
            if ($canvas_del) {
                return response()->json(['message' =>'success', 'class_name' => 'success','title'=>'Deleted!']);
            }else{
                return response()->json(['message' =>'faild', 'class_name' => 'error','title'=>'Not Deleted!']);
            }
            
    }
}
