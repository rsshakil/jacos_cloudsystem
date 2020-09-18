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
Route::apiResources(

	[
		'master_item' => 'API\Byr_itemController'
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


		// Route::post('/permission_check', 'API\PermissionController@check');
        
Route::post('scenario_exec/{cmn_scenario_id}', 'API\Cmn_ScenarioController@exec');
Route::post('job_exec/{cmn_scenario_id}', 'API\Cmn_jobController@exec');
Route::get('/slr_job_list_by_seller_id/{slr_seller_id}', 'API\Cmn_jobController@slr_job_list_by_seller_id');

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
Route::get('/get_bms_order_byr_order_id/{byr_order_id}', 'API\Byr_orderController@get_bms_order_byr_order_id');
Route::post('/update_byr_order_detail_status', 'API\Byr_orderController@update_byr_order_detail_status');
Route::post('item_master_exec/{cmn_scenario_id}', 'API\Cmn_jobController@item_master_exec');
Route::get('get_all_master_item/{adm_user_id}', 'API\Byr_itemController@get_all_master_item');
Route::get('get_byr_order_receive_list/{adm_user_id}', 'API\Byr_order_receiveController@get_byr_order_receive_list');
Route::get('get_byr_order_corrected_receive_list/{adm_user_id}', 'API\Byr_order_receiveController@get_byr_order_corrected_receive_list');
Route::get('get_byr_payment_list/{adm_user_id}', 'API\Byr_paymentController@get_byr_payment_list');
Route::get('get_byr_return_list/{adm_user_id}', 'API\Byr_return_itemController@get_byr_return_list');
Route::get('get_all_cat_list/{adm_user_id}', 'API\Cmn_categoryController@get_all_cat_list');
Route::get('get_all_invoice_list/{adm_user_id}', 'API\Byr_invoiceController@get_all_invoice_list');
Route::get('get_all_invoice_detail_list/{byr_invoice_id}', 'API\Byr_invoiceController@get_all_invoice_detail_list');
Route::get('get_all_invoice_by_voucher_number/{voucher_number}', 'API\Byr_invoiceController@get_all_invoice_by_voucher_number');
Route::post('/cmn_category_create', 'API\Cmn_categoryController@store');

// Mayeen
Route::post('/load_canvas_setting_data', 'API\Byr_orderController@canvasSettingData');
Route::post('/canvas_data_save', 'API\Byr_orderController@canvasDataSave');
Route::post('load_canvas_data/{cmn_scenario_id}', 'API\Byr_orderController@canvasAllData');
Route::post('/delete_canvas', 'API\Byr_orderController@deleteCanvasData');

Route::post('/load_pdf_platform_canvas_setting_data', 'API\CmnPdfPlatformSettings@canvasSettingData');
Route::post('/pdf_platform_canvas_data_save', 'API\CmnPdfPlatformSettings@canvasDataSave');
Route::post('load_pdf_platform_canvas_data/{cmn_scenario_id}', 'API\CmnPdfPlatformSettings@pdfPlatformAllData');
Route::post('/delete_pdf_platform_canvas', 'API\CmnPdfPlatformSettings@deleteCanvasData');
