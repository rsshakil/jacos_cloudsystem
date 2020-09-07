<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMN\cmn_tbl_col_setting;
use Auth;

class Tbl_col_settingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


        if ($request->url_slug == 'order_list_detail') {
            $col_settinge = array(
                array(
                    "header_text" => '注文タイプ',
                    'header_field' => 'order_type',
                    'header_status' => true
                ),
                array(
                    'header_text' => '店舗名(ｶﾅ)',
                    'header_field' => 'shop_name_kana',
                    'header_status' => true
                ),
                array(
                    'header_text' => '分類コード',
                    'header_field' => 'category_code',
                    'header_status' => true
                ),
                array(
                    'header_text' => '伝票区分',
                    'header_field' => 'voucher_category',
                    'header_status' => true
                ),
                array(
                    'header_text' => '伝票番号',
                    'header_field' => 'voucher_number',
                    'header_status' => true
                ),
                array(
                    'header_text' => '明細番号',
                    'header_field' => 'list_number',
                    'header_status' => true
                ),
                array(
                    'header_text' => '便番号',
                    'header_field' => 'delivery_service_code',
                    'header_status' => true
                ),
                /*
                array(
                    'header_text' => 'ステータス',
                    'header_field' => 'status',
                    'header_status' => true
                ),*/
                array(
                    'header_text' => 'JAN',
                    'header_field' => 'jan',
                    'header_status' => true
                ),
                array(
                    'header_text' => '商品名',
                    'header_field' => 'item_name',
                    'header_status' => true
                ),
                array(
                    'header_text' => '商品名かな',
                    'header_field' => 'item_name_kana',
                    'header_status' => true
                ),
                array(
                    'header_text' => '規格',
                    'header_field' => 'spec',
                    'header_status' => true
                ),
                array(
                    'header_text' => '規格かな',
                    'header_field' => 'spec_kana',
                    'header_status' => true
                ),
                array(
                    'header_text' => '入数',
                    'header_field' => 'inputs',
                    'header_status' => true
                ),
                array(
                    'header_text' => 'サイズ',
                    'header_field' => 'size',
                    'header_status' => true
                ),
                array(
                    'header_text' => 'カラー',
                    'header_field' => 'color',
                    'header_status' => true
                ),
                array(
                    'header_text' => '発注単位',
                    'header_field' => 'order_lot_inputs',
                    'header_status' => true
                ),
                array(
                    'header_text' => '発注日時',
                    'header_field' => 'order_date',
                    'header_status' => true
                ),
               
                array(
                    'header_text' => '納品予定日',
                    'header_field' => 'expected_delivery_date',
                    'header_status' => true
                ),
                array(
                    'header_text' => '特売区分',
                    'header_field' => 'sale_category',
                    'header_status' => true
                ),
                array(
                    'header_text' => '原単価',
                    'header_field' => 'cost_unit_price',
                    'header_status' => true
                ),
                array(
                    'header_text' => '原価金額',
                    'header_field' => 'cost_price',
                    'header_status' => true
                ),
                array(
                    'header_text' => '売単価',
                    'header_field' => 'selling_unit_price',
                    'header_status' => true
                ),
                array(
                    'header_text' => '売価金額',
                    'header_field' => 'selling_price',
                    'header_status' => true
                )
            );
            if (cmn_tbl_col_setting::where('url_slug', $request->url_slug)->where('update_by', $request->user_id)->exists()) {
                return $result = response()->json(['message' => 'already exixts']);
            } else {
                $jsn = json_encode($col_settinge);
                $data_ins_array = array(
                    'url_slug' => $request->url_slug,
                    'content_setting' => $jsn,
                    'update_by' => $request->user_id,
                );
                cmn_tbl_col_setting::insert($data_ins_array);

                return $result = response()->json(['message' => 'insert_success']);
            }
        }
        return response()->json(['success' => 'add your content']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $html = '';
        $header_list = array();
        $slected_list = array();
        if (cmn_tbl_col_setting::where('url_slug', $id)->exists()) {
            $result = cmn_tbl_col_setting::where('url_slug', $id)->first();
            $header_list = json_decode($result->content_setting);
            foreach ($header_list as $header) {
                $checked = ($header->header_status == true ? 'checked' : '');
                if ($header->header_status == true) {
                    $slected_list[] = $header->header_field;
                }
                $html .= '<tr>';
                $html .= '<td data_field="' . $header->header_field . '">' . $header->header_text . '</td>';
                $html .= '<td><label class="switch">
                    <input @change="handleChange()" name="' . $header->header_field . '" data_header_text="' . $header->header_text . '" type="checkbox" ' . $checked . '>
                    <span class="slider round"></span>
                  </label></td>';
                // $html .= '<td><div><b-form-checkbox @change="handleChange($event)"  v-model="' . $header->header_field . '" name="check-button" switch></b-form-checkbox></div></td>';
                // $html .= '<td><b-form-checkbox  @change="handleChange()" :value="' . $header->header_field . '" switch><p class="btn btn-info" style="padding:5px;margin:3px;">' . $header->header_text . '</p></b-form-checkbox></td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="2">No setting found</td></tr>';
        }
        $table = '<table class="table table-bordered"><thead><tr><th>Col</th><th>status</th></tr></thead><tbody>' . $html . '</tbody></table>';
        return $result = response()->json(['result' => $table, 'arrs' => $header_list, 'col_lists' => $header_list, 'selected_columns' => $slected_list]);
    }
    public function dispaly_col_by_user($url_slug,$user_id)
    {
        $html = '';
        $header_list = array();
        $slected_list = array();
        if (cmn_tbl_col_setting::where('url_slug', $url_slug)->where('update_by',$user_id)->exists()) {
            $result = cmn_tbl_col_setting::where('url_slug', $url_slug)->where('update_by',$user_id)->first();
            $header_list = json_decode($result->content_setting);
            foreach ($header_list as $header) {
                $checked = ($header->header_status == true ? 'checked' : '');
                if ($header->header_status == true) {
                    $slected_list[] = $header->header_field;
                }
                $html .= '<tr>';
                $html .= '<td data_field="' . $header->header_field . '">' . $header->header_text . '</td>';
                $html .= '<td><label class="switch">
                    <input @change="handleChange()" name="' . $header->header_field . '" data_header_text="' . $header->header_text . '" type="checkbox" ' . $checked . '>
                    <span class="slider round"></span>
                  </label></td>';
                // $html .= '<td><div><b-form-checkbox @change="handleChange($event)"  v-model="' . $header->header_field . '" name="check-button" switch></b-form-checkbox></div></td>';
                // $html .= '<td><b-form-checkbox  @change="handleChange()" :value="' . $header->header_field . '" switch><p class="btn btn-info" style="padding:5px;margin:3px;">' . $header->header_text . '</p></b-form-checkbox></td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="2">No setting found</td></tr>';
        }
        $table = '<table class="table table-bordered"><thead><tr><th>Col</th><th>status</th></tr></thead><tbody>' . $html . '</tbody></table>';
        return $result = response()->json(['result' => $table, 'arrs' => $header_list, 'col_lists' => $header_list, 'selected_columns' => $slected_list]);
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
        $slected_list = array();
        if (cmn_tbl_col_setting::where('url_slug', $id)->where('update_by',$request->user_id)->exists()) {
            // $result = cmn_tbl_col_setting::where('url_slug', $id)->first();
            // $header_list = json_decode($result->content_setting);
            // foreach ($header_list as $lst) {
            //     $lst->header_status = false;
            // }
            // $selected_lists = $request->content_setting;
            // foreach ($selected_lists as $selected_list) {
            //     $key = array_search($selected_list, array_column($header_list, 'header_field'));
            //     $header_list[$key]->header_status = true;
            // }
            $jsn = json_encode($request->setting_list);
            cmn_tbl_col_setting::where('url_slug', $id)->where('update_by',$request->user_id)->update(['content_setting' => $jsn]);
            $result = cmn_tbl_col_setting::where('url_slug', $id)->first();
            $header_list = json_decode($result->content_setting);
            foreach ($header_list as $header) {
                if ($header->header_status == true) {
                    $slected_list[] = $header->header_field;
                }
            }
            
        }
        return $result = response()->json(['result' => $slected_list, 'url' => $id]);
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
}