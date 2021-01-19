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
        // 'byrorders' => 'API\Byr_orderController',
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
		'get_all_buyer' => 'API\BYR\ByrController'
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
Route::get('/get_permission_model/{id?}', 'API\AssignPermissionModel@getPermissionModel');
Route::post('/assign_permission_to_user', 'API\AssignPermissionModel@assignPermissionToModel');

Route::post('/get_permission_for_roles', 'API\AssignPermissionModel@getPermissionsByRole');
Route::post('/permissions_by_users', 'API\AssignPermissionModel@getPermissionsByUser');
Route::post('/change_password', 'API\UsersController@changePassword');

Route::get('/user_details/{user_id}', 'API\UsersController@userDetails');
Route::post('/users_update', 'API\UsersController@update');

Route::get('/home_lang_data', 'API\LanguageController@homeLangData');


		// Route::post('/permission_check', 'API\PermissionController@check');
        
Route::post('scenario_exec', 'API\Cmn_ScenarioController@exec');
Route::post('job_exec', 'API\Cmn_jobController@exec');
Route::get('/slr_job_list_by_seller_id/{slr_seller_id}', 'API\Cmn_jobController@slr_job_list_by_seller_id');

Route::get('/cmn_company_user_list/{cmn_company_id?}', 'API\BYR\ByrController@cmn_company_user_list');
// Route::get('/company_seller_user_list/{cmn_company_id}', 'API\BYR\ByrController@company_seller_user_list');
Route::get('/company_partner_list/{cmn_company_id}', 'API\BYR\ByrController@company_partner_list');
Route::get('/get_byr_slr_company/{cmn_company_id?}', 'API\BYR\ByrController@get_byr_slr_company');

Route::get('/get_scenario_list', 'API\Cmn_ScenarioController@get_scenario_list');
Route::get('/slr_management/{adm_user_id}', 'API\BYR\ByrController@slr_management');
Route::post('/get_byr_order_list', 'API\Byr_orderController@get_byr_order_list');
Route::get('/get_all_company_list/{adm_user_id}', 'API\BYR\ByrController@get_all_company_list');
Route::post('/update_shipment_detail', 'API\Byr_orderController@update_shipment_detail');
Route::post('/update_shipment_detail_bycurrentdatetime', 'API\Byr_orderController@update_shipment_detail_bycurrentdatetime');
Route::post('/cmn_user_create', 'API\BYR\ByrController@cmn_user_create');
Route::post('/slr_seller_user_create', 'API\BYR\ByrController@slr_seller_user_create');
Route::post('/create_buyer', 'API\BYR\ByrController@createBuyer');
Route::post('/slr_company_create', 'API\BYR\ByrController@slr_company_create');
Route::post('/get_byr_info_by_byr_order_id', 'API\Byr_orderController@get_byr_info_by_byr_order_id');
Route::get('/dispaly_col_by_user/{url_slug}/{user_id}', 'API\Tbl_col_settingController@dispaly_col_by_user');

Route::post('/bms_order_save/{job_id}', 'API\BmsOrderController@store');
Route::get('/get_bms_order_byr_order_id/{byr_order_id}', 'API\Byr_orderController@get_bms_order_byr_order_id');
Route::post('/update_byr_order_detail_status', 'API\Byr_orderController@update_byr_order_detail_status');
Route::post('item_master_exec', 'API\Cmn_jobController@exec');
// Route::post('bms_csv_exec', 'API\Cmn_jobController@exec');
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
Route::post('/load_canvas_data', 'API\Byr_orderController@canvasAllData');
Route::post('/delete_canvas', 'API\Byr_orderController@deleteCanvasData');
Route::post('/shipment_csv_create', 'API\ShipmentConroller@shipmentCSVCreate');

