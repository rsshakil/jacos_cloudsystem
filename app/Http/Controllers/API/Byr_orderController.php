<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Byr_order_detail;
use App\Byr_order;
use App\byr_buyer;
use App\Byr_shipment;
use App\Byr_shipment_detail;
use App\byr_shop;
use App\cmn_pdf_canvas;
use App\cmn_tbl_col_setting;
use DB;

class Byr_orderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //test
        $result = Byr_order::select( 'byr_orders.byr_order_id','byr_orders.receive_file_path','byr_orders.status','byr_orders.receive_date','byr_orders.data_count','byr_orders.category',
        DB::raw('(select expected_delivery_date from byr_order_details where byr_order_id  =   byr_orders.byr_order_id limit 1) as expected_delivery_date')  )->get();
        $byr_buyer = byr_buyer::all();
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

        $result = DB::table('byr_orders')
            ->select('byr_order_details.*', 'byr_shipment_details.confirm_quantity')
            ->join('byr_order_details', 'byr_orders.byr_order_id', '=', 'byr_order_details.byr_order_id')
            ->join('byr_shipment_details', 'byr_shipment_details.byr_order_detail_id', '=', 'byr_order_details.byr_order_detail_id')
            ->where('byr_orders.byr_order_id', $byr_order_id)
            ->get();
        $byr_shops = DB::table('byr_shops')
            ->select('byr_shops.shop_name', 'byr_shops.shop_name_kana', 'byr_order_details.byr_shop_id')
            ->join('byr_order_details', 'byr_order_details.byr_shop_id', '=', 'byr_shops.byr_shop_id')
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
        return response()->json(['order_list_detail' => $result, 'byr_shops' => $byr_shops,'slected_list'=>$slected_list]);
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
    public function canvasAllData(Request $request){
        $byr_order_id=$request->byr_order_id;
        $canvas_data=byr_order::join('cmn_connects','cmn_connects.cmn_connect_id','=','byr_orders.cmn_connect_id')
        ->join('cmn_pdf_canvas','cmn_pdf_canvas.byr_buyer_id','=','cmn_connects.byr_buyer_id')
        ->where('byr_orders.byr_order_id',$byr_order_id)
        ->get();
        // $canvas_data=cmn_pdf_canvas::get();

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
        return response()->json(['canvas_data'=>$canvas_data,'can_info'=>$can_info_array]);
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
        ->orderBy('cmn_pdf_canvas.created_at','DESC')->get();
        $canvas_array=array();
        if (!empty($canvas_info)) {
            foreach ($canvas_info as $key => $canvas) {
                $tmp['cmn_pdf_canvas_id']=$canvas->cmn_pdf_canvas_id;
                $tmp['byr_buyer_id']=$canvas->byr_buyer_id;
                $tmp['company_name']=$canvas->company_name;
                $tmp['canvas_name']=$canvas->canvas_name;
                $tmp['canvas_image']=$canvas->canvas_image;
                $tmp['canvas_bg_image']=$canvas->canvas_bg_image;
                $tmp['canvas_objects']=$this->UnserializedCanvasData($canvas->canvas_objects);;
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
        $objPosArray = $request->objPosArray;

        $canvasRawBgImg = $canData['backgroundImage']['src'];
        if (!empty($update_image_info)) {
            $canvasBgImg = $this->save_base64_image($canvasRawBgImg, 'canvas_bg_image_'. time().'_'.$byr_id, $path_with_end_slash = "public/backend/images/canvas/Background/");
        } else {
            $canvasBgImgTmp = explode('/', $canvasRawBgImg);
            $canvasBgImg = $canvasBgImgTmp[count($canvasBgImgTmp) - 1];
        }
        // return $canvasBgImg;
        $canvas_image = $this->save_base64_image($base64_canvas_image, 'canvas_image_'. time().'_'.$byr_id, $path_with_end_slash = "public/backend/images/canvas/Canvas_screenshoot/");
        // Serialize the above data
        $canData_string = serialize($canData);
        $canvas_array = array(
            'byr_buyer_id' => $byr_id,
            'canvas_name' => $canvas_name,
            'canvas_image' => $canvas_image,
            'canvas_bg_image' => $canvasBgImg,
            'canvas_objects' => $canData_string,
            'position_values' => $objPosArray,
        );
        if (!empty($canvas_id)) {
            $can_exist=cmn_pdf_canvas::where('cmn_pdf_canvas_id', $canvas_id)->first();
            if ($can_exist['byr_buyer_id']!=$byr_id) {
                if (cmn_pdf_canvas::where('byr_buyer_id', $byr_id)->exists()) {
                    return response()->json(['message' =>'duplicated', 'class_name' => 'error','title'=>'Not Updated!']);
                }
            }

            $canvas_image_info = cmn_pdf_canvas::select('canvas_image','canvas_bg_image')->where('cmn_pdf_canvas_id', $canvas_id)->first();
            $file_path = \public_path() . '/backend/images/canvas/';
            \Log::info('file_name_new=' . $file_path);
            if (file_exists($file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image'])) {
                @unlink($file_path .'Canvas_screenshoot/'. $canvas_image_info['canvas_image']);
            }
            if (!empty($update_image_info)) {
                if (file_exists($file_path.'Background/' . $canvas_image_info['canvas_bg_image'])) {
                    @unlink($file_path.'Background/' . $canvas_image_info['canvas_bg_image']);
                }
            }
            cmn_pdf_canvas::where('cmn_pdf_canvas_id', $canvas_id)->update($canvas_array);
            return response()->json(['message' =>'updated', 'class_name' => 'success','title'=>'Updated!']);
        } else {
            if (!(cmn_pdf_canvas::where('byr_buyer_id', $byr_id)->exists())) {
                cmn_pdf_canvas::insert($canvas_array);
                return response()->json(['message' =>'created', 'class_name' => 'success','title'=>'Created!']);
            }else{
                return response()->json(['message' =>'duplicated', 'class_name' => 'error','title'=>'Not Created!']);
            }
        }
    }
    public function deleteCanvasData(Request $request){
        $canvas_id=$request->cmn_pdf_canvas_id;
        $canvas_image_info = cmn_pdf_canvas::select('canvas_image','canvas_bg_image')->where('cmn_pdf_canvas_id', $canvas_id)->first();
            $file_path = public_path() . '/backend/images/canvas/';
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
    private function UnserializedCanvasData($canvas_objects)
    {
        $canvas_data = unserialize($canvas_objects);
        $canvas_array = array();
        foreach ($canvas_data['objects'] as $key => $value) {
            $temp_array['type'] = $value['type'];
            $temp_array['version'] = $value['version'];
            $temp_array['originX'] = $value['originX'];
            $temp_array['originY'] = $value['originY'];
            $temp_array['left'] = (float) $value['left'];
            $temp_array['top'] = (float) $value['top'];
            $temp_array['width'] = (float) $value['width'];
            $temp_array['height'] = (float) $value['height'];
            $temp_array['fill'] = $value['fill'];
            $temp_array['stroke'] = $value['stroke'];
            $temp_array['strokeWidth'] = (float) $value['strokeWidth'];
            $temp_array['strokeDashArray'] = $value['strokeDashArray'];
            $temp_array['strokeLineCap'] = $value['strokeLineCap'];
            $temp_array['strokeDashOffset'] = (float) $value['strokeDashOffset'];
            $temp_array['strokeLineJoin'] = $value['strokeLineJoin'];
            $temp_array['strokeMiterLimit'] = (float) $value['strokeMiterLimit'];
            $temp_array['scaleX'] = (float) $value['scaleX'];
            $temp_array['scaleY'] = (float) $value['scaleY'];
            $temp_array['angle'] = (float) $value['angle'];
            $temp_array['flipX'] = (float) $value['flipX'];
            $temp_array['flipY'] = (float) $value['flipY'];
            $temp_array['opacity'] = (float) $value['opacity'];
            $temp_array['shadow'] = $value['shadow'];
            $temp_array['visible'] = (float) $value['visible'];
            $temp_array['clipTo'] = $value['clipTo'];
            $temp_array['backgroundColor'] = $value['backgroundColor'];
            $temp_array['fillRule'] = $value['fillRule'];
            $temp_array['paintFirst'] = $value['paintFirst'];
            $temp_array['globalCompositeOperation'] = $value['globalCompositeOperation'];
            $temp_array['transformMatrix'] = $value['transformMatrix'];
            $temp_array['skewX'] = (float) $value['skewX'];
            $temp_array['skewY'] = (float) $value['skewY'];
            $temp_array['text'] = $value['text'];
            $temp_array['fontSize'] = (float) $value['fontSize'];
            $temp_array['fontWeight'] = $value['fontWeight'];
            $temp_array['fontFamily'] = $value['fontFamily'];
            $temp_array['fontStyle'] = $value['fontStyle'];
            $temp_array['lineHeight'] = (float) $value['lineHeight'];
            $temp_array['underline'] = (float) $value['underline'];
            $temp_array['overline'] = (float) $value['overline'];
            $temp_array['linethrough'] = (float) $value['linethrough'];
            $temp_array['textAlign'] = $value['textAlign'];
            $temp_array['textBackgroundColor'] = $value['textBackgroundColor'];
            $temp_array['charSpacing'] = (float) $value['charSpacing'];
            $temp_array['minWidth'] = (float) $value['minWidth'];
            $temp_array['splitByGrapheme'] = (float) $value['splitByGrapheme'];
            $canvas_array[] = $temp_array;
        }
        // return $canvas_array;

        $new_array = array(
            'version' => $canvas_data['version'],
            'objects' => $canvas_array,
        );
        return $new_array;
    }
    public function save_base64_image($base64_image_string, $output_file_without_extension, $path_with_end_slash = "")
    {
        $splited = explode(',', substr($base64_image_string, 5), 2);
        $mime = $splited[0];
        $data = $splited[1];

        $mime_split_without_base64 = explode(';', $mime, 2);
        $mime_split = explode('/', $mime_split_without_base64[0], 2);
        if (count($mime_split) == 2) {
            $extension = $mime_split[1];
            if ($extension == 'jpeg') {
                $extension = 'jpg';
            }
            //if($extension=='javascript')$extension='js';
            //if($extension=='text')$extension='txt';
            $output_file_with_extension = $output_file_without_extension . '.' . $extension;
        }
        file_put_contents($path_with_end_slash . $output_file_with_extension, base64_decode($data));
        // move_uploaded_file(base64_decode($data),$path_with_end_slash . $output_file_with_extension);
        return $output_file_with_extension;
    }
}