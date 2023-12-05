<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::middleware('jwt.verify')
    ->namespace('Khaleds\Voucher\Http\Controllers\api')
        ->prefix('/api')
        ->group(function (){
            Route::post('setVoucher','VoucherController@setVoucher');
        });
});
