<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BYR\byr_buyer;
use App\Models\BYR\byr_item;
use App\Models\BYR\byr_item_class;
use App\Models\CMN\cmn_maker;
use App\Models\CMN\cmn_category;
use App\Models\CMN\cmn_category_description;
use App\Models\CMN\cmn_category_path;
use App\Models\BYR\byr_shop;
use App\Models\CMN\cmn_pdf_canvas;
use App\Models\CMN\cmn_tbl_col_setting;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_connect;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
use DB;
class Cmn_categoryController extends Controller
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

    public function get_all_cat_list($adm_user_id){
        $authUser=User::find($adm_user_id);
        if(!$authUser->hasRole('Super Admin')){
            $cmn_company_info = cmn_companies_user::select('byr_buyers.cmn_company_id','byr_buyers.byr_buyer_id','cmn_connects.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
            ->join('cmn_connects', 'cmn_connects.byr_buyer_id', '=', 'byr_buyers.byr_buyer_id')
            ->where('cmn_companies_users.adm_user_id',$adm_user_id)->first();
            $cmn_company_id = $cmn_company_info->cmn_company_id;
            $byr_buyer_id = $cmn_company_info->byr_buyer_id;
            $cmn_connect_id = $cmn_company_info->cmn_connect_id;

            $categorys = collect(\DB::select("SELECT cp.cmn_category_id AS cmn_category_id,cd2.category_code, GROUP_CONCAT(cd1.category_name ORDER BY cp.lavel SEPARATOR ' > ') AS name, c1.parent_id FROM cmn_category_paths cp LEFT JOIN cmn_categories c1 ON (cp.cmn_category_id = c1.cmn_category_id) LEFT JOIN cmn_categories c2 ON (cp.path_id = c2.cmn_category_id) LEFT JOIN cmn_category_descriptions cd1 ON (cp.path_id = cd1.cmn_category_id) LEFT JOIN cmn_category_descriptions cd2 ON (cp.cmn_category_id = cd2.cmn_category_id) where c1.is_deleted=0 and c2.is_deleted=0 and cd2.byr_buyer_id='".$byr_buyer_id."' GROUP BY cp.cmn_category_id"));

            $parent_list = cmn_category_description::where('byr_buyer_id',$byr_buyer_id,'is_deleted',0)->get();


        }else{
            $categorys = collect(\DB::select("SELECT cp.cmn_category_id AS cmn_category_id,cd2.category_code, GROUP_CONCAT(cd1.category_name ORDER BY cp.lavel SEPARATOR ' > ') AS name, c1.parent_id FROM cmn_category_paths cp LEFT JOIN cmn_categories c1 ON (cp.cmn_category_id = c1.cmn_category_id) LEFT JOIN cmn_categories c2 ON (cp.path_id = c2.cmn_category_id) LEFT JOIN cmn_category_descriptions cd1 ON (cp.path_id = cd1.cmn_category_id) LEFT JOIN cmn_category_descriptions cd2 ON (cp.cmn_category_id = cd2.cmn_category_id) where c1.is_deleted=0 and c2.is_deleted=0 GROUP BY cp.cmn_category_id"));
            $parent_list = cmn_category_description::where('is_deleted',0)->get();
        }

        return response()->json(['cat_list' => $categorys,'parent_list'=>$parent_list]);
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
        $this->validate($request,[
            'category_code' => 'required|string|max:2',
        ]);
        $adm_user_id = $request->adm_user_id;
        $authUser=User::find($adm_user_id);
        if(!$authUser->hasRole('Super Admin')){
            $cmn_company_info = cmn_companies_user::select('byr_buyers.cmn_company_id','byr_buyers.byr_buyer_id','cmn_connects.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
            ->join('cmn_connects', 'cmn_connects.byr_buyer_id', '=', 'byr_buyers.byr_buyer_id')
            ->where('cmn_companies_users.adm_user_id',$adm_user_id)->first();
            $cmn_company_id = $cmn_company_info->cmn_company_id;
            $byr_buyer_id = $cmn_company_info->byr_buyer_id;
            $cmn_connect_id = $cmn_company_info->cmn_connect_id;
        }else{
            $byr_buyer_id =1;
        }


        $name = $request->name;
        $cmn_category_id = $request->cmn_category_id;
        $category_code = $request->category_code;
        $parent_id = $request->parent_id;
        if($parent_id!=0){
            $parent_ct = cmn_category_description::where('cmn_category_id',$parent_id)->first();
            $last2digits=substr($parent_ct->category_code, -2);
            $last4digits=substr($parent_ct->category_code, -4);
            if($last2digits!=00){
                return $result = response()->json(['message' => 'fail']);
            }else{
                if($last4digits!='0000'){
                    $first4digits=substr($parent_ct->category_code,0,4);
                    $category_code = $first4digits.$category_code;
                }else{
                    $first2digits=substr($parent_ct->category_code,0,2);
                    $category_code = $first2digits.$category_code.'00';
                }
            }
        }else{
            $category_code = $category_code.'0000';
        }
        if($cmn_category_id==0){
            $cat_id = cmn_category::insertGetId(['parent_id'=>$parent_id]);
            $cat_desc = cmn_category_description::insertGetId(['cmn_category_id'=>$cat_id,'category_name'=>$category_code,'byr_buyer_id'=>$byr_buyer_id,'category_code'=>$category_code]);
            $result = DB::select("SELECT cmn_category_paths.*,cmn_category_descriptions.category_code FROM cmn_category_paths inner join cmn_category_descriptions on cmn_category_descriptions.cmn_category_id=cmn_category_paths.path_id WHERE cmn_category_paths.cmn_category_id = '". $parent_id . "' ORDER BY `lavel` ASC");
            $lavel=0;
            if($result){
                foreach($result as $val){
                    cmn_category_path::insert(['cmn_category_id'=>$cat_id,'path_id'=>$val->path_id,'lavel'=>$lavel]);
                    $lavel++;
                }
            }
            cmn_category_path::insert(['cmn_category_id'=>$cat_id,'path_id'=>$cat_id,'lavel'=>$lavel]);
            return $result = response()->json(['message' => 'insert_success']);
        }else{
            cmn_category::where('cmn_category_id',$cmn_category_id)->update(['parent_id'=>$parent_id]);
            cmn_category_description::where('cmn_category_id',$cmn_category_id)->update(['category_name'=>$category_code,'category_code'=>$category_code]);
            cmn_category_path::where('cmn_category_id',$cmn_category_id)->delete();
            $result = DB::select("SELECT cmn_category_paths.*,cmn_category_descriptions.category_code FROM cmn_category_paths inner join cmn_category_descriptions on cmn_category_descriptions.cmn_category_id=cmn_category_paths.path_id WHERE cmn_category_paths.cmn_category_id = '". $parent_id . "' ORDER BY `lavel` ASC");
            $lavel=0;
            if($result){
                foreach($result as $val){
                    cmn_category_path::insert(['cmn_category_id'=>$cmn_category_id,'path_id'=>$val->path_id,'lavel'=>$lavel]);
                    $lavel++;
                }
            }
            cmn_category_path::insert(['cmn_category_id'=>$cmn_category_id,'path_id'=>$cmn_category_id,'lavel'=>$lavel]);
            return $result = response()->json(['message' => 'update_success']);
        }

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
