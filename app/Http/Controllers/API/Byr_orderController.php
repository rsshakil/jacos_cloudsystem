<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AllUsedFunction;
use Illuminate\Http\Request;
use App\Models\BYR\byr_order_item;
use App\Models\BYR\byr_order;
use App\Models\BYR\byr_buyer;
use App\Models\BYR\byr_shipment;
use App\Models\BYR\byr_shipment_item;
use App\Models\BYR\byr_shop;
use App\Models\CMN\cmn_pdf_canvas;
use App\Models\CMN\cmn_tbl_col_setting;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_connect;
use App\Models\CMN\cmn_company;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
use DB;
use Auth;

class Byr_orderController extends Controller
{
    private $all_used_fun;

    public function __construct()
    {
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
        $result = byr_order::select(
            'byr_orders.byr_order_id',
            'byr_orders.receive_file_path',
            'byr_orders.status',
            'byr_orders.receive_date',
            'byr_orders.data_count',
            'byr_orders.category',
            DB::raw('(select expected_delivery_date from byr_order_vouchers where byr_order_id  =   byr_orders.byr_order_id limit 1) as expected_delivery_date')
        )->get();
        $byr_buyer = byr_buyer::all();
        return response()->json(['order_list' => $result,'byr_buyer_list'=>$byr_buyer]);
    }

