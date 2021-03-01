<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CMN\cmn_connect;
use App\Models\CMN\cmn_company;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
// use DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('language/{locale}', function ($locale) {
    // return $locale;
    Session::put('locale',$locale);
    App::setLocale($locale);
    // return App::getLocale();
    return redirect()->back();
});
Route::get('/', function () {
	// return view('frontend.welcome');
	return redirect('login');
});
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::post('/user', function(Request $request){
    $user_image=Auth::user()->image;
    $user=Auth::User();
    $user['image']=$user_image;
    return $user;
    // return response()->json(['user'=>$user]);
});
Route::get('/{any}', 'HomeController@index')->where('any', '.*');

