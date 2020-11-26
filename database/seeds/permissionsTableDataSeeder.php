<?php
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class permissionsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_array=array(
            [
                'name' => 'role_menu',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'role_view',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'role_create',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'role_update',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'role_delete',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'permission_menu',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'permission_view',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'permission_create',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'permission_update',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'permission_delete',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'assign_role_to_user_menu',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'assign_role_to_user_view',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'assign_role_to_user_update',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'assign_permission_to_user_menu',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'assign_permission_to_user_view',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'assign_permission_to_user_update',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'manage_user_menu',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'users_view',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'user_profile_view',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'user_create',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'user_permission_view',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'user_update',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'change_password',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'user_delete',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'personal_profile_view',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'personal_user_update',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'personal_password_change',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'all_menu_show',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'dashboard_menu',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'dashboard_view',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'slr_view',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'byr_view',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'company_create',
                'guard_name' => 'web',
                'is_system' => 0,
            ],
            [
                'name' => 'add_company_users',
                'guard_name' => 'web',
                'is_system' => 0,
            ]
        );
        Permission::insert($permission_array);
    }
}
