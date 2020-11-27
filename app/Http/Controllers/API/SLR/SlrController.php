<?php

namespace App\Http\Controllers\API\SLR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\API\AllUsedFunction;
use App\Models\BYR\byr_order_item;
use App\Models\BYR\byr_order;
use App\Models\BYR\byr_buyer;
use App\Models\BYR\byr_shipment;
use App\Models\BYR\byr_shipment_item;
use App\Models\BYR\byr_shop;
use App\Models\CMN\cmn_pdf_canvas;
use App\Models\CMN\cmn_tbl_col_setting;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_connect;
use App\Models\CMN\cmn_company;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
use DB;
use Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class SlrController extends Controller
{
    private $all_used_fun;

    public function __construct(){
        $this->all_used_fun = new AllUsedFunction();
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
    public function get_selected_byr_info($byr_buyer_id){
        
        $byr_info = $this->all_used_fun->get_byr_info_by_byr_buyer_id($byr_buyer_id);
       
        return response()->json(['byr_info' => $byr_info]);
    }
    public function getPermissionForBuyer(Request $request){
        $byr_id=$request->byr_id;
        $permission_array=array();
        if ($byr_id!=null) {
            $byr_buyer_info=byr_buyer::select('adm_role_id')->where('byr_buyer_id',$byr_id)->first();
            $role_id=$byr_buyer_info->adm_role_id;

            $role = Role::findById($role_id);
            $permission_array=$role->getAllPermissions();
        }
        return response()->json(['permission_array'=>$permission_array]);
        

// return $permission_array;
//         // $permission_array=array();
//         $permission_for_role=array();
//         // foreach ($role_id as $key => $value) {
//         //     $role = Role::findById($value);
//         //     $permission_array[]=$role->getAllPermissions();
//         // }
//         foreach ($permission_array as $key => $permissions) {
//             // print_r($permissions);
//            foreach ($permissions as $key1 => $permission) {
//             print_r($permission);
//                 // $tmp=$permission->name;
//                 // $permission_for_role[]=$tmp;
               
//            }
//         }
        
    }
}
