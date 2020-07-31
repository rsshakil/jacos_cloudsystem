<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Byr_order_detail;
use App\Byr_order;
use App\Byr_shipment;
use App\Byr_shipment_detail;
use App\byr_shop;
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
        $result = DB::table('byr_orders')
            ->select('byr_orders.status,byr_orders.receive_date,byr_orders.category,byr_order_details.expected_delivery_date')
            ->join('byr_order_details', 'byr_orders.byr_order_id', '=', 'byr_order_details.byr_order_id')
            ->get();
        return response()->json(['order_list' => $result]);
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
        return response()->json(['order_list_detail' => $result, 'byr_shops' => $byr_shops]);
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