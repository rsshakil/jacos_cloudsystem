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
        $level1 = '1';
        $level2 = '2';
        $level3 = '3';
        if(!$authUser->hasRole(config('const.adm_role_name'))){
            $cmn_company_info = cmn_companies_user::select('byr_buyers.cmn_company_id','byr_buyers.byr_buyer_id','cmn_connects.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
            ->join('cmn_connects', 'cmn_connects.byr_buyer_id', '=', 'byr_buyers.byr_buyer_id')
            ->where('cmn_companies_users.adm_user_id',$adm_user_id)->first();
            $cmn_company_id = $cmn_company_info->cmn_company_id;
            $byr_buyer_id = $cmn_company_info->byr_buyer_id;
            $cmn_connect_id = $cmn_company_info->cmn_connect_id;
            // $categories = cmn_category::where('is_deleted', 0)->with('parent')->get();
            // print_r($categories);exit;
            $categorysAllforOpt = cmn_category::where(['cmn_categories.is_deleted'=>0,'cmn_categories.byr_buyer_id'=>$byr_buyer_id,'level'=>'1'])->orWhere('level','2')->get();
            $categorys = cmn_category::select('cmn_categories.*',
            'cmn_cat_level2.cmn_category_id as cmn_category_id2',
            'cmn_cat_level2.category_code as category_code2',
            'cmn_cat_level2.category_name as category_name2',
            'cmn_cat_level2.parent_category_id as parent_category_id2',
            'cmn_cat_level3.cmn_category_id as cmn_category_id3',
            'cmn_cat_level3.category_code as category_code3',
            'cmn_cat_level3.category_name as category_name3',
            'cmn_cat_level3.parent_category_id as parent_category_id3'
            )
            ->leftJoin('cmn_categories as cmn_cat_level2', function($join) use ($level2)
    {
        $join->on('cmn_categories.cmn_category_id', '=', 'cmn_cat_level2.parent_category_id');
        // $join->where('cmn_cat_level2.level','=',DB::raw("'".$level2."'"));
       // $join->where('cmn_cat_level2.parent_category_id','!=',0);

    })
    ->leftJoin('cmn_categories as cmn_cat_level3', function($join) use ($level3)
    {
        $join->on('cmn_cat_level2.cmn_category_id', '=', 'cmn_cat_level3.parent_category_id');
        // $join->where('cmn_cat_level3.level','=',DB::raw("'".$level3."'"));
       // $join->where('cmn_cat_level3.parent_category_id','!=',0);

    })

            ->where(['cmn_categories.is_deleted'=>0,'cmn_categories.byr_buyer_id'=>$byr_buyer_id])
            ->orderBy('cmn_categories.cmn_category_id','desc')
            ->paginate($per_page);
        }else{
            $categorysAllforOpt = cmn_category::where(['cmn_categories.is_deleted'=>0,'level'=>'1'])->orWhere('level','2')->get();
            $categorys = cmn_category::select('cmn_categories.*',
            'cmn_cat_level2.cmn_category_id as cmn_category_id2',
            'cmn_cat_level2.category_code as category_code2',
            'cmn_cat_level2.category_name as category_name2',
            'cmn_cat_level2.parent_category_id as parent_category_id2',
            'cmn_cat_level3.cmn_category_id as cmn_category_id3',
            'cmn_cat_level3.category_code as category_code3',
            'cmn_cat_level3.category_name as category_name3',
            'cmn_cat_level3.parent_category_id as parent_category_id3'
            )
            ->leftJoin('cmn_categories as cmn_cat_level2', function($join) use ($level2)
    {
        $join->on('cmn_categories.cmn_category_id', '=', 'cmn_cat_level2.parent_category_id');
        // $join->where('cmn_cat_level2.level','=',DB::raw("'".$level2."'"));
       // $join->where('cmn_cat_level2.parent_category_id','!=',0);

    })
    ->leftJoin('cmn_categories as cmn_cat_level3', function($join) use ($level3)
    {
        $join->on('cmn_cat_level2.cmn_category_id', '=', 'cmn_cat_level3.parent_category_id');
        // $join->where('cmn_cat_level3.level','=',DB::raw("'".$level3."'"));
       // $join->where('cmn_cat_level3.parent_category_id','!=',0);

    })
            ->where(['cmn_categories.is_deleted'=>0])
            ->paginate($per_page);
        }

        return response()->json(['cat_list' => $categorys,'allCatForParent'=>$categorysAllforOpt]);
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
            'category_code' => 'required|string|max:3|min:3',
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
        $category_code = $request->category_code;
        $category_name = $request->category_name;
        $parent_id = $request->parent_category_id;
        $level = '1';
        if($parent_id!=0){
            $parent_ct = cmn_category::where('cmn_category_id',$parent_id)->first();
            $level = $parent_ct->level+1;
        }
        if($cmn_category_id==0){
            $cat_id = cmn_category::insertGetId(['parent_category_id'=>$parent_id,'category_name'=>$category_code,'byr_buyer_id'=>$byr_buyer_id,'category_code'=>$category_code,'category_name'=>$category_name,'level'=>$level]);
            return $result = response()->json(['message' => 'insert_success']);
        }else{
            cmn_category::where('cmn_category_id',$cmn_category_id)->update(['parent_category_id'=>$parent_id,'category_name'=>$category_name,'category_code'=>$category_code,'level'=>$level]);
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
                $level = '1';
                for($i=0;$i<3;$i++){
                    if($i==0){
                        $level = '1';
                    }else if($i==1){
                        $level = '2';
                    }else{
                        $level = '3';
                    }
                    $cat2 = $item[0];
                    $cat2name = $item[1];
                    $cat4 = $item[2];
                    $cat4name = $item[3];
                    $catInfo = cmn_category::where(['category_code'=>$item[$codeKey],'level'=>$level,'category_name'=>$item[$nameKey]])->first();
                    if(!$catInfo){
                        $subCatInfo = array();

                        if($i==1){
                            $subCatInfo = cmn_category::where(['category_code'=>$cat2,'category_name'=>$cat2name,'level'=>'1'])->first();
                            }
                        if($i==2){
                            $subCatInfo = cmn_category::where(['category_code'=>$cat4,'category_name'=>$cat4name,'level'=>'2'])->first();
                        }
                        $parent_id = 0;
                        if($subCatInfo){
                            $parent_id = $subCatInfo->cmn_category_id;
                        }
                        $cat_desc = cmn_category::insertGetId([
                        'parent_category_id'=>$parent_id,
                        'category_name'=>$item[$nameKey],
                        'byr_buyer_id'=>$byr_buyer_id,
                        'category_code'=>$item[$codeKey],
                        'level'=>$level
                        ]);
                        
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
