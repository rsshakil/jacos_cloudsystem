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
Route::post('/load_canvas_data', 'API\Byr_orderController@canvasAllData');
Route::post('/delete_canvas', 'API\Byr_orderController@deleteCanvasData');
		// Route::post('/permission_check', 'API\PermissionController@check');
        
Route::post('scenario_exec/{cmn_scenario_id}', 'API\Cmn_ScenarioController@exec');

Route::post('/load_canvas_setting_data', 'API\Byr_orderController@canvasSettingData');