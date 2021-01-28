<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BYR\byr_order_detail;
use App\Models\BYR\byr_order;
use App\Models\BYR\byr_shipment;
use App\Models\BYR\byr_shipment_detail;
use DB;

class Byr_shipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::table('byr_orders')
            ->select('*')
            ->join('byr_order_details', 'byr_orders.byr_order_id', '=', 'byr_order_details.byr_order_id')
            ->get();
        return response()->json(['shipment_list' => $result]);
    }
}