Route::post('/get_permissions_for_buyer', 'API\BYR\ByrController@getPermissionForBuyer');
Route::post('/get_seller_list', 'API\BYR\ByrController@getSellerList');
Route::post('/buyer_partner_create', 'API\BYR\ByrController@buyerPartnerCreate');
// Route::post('/order_create_fixed_length', 'API\BmsOrderController@orderCreateDeleteFixedLength');
// Route::post('/delete_old_files', 'API\BmsOrderController@orderCreateDeleteFixedLength');

Route::post('/load_pdf_platform_canvas_setting_data', 'API\CmnPdfPlatformSettings@canvasSettingData');
Route::post('/pdf_platform_canvas_data_save', 'API\CmnPdfPlatformSettings@canvasDataSave');
Route::post('load_pdf_platform_canvas_data/{cmn_scenario_id}', 'API\CmnPdfPlatformSettings@pdfPlatformAllData');
Route::post('/delete_pdf_platform_canvas', 'API\CmnPdfPlatformSettings@deleteCanvasData');
Route::post('/blog_create', 'API\Cmn_blogController@store');
Route::get('/get_all_blog_list', 'API\Cmn_blogController@index');
Route::get('/get_all_published_blog_list', 'API\Cmn_blogController@get_all_published_blog_list');
Route::get('/get_signle_top_blog', 'API\Cmn_blogController@get_signle_top_blog');
Route::get('/get_user_top_blog', 'API\Cmn_blogController@get_user_top_blog');
Route::get('/get_user_top_blog_by_byr_id/{byr_buyer_id}', 'API\Cmn_blogController@get_user_top_blog_by_byr_id');
Route::post('/update_blog_infos', 'API\Cmn_blogController@update_blog_infos');
Route::post('/ckeditor_file_up', 'API\Cmn_blogController@ckeditor_file_up');

Route::post('/get_byr_slr_data', 'API\Byr_orderController@getByrSlrData');
Route::post('/order_details', 'API\Byr_orderController@orderDetails');
Route::get('/order_item_details/{data_shipment_voucher_id}', 'API\Byr_orderController@orderItemDetails');

// level3
Route::post('get_user_login', 'API\Level3\Level3Controller@userLogin');
Route::post('history_url', 'API\Level3\Level3Controller@historyData');
Route::post('get_customer', 'API\Level3\Level3Controller@getCustomer');
// Route::post('delete_customer', 'API\Level3\Level3Controller@deleteCustomer');
Route::post('show_service_url', 'API\Level3\Level3Controller@showServiceData');
Route::post('add_service', 'API\Level3\Level3Controller@addService');
Route::post('get_schedule_data', 'API\Level3\Level3Controller@scheduleData');
Route::post('set_schedule_data', 'API\Level3\Level3Controller@setScheduleData');
Route::post('set_file_path', 'API\Level3\Level3Controller@setFilePath');
Route::post('set_job_data', 'API\Level3\Level3Controller@setJobData');
Route::post('lv3_schedule_data', 'API\Level3\Level3Controller@lv3ScheduleData');
Route::post('get_service_data', 'API\Level3\Level3Controller@getServiceData');
Route::post('history_create', 'API\Level3\Level3Controller@historyCreate');
Route::post('job_scenario', 'API\Level3\Level3Controller@jobScenario');
Route::get('slr_job_list_all', 'API\Cmn_jobController@index');

// Route::post('schedule_file_data', 'API\Level3\Level3Controller@setScheduleFileData');


// Route::post('get_file_path', 'ApiController@getFilePath');


// Route::post('file_send_url', 'API\Level3\Level3Controller@fileSave');
// Route::post('get_shipment_file', 'API\Level3\Level3Controller@getShipmentFile');

// Route::post('add_customer', 'API\Level3\Level3Controller@addCustomer');



Route::post('delete_service', 'API\Level3\Level3Controller@deleteService');
Route::post('/job_list', 'API\Level3\Level3Controller@job_list');

//get user company byr slr list
Route::post('/get_user_company_byr_slr_list', 'API\UsersController@get_user_company_byr_slr_list');
Route::get('/get_selected_byr_info/{byr_buyer_id}', 'API\SLR\SlrController@get_selected_byr_info');
