<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\AllUsedFunction;
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
    private $all_functions;
    public function __construct()
    {
        $this->all_functions = new AllUsedFunction();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function get_all_cat_list(Request $request){
        $adm_user_id = $request->adm_user_id;
        $per_page = $request->select_field_per_page_num;
        $authUser=User::find($adm_user_id);
        if(!$authUser->hasRole(config('const.adm_role_name'))){
            $cmn_company_info = cmn_companies_user::select('byr_buyers.cmn_company_id','byr_buyers.byr_buyer_id','cmn_connects.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
            ->join('cmn_connects', 'cmn_connects.byr_buyer_id', '=', 'byr_buyers.byr_buyer_id')
            ->where('cmn_companies_users.adm_user_id',$adm_user_id)->first();
            $cmn_company_id = $cmn_company_info->cmn_company_id;
            $byr_buyer_id = $cmn_company_info->byr_buyer_id;
            $cmn_connect_id = $cmn_company_info->cmn_connect_id;
            $categorysAllforOpt = collect(\DB::select("SELECT cp.cmn_category_id AS cmn_category_id,cd2.category_code,cd2.category_name, GROUP_CONCAT(cd1.category_name ORDER BY cp.level SEPARATOR ' > ') AS name, c1.parent_id FROM cmn_category_paths cp LEFT JOIN cmn_categories c1 ON (cp.cmn_category_id = c1.cmn_category_id) LEFT JOIN cmn_categories c2 ON (cp.path_id = c2.cmn_category_id) LEFT JOIN cmn_category_descriptions cd1 ON (cp.path_id = cd1.cmn_category_id) LEFT JOIN cmn_category_descriptions cd2 ON (cp.cmn_category_id = cd2.cmn_category_id) where c1.is_deleted=0 and c2.is_deleted=0 and cd2.byr_buyer_id='".$byr_buyer_id."' GROUP BY cp.cmn_category_id"));
            $categorys = cmn_category_path::select('cmn_category_paths.cmn_category_id AS cmn_category_id','cd2.category_code','cd2.category_name', 'cd2.category_orign_code',
            DB::raw('GROUP_CONCAT(cd1.category_name ORDER BY cmn_category_paths.level SEPARATOR " > ") AS name'),
             'c1.parent_id')
            ->leftJoin('cmn_categories as c1','cmn_category_paths.cmn_category_id', '=','c1.cmn_category_id')
            ->leftJoin('cmn_categories as c2','cmn_category_paths.path_id', '=','c2.cmn_category_id')
            ->leftJoin('cmn_category_descriptions as cd1','cmn_category_paths.path_id','=','cd1.cmn_category_id')
            ->leftJoin('cmn_category_descriptions as cd2','cmn_category_paths.cmn_category_id','=','cd2.cmn_category_id')
            ->where(['c1.is_deleted'=>0,'c2.is_deleted'=>0,'cd2.byr_buyer_id'=>$byr_buyer_id])
            ->groupBy('cmn_category_paths.cmn_category_id')
            ->paginate($per_page);


            $parent_list = cmn_category_description::where(['byr_buyer_id'=>$byr_buyer_id,'is_deleted'=>0])->get();
            

        }else{
            $categorysAllforOpt = collect(\DB::select("SELECT cp.cmn_category_id AS cmn_category_id,cd2.category_code,cd2.category_name, GROUP_CONCAT(cd1.category_name ORDER BY cp.level SEPARATOR ' > ') AS name, c1.parent_id FROM cmn_category_paths cp LEFT JOIN cmn_categories c1 ON (cp.cmn_category_id = c1.cmn_category_id) LEFT JOIN cmn_categories c2 ON (cp.path_id = c2.cmn_category_id) LEFT JOIN cmn_category_descriptions cd1 ON (cp.path_id = cd1.cmn_category_id) LEFT JOIN cmn_category_descriptions cd2 ON (cp.cmn_category_id = cd2.cmn_category_id) where c1.is_deleted=0 and c2.is_deleted=0 GROUP BY cp.cmn_category_id"));
            $categorys = cmn_category_path::select('cmn_category_paths.cmn_category_id AS cmn_category_id','cd2.category_code','cd2.category_name', 'cd2.category_orign_code',
            DB::raw('GROUP_CONCAT(cd1.category_name ORDER BY cmn_category_paths.level SEPARATOR " > ") AS name'),
             'c1.parent_id')
            ->leftJoin('cmn_categories as c1','cmn_category_paths.cmn_category_id', '=','c1.cmn_category_id')
            ->leftJoin('cmn_categories as c2','cmn_category_paths.path_id', '=','c2.cmn_category_id')
            ->leftJoin('cmn_category_descriptions as cd1','cmn_category_paths.path_id','=','cd1.cmn_category_id')
            ->leftJoin('cmn_category_descriptions as cd2','cmn_category_paths.cmn_category_id','=','cd2.cmn_category_id')
            ->where(['c1.is_deleted'=>0,'c2.is_deleted'=>0])
            ->groupBy('cmn_category_paths.cmn_category_id')
            ->paginate($per_page);
            
            $parent_list = cmn_category_description::where('is_deleted',0)->get();
        }

        return response()->json(['cat_list' => $categorys,'allCatForParent'=>$categorysAllforOpt,'parent_list'=>$parent_list]);
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
            'category_orign_code' => 'required|string|max:3',
            'category_name' => 'required|string|min:2',
        ]);
        $adm_user_id = $request->adm_user_id;
        $authUser=User::find($adm_user_id);
        if(!$authUser->hasRole(config('const.adm_role_name'))){
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
        $category_orign_code = $request->category_orign_code;
        $category_code = $request->category_orign_code;
        $category_name = $request->category_name;
        $parent_id = $request->parent_id;
        if($parent_id!=0){
            $parent_ct = cmn_category_description::where('cmn_category_id',$parent_id)->first();
            $last2digits=substr($parent_ct->category_code, -3);
            $last4digits=substr($parent_ct->category_code, -6);
            if($last2digits!=000){
                return $result = response()->json(['message' => 'fail']);
            }else{
                if($last4digits!='000000'){
                    $first4digits=substr($parent_ct->category_code,0,6);
                    $category_code = $first4digits.$category_code;
                }else{
                    $first2digits=substr($parent_ct->category_code,0,3);
                    $category_code = $first2digits.$category_code.'000';
                }
            }
        }else{
            $category_code = $category_code.'000000';
        }
        if($cmn_category_id==0){
            $cat_id = cmn_category::insertGetId(['parent_id'=>$parent_id]);
            $cat_desc = cmn_category_description::insertGetId(['cmn_category_id'=>$cat_id,'category_name'=>$category_code,'byr_buyer_id'=>$byr_buyer_id,'category_code'=>$category_code,'category_orign_code'=>$category_orign_code,'category_name'=>$category_name]);
            $result = DB::select("SELECT cmn_category_paths.*,cmn_category_descriptions.category_code FROM cmn_category_paths inner join cmn_category_descriptions on cmn_category_descriptions.cmn_category_id=cmn_category_paths.path_id WHERE cmn_category_paths.cmn_category_id = '". $parent_id . "' ORDER BY `level` ASC");
            $level=0;
            if($result){
                foreach($result as $val){
                    cmn_category_path::insert(['cmn_category_id'=>$cat_id,'path_id'=>$val->path_id,'level'=>$level]);
                    $level++;
                }
            }
            cmn_category_path::insert(['cmn_category_id'=>$cat_id,'path_id'=>$cat_id,'level'=>$level]);
            return $result = response()->json(['message' => 'insert_success']);
        }else{
            cmn_category::where('cmn_category_id',$cmn_category_id)->update(['parent_id'=>$parent_id]);
            cmn_category_description::where('cmn_category_id',$cmn_category_id)->update(['category_name'=>$category_name,'category_code'=>$category_code,'category_orign_code'=>$category_orign_code]);
            cmn_category_path::where('cmn_category_id',$cmn_category_id)->delete();
            $result = DB::select("SELECT cmn_category_paths.*,cmn_category_descriptions.category_code FROM cmn_category_paths inner join cmn_category_descriptions on cmn_category_descriptions.cmn_category_id=cmn_category_paths.path_id WHERE cmn_category_paths.cmn_category_id = '". $parent_id . "' ORDER BY `level` ASC");
            $level=0;
            if($result){
                foreach($result as $val){
                    cmn_category_path::insert(['cmn_category_id'=>$cmn_category_id,'path_id'=>$val->path_id,'level'=>$level]);
                    $level++;
                }
            }
            cmn_category_path::insert(['cmn_category_id'=>$cmn_category_id,'path_id'=>$cmn_category_id,'level'=>$level]);
            return $result = response()->json(['message' => 'update_success']);
        }

    }
    public function uploadByrCategoryCsv(Request $request){

        $adm_user_id = $request->adm_user_id;
        $authUser=User::find($adm_user_id);
        if(!$authUser->hasRole(config('const.adm_role_name'))){
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


        $file_name = time().'-'.$request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs(config('const.SHIPMENT_CSV_UPDATE_PATH'), $file_name);
        \Log::debug('save path:'.$path);

        $received_path = storage_path().'/app//'.config('const.SHIPMENT_CSV_UPDATE_PATH').'/'.$file_name;
        // フォーマット変換

        $dataArr = $this->all_functions->csvReader($received_path, 1);

        if($dataArr){
            foreach(array_chunk($dataArr, 1000) as $items ) {
               foreach($items as $item){
                   if(count($item)==6){
                $codeKey = 0;
                $nameKey = 1;
                for($i=0;$i<3;$i++){
                    if($i==0){
                        $catCode = $item[$codeKey].'000000';
                    }else if($i==1){
                        $catCode = $item[0].$item[$codeKey].'000';
                       
                    }else{
                        $catCode = $item[0].$item[2].$item[$codeKey];
                       
                    }
                    $catCode2 = $item[0].'000000';
                    $catCode4 = $item[0].$item[2].'000';
                    
                    $catInfo = cmn_category_description::select('cmn_category_descriptions.*','cmn_categories.parent_id')->join('cmn_categories','cmn_categories.cmn_category_id','=','cmn_category_descriptions.cmn_category_id')->where('category_code',$catCode)->first();
                    if(!$catInfo){
                        $subCatInfo = array();

                        if($i==1){
                            $subCatInfo = cmn_category_description::select('cmn_category_descriptions.*','cmn_categories.parent_id')->join('cmn_categories','cmn_categories.cmn_category_id','=','cmn_category_descriptions.cmn_category_id')->where('cmn_category_descriptions.category_code',$catCode2)->first();
                            //echo $catCode2;exit;    
                            //$subCatInfo = cmn_category_description::where('cmn_category_descriptions.category_code',$catCode2)->first();
                        
                        }
                        if($i==2){
                            $subCatInfo = cmn_category_description::select('cmn_category_descriptions.*','cmn_categories.parent_id')->join('cmn_categories','cmn_categories.cmn_category_id','=','cmn_category_descriptions.cmn_category_id')->where('cmn_category_descriptions.category_code',$catCode4)->first();
                        }
                        $parent_id = 0;
                        if($subCatInfo){
                            $parent_id = $subCatInfo->cmn_category_id;
                        }
                        $cat_id = cmn_category::insertGetId(['parent_id'=>$parent_id]);
                        $cat_desc = cmn_category_description::insertGetId([
                        'cmn_category_id'=>$cat_id,
                        'category_name'=>$item[$nameKey],
                        'byr_buyer_id'=>$byr_buyer_id,
                        'category_code'=>$catCode,
                        'category_orign_code'=>$item[$codeKey]
                        ]);
                        $result = DB::select("SELECT cmn_category_paths.*,cmn_category_descriptions.category_code FROM cmn_category_paths inner join cmn_category_descriptions on cmn_category_descriptions.cmn_category_id=cmn_category_paths.path_id WHERE cmn_category_paths.cmn_category_id = '". $parent_id . "' ORDER BY `level` ASC");
            
                        $level=0;
            if($result){
                foreach($result as $val){
                    cmn_category_path::insert(['cmn_category_id'=>$cat_id,'path_id'=>$val->path_id,'level'=>$level]);
                    $level++;
                }
            }
            cmn_category_path::insert(['cmn_category_id'=>$cat_id,'path_id'=>$cat_id,'level'=>$level]);
                    }
                    
                    $codeKey = $codeKey+2;
                    $nameKey = $nameKey+2;
                }
            }
            }
            }

        }
        unlink(storage_path().'/app/'.$path);
        return $result = response()->json(['message' => 'update_success']);
        // $update_status=Data_Controller::shipmentUpdateArray($dataArr,$file_name);
        // $ret = json_decode($update_status->getContent(), true);
        // if ($ret['status']===$this->error) {
        //     unlink(storage_path().'/app/'.$path);
        // }
    }
}
