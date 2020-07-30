<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Byr_order_detail;
use App\Byr_order;
use App\Byr_shipment;
use App\Byr_shipment_detail;
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
            ->select('*')
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
            ->select('*')
            ->join('byr_order_details', 'byr_orders.byr_order_id', '=', 'byr_order_details.byr_order_id')
            ->where('byr_orders.byr_order_id', $byr_order_id)
            ->get();
        return response()->json(['order_list_detail' => $result]);
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