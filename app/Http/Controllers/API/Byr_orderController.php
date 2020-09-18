<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AllUsedFunction;
use Illuminate\Http\Request;
use App\Models\BYR\byr_order_detail;
use App\Models\BYR\byr_order;
use App\Models\BYR\byr_buyer;
use App\Models\BYR\byr_shipment;
use App\Models\BYR\byr_shipment_detail;
use App\Models\BYR\byr_shop;
use App\Models\CMN\cmn_pdf_canvas;
use App\Models\CMN\cmn_tbl_col_setting;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_connect;
use App\Models\CMN\cmn_company;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
use DB;


class Byr_orderController extends Controller
{
    private $all_used_fun;

    public function __construct(){
        $this->all_used_fun = new AllUsedFunction();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //test
        $result = byr_order::select( 'byr_orders.byr_order_id','byr_orders.receive_file_path','byr_orders.status','byr_orders.receive_date','byr_orders.data_count','byr_orders.category',
        DB::raw('(select expected_delivery_date from byr_order_details where byr_order_id  =   byr_orders.byr_order_id limit 1) as expected_delivery_date')  )->get();
        $byr_buyer = byr_buyer::all();
        return response()->json(['order_list' => $result,'byr_buyer_list'=>$byr_buyer]);
    }

    public function get_byr_order_list($adm_user_id)
    {
        $authUser=User::find($adm_user_id);
        $cmn_company_id = 0;
        if(!$authUser->hasRole('Super Admin')){
            $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id);
            $cmn_company_id = $cmn_company_info['cmn_company_id'];
            $byr_buyer_id = $cmn_company_info['byr_buyer_id'];
            $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }
        $result = byr_order::select( 'byr_orders.byr_order_id','cmn_companies.company_name','byr_orders.receive_file_path','byr_orders.status','byr_orders.receive_date','byr_orders.data_count','byr_orders.category',
        DB::raw('(select expected_delivery_date from byr_order_details where byr_order_id  =   byr_orders.byr_order_id limit 1) as expected_delivery_date')  )
        ->join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_orders.cmn_connect_id')
        ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
        ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id');
        if(!$authUser->hasRole('Super Admin')){
            $result = $result->where('byr_orders.cmn_connect_id',$cmn_connect_id);
        }
        $result = $result->get();
        $byr_buyer =$this->all_used_fun->get_company_list($cmn_company_id);
        
