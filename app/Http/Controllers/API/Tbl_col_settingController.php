<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\cmn_tbl_col_setting;
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
                    'header_text' => '分類コード',
                    'header_field' => 'category_code',
                    'header_status' => true
                ),
                array(
                    'header_text' => '伝票区分',
                    'header_field' => 'voucher_category',
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
                    'update_by' => $request->user_id
                );
                cmn_tbl_col_setting::insert($data_ins_array);
                //Session::flash('message', 'Data inserted!');
                //Session::flash('class_name', 'alert-success');

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
        //
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
}