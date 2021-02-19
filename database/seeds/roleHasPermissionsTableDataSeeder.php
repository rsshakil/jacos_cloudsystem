<?php
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class roleHasPermissionsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_super_admin = Role::findByName('Super Admin');
        $permissions = Permission::all();
        $role_super_admin->givePermissionTo($permissions);

        $role_admin = Role::findByName('Admin');
        $role_admin->givePermissionTo('home','dashboard_menu','dashboard_view','role_menu','role_create','role_view','permission_menu','permission_create','permission_view','scenario_management','user_create','users_view','user_profile_view','user_permission_view','change_password','personal_profile_view','personal_user_update','personal_password_change','all_menu_show');

        $role_user = Role::findByName('User');
        $role_user->givePermissionTo('home','dashboard_menu','dashboard_view','personal_profile_view','personal_user_update','personal_password_change','all_menu_show');

        $role_saler = Role::findByName('Slr');
        $role_saler->givePermissionTo('home','selected_buyer','order_list_details','order_item_list_detail','management_setting','slr_view','add_company_users','order_list','slr_management','order_receive','order_corrected_receive','return_item_list','payment_list','invoice_list','byr_management');
        
        $role_byr = Role::findByName('Byr');
        $role_byr->givePermissionTo('home','voucher_setting','item_category','pdf_platform_setting','pdf_platform_view','byr_view','blog','item_master','item_category');
       
        // $role_byr = Role::findByName('Byr1');
        // $role_byr->givePermissionTo('home','voucher_setting','item_master','item_category','pdf_platform_setting','pdf_platform_view','byr_view');

        // $role_byr = Role::findByName('Byr2');
        // $role_byr->givePermissionTo('home','voucher_setting','item_master','item_category','pdf_platform_setting','pdf_platform_view','byr_view');

        // $role_byr = Role::findByName('Byr3');
        // $role_byr->givePermissionTo('home','voucher_setting','item_master','item_category','pdf_platform_setting','pdf_platform_view','byr_view');
    }
}
