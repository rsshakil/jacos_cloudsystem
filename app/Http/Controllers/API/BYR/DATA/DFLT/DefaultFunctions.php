<?php

namespace App\Http\Controllers\API\BYR\DATA\DFLT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BYR\byr_buyer;
use App\Models\CMN\cmn_companies_user;
use App\Models\CMN\cmn_company;

class DefaultFunctions extends Controller
{
    public function getByrInfo($adm_user_id){
        return cmn_companies_user::select('bb.*')
        ->join('cmn_companies as cc','cc.cmn_company_id','=','cmn_companies_users.cmn_company_id')
        ->join('byr_buyers as bb','bb.cmn_company_id','=','cc.cmn_company_id')
        ->where('cmn_companies_users.adm_user_id',$adm_user_id)
        ->first();
    }
}
