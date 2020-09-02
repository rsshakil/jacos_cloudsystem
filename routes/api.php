<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Authentication Route
// Route::group(['middleware'=>'MyMiddleWire'],function(){
Route::apiResources(
    [
        'role' => 'API\RoleController',
        'permission' => 'API\PermissionController',
        'users' => 'API\UsersController'
    ]
);

Route::apiResources(
    [
        'byrorders' => 'API\Byr_orderController',
        'byrshipments' => 'API\Byr_shipmentController'
    ]
);
Route::apiResources(

	[
		'tblecolsetting' => 'API\Tbl_col_settingController'
	]
);

Route::apiResources(

	[
		'jacosmanagement' => 'API\Jacos_managementController'
	]
);

Route::get('/all_users_roles', 'API\AssignRoleModel@allUsersAndRoles');
Route::get('/get_roles/{id}', 'API\AssignRoleModel@getRoleById');
Route::post('/assign_role_to_user', 'API\AssignRoleModel@assignModelRole');

Route::get('/all_users_permissions', 'API\AssignPermissionModel@allUsersAndPermissions');
Route::get('/get_permission_model/{id}', 'API\AssignPermissionModel@getPermissionModel');
Route::post('/assign_permission_to_user', 'API\AssignPermissionModel@assignPermissionToModel');

Route::post('/get_permission_for_roles', 'API\AssignPermissionModel@getPermissionsByRole');
Route::post('/permissions_by_users', 'API\AssignPermissionModel@getPermissionsByUser');
Route::post('/change_password', 'API\UsersController@changePassword');

Route::get('/user_details/{user_id}', 'API\UsersController@userDetails');
Route::post('/users_update', 'API\UsersController@update');

Route::get('/home_lang_data', 'API\LanguageController@homeLangData');

Route::post('/canvas_data_save', 'API\Byr_orderController@canvasDataSave');
Route::post('load_canvas_data/{cmn_scenario_id}', 'API\Byr_orderController@canvasAllData');
Route::post('/delete_canvas', 'API\Byr_orderController@deleteCanvasData');
		// Route::post('/permission_check', 'API\PermissionController@check');
        
Route::post('scenario_exec/{cmn_scenario_id}', 'API\Cmn_ScenarioController@exec');
Route::post('job_exec/{cmn_scenario_id}', 'API\Cmn_jobController@exec');
Route::get('/slr_job_list_by_seller_id/{slr_seller_id}', 'API\Cmn_jobController@slr_job_list_by_seller_id');

Route::post('/load_canvas_setting_data', 'API\Byr_orderController@canvasSettingData');
Route::get('/company_user_list/{cmn_company_id}', 'API\Jacos_managementController@company_user_list');
// Route::get('/company_seller_user_list/{cmn_company_id}', 'API\Jacos_managementController@company_seller_user_list');
Route::get('/company_partner_list/{byr_buyer_id}', 'API\Jacos_managementController@company_partner_list');
Route::get('/get_scenario_list', 'API\Cmn_ScenarioController@get_scenario_list');
Route::get('/slr_management/{adm_user_id}', 'API\Jacos_managementController@slr_management');
Route::get('/get_byr_order_list/{adm_user_id}', 'API\Byr_orderController@get_byr_order_list');
Route::get('/get_all_byr_company_list/{adm_user_id}', 'API\Jacos_managementController@get_all_byr_company_list');
Route::post('/update_shipment_detail', 'API\Byr_orderController@update_shipment_detail');
Route::post('/byr_buyer_user_create', 'API\Jacos_managementController@byr_buyer_user_create');
Route::post('/slr_seller_user_create', 'API\Jacos_managementController@slr_seller_user_create');
Route::post('/byr_company_create', 'API\Jacos_managementController@byr_company_create');
Route::post('/slr_company_create', 'API\Jacos_managementController@slr_company_create');
Route::get('/get_byr_info_by_byr_order_id/{byr_order_id}', 'API\Byr_orderController@get_byr_info_by_byr_order_id');
Route::get('/dispaly_col_by_user/{url_slug}/{user_id}', 'API\Tbl_col_settingController@dispaly_col_by_user');

Route::post('/bms_order_save/{job_id}', 'API\BmsOrderController@store');
