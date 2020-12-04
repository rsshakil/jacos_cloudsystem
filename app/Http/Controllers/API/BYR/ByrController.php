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
    public function get_all_company_list($adm_user_id)
    {
        $companies=cmn_company::select('byr_buyers.byr_buyer_id','byr_buyers.super_code','cmn_companies.*')
        ->join('byr_buyers','byr_buyers.cmn_company_id','=','cmn_companies.cmn_company_id')
        ->get();
        // $adm_user_id=Auth::user()->id;
        // $authUser=User::find($adm_user_id);
        // if(!$authUser->hasRole('Super Admin')){
        //     $slr_info = $this->all_used_fun->get_slr_info_by_slr_seller_id();
           
        // }
       
        // $result = DB::table('cmn_connects')
        // ->join('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
        // ->join('cmn_companies', 'cmn_companies.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
        // ->select('byr_buyers.super_code','cmn_companies.*','byr_buyers.byr_buyer_id')
        // ->groupBy('byr_buyers.byr_buyer_id');
        // if(!$authUser->hasRole('Super Admin')){
        //     $result = $result->where('cmn_connects.slr_seller_id',$slr_info->slr_seller_id);
        // }
        // return $result=$result->get();
        return response()->json(['companies'=>$companies]);
    }

    public function get_buyer_user_list($cmn_company_id=null){
        $buyer_users=array();
        if ($cmn_company_id!=null) {
            $buyer_users=cmn_companies_user::select('adm_users.*')
            ->join('adm_users', 'adm_users.id', '=', 'cmn_companies_users.adm_user_id')
            ->where('cmn_companies_users.cmn_company_id',$cmn_company_id)
            ->get();
        }
        // $buyers = byr_buyer::select('adm_users.*')
        // ->join('cmn_companies_users', 'cmn_companies_users.cmn_company_id', '=', 'byr_buyers.cmn_company_id')
        // ->join('adm_users', 'adm_users.id', '=', 'cmn_companies_users.adm_user_id')
        // ->where('byr_buyers.cmn_company_id',$cmn_company_id)
        // ->get();
        return response()->json(['user_list'=>$buyer_users]); 
    }

    public function company_partner_list($cmn_company_id){
      $result = DB::table('byr_buyers')
        ->join('cmn_connects', 'byr_buyers.byr_buyer_id', '=', 'cmn_connects.byr_buyer_id')
        ->join('slr_sellers', 'slr_sellers.slr_seller_id', '=', 'cmn_connects.slr_seller_id')
        ->join('cmn_companies', 'slr_sellers.cmn_company_id', '=', 'cmn_companies.cmn_company_id')
        ->select('slr_sellers.slr_seller_id','cmn_connects.byr_buyer_id','cmn_connects.cmn_connect_id','byr_buyers.super_code', 'cmn_companies.company_name', 'cmn_companies.jcode','cmn_connects.partner_code','cmn_connects.is_active', 'slr_sellers.slr_seller_id')
        ->where('byr_buyers.cmn_company_id',$cmn_company_id)
        ->get();
        return response()->json(['partner_list'=>$result]); 
    }
    public function get_byr_slr_company($cmn_company_id=null){
        $buyer_info=byr_buyer::select('byr_buyers.byr_buyer_id','cmn_companies.cmn_company_id','cmn_companies.company_name as buyer_name')
        ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')
        ->get();
        return response()->json(['buyer_info'=>$buyer_info]);
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
    public function getPermissionForBuyer(Request $request){
        $cmn_company_id=$request->cmn_company_id;
        $selected_permission_array=array();
        $permission_array = Permission::select('id as permission_id','name as permission_name')->where('name','like','byr_'.'%')->get();
        if ($cmn_company_id!=null) {
            $byr_buyer_info=byr_buyer::select('adm_role_id')->where('cmn_company_id',$cmn_company_id)->first();
            $role_id=$byr_buyer_info->adm_role_id;

            $role = Role::findById($role_id);
            $selected_permission_array=$role->getAllPermissions();
        }
        return response()->json(['permission_array'=>$permission_array,'selected_permission_array'=>$selected_permission_array]); 
    }
    public function buyer_user_create(Request $request){
        // return $request->all();
        $adm_user_id = $request->adm_user_id;
        if ($adm_user_id==null) {
            $this->validate($request,[
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:adm_users',
                'password' => 'required|string|min:6',
                'cmn_company_id' => 'required'
            ]);
        }else{
            $this->validate($request,[
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191',
                'cmn_company_id' => 'required',
            ]);
        }
        
        $cmn_company_id = $request->cmn_company_id;

        $user_info=$this->all_used_fun->buyer_or_saller_user_store($request);
        if ($user_info['message']=='created') {
            cmn_companies_user::insert(['cmn_company_id'=>$cmn_company_id,'adm_user_id'=>$user_info['last_user_id']]);
        }
        return response()->json($user_info);
    }

    public function getSellerList(Request $request){
        // return $request->all();
        $cmn_connect_id=$request->cmn_connect_id;
        $selected_sellers=array();
        $seller_query=cmn_company::select('slr_sellers.slr_seller_id','cmn_companies.cmn_company_id','cmn_companies.company_name as seller_name','cmn_companies.jcode')
        ->join('slr_sellers','slr_sellers.cmn_company_id','=','cmn_companies.cmn_company_id');
        $sellers=$seller_query->get();
        if ($cmn_connect_id!=null) {
            $selected_sellers=$seller_query->join('cmn_connects','cmn_connects.slr_seller_id','=','slr_sellers.slr_seller_id')
            ->where('cmn_connects.cmn_connect_id',$cmn_connect_id)->first();
            // $sellers=$seller_query;
        }
        return response()->json(['sellers'=>$sellers,'selected_sellers'=>$selected_sellers]); 
    }

    public function buyerPartnerCreate(Request $request){
        
        $this->validate($request,[
            'cmn_company_id' => 'required|integer',
            'partner_code' => 'required',
            'selected_sellers' => 'required|array'
        ]);
        // return $request->all();
        $cmn_company_id=$request->cmn_company_id;
        $cmn_connect_id=$request->cmn_connect_id;
        $partner_code=$request->partner_code;
        $selected_sellers=$request->selected_sellers;
        $slr_seller_id=$selected_sellers['slr_seller_id'];

        $buyer_id_info=byr_buyer::select('byr_buyer_id')->where('cmn_company_id',$cmn_company_id)->first();
        $byr_buyer_id=$buyer_id_info->byr_buyer_id;

        $partner_array=array(
            'byr_buyer_id'=>$byr_buyer_id,
            'partner_code'=>$partner_code,
            'slr_seller_id'=>$slr_seller_id,
            'is_active'=>1,
        );
        if ($cmn_connect_id!=null) {
            cmn_connect::where('cmn_connect_id',$cmn_connect_id)->update($partner_array);
            return response()->json(['title'=>"Updated!",'message' =>"updated", 'class_name' => 'success']);
        }else{
            cmn_connect::insert($partner_array);
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

    public function createBuyer(Request $request){
        $this->validate($request,[
            // 'buyer_name' => 'required|string|max:100',
            // 'buyer_email' => 'required|string|max:191',
            // 'buyer_password' => 'required|string|max:191',
            'company_name' => 'required|string|max:191',
            'super_code' => 'required|string|max:20',
            'jcode' => 'required|string|min:3',
            'postal_code' => 'required|string|min:3',
            'address' => 'required|string|min:3',
        ]);
        $cmn_company_id = $request->cmn_company_id;
        // $buyer_name = $request->buyer_name;
        // $buyer_email = $request->buyer_email;
        // $buyer_password = $request->buyer_password;
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
        // $user_array=array(
        //     'name'=>$buyer_name,
        //     'email'=>$buyer_email,
        //     'password'=>Hash::make($buyer_password),
        // );
        if($cmn_company_id!=null){
            // $adm_user_info = $this->all_used_fun->buyer_or_saller_store($user_array,$cmn_company_id);
            // if ($adm_user_info['class_name']=='error') {
            //     return response()->json($adm_user_info);
            // }else{
                // $adm_user_id=$adm_user_info['returnable_user_id'];
                cmn_company::where('cmn_company_id',$cmn_company_id)->update($buyer_company_array);
                $adm_role_info=byr_buyer::where('cmn_company_id',$cmn_company_id)->first();
                $adm_role_id=$adm_role_info->adm_role_id;
                $this->all_used_fun->assignPermissionToRole($adm_role_id, $selected_permissions);
                byr_buyer::where('cmn_company_id',$cmn_company_id)->update(['super_code'=>$super_code]);
            // }
            return response()->json(['title'=>"Updated!",'message' =>"updated", 'class_name' => 'success']);
            
        }else{
            // $adm_user_info = $this->all_used_fun->buyer_or_saller_store($user_array);
            // \Log::info($adm_user_info);
            // \Log::info($adm_user_info['class_name']);
            // // if (json_encode($adm_user_info->class_name=='error')) {
            // if ($adm_user_info['class_name']=='error') {
            //     return response()->json($adm_user_info);
            // }else{
                // $adm_user_id=$adm_user_info['returnable_user_id'];
                $role_last_id = Role::insertGetId(['name' => 'byr'.$jcode, 'guard_name' => 'web', 'role_description' => 'byr'.$jcode, 'is_system' => 0]);
                $this->all_used_fun->assignPermissionToRole($role_last_id, $selected_permissions);
                $cmn_company_id = cmn_company::insertGetId($buyer_company_array);
                byr_buyer::insert(['cmn_company_id'=>$cmn_company_id,'super_code'=>$super_code,'adm_role_id'=>$role_last_id]);
                // $buyer_last_id=byr_buyer::insertGetId(['cmn_company_id'=>$cmn_company_id,'super_code'=>$super_code,'adm_role_id'=>$role_last_id]);
                // cmn_companies_user::insert(['cmn_company_id'=>$cmn_company_id,'adm_user_id'=>$adm_user_id]);
                // cmn_connect::insert(['byr_buyer_id'=>$buyer_last_id,'slr_seller_id'=>Auth::User()->id]);
            // }
            return response()->json(['title'=>"Created!",'message' =>"created", 'class_name' => 'success']);
        }
        // return response()->json(['title'=>"Created!",'message' =>"created", 'class_name' => 'success']);
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
