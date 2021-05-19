<?php

namespace App\Http\Controllers\API\SLR;

use App\Http\Controllers\Controller;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
use App\Models\CMN\cmn_company;
use App\Models\SLR\slr_seller;
use Illuminate\Http\Request;
use DB;

class SlrController extends Controller
{
    public static function getSlrInfoByUserId($adm_user_id)
    {
        \Log::debug(__METHOD__.':start---');
        $query = cmn_companies_user::where('adm_user_id', $adm_user_id)
            ->join('slr_sellers', 'slr_sellers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
            ->join('cmn_companies', 'cmn_companies_users.cmn_company_id', '=', 'cmn_companies.cmn_company_id')
            ->select(
                'slr_sellers.slr_seller_id',
                'slr_sellers.cmn_company_id',
                'cmn_companies.company_name',
                'cmn_companies.company_name_kana',
                'cmn_companies.jcode',
                'cmn_companies.phone',
                'cmn_companies.fax',
                'cmn_companies.postal_code',
                'cmn_companies.address'
            );
        $result = $query->first();
        \Log::debug(__METHOD__.':end---');
        return $result;
    }
    
    /**
     * slr_management
     *
     * @param  mixed $adm_user_id
     * @return void
     */
    public function slr_management($adm_user_id)
    {
        \Log::debug(__METHOD__.':start---');
        $authUser = User::find($adm_user_id);
        if (!$authUser->hasRole(config('const.adm_role_name'))) {
            $cmn_company_info = cmn_companies_user::where('adm_user_id', $adm_user_id)->first();
            $cmn_company_id = $cmn_company_info->cmn_company_id;
        }

        $query = DB::table('cmn_companies')
            ->join('slr_sellers', 'slr_sellers.cmn_company_id', '=', 'cmn_companies.cmn_company_id')
            ->groupBy('cmn_companies.cmn_company_id');
        if (!$authUser->hasRole(config('const.adm_role_name'))) {
            $query = $query->where('cmn_companies.cmn_company_id', $cmn_company_id);
        }
        $result = $query->get();
        \Log::debug(__METHOD__.':end---');
        return response()->json(['slr_list' => $result]);
    }
    public function getSellerList(Request $request)
    {
        $cmn_connect_id = $request->cmn_connect_id;
        $selected_sellers = array();
        $seller_query = cmn_company::select('slr_sellers.slr_seller_id', 'cmn_companies.cmn_company_id', 'cmn_companies.company_name as seller_name', 'cmn_companies.jcode')
            ->join('slr_sellers', 'slr_sellers.cmn_company_id', '=', 'cmn_companies.cmn_company_id');
        $sellers = $seller_query->get();
        if ($cmn_connect_id != null) {
            $selected_sellers = $seller_query->join('cmn_connects', 'cmn_connects.slr_seller_id', '=', 'slr_sellers.slr_seller_id')
                ->where('cmn_connects.cmn_connect_id', $cmn_connect_id)->first();
        }
        return response()->json(['sellers' => $sellers, 'selected_sellers' => $selected_sellers]);
    }
}
