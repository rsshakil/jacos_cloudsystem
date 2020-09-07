<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;
use App\Models\ADM\User;

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
}
