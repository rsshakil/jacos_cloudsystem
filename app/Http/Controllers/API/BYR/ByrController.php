<?php

namespace App\Http\Controllers\API\BYR;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AllUsedFunction;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\ADM\User;
use App\Models\ADM\adm_user_details;
use App\Models\BYR\byr_buyer;
use App\Models\SLR\slr_seller;
use App\Models\CMN\cmn_companies_user;
use App\Models\CMN\cmn_company;
use App\Models\CMN\cmn_connect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use session;

class ByrController extends Controller
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
        $result = DB::table('cmn_companies')
        ->join('byr_buyers', 'byr_buyers.cmn_company_id', '=', 'cmn_companies.cmn_company_id')
        ->select('byr_buyers.super_code','cmn_companies.jcode', 'cmn_companies.company_name','cmn_companies.cmn_company_id','byr_buyers.byr_buyer_id')
        ->groupBy('cmn_companies.cmn_company_id')
        ->get();
        return response()->json(['company_list'=>$result]);
    }
    public function get_all_byr_company_list($adm_user_id)
    {
        $adm_user_id=Auth::user()->id;
        $authUser=User::find($adm_user_id);
        if(!$authUser->hasRole('Super Admin')){
            $slr_info = $this->all_used_fun->get_slr_info_by_slr_seller_id();
           
        }
       
        $result = DB::table('cmn_connects')
        ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
        ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
        ->select('byr_buyers.super_code','cmn_companies.*','byr_buyers.byr_buyer_id')
        ->groupBy('byr_buyers.byr_buyer_id');
        if(!$authUser->hasRole('Super Admin')){
            $result = $result->where('cmn_connects.slr_seller_id',$slr_info->slr_seller_id);
        }
        $result=$result->get();
        return response()->json(['company_list'=>$result]);
    }

    public function company_user_list($cmn_company_id){
        $result = DB::table('cmn_companies_users')
        ->join('adm_users', 'adm_users.id', '=', 'cmn_companies_users.adm_user_id')
        ->select('adm_users.*')
        ->where('cmn_companies_users.cmn_company_id',$cmn_company_id)
        ->get();
        return response()->json(['user_list'=>$result]); 
    }

    public function company_partner_list($cmn_company_id){
      $result = DB::table('byr_buyers')
       
        ->join('cmn_connects', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
        ->join('slr_sellers', 'slr_sellers.slr_seller_id', '=', 'cmn_connects.slr_seller_id')
        ->join('cmn_companies', 'slr_sellers.cmn_company_id', '=', 'cmn_companies.cmn_company_id')
        ->select('slr_sellers.slr_seller_id','cmn_connects.byr_buyer_id','byr_buyers.super_code', 'cmn_companies.company_name', 'cmn_companies.jcode','cmn_connects.partner_code','cmn_connects.is_active', 'slr_sellers.slr_seller_id')
        ->where('byr_buyers.cmn_company_id',$cmn_company_id)
        ->get();
        return response()->json(['partner_list'=>$result]); 
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

    public function slr_management($adm_user_id){
        $authUser=User::find($adm_user_id);
        if(!$authUser->hasRole('Super Admin')){
            $cmn_company_info = cmn_companies_user::where('adm_user_id',$adm_user_id)->first();
            $cmn_company_id = $cmn_company_info->cmn_company_id;
        }
        
        $result = DB::table('cmn_companies')
        ->join('slr_sellers', 'slr_sellers.cmn_company_id', '=', 'cmn_companies.cmn_company_id')
        ->groupBy('cmn_companies.cmn_company_id');
        if(!$authUser->hasRole('Super Admin')){
            $result = $result->where('cmn_companies.cmn_company_id',$cmn_company_id);
        }
        $result= $result->get();
        return response()->json(['slr_list'=>$result]);
    }

    public function byr_buyer_user_create(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:adm_users',
            'password' => 'required|string|min:6'
        ]);

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $super_code = $request->super_code;
        $cmn_company_id = $request->cmn_company_id;
        $hash_password = Hash::make($password);
        $user_exist = User::where('email', $email)->first();
        if ($user_exist) {
            return response()->json(['title'=>"Exists!",'message' =>"exists", 'class_name' => 'error']);
        } else {
            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->password = $hash_password;
            $user->save();
            $last_user_id = $user->id;
            $user_details = new adm_user_details;
            $user_details->user_id = $last_user_id;
            $user_details->save();
            $users = User::findOrFail($last_user_id);
            $users->assignRole('Byr');
            // byr_buyer::insert(['cmn_company_id'=>$cmn_company_id,'super_code'=>$super_code]);
            cmn_companies_user::insert(['cmn_company_id'=>$cmn_company_id,'adm_user_id'=>$last_user_id]);

            return response()->json(['title'=>"Created!",'message' =>"created", 'class_name' => 'success']);
        }

    }


    public function slr_seller_user_create(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:adm_users',
            'password' => 'required|string|min:6',
        ]);

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $cmn_company_id = $request->cmn_company_id;
        $hash_password = Hash::make($password);
        $user_exist = User::where('email', $email)->first();
        if ($user_exist) {
            return response()->json(['title'=>"Exists!",'message' =>"exists", 'class_name' => 'error']);
        } else {
            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->password = $hash_password;
            $user->save();
            $last_user_id = $user->id;
            $user_details = new adm_user_details;
            $user_details->user_id = $last_user_id;
            $user_details->save();
            $users = User::findOrFail($last_user_id);
            $users->assignRole('Slr');
            // slr_seller::insert(['cmn_company_id'=>$cmn_company_id]);
            cmn_companies_user::insert(['cmn_company_id'=>$cmn_company_id,'adm_user_id'=>$last_user_id]);
            return response()->json(['title'=>"Created!",'message' =>"created", 'class_name' => 'success']);
        }

    }

    public function byr_create(Request $request){
        // return $request->all();
        $this->validate($request,[
            'buyer_name' => 'required|string|max:100',
            'buyer_email' => 'required|string|max:191',
            'buyer_password' => 'required|string|max:191',
            'company_name' => 'required|string|max:191',
            'super_code' => 'required|string|max:20',
            'jcode' => 'required|string|min:3',
            'postal_code' => 'required|string|min:3',
            'address' => 'required|string|min:3',
        ]);
        $cmn_company_id = $request->cmn_company_id;
        $buyer_name = $request->buyer_name;
        $buyer_email = $request->buyer_email;
        $buyer_password = $request->buyer_password;
        $company_name = $request->company_name;
        $jcode = $request->jcode;
        $super_code = $request->super_code;
        $postal_code = $request->postal_code;
        $address = $request->address;
        $selected_permissions = $request->selected_permissions;
        $buyer_company_array=array(
            'company_name'=>$company_name,
            'jcode'=>$jcode,
            'postal_code'=>$postal_code,
            'address'=>$address
        );
        $user_array=array(
            'name'=>$buyer_name,
            'email'=>$buyer_email,
            'password'=>Hash::make($buyer_password),
        );
        if($cmn_company_id!=null){
            $adm_user_info = $this->all_used_fun->buyer_or_saller_store($user_array,$cmn_company_id);
            if ($adm_user_info['class_name']=='error') {
                return response()->json($adm_user_info);
            }else{
                $adm_user_id=$adm_user_info['returnable_user_id'];
                cmn_company::where('cmn_company_id',$cmn_company_id)->update($buyer_company_array);
                $adm_role_info=byr_buyer::where('cmn_company_id',$cmn_company_id)->first();
                $adm_role_id=$adm_role_info->adm_role_id;
                $this->all_used_fun->assignPermissionToRole($adm_role_id, $selected_permissions);
                byr_buyer::where('cmn_company_id',$cmn_company_id)->update(['super_code'=>$super_code]);
            }
            
        }else{
            $adm_user_info = $this->all_used_fun->buyer_or_saller_store($user_array);
            \Log::info($adm_user_info);
            \Log::info($adm_user_info['class_name']);
            // if (json_encode($adm_user_info->class_name=='error')) {
            if ($adm_user_info['class_name']=='error') {
                return response()->json($adm_user_info);
            }else{
                $adm_user_id=$adm_user_info['returnable_user_id'];
                $role_last_id = Role::insertGetId(['name' => 'byr'.$jcode, 'guard_name' => 'web', 'role_description' => 'byr'.$jcode, 'is_system' => 0]);
                $this->all_used_fun->assignPermissionToRole($role_last_id, $selected_permissions);
                $cmn_company_id = cmn_company::insertGetId($buyer_company_array);
                $buyer_last_id=byr_buyer::insertGetId(['cmn_company_id'=>$cmn_company_id,'super_code'=>$super_code,'adm_role_id'=>$role_last_id]);
                cmn_companies_user::insert(['cmn_company_id'=>$cmn_company_id,'adm_user_id'=>$adm_user_id]);
                cmn_connect::insert(['byr_buyer_id'=>$buyer_last_id,'slr_seller_id'=>Auth::User()->id]);
            }
        }
        return response()->json(['title'=>"Created!",'message' =>"created", 'class_name' => 'success']);
    }

    public function slr_company_create(Request $request){
        $this->validate($request,[
            'company_name' => 'required|string|max:191',
            'phone' => 'required|string|max:20',
            'fax' => 'required|string|max:20',
            'jcode' => 'required|string|min:3',
            'postal_code' => 'required|string|min:3',
            'address' => 'required|string|min:3',
        ]);
        if($request->cmn_company_id!=null){
            cmn_company::where('cmn_company_id',$request->cmn_company_id)->update(['company_name'=>$request->company_name,'jcode'=>$request->jcode,'postal_code'=>$request->postal_code,'address'=>$request->address,'phone'=>$request->phone,'fax'=>$request->fax]);
        }else{
            $cmn_company_id = cmn_company::insertGetId(['company_name'=>$request->company_name,'jcode'=>$request->jcode,'postal_code'=>$request->postal_code,'address'=>$request->address,'phone'=>$request->phone,'fax'=>$request->fax]);
        slr_seller::insert(['cmn_company_id'=>$cmn_company_id]);
        }
        
        return response()->json(['title'=>"Created!",'message' =>"created", 'class_name' => 'success']);
    }

    public function slr_management_test(){
        echo '<pre>';
        print_r(Auth::user());
    }
}