    public function get_byr_order_list(Request $request)
    {
        // return $request->all();
        // $authUser=\Auth::User()->id;
        $adm_user_id=$request->adm_user_id;
        $byr_buyer_id=$request->byr_buyer_id;
        // $byr_buyer_id=$request->byr_buyer_id;
        $check_datetime=$request->check_datetime;
        $confirmation_status=$request->confirmation_status;
        $decission_cnt=$request->decission_cnt;
        $delivery_date_from=$request->delivery_date_from;
        $delivery_date_to=$request->delivery_date_to;
        $delivery_service_code=$request->delivery_service_code;
        $print_cnt=$request->print_cnt;
        $receive_date_from=$request->receive_date_from;
        $receive_date_to=$request->receive_date_to;
        // $receive_date_from=date('y-m-d h:i:s',strtotime($request->receive_date_from));
        // $receive_date_to=date('y-m-d h:i:s',strtotime($request->receive_date_to));
        $submit_type=$request->submit_type;
        $temperature=$request->temperature;
        // return $byr_buyer_id;

        // $print_cnt=$print_cnt=="*"?null:$print_cnt;
        $search_where='';
        $having_var='';
        if ($submit_type=="search") {
            $search_where="AND dor.receive_datetime BETWEEN '".$receive_date_from."' AND '".$receive_date_to."' ";
            $search_where.="OR dov.mes_lis_ord_tra_dat_delivery_date BETWEEN '".$delivery_date_from."' AND '".$delivery_date_from."' ";
            $search_where.="AND dov.mes_lis_ord_log_del_delivery_service_code='".$delivery_service_code."' ";
            $search_where.="OR dov.check_datetime='".$check_datetime."' ";
            $search_where.="AND dov.mes_lis_ord_tra_ins_temperature_code='".$temperature."' ";

            if ($print_cnt=="*") {
                $having_var="HAVING print_cnt = '' ";
            } elseif ($print_cnt=="!0") {
                $having_var="HAVING print_cnt!=0 ";
            } else {
                $having_var="HAVING print_cnt='".$print_cnt."' ";
            }
            if ($decission_cnt=="*") {
                $having_var.="OR decision_cnt = ''";
            } elseif ($decission_cnt=="!0") {
                $having_var.="OR decision_cnt!=0";
            } else {
                $having_var.="OR decision_cnt='".$decission_cnt."'";
            }

            // $having_var.="AND decision_cnt='".$decission_cnt."'";
        }
        // return $byr_buyer_id;
        $authUser=User::find($adm_user_id);
        $cmn_company_id = '';
        $cmn_connect_id = '';
        if (!$authUser->hasRole('Super Admin')) {
            $cmn_company_info = cmn_companies_user::select('slr_sellers.cmn_company_id', 'slr_sellers.slr_seller_id', 'cmn_connects.cmn_connect_id')
                ->join('slr_sellers', 'slr_sellers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
                ->join('cmn_connects', 'cmn_connects.slr_seller_id', '=', 'slr_sellers.slr_seller_id')
                ->where('cmn_companies_users.adm_user_id', $adm_user_id)->first();
            $cmn_company_id = $cmn_company_info->cmn_company_id;
            // $byr_buyer_id = $cmn_company_info->byr_buyer_id;
            $cmn_connect_id = $cmn_company_info->cmn_connect_id;

            // $cmn_company_info = $this->all_used_fun->get_user_info($adm_user_id);
            // $cmn_company_id = $cmn_company_info['cmn_company_id'];
            // $byr_buyer_id = $cmn_company_info['byr_buyer_id'];
            // $cmn_connect_id = $cmn_company_info['cmn_connect_id'];
        }

        // return $byr_buyer_id;
        // return $cmn_connect_id;
        $result=DB::select("SELECT
        dor.data_order_id,
        dor.receive_datetime,
        dov.mes_lis_ord_par_sel_code,
        dov.mes_lis_ord_par_sel_name,
        dov.mes_lis_ord_tra_dat_delivery_date,
        dov.mes_lis_ord_tra_goo_major_category,
        dov.mes_lis_ord_log_del_delivery_service_code,
        dov.mes_lis_ord_tra_ins_temperature_code
        ,COUNT(distinct dov.data_order_voucher_id) AS cnt
        ,COUNT( isnull( dsv.decision_datetime) OR NULL) AS decision_cnt
        ,COUNT( !isnull( dsv.print_datetime)  OR NULL) AS print_cnt
        ,dov.check_datetime
        
        FROM data_orders AS dor
        INNER JOIN data_order_vouchers AS dov ON dor.data_order_id=dov.data_order_id
        INNER JOIN data_shipment_vouchers AS dsv ON dsv.data_order_voucher_id = dov.data_order_voucher_id
        WHERE
        dor.cmn_connect_id='$cmn_connect_id'
        $search_where
        GROUP BY
        dor.receive_datetime
        ,dor.sta_sen_identifier
        ,dov.mes_lis_ord_tra_dat_delivery_date
        ,dov.mes_lis_ord_tra_goo_major_category
        ,dov.mes_lis_ord_log_del_delivery_service_code
        ,dov.mes_lis_ord_tra_ins_temperature_code
        $having_var
        
        ");
        // return $result ;
        // $result = byr_order::select('byr_orders.*','cmn_companies.company_name','byr_order_vouchers.*',
        // DB::raw('(select count(voucher_number) from byr_order_vouchers where byr_order_vouchers.byr_order_id  =   byr_orders.byr_order_id group by byr_order_vouchers.expected_delivery_date,byr_order_vouchers.temperature,byr_order_vouchers.category_code,byr_order_vouchers.expected_delivery_date limit 1) as total_voucher_number'),
        // DB::raw('(select count(confirm_date) from byr_shipment_vouchers where byr_shipment_vouchers.byr_order_voucher_id  =   byr_order_vouchers.byr_order_voucher_id limit 1) as total_confirm_date'),
        // DB::raw('(select count(print_out_date) from byr_shipment_vouchers where byr_shipment_vouchers.byr_order_voucher_id  =   byr_order_vouchers.byr_order_voucher_id limit 1) as total_print_out_date')
        //  )
        // ->join('byr_order_vouchers','byr_order_vouchers.byr_order_id','=','byr_orders.byr_order_id')
        // ->leftJoin('byr_shipment_vouchers','byr_shipment_vouchers.byr_order_voucher_id','=','byr_order_vouchers.byr_order_voucher_id')
        // ->join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_orders.cmn_connect_id')
        // ->join('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
        // ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')
        // ->groupBy('byr_order_vouchers.expected_delivery_date','byr_order_vouchers.category_code','byr_order_vouchers.temperature');
        // if(!$authUser->hasRole('Super Admin')){
        //     $result = $result->where('byr_orders.cmn_connect_id',$cmn_connect_id);
        // }
        // echo $result->toSql();exit;
        // $result = $result->get();
        // return $result;
        // return $byr_buyer_id;
        $buyer_settings=byr_buyer::select('setting_information')->where('byr_buyer_id', $byr_buyer_id)->first();
        $byr_buyer =$this->all_used_fun->get_company_list($cmn_company_id);
        
        return response()->json(['order_list' => $result,'byr_buyer_list'=>$byr_buyer,'buyer_settings'=>$buyer_settings->setting_information]);
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
    public function orderDetails(Request $request)
    {
        // return $request->all();
        $data_order_id=$request->data_order_id;
        $delivery_date=$request->delivery_date;
        $delivery_service_code=$request->delivery_service_code;
        $major_category=$request->major_category;
        $temperature_code=$request->temperature_code;

        // return $request->all();
        // $result=DB::select("
        // ");
        $result=DB::select("
        SELECT
        dsv.mes_lis_shi_tra_dat_delivery_date,
        dsv.mes_lis_shi_tra_goo_major_category,
        dsv.mes_lis_shi_log_del_delivery_service_code,
        dsv.mes_lis_shi_tra_ins_temperature_code,
        dsv.decision_datetime,
        dsv.mes_lis_shi_par_shi_code,
        dsv.mes_lis_shi_par_rec_code,
        dsv.mes_lis_shi_par_rec_name,
        dsv.mes_lis_shi_tra_trade_number,
        dsv.mes_lis_shi_tra_ins_goods_classification_code,
        dsv.mes_lis_shi_tot_tot_net_price_total,
        dsv.`status`,
        dsv.updated_at,
        dsv.print_datetime,
        dsv.send_datetime
        FROM data_shipments AS ds
        inner join data_shipment_vouchers AS dsv ON ds.data_shipment_id=dsv.data_shipment_id
        INNER JOIN data_shipment_items AS dsi ON dsi.data_shipment_voucher_id = dsv.data_shipment_voucher_id
        WHERE
        ds.data_order_id='$data_order_id' AND
        dsv.mes_lis_shi_tra_dat_delivery_date= '$delivery_date' AND
        dsv.mes_lis_shi_tra_goo_major_category = '$major_category' AND
        dsv.mes_lis_shi_log_del_delivery_service_code = '$delivery_service_code' AND
        dsv.mes_lis_shi_tra_ins_temperature_code = '$temperature_code'
        GROUP BY dsv.mes_lis_shi_tra_trade_number
        ");
        
        $orderItem=collect(\DB::select("
        SELECT * FROM data_order_items 
        inner join data_order_vouchers on data_order_vouchers.data_order_voucher_id=data_order_items.data_order_voucher_id
        inner join data_orders on data_orders.data_order_id=data_order_vouchers.data_order_id
        where data_orders.data_order_id = '$data_order_id'
        "))->first();
        // AND dsv.mes_lis_shi_par_shi_code = ''
        // AND dsv.mes_lis_shi_par_rec_code = ''
        // AND dsv.mes_lis_shi_tra_trade_number = ''
        // AND dsi.mes_lis_shi_lin_ite_order_item_code = ''
        // AND dsv.mes_lis_shi_tra_ins_goods_classification_code = ''
        // AND dsv.decision_datetime = ''
        // AND dsv.print_datetime = ''
        // return $result;
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
        return response()->json(['order_list_detail' => $result,'orderItem'=>$orderItem,'slected_list'=>$slected_list]);
        // $result = DB::table('byr_order_vouchers')
        //     ->select('byr_order_vouchers.*','byr_order_items.*', 'byr_shipment_items.confirm_quantity', 'byr_shipment_items.lack_reason')
        //     ->join('byr_order_items', 'byr_order_items.byr_order_voucher_id', '=', 'byr_order_vouchers.byr_order_voucher_id')
        //     ->leftJoin('byr_shipment_vouchers', 'byr_shipment_vouchers.byr_order_voucher_id', '=', 'byr_order_vouchers.byr_order_voucher_id')
        //     ->leftJoin('byr_shipment_items', 'byr_shipment_items.byr_shipment_voucher_id', '=', 'byr_shipment_vouchers.byr_shipment_voucher_id')
        //     // ->leftJoin('byr_shops', 'byr_shops.byr_shop_id', '=', 'byr_order_details.byr_shop_id')
        //     ->where('byr_order_vouchers.byr_order_id', $byr_order_id)
        //     ->get();
        /*coll setting*/
        // $slected_list = array();
        // $result_data = cmn_tbl_col_setting::where('url_slug', 'order_list_detail')->first();
        //     $header_list = json_decode($result_data->content_setting);
        //     foreach ($header_list as $header) {
        //         if ($header->header_status == true) {
        //             $slected_list[] = $header->header_field;
        //         }
        //     }
        /*coll setting*/
        // return response()->json(['order_list_detail' => $result,'slected_list'=>$slected_list]);
    }

    public function orderItemDetails($data_shipment_voucher_id)
    {
        //order $data_order_voucher_id=1;
        $data_order_voucher_id=1;
        $orderItem=collect(\DB::select("
        SELECT * FROM data_order_items 
        inner join data_order_vouchers on data_order_vouchers.data_order_voucher_id=data_order_items.data_order_voucher_id
        inner join data_orders on data_orders.data_order_id=data_order_vouchers.data_order_id
        where data_order_items.data_order_voucher_id = '$data_shipment_voucher_id'
        "))->first();
        //shipment
        $result=DB::select("
        SELECT * FROM data_shipment_items 
        inner join data_shipment_vouchers on data_shipment_vouchers.data_shipment_voucher_id=data_shipment_items.data_shipment_voucher_id
        inner join data_shipments on data_shipments.data_shipment_id=data_shipment_vouchers.data_shipment_id
        where data_shipment_items.data_shipment_voucher_id = '$data_shipment_voucher_id'
        ");

        // print_r($result);exit;
        $slected_list = array();
        $result_data = cmn_tbl_col_setting::where('url_slug', 'order_item_list_detail')->first();
        if ($result_data) {
            $header_list = json_decode($result_data->content_setting);
            foreach ($header_list as $header) {
                if ($header->header_status == true) {
                    $slected_list[] = $header->header_field;
                }
            }
        }
        /*coll setting*/
        return response()->json(['order_item_list_detail' => $result,'orderItem'=>$orderItem,'slected_list'=>$slected_list]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($byr_order_id)
    {
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

    public function update_shipment_detail(Request $request)
    {
        byr_order_item::where('byr_order_item_id', $request->byr_order_item_id)->update(['status'=>'確定済み']);
        byr_shipment_item::where('byr_order_item_id', $request->byr_order_item_id)->update(['confirm_quantity'=>$request->confirm_quantity,'lack_reason'=>$request->lack_reason]);
        return response()->json(['success' => '1']);
    }

    public function update_byr_order_detail_status(Request $request)
    {
        if ($request->selected_item) {
            foreach ($request->selected_item as $item) {
                byr_order_item::where('byr_order_item_id', $item)->update(['status'=>'確定済み']);
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
    public function canvasAllData(Request $request)
    {
        $cmn_scenario_id=$request->cmn_scenario_id;
        $byr_order_id=$request->byr_order_id;
        $sc=cmn_scenario::where('cmn_scenario_id', $cmn_scenario_id)->first();
        // return app_path().'/'.$sc->file_path.'.php';
        // scenario call
        if (!file_exists(app_path().'/'.$sc->file_path.'.php')) {
            \Log::error('Scenario file is not exist!:'.$sc->file_path);
            return ['status'=>'1','message'=>'Scenario file is not exist!'.$sc->file_path];
        }
        // ファイル読み込み
        
        // $sc_obj = new ouk_order_toj();//$sc->file_path;
        $customClassPath = "\\App\\";
        $nw_f_pth = explode('/', $sc->file_path);
        foreach ($nw_f_pth as $p) {
            $customClassPath .= $p.'\\';
        }
        $customClassPath = rtrim($customClassPath, "\\");
        $sc_obj = new $customClassPath;
        if (!method_exists($sc_obj, 'exec')) {
            \Log::error('scenario exec error');
            return ['status'=>'1','message'=>'Scenario exec function is not exist!'];
        }
        $ret = $sc_obj->exec($request, $sc);
        // if ($ret !== 0) {
        //     // error
        //     \Log::debug('scenario exec error');
        // } else {
        //     // success
        //     \Log::debug('scenario exec success');
        // }
        // return $ret;

        $canvas_data=byr_order::select('cmn_pdf_canvas.*', 'byr_orders.byr_order_id')
        ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'byr_orders.cmn_connect_id')
        ->join('cmn_pdf_canvas', 'cmn_pdf_canvas.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
        ->where('byr_orders.byr_order_id', $byr_order_id)
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
    public function canvasSettingData()
    {
        $all_buyer=byr_buyer::select('byr_buyers.byr_buyer_id', 'cmn_companies.company_name')
        ->join('cmn_companies', 'byr_buyers.cmn_company_id', '=', 'cmn_companies.cmn_company_id')
        ->orderBy('byr_buyers.byr_buyer_id', 'ASC')
        ->get();
        // $canvas_info = cmn_pdf_canvas::orderBy('created_at','DESC')->get();
        $canvas_info = cmn_pdf_canvas::select('cmn_pdf_canvas.*', 'cmn_companies.company_name')
        ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_pdf_canvas.byr_buyer_id')
        ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
        ->orderBy('cmn_pdf_canvas.updated_at', 'DESC')->get();
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
    public function canvasDataSave(Request $request)
    {
        // return $request->all();
        $canvas_id = $request->canvas_id;
        $update_image_info = $request->update_image_info;
        $byr_id = $request->byr_id;
        $canvas_name = $request->canvas_name;
        $base64_canvas_image = $request->canvasImage;
        $canData = $request->canData;

        $canvasRawBgImg = $canData['backgroundImage']['src'];

        // if (!empty($update_image_info)) {
            
        // } else {
            
        // }
        // return $canvasBgImg;
        
        // Serialize the above data
        // $canData_string = serialize($canData);
        $canvas_array = array(
            'byr_buyer_id' => $byr_id,
            'canvas_name' => $canvas_name,
            // 'canvas_image' => $canvas_image,
            // 'canvas_bg_image' => $canvasBgImg,
            'canvas_objects' => json_encode($canData),
        );
        if (!empty($canvas_id)) {
            $can_exist=cmn_pdf_canvas::where('cmn_pdf_canvas_id', $canvas_id)->first();
            if ($can_exist['byr_buyer_id']!=$byr_id) {
                if (cmn_pdf_canvas::where('byr_buyer_id', $byr_id)->exists()) {
                    return response()->json(['message' =>'duplicated', 'class_name' => 'error','title'=>'Not Updated!']);
                }
            }

            $canvas_image_info = cmn_pdf_canvas::select('canvas_image', 'canvas_bg_image')->where('cmn_pdf_canvas_id', $canvas_id)->first();
            $file_path = \storage_path() . '/app/public/backend/images/canvas/';
            \Log::info('file_name_new=' . $file_path);
            if ($canvas_image_info['canvas_image']!="canvas_image_screenshoot_seeder.png") {
                if (file_exists($file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image'])) {
                    @unlink($file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image']);
                }
            }
            $canvas_image = $this->all_used_fun->save_base64_image($base64_canvas_image, 'canvas_image_'. time().'_'.$byr_id, $path_with_end_slash = "storage/app/public/backend/images/canvas/Canvas_screenshoot/");
            
            if (!empty($update_image_info)) {
                if ($canvas_image_info['canvas_bg_image']!="bg_image.jpg" ||$canvas_image_info['canvas_bg_image']!="canvas_bg_image_seeder.png") {
                    if (file_exists($file_path.'Background/' . $canvas_image_info['canvas_bg_image'])) {
                        @unlink($file_path.'Background/' . $canvas_image_info['canvas_bg_image']);
                    }
                }
                $canvasBgImg = $this->all_used_fun->save_base64_image($canvasRawBgImg, 'canvas_bg_image_'. time().'_'.$byr_id, $path_with_end_slash = "storage/app/public/backend/images/canvas/Background/");
            } else {
                $canvasBgImgTmp = explode('/', $canvasRawBgImg);
                $canvasBgImg = $canvasBgImgTmp[count($canvasBgImgTmp) - 1];
            }
            $canvas_array['canvas_image']=$canvas_image;
            $canvas_array['canvas_bg_image']=$canvasBgImg;
            cmn_pdf_canvas::where('cmn_pdf_canvas_id', $canvas_id)->update($canvas_array);
            return response()->json(['message' =>'updated', 'class_name' => 'success','title'=>'Updated!']);
        } else {
            if (!(cmn_pdf_canvas::where('byr_buyer_id', $byr_id)->exists())) {
                if (!empty($update_image_info)) {
                    $canvasBgImg = $this->all_used_fun->save_base64_image($canvasRawBgImg, 'canvas_bg_image_'. time().'_'.$byr_id, $path_with_end_slash = "storage/app/public/backend/images/canvas/Background/");
                } else {
                    $canvasBgImgTmp = explode('/', $canvasRawBgImg);
                    $canvasBgImg = $canvasBgImgTmp[count($canvasBgImgTmp) - 1];
                }
                $canvas_image = $this->all_used_fun->save_base64_image($base64_canvas_image, 'canvas_image_'. time().'_'.$byr_id, $path_with_end_slash = "storage/app/public/backend/images/canvas/Canvas_screenshoot/");
                $canvas_array['canvas_image']=$canvas_image;
                $canvas_array['canvas_bg_image']=$canvasBgImg;
                cmn_pdf_canvas::insert($canvas_array);
                return response()->json(['message' =>'created', 'class_name' => 'success','title'=>'Created!']);
            } else {
                return response()->json(['message' =>'duplicated', 'class_name' => 'error','title'=>'Not Created!']);
            }
        }
    }
    public function deleteCanvasData(Request $request)
    {
        $canvas_id=$request->cmn_pdf_canvas_id;
        $canvas_image_info = cmn_pdf_canvas::select('canvas_image', 'canvas_bg_image')->where('cmn_pdf_canvas_id', $canvas_id)->first();
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
        } else {
            return response()->json(['message' =>'faild', 'class_name' => 'error','title'=>'Not Deleted!']);
        }
    }

    public function get_byr_info_by_byr_order_id(Request $request)
    {
        $data_order_id=$request->data_order_id;

        $result = DB::table('byr_orders')
            ->select('byr_buyers.*')
            ->join('cmn_connects', 'cmn_connects.cmn_connect_id', '=', 'byr_orders.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
            ->where('byr_orders.byr_order_id', $byr_order_id)
            ->first();
        return response()->json(['byr_info'=>$result]);
    }
    public function getByrSlrData(Request $request)
    {
        // return "OK";
        $user_id=$request->user_id;
        $slr_info=cmn_companies_user::select('slr_sellers.slr_seller_id')
        ->join('slr_sellers', 'slr_sellers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
        ->where('cmn_companies_users.adm_user_id', $user_id)->first();
        $slr_id=$slr_info->slr_seller_id;
        
        $slr_order_info=cmn_connect::select(DB::raw('count(data_orders.data_order_id) as total_order'), 'byr_buyers.byr_buyer_id', 'cmn_companies.company_name as buyer_name')
        ->leftJoin('data_orders', 'data_orders.cmn_connect_id', '=', 'cmn_connects.cmn_connect_id')
        ->leftJoin('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
        ->leftJoin('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
        ->where('cmn_connects.slr_seller_id', $slr_id)
        ->groupBy('byr_buyers.byr_buyer_id')
        ->get();
        // $slr_order_info=cmn_connect::select(DB::raw('count(byr_orders.byr_order_id) as total_order'),'byr_buyers.byr_buyer_id','cmn_companies.company_name as buyer_name')
        // ->leftJoin('byr_orders','byr_orders.cmn_connect_id','=','cmn_connects.cmn_connect_id')
        // ->leftJoin('byr_buyers','byr_buyers.byr_buyer_id','=','cmn_connects.byr_buyer_id')
        // ->leftJoin('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')
        // ->where('cmn_connects.slr_seller_id',$slr_id)
        // ->groupBy('byr_buyers.byr_buyer_id')
        // ->get();
        return response()->json(['slr_order_info'=>$slr_order_info]);
    }
}
