<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\API\AllUsedFunction;
use Illuminate\Support\Facades\Auth;
use App\Models\ADM\User;

class PermissionController extends Controller
{
    private $all_used_functions;
    
    public function __construct()
    {
        $this->all_used_functions = new AllUsedFunction();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = $this->all_used_functions->get_permissions();
        return response()->json([
            'permissions'=>$permissions,
            ]);
    }

    /**
     * Insert and update permission
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'permission_name' => 'required|max:50',
        ]);
        if ($validation->passes()) {
            $permission_update_id = $request->permission_update_id;
            $permission_name = $request->permission_name;
            $permission_description = $request->permission_description;
            if ($permission_update_id == null) {
                $permissions = Permission::where('name', $permission_name)->get();
                $permissions = json_decode($permissions);
                if (empty($permissions)) {
                    Permission::create([
                        'name' => $permission_name, 
                        'permission_description' => $permission_description, 
                        'is_system' => 0]);
                        return response()->json(['message' => "created", 'class_name' => 'success','title'=>'Created!']);
                        // return response()->json(['message' => __('messages.permission_setup_completed'), 'class_name' => 'success','title'=>'Created!']);
                } else {
                    return response()->json(['message' =>'duplicated', 'class_name' => 'warning','title'=>'Exists!']);
                    // return redirect()->back()->with(['message' => __('messages.permission_name_duplicate'), 'class_name' => 'alert-danger']);
                }
            } else {
                $permission_check = Permission::where('id', $permission_update_id)->first();
                if ($permission_check['name'] != $permission_name) {
                    if (Permission::where('name', '=', $permission_name)->exists()) {
                        return response()->json(['message' => 'duplicated', 'class_name' => 'warning','title'=>'Exists!']);
                    }
                }
                Permission::where('id', $permission_update_id)->update([
                    'name' => $permission_name,
                    'permission_description' => $permission_description]);
                    return response()->json(['message' => 'updated', 'class_name' => 'success','title'=>'Updated!']);
                // return redirect()->back()->with(['message' => __('messages.permission_updated'), 'class_name' => 'alert-success']);
            }
        } else {
            return response()->json(['message' => 'required', 'class_name' => 'error','title'=>'Warning!']);
            // return redirect()->back()->with(['message' => __('messages.permission_name_blank'), 'class_name' => 'alert-danger']);
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
     * To delete a permission
     *
     * @param  int permission_id
     * @return a json array with success message to Jquery function.
     */
    public function destroy($permission_id)
    {
        $permission_info=Permission::where([['id', '=', $permission_id], ['is_system', '=', 0]])->first();
        $permission_name=$permission_info['name'];
        $is_delete = Permission::where([['id', '=', $permission_id], ['is_system', '=', 0]])->delete();
        if ($is_delete) {
            return response()->json(['message' =>'deleted', 'class_name' => 'success','title'=>'Deleted!']);
            // return response()->json(['message' => __('messages.permission_deleted').":".$permission_name, 'class_name' => 'success','title'=>'Deleted!']);
        } else {
            return response()->json(['message' =>'faild', 'class_name' => 'error','title'=>'Not Deleted!']);
            // return response()->json(['message' =>__('messages.permission_not_deleted').":".$permission_name, 'class_name' => 'error','title'=>'Not Deleted!']);
        }   
    }
    // function check(Request $request) {
    //     $permissionName=$request->get('permission_name');
    //     $user_id=$request->get('user');
    //     // return $user['id'];
    //     $user=User::find($user_id);
    //     //  return $request->all();
    //     if (! $user->hasPermissionTo($permissionName)) {
    //          abort(403);
    //     }
    //     return response('', 204);
    //  }
}
