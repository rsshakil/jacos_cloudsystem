<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BYR\byr_buyer;
use App\Models\BYR\byr_item;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
class Byr_itemController extends Controller
{
    public function get_all_master_item($adm_user_id){
        $authUser=User::find($adm_user_id);
        if(!$authUser->hasRole(config('const.adm_role_name'))){
            $cmn_company_info = cmn_companies_user::select('byr_buyers.cmn_company_id','byr_buyers.byr_buyer_id','cmn_connects.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
            ->join('cmn_connects', 'cmn_connects.byr_buyer_id', '=', 'byr_buyers.byr_buyer_id')
            ->where('cmn_companies_users.adm_user_id',$adm_user_id)->first();
            $byr_buyer_id = $cmn_company_info->byr_buyer_id;
        }

        if(!$authUser->hasRole(config('const.adm_role_name'))){
            $result = byr_item::select('byr_items.*','byr_item_classes.*','cmn_category_descriptions.category_name','cmn_category_descriptions.category_code','cmn_makers.maker_name_kana','cmn_makers.maker_name')
            ->join('byr_item_classes', 'byr_item_classes.byr_item_id', '=', 'byr_items.byr_item_id')
            ->join('cmn_makers', 'cmn_makers.cmn_maker_id', '=', 'byr_items.cmn_maker_id')
            ->join('cmn_category_descriptions', 'cmn_category_descriptions.cmn_category_id', '=', 'byr_items.cmn_category_id')
            ->where('byr_items.byr_buyer_id',$byr_buyer_id)
            ->get();

            $byr_buyer = byr_buyer::where('byr_buyer_id',$byr_buyer_id)->get();
        }else{
            $result = byr_item::select('byr_items.*','byr_item_classes.*','cmn_category_descriptions.category_name','cmn_category_descriptions.category_code','cmn_makers.maker_name_kana','cmn_makers.maker_name')
            ->join('byr_item_classes', 'byr_item_classes.byr_item_id', '=', 'byr_items.byr_item_id')
            ->join('cmn_makers', 'cmn_makers.cmn_maker_id', '=', 'byr_items.cmn_maker_id')
            ->join('cmn_category_descriptions', 'cmn_category_descriptions.cmn_category_id', '=', 'byr_items.cmn_category_id')
            ->get();
            $byr_buyer = byr_buyer::all();
        }



        return response()->json(['item_list' => $result,'byr_buyer_list'=>$byr_buyer]);
    }
}
