<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Application\ProductController;
use App\Http\Controllers\Application\SpinnerController;
use App\Http\Controllers\Application\OrderController;
use App\Http\Controllers\Application\CartController;
use App\Http\Controllers\Application\UserController;
use App\Http\Controllers\Application\UserDashboardController;
use App\Http\Controllers\Application\UserCartController;
use App\Http\Controllers\Application\FawryPaymentController;
use App\Http\Controllers\Application\GeneralAPIController;
use App\Http\Controllers\Application\CategoriesController;
use App\Http\Controllers\Application\HomeController;
use App\Http\Controllers\Application\PayByWalletController;
use App\Http\Controllers\Application\TestingOracleController;


Route::group(['middleware' => ['jwt.verify']], function () {

});


Route::post('sendUserToOracle', [TestingOracleController::class, 'sendUser']);
Route::post('sendUOrderToOracle', [TestingOracleController::class, 'sendOrder']);
//testing only
//Route::post('changePassword', [TestingOracleController::class, 'changePassword']);
//Route::get('stock', [OrderController::class, 'stockManagement']);
//Route::post('testPay', [TestingOracleController::class, 'testPay']);

Route::post('updateTableJS', [\App\Http\Controllers\Admin\OracleProductsController::class, 'updateTableJS']);


Route::get("test", function () {
    echo "dasd";
});







