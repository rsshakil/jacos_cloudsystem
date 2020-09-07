<?php

namespace App\Models\ADM;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use App\Models\ADM\adm_user_details;
use App\Models\CMN\cmn_companies_user;
use App\Models\BYR\byr_buyer;
use App\Models\SLR\slr_seller;
use Auth;
class User extends Authenticatable
{
    use Notifiable,HasRoles;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * Get the phone record associated with the user.
     */
    // public function userDetailsRel()
    // {
    //     // return $this->hasOne('App\adm_user_details', 'user_id');
    //     return $this->hasOne('App\adm_user_details', 'user_id', 'id');
    // }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $table = 'adm_users';
    // public function getFirstNameAttribute() 
    public function getImageAttribute() 
    {
        $user_id= Auth::user()->id;
        $user_details = adm_user_details::where('user_id', $user_id)->first();
        if($user_details){
            $image_name = $user_details->image;
        } else {
            $image_name = null;
        }        
        return $image_name;
    }
    // For check permission like can in vue 
    public function getAllPermissionsAttribute() {
        $permissions = [];
          foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
              $permissions[] = $permission->name;
            }
          }
        return $permissions;
    }

    public function getCompanyIdAttribute() 
    {
        $user_id= Auth::user()->id;
        $company_info = cmn_companies_user::where('adm_user_id', $user_id)->first();
        if($company_info){
            $cmn_company_id = $company_info->cmn_company_id;
        } else {
          $cmn_company_id = null;
        }        
        return $cmn_company_id;
    }

    public function getUserTypeAttribute(){
      $cmn_company_id= $this->getCompanyIdAttribute();
      $buyer_list = byr_buyer::where('cmn_company_id',$cmn_company_id)->get();
      $seller_list = slr_seller::where('cmn_company_id',$cmn_company_id)->get();
      if($buyer_list){
        return 'byr';
      }else{
        return 'slr';
      }
    }

    public function getByrSlrIdAttribute() 
    {
        $cmn_company_id= $this->getCompanyIdAttribute();
        $user_type= $this->getUserTypeAttribute();
        if($user_type=='slr'){
          $company_user_list = slr_seller::where('cmn_company_id',$cmn_company_id)->get();
        }else{
          $company_user_list = byr_buyer::where('cmn_company_id',$cmn_company_id)->get();
        }
        return $company_user_list;
    }

}
