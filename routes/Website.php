<?php

use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\DigitalBrochureController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Admin\OracleProductsController;
use App\Http\Controllers\Admin\OracleInvoicesController;
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

Route::get('/shop/{id?}', 'CartController@shop')->name('shop');
Route::post('/shop/{id?}', 'CartController@search')->name('shop');
Route::get('/cart/{id?}', 'CartController@cart')->name('cart.index');

Route::post('/proceed', 'CartController@proceed')->name('cart.proceed');
Route::post('/add', 'CartController@add')->name('cart.store');
Route::post('/update', 'CartController@update')->name('cart.update');
Route::post('/remove', 'CartController@remove')->name('cart.remove');
Route::post('/clear', 'CartController@clear')->name('cart.clear');
Route::get('/fawry', 'CartController@fawry')->name('fawry');

// emad danial
Route::get('/registeruser', 'RegistrationController@create');
Route::post('/registeruser', 'RegistrationController@store');
Route::get('/beforeregister', 'RegistrationController@beforeRegister');
Route::get('/contactus', 'RegistrationController@contactus');
Route::get('/joinus', 'RegistrationController@joinus');
Route::get('/getCart', 'User\UserCartController@index');
Route::post('/joinus', 'RegistrationController@joinusPost');
Route::get('/login', 'RegistrationController@loginForm')->name('login');
Route::get('/forgot', 'RegistrationController@forgot')->name('forgot');
//Route::get('/testtest', 'RegistrationController@loginForm')->name('testtest');


Route::get('/updateProductsPriceOraclelJob', [OracleProductsController::class,'updateProductsPriceOraclelJob']);
Route::get('/updateInvoiceOraclelJob', [OracleInvoicesController::class,'updateInvoiceOraclelJob']);
Route::get('/sendOrderToOracleThatNotSending', [OracleProductsController::class,'sendOrderToOracleThatNotSending']);
Route::post('/sendOrderToOracleNotSending', [OracleProductsController::class,'sendOrderToOracleNotSending'])->name('sendOrderToOracleNotSending');

Route::post('/login', 'RegistrationController@signIn');
Route::post('/forgot', 'RegistrationController@forgotPost');

Route::group(['middleware' => ['auth']], function () {
    // members routes
    Route::post('/updateUser', 'RegistrationController@updateUser')->name('updateUser');
    Route::post('/addNewG1Member', 'RegistrationController@addNewG1Member')->name('addNewG1Member');
    Route::get('/getCheckout', 'User\UserCartController@getCheckout');
    Route::get('/signout', 'RegistrationController@signOut');
    Route::get('/orderSuccess/{id}', 'User\UserCartController@orderSuccess');
    Route::get('/orderDetails/{id}', 'User\UserCartController@orderDetails');
    Route::post('/saveWebOrder', 'User\UserCartController@saveWebOrder');
    Route::post('/saveProductReview', 'User\UserCartController@saveProductReview');
    Route::post('/checkWebOrder', 'User\UserCartController@checkWebOrder');
    Route::post('/addUserAddress', 'RegistrationController@addUserAddress');
    Route::post('/deleteUserAddress', 'RegistrationController@deleteUserAddress');
    Route::post('/updateUserProfileImage', 'RegistrationController@updateUserProfileImage');
    Route::post('/updateUserContactInformation', 'RegistrationController@updateUserContactInformation');
    Route::get('/memberProfile', 'User\MemberController@index');
    Route::post('/order/cancelMemberOrder', 'User\MemberController@cancelMemberOrder')->name('order.cancelMemberOrder');
    Route::post('/ExportActiveTeamSheet', 'User\MemberController@ExportActiveTeamSheet')->name('ExportActiveTeamSheet');
});
Route::post('/payWithfawry', 'User\UserCartController@payWithfawry')->name('payWithfawry');
Route::get('/returnFromfawry', 'User\UserCartController@returnFromfawry')->name('returnFromfawry');

Route::get('registrationfree/{id}/{token}', 'RegistrationController@createfree');
Route::post('registrationfree/{id}/{token}', 'RegistrationController@storefree');

Route::get('export', 'MyController@export')->name('export');
Route::get('importExportView', 'MyController@importExportView');
Route::post('import', 'MyController@import')->name('import');

Route::get('registration/{id}/{token}', 'RegistrationController@create');

Route::post('registration/{id}/{token}', 'RegistrationController@store');


Route::post('get-regions', 'RegistrationController@getRegions');
Route::post('get-cities', 'RegistrationController@getCities');


Route::get('fawry2', 'CartController@fawry2');


Route::get('complete', 'CartController@complete')->name('complete');
Route::post('complete', 'CartController@completestore');

Route::group(['middleware' => ['auth']], function () {
    /**
     * Logout Route
     */
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
});
//Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

Route::get('forgot/{id}/{token}', 'HomeController@forgot')->name('forgot/{id}/{token}');
Route::post('forgot/{id}', 'HomeController@updateforgot');
Route::post('/addSubscriberEmail', 'HomeController@addSubscriberEmail');
Route::post('/sendMessageEmail', 'HomeController@sendMessageEmail');
Route::get('paySuccess', 'HomeController@paySuccess')->name('paySuccess');
Route::get('/subscribers', 'HomeController@subscribers')->name('subscribers');

Route::get('/lang/{locale}', [HomeController::class, 'lang']);
// Route::get('/', function () {
//     return redirect((session()->get('locale'))?session()->get('locale'):app()->getLocale());
// });
//Route::post('/get-regions', [HomeController::class, 'getregions']);

// Route::group([
// 	'prefix' => '{locale}',
// 	'where' => ['locale' => '[a-zA-Z]{2}'],
// 	'middleware' => 'setlocale'], function() {

// 	})->defaults('locale', 'ar');

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/signup', function () {
    return view('signup');
});
Route::get('/category', [HomeController::class, 'category']);
Route::get('/deleteOldPendingOrder', [HomeController::class, 'deleteOldPendingOrder']);
Route::get('/changeOrderChargeStatusJob', [HomeController::class, 'changeOrderChargeStatusJob']);

Route::get('/page', function () {
    return view('index');
});