        return response()->json(['order_list' => $result,'byr_buyer_list'=>$byr_buyer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($byr_order_id)
    {

        $result = DB::table('byr_order_details')
            ->select('byr_order_details.*', 'byr_shipment_details.confirm_quantity', 'byr_shipment_details.lack_reason','byr_shops.shop_name_kana')
            ->leftJoin('byr_shipment_details', 'byr_shipment_details.byr_order_detail_id', '=', 'byr_order_details.byr_order_detail_id')
            ->leftJoin('byr_shops', 'byr_shops.byr_shop_id', '=', 'byr_order_details.byr_shop_id')
            ->where('byr_order_details.byr_order_id', $byr_order_id)
            ->get();
        /*coll setting*/
        $slected_list = array();
        $result_data = cmn_tbl_col_setting::where('url_slug', 'order_list_detail')->first();
            $header_list = json_decode($result_data->content_setting);
            foreach ($header_list as $header) {
                if ($header->header_status == true) {
                    $slected_list[] = $header->header_field;
                }
            }
        /*coll setting*/
        return response()->json(['order_list_detail' => $result,'slected_list'=>$slected_list]);
    }

    public function get_bms_order_byr_order_id($byr_order_id)
    {
        $result = DB::table('bms_orders')->where('bms_orders.byr_order_id', $byr_order_id)
            ->get();
        /*coll setting*/
        $slected_list = array();
        $result_data = cmn_tbl_col_setting::where('url_slug', 'order_list_detail')->first();
            $header_list = json_decode($result_data->content_setting);
            foreach ($header_list as $header) {
                if ($header->header_status == true) {
                    $slected_list[] = $header->header_field;
                }
            }
        /*coll setting*/
        return response()->json(['order_list_detail' => $result,'slected_list'=>$slected_list]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function update_shipment_detail(Request $request){
        byr_order_detail::where('byr_order_detail_id',$request->byr_order_detail_id)->update(['status'=>'確定済み']);
        byr_shipment_detail::where('byr_order_detail_id',$request->byr_order_detail_id)->update(['confirm_quantity'=>$request->confirm_quantity,'lack_reason'=>$request->lack_reason]);
        return response()->json(['success' => '1']);
    }

    public function update_byr_order_detail_status(Request $request){
        if($request->selected_item){
            foreach($request->selected_item as $item){
                byr_order_detail::where('byr_order_detail_id',$item)->update(['status'=>'確定済み']);

            }
        }
        //Byr_shipment_detail::where('byr_order_detail_id',$request->byr_order_detail_id)->update(['confirm_quantity'=>$request->confirm_quantity,'lack_reason'=>$request->lack_reason]);
        return response()->json(['success' => '1']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function canvasAllData(Request $request, $cmn_scenario_id){
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
        $canvas_data=byr_order::select('cmn_pdf_canvas.*','byr_orders.byr_order_id')
        ->join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_orders.cmn_connect_id')
        ->join('cmn_pdf_canvas','cmn_pdf_canvas.byr_buyer_id','=','cmn_connects.byr_buyer_id')
        ->where('byr_orders.byr_order_id',$byr_order_id)
        ->get();
        // $canvas_data=cmn_pdf_canvas::get();

        // $can_info_query=Byr_order_detail::select('byr_order_details.item_name','byr_order_details.jan','byr_order_details.color','byr_order_details.voucher_number')
        // ->join('byr_orders','byr_order_details.byr_order_id','=','byr_orders.byr_order_id')
        // ->where('byr_orders.byr_order_id',$byr_order_id)
        // ->get();
        // $collection = collect($can_info_query);
        // $grouped = $collection->groupBy('voucher_number');
        // $can_info=$grouped->toArray();
        // $can_info_array=array();
        // foreach ($can_info as $key => $value) {
        //     $can_info_array[]=$value;
        // }
        return response()->json(['canvas_data'=>$canvas_data,'can_info'=>$ret]);
    }
    public function canvasSettingData(){
        $all_buyer=byr_buyer::select('byr_buyers.byr_buyer_id','cmn_companies.company_name')
        ->join('cmn_companies','byr_buyers.cmn_company_id','=','cmn_companies.cmn_company_id')
        ->orderBy('byr_buyers.byr_buyer_id','ASC')
        ->get();
        // $canvas_info = cmn_pdf_canvas::orderBy('created_at','DESC')->get();
        $canvas_info = cmn_pdf_canvas::select('cmn_pdf_canvas.*','cmn_companies.company_name')
        ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_pdf_canvas.byr_buyer_id')
        ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')
        ->orderBy('cmn_pdf_canvas.updated_at','DESC')->get();
        $canvas_array=array();
        if (!empty($canvas_info)) {
            foreach ($canvas_info as $key => $canvas) {
                $tmp['cmn_pdf_canvas_id']=$canvas->cmn_pdf_canvas_id;
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
            $canvasBgImg = $this->all_used_fun->save_base64_image($canvasRawBgImg, 'canvas_bg_image_'. time().'_'.$byr_id, $path_with_end_slash = "storage/app/public/backend/images/canvas/Background/");
        } else {
            $canvasBgImgTmp = explode('/', $canvasRawBgImg);
            $canvasBgImg = $canvasBgImgTmp[count($canvasBgImgTmp) - 1];
        }
        // return $canvasBgImg;
        $canvas_image = $this->all_used_fun->save_base64_image($base64_canvas_image, 'canvas_image_'. time().'_'.$byr_id, $path_with_end_slash = "storage/app/public/backend/images/canvas/Canvas_screenshoot/");
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
        if (!empty($canvas_id)) {
            $can_exist=cmn_pdf_canvas::where('cmn_pdf_canvas_id', $canvas_id)->first();
            if ($can_exist['byr_buyer_id']!=$byr_id) {
                if (cmn_pdf_canvas::where('byr_buyer_id', $byr_id)->exists()) {
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

            $canvas_image_info = cmn_pdf_canvas::select('canvas_image','canvas_bg_image')->where('cmn_pdf_canvas_id', $canvas_id)->first();
            $file_path = \storage_path() . '/app/public/backend/images/canvas/';
            \Log::info('file_name_new=' . $file_path);
            if (file_exists($file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image'])) {
                @unlink($file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image']);
            }
            if (!empty($update_image_info)) {
                if ($canvas_image_info['canvas_bg_image']!="bg_image.jpg") {
                    if (file_exists($file_path.'Background/' . $canvas_image_info['canvas_bg_image'])) {
                        @unlink($file_path.'Background/' . $canvas_image_info['canvas_bg_image']);
                    }
                }
            }
            cmn_pdf_canvas::where('cmn_pdf_canvas_id', $canvas_id)->update($canvas_array);
            return response()->json(['message' =>'updated', 'class_name' => 'success','title'=>'Updated!']);
        } else {
            if (!(cmn_pdf_canvas::where('byr_buyer_id', $byr_id)->exists())) {
                cmn_pdf_canvas::insert($canvas_array);
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
        $canvas_image_info = cmn_pdf_canvas::select('canvas_image','canvas_bg_image')->where('cmn_pdf_canvas_id', $canvas_id)->first();
            $file_path = storage_path() . '/app/public/backend/images/canvas/';
            \Log::info('file_name_new=' . $file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image']);
            if (file_exists($file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image'])) {
                @unlink($file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image']);
            }
            if ($canvas_image_info['canvas_bg_image']!="bg_image.jpg") {
                if (file_exists($file_path .'Background/'. $canvas_image_info['canvas_bg_image'])) {
                    @unlink($file_path .'Background/'. $canvas_image_info['canvas_bg_image']);
                }
            }
            $canvas_del=cmn_pdf_canvas::where('cmn_pdf_canvas_id', $canvas_id)->delete();
            if ($canvas_del) {
                return response()->json(['message' =>'success', 'class_name' => 'success','title'=>'Deleted!']);
            }else{
                return response()->json(['message' =>'faild', 'class_name' => 'error','title'=>'Not Deleted!']);
            }
            
    }

    public function get_byr_info_by_byr_order_id($byr_order_id){
        $result = DB::table('byr_orders')
            ->select('byr_buyers.*')
            ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'byr_orders.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
            ->where('byr_orders.byr_order_id', $byr_order_id)
            ->first();
        return response()->json(['byr_info'=>$result]);
    }
}