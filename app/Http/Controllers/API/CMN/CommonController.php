<?php

namespace App\Http\Controllers\API\CMN;

use App\Http\Controllers\API\AllUsedFunction;
use App\Http\Controllers\Controller;
use App\Models\ADM\adm_user_details;
use App\Models\ADM\User;
use App\Models\BYR\byr_buyer;
use App\Models\CMN\cmn_companies_user;
use App\Models\SLR\slr_seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CommonController extends Controller
{
    private $all_used_fun;

    public function __construct()
    {
        $this->all_used_fun = new AllUsedFunction();
    }
    public function get_byr_slr_company($cmn_company_id = null)
    {
        $buyer_info = byr_buyer::select('byr_buyers.byr_buyer_id', 'cmn_companies.cmn_company_id', 'cmn_companies.company_name as buyer_name')
            ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
            ->get();
        $seller_info = slr_seller::select('slr_sellers.slr_seller_id', 'cmn_companies.cmn_company_id', 'cmn_companies.company_name as seller_name')
            ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'slr_sellers.cmn_company_id')
            ->get();
        return response()->json(['buyer_info' => $buyer_info, 'seller_info' => $seller_info]);
    }

    public function cmn_user_create(Request $request)
    {
        $adm_user_id = $request->adm_user_id;
        if ($adm_user_id == null) {
            $this->validate($request, [
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:adm_users',
                'password' => 'required|string|min:6',
                'cmn_company_id' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191',
                'cmn_company_id' => 'required',
            ]);
        }

        $cmn_company_id = $request->cmn_company_id;

        $user_info = $this->buyer_or_saller_user_store($request);
        if ($user_info['message'] == 'created') {
            cmn_companies_user::insert(['cmn_company_id' => $cmn_company_id, 'adm_user_id' => $user_info['last_user_id']]);
        }
        return response()->json($user_info);
    }
    /**
     * Get user id as buyer or saller id
     * @param  array $request_array with contain name,email,password
     * @return array user_id
     */
    public function buyer_or_saller_user_store($request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $adm_user_id = $request->adm_user_id;

        $user_array = array(
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        );

        $user_exist = User::where('email', $email)->first();
        if ($adm_user_id != null) {
            $exist_user_info = User::where('id', $adm_user_id)->first();
            if ($exist_user_info->email != $email) {
                if ($user_exist) {
                    return array('title' => "Exists!", 'message' => "exists", 'class_name' => 'error');
                }
            }
            if ($password == null) {
                $user_array['password'] = $exist_user_info->password;
            }
            User::where('id', $adm_user_id)->update($user_array);
            return array('title' => "Updated!", 'message' => "updated", 'class_name' => 'success');
        } else {
            if ($user_exist) {
                return array('title' => "Exists!", 'message' => "exists", 'class_name' => 'error');
            } else {
                $last_user_id = User::insertGetId($user_array);
                adm_user_details::insert(['user_id' => $last_user_id]);
            }
            return array('title' => "Created!", 'message' => "created", 'class_name' => 'success', 'last_user_id' => $last_user_id);
        }

    }
}
