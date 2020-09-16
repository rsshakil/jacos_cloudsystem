<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\CMN\cmn_tbl_col_setting;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_connect;
use App\Models\CMN\cmn_company;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
use App\Models\BYR\byr_receive;
use App\Models\BYR\byr_corrected_receive;
use App\Models\BYR\byr_buyer;
use App\Models\BYR\byr_return;
use DB;

class AllUsedFunction extends Controller
{
    
    public function allUsers(){
        $users = User::select('id as user_id','name as user_name')->get();
        return $users;
    }
    public function allUsersAll(){
        $users = User::all();
        return $users;
    }
    
    /**
     * Get all permission for a desired role
     *
     * @param  int $role_id
     * @return All permission as an array.
     */
    public function get_role_permission_by_role_id($role_id = null,$status = null)
    {
        if (!empty($role_id)) {
            // $permissions=$this->get_selected_permission_by_role_id($role_id);
            $permissions=$this->get_permissions($role_id);
                $permission_array=array();
                foreach ($permissions as $key => $permission) {
                    if($status==null){
                        $permission_array[]='<button class="btn btn-info btn-sm" style="margin-top:5px;">'.$permission->name.'</button>';
                    }else{
                        $permission_array[]=$permission->name;
                    }
                    
                }
            return $permissions=implode(' ',$permission_array);
        } else {
            return $permissions = Permission::select('id','name')->get();
        }
    }
    /**
     * Get all permission for a desired role
     *
     * @param  int $role_id
     * @return All permission as an array.
     */
    public function get_permissions($role_id = null)
    {
        if ($role_id != null) {
            $permissions = Permission::select('adm_permissions.*')
                ->join('adm_role_has_permissions as rhp', 'adm_permissions.id', '=', 'rhp.permission_id')
                ->where('rhp.role_id', $role_id)
                ->get();
        }else{
            $permissions=Permission::all();
        }
            
     return $permissions;
        
    }
    
    public function allPermissionForUser($user){
        $all_permissions_for_user= $user->getAllPermissions();
        $all_permissions_for_user_array=array();
        foreach ($all_permissions_for_user as $all_permission_for_user) {
            $all_permissions_for_user_array[]=$all_permission_for_user->name;
        }
        return $all_permissions_for_user_array;
    }

    public function get_permission_custom_field(){
        return $permissions = Permission::select('id as permission_id','name as permission_name')->get();
    }
    public function get_role_custom_field(){
        return $roles = Role::select('id as role_id','name as role_name')->get();
    }
    public function get_roles(){
        return $roles = Role::all();
    }

    public function csvReader($baseUrl)
    {
        $data = array_map('str_getcsv', file($baseUrl));
        $csv_data = array_slice($data, 1);
        // return $csv_data;
        $rowData = $this->convert_from_sjis_to_utf8_recursively($csv_data);
        \Log::debug('----- CSV file read completed from this url: (' . $baseUrl . ')-----');
        return $rowData;
    }

    /**
     * File encoding from SJIJ to utf8
     * @param  SJIJ String or array
     * @return utf-8 encoded string
     */
    public static function convert_from_sjis_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            \Log::debug('----- SJIJ to UTF-8 conversion completed -----');
            // $dat=str_replace("\u{00a0}", ' ', $dat);
            if(mb_detect_encoding($dat) != "UTF-8"){
                return mb_convert_encoding($dat, "UTF-8", "sjis-win");
                // return utf8_encode($dat);   
            }else{
                return mb_convert_encoding($dat,"UTF-8","auto");
                // return $dat;
            }
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) {
                $ret[$i] = self::convert_from_sjis_to_utf8_recursively($d);
            }

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) {
                $dat->$i = self::convert_from_sjis_to_utf8_recursively($d);
            }

            return $dat;
        } else {
            return $dat;
        }
    }
    /**
     * File encoding from utf8 to SJIJ
     * @param utf-8 String or array
     * @return  SJIJ encoded string
     */
    public static function convert_from_utf8_to_sjis__recursively($dat)
    {
        if (is_string($dat)) {
            \Log::debug('----- UTF-8 to SJIJ conversion completed -----');
            // Original
            return mb_convert_encoding($dat, "sjis-win", "UTF-8");
            // return mb_convert_encoding($dat, "SJIS", "UTF-8");
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) {
                $ret[$i] = self::convert_from_utf8_to_sjis__recursively($d);
            }

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) {
                $dat->$i = self::convert_from_utf8_to_sjis__recursively($d);
            }

            return $dat;
        } else {
            return $dat;
        }
    }
    /**
     * File encoding from Latin1 utf8
     * @param Latin1 String or array
     * @return  utf-8 encoded string
     */
    public static function convert_from_latin1_to_utf8_recursively($dat)
   {
      if (is_string($dat)) {
         return utf8_encode($dat);
      } elseif (is_array($dat)) {
         $ret = [];
         foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

         return $ret;
      } elseif (is_object($dat)) {
         foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

         return $dat;
      } else {
         return $dat;
      }
   }
    public function file_name_change($file_name)
    {
        $file_array = explode('.', $file_name);
        $array_size = sizeof($file_array);
        $file_name_without_ext = $file_array[$array_size - 2];
        $today_for_file = date("YmdHis");
        return $file_name = $file_name_without_ext . "_" . $today_for_file . "." . $file_array[$array_size - 1];
    }

    public function get_company_list($cmn_company_id=0){
        if($cmn_company_id!=0){
            return $results  = cmn_company::where('cmn_company_id',$cmn_company_id)->get();
        }else{
            return $byr_buyer = byr_buyer::select('cmn_companies.*')
            ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')->get();
        }
    }

    public function get_user_info($adm_user_id=0){
        $arr=array('cmn_company_id'=>0,'byr_buyer_id'=>0,'cmn_connect_id'=>0);
        if($adm_user_id=!0){
            $cmn_company_info = cmn_companies_user::select('byr_buyers.cmn_company_id','byr_buyers.byr_buyer_id','cmn_connects.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
            ->join('cmn_connects', 'cmn_connects.byr_buyer_id', '=', 'byr_buyers.byr_buyer_id')
            ->where('cmn_companies_users.adm_user_id',$adm_user_id)->first();
            $cmn_company_id = $cmn_company_info->cmn_company_id;
            $byr_buyer_id = $cmn_company_info->byr_buyer_id;
            $cmn_connect_id = $cmn_company_info->cmn_connect_id;
            $arr = array(
                'cmn_company_id'=>$cmn_company_id,
                'byr_buyer_id'=>$byr_buyer_id,
                'cmn_connect_id'=>$cmn_connect_id
            );
        }
        return $ar;
    }
}
