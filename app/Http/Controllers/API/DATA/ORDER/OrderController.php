<?php

namespace App\Http\Controllers\API\DATA\ORDER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMN\cmn_companies_user;
use App\Models\CMN\cmn_connect;
use DB;

class OrderController extends Controller
{
    public function getByrOrderDataBySlr(Request $request)
    {
        $user_id = $request->user_id;
        $slr_info = cmn_companies_user::select('slr_sellers.slr_seller_id')
            ->join('slr_sellers', 'slr_sellers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
            ->where('cmn_companies_users.adm_user_id', $user_id)->first();
        $slr_id = $slr_info->slr_seller_id;

        $slr_order_info = cmn_connect::select(DB::raw('count(data_orders.data_order_id) as total_order'), 'byr_buyers.byr_buyer_id', 'cmn_companies.company_name as buyer_name')
            ->leftJoin('data_orders', 'data_orders.cmn_connect_id', '=', 'cmn_connects.cmn_connect_id')
            ->leftJoin('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
            ->leftJoin('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
            ->where('cmn_connects.slr_seller_id', $slr_id)
            ->groupBy('byr_buyers.byr_buyer_id')
            ->get();
        return response()->json(['slr_order_info' => $slr_order_info]);
    }
}
