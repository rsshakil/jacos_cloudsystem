<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;
use App\User;

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
            $permissions = Permission::select('permissions.*')
                ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->where('role_has_permissions.role_id', $role_id)
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
}
