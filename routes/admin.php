<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UsersController;

use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\OrderHeaderController;
use App\Http\Controllers\Admin\OracleInvoicesController;
use App\Http\Controllers\Admin\StoreInvoicesPrintController;
use App\Http\Controllers\Admin\PurchaseInvoicesController;
use App\Http\Controllers\Admin\ReportsController;

use App\Http\Controllers\Admin\OracleProductsController;

Route::get('/', '\App\Http\Controllers\Admin\AuthController@login');
Route::get('/login', '\App\Http\Controllers\Admin\AuthController@login')->name('adminLogin');
Route::get('/logout', '\App\Http\Controllers\Admin\AuthController@adminLogout')->name('adminLogout');

Route::post('/handleLogin', [AuthController::class, 'handleLogin'])->name('handleLogin');
Route::get('orderHeaders/storeorder', [OrderHeaderController::class, 'storeorder'])->name('orderHeaders.storeorder')->middleware(['auth:admin','roleChecker:super_admin,store_manager,manager_assistant,casher']);
Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('home', [HomeController::class, 'home'])->name('adminDashboard');

    Route::resource('users', 'UsersController')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('users/ImportUserSheet', [UsersController::class, 'importUserSheet'])->name('users.importUserSheet')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::post('users/ExportUserSheet', [UsersController::class, 'ExportUserSheet'])->name('users.ExportUserSheet')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::post('users/makeUserNewRecruit', [UsersController::class, 'makeUserNewRecruit'])->name('users.makeUserNewRecruit')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);

    Route::resource('countries', 'CountryController')->middleware(['roleChecker:super_admin,null,null']);
    Route::resource('digital_brochure', 'DigitalBrochureController')->middleware(['roleChecker:super_admin,null,null']);
    Route::resource('cities', 'CityController')->middleware(['roleChecker:super_admin,null,null']);
    Route::resource('areas', 'AreasController')->middleware(['roleChecker:super_admin,null,null']);
    Route::resource('banners', 'BannerController')->middleware(['roleChecker:super_admin,casher,null']);
    Route::resource('nettingJoin', 'NettingJoinController')->middleware(['roleChecker:super_admin,casher,null']);
    Route::resource('registerLinks', 'RegisterLinkController')->middleware(['roleChecker:super_admin,casher,null']);
    Route::resource('vouchers', 'VouchersController')->middleware(['roleChecker:super_admin,null,null']);


    Route::resource('sharePageCategories', 'SharePageCategoriesController')->middleware(['roleChecker:super_admin,casher,null']);
    Route::resource('sharePages', 'SharePageController')->middleware(['roleChecker:super_admin,casher,null']);
    Route::resource('spinnerCategories', 'SpinnerCategoriesController')->middleware(['roleChecker:super_admin,null,null']);
    Route::resource('spinners', 'SpinnerController')->middleware(['roleChecker:super_admin,null,null']);
    Route::resource('companies', 'CompanyController')->middleware(['roleChecker:super_admin,casher,null']);
    Route::post('companyChangeStatus/{id}', 'CompanyController@changeStatus')->middleware(['roleChecker:super_admin,casher,null'])->name('companyChangeStatus');
    Route::resource('staticPages', 'StaticPagesController')->middleware(['roleChecker:super_admin,casher,null']);
    Route::resource('filters', 'FiltersController')->middleware(['roleChecker:super_admin,casher,null']);
    Route::resource('welcome_program', 'WelcomeProgramController')->middleware(['roleChecker:super_admin,casher,null']);
    Route::post('welcome_program/deleteProduct', 'WelcomeProgramController@deleteProduct')->name('welcome_program.deleteProduct')->middleware(['roleChecker:super_admin,casher,null']);
    Route::resource('reviews', 'ReviewsController')->middleware(['roleChecker:super_admin,casher,null']);
    Route::get('mainCategory/{parent_id?}', [ProductCategoryController::class, 'getProductsCategories'])->name('productsCategories.mainCategory')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('categoryChangeStatus/{id}', 'ProductCategoryController@changeStatus')->middleware(['roleChecker:super_admin,casher,null'])->name('categoryChangeStatus');

    Route::get('mainCategory/viewGraph/{category}', [ProductCategoryController::class, 'viewGraph'])->name('productsCategories.viewGraph')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('deleteCategoryProduct/{id}', [ProductCategoryController::class, 'deleteCategoryProduct'])->name('deleteCategoryProduct')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::post('addCategoryProduct', [ProductCategoryController::class, 'addCategoryProduct'])->name('addCategoryProduct')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::get('subCategory', [ProductCategoryController::class, 'getSubProductsCategories'])->name('productsCategories.subCategory')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('mainCategory/{category}/edit', [ProductCategoryController::class, 'editProductsCategories'])->name('productsCategories.edit')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('mainCategory/{category}/delete', [ProductCategoryController::class, 'deleteProductsCategories'])->name('productsCategories.delete')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::get('subCategory/{category}/edit', [ProductCategoryController::class, 'editSubProductsCategories'])->name('productsCategories.subCategoryEdit')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::put('updateSubProductsCategories/{category}/edit', [ProductCategoryController::class, 'updateSubProductsCategories'])->name('productsCategories.subCategoryUpdate')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::put('mainCategory/{category}/edit', [ProductCategoryController::class, 'updateProductsCategories'])->name('productsCategories.update')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('mainCategory/store', [ProductCategoryController::class, 'storeProductsCategories'])->name('productsCategories.store')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::get('mainCategory/store/create', [ProductCategoryController::class, 'createProductsCategories'])->name('productsCategories.create')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::get('storeSubCategory/store', [ProductCategoryController::class, 'addProductsSubCategories'])->name('productsCategories.storeSubCategory')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::post('storeSubCategory/store', [ProductCategoryController::class, 'storeProductsSubCategories'])->name('productsCategories.storeSubCategory')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::get('getCteroires', [ProductCategoryController::class, 'getCteroires'])->name('getCteroires')->middleware(['roleChecker:super_admin,null,null']);

    Route::resource('products', 'ProductsController')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);

    Route::get('products/Export/ProductsSheet', [ProductsController::class, 'ExportProductsSheet'])->name('products.ExportProductsSheet')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('products/change/Status', [ProductsController::class, 'changeStatus'])->name('products.changeStatus')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::resource('orderHeaders', 'OrderHeaderController')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('orderHeaders/view/{id}', [OrderHeaderController::class, 'view'])->name('orderHeaders.view')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('orderHeaders/print80c/{id}', [OrderHeaderController::class, 'print80c'])->name('orderHeaders.print80c')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('orderHeaders/ExportOrderHeadersSheet', [OrderHeaderController::class, 'ExportOrderHeadersSheet'])->name('orderHeaders.ExportOrderHeadersSheet')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('orderHeaders/ImportOrderSheet', [OrderHeaderController::class, 'importOrderSheet'])->name('orderHeaders.importOrderSheet')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::post('orderHeaders/ExportOrderCharge', [OrderHeaderController::class, 'ExportOrderCharge'])->name('orderHeaders.ExportOrderCharge')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('orderHeaders/changeOrderChargeStatus', [OrderHeaderController::class, 'changeOrderChargeStatus'])->name('orderHeaders.changeOrderChargeStatus')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('orderHeaders/cancelOrderCharge', [OrderHeaderController::class, 'cancelOrderCharge'])->name('orderHeaders.cancelOrderCharge')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('orderHeaders/cancelOrderQuantity', [OrderHeaderController::class, 'cancelOrderQuantity'])->name('orderHeaders.cancelOrderQuantity')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('orderHeaders/CreatePickupRequest', [OrderHeaderController::class, 'CreatePickupRequest'])->name('orderHeaders.CreatePickupRequest')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('orderHeaders/getAllproducts', [OrderHeaderController::class, 'getAllproducts']);
    Route::post('orderHeaders/CalculateProductsAndShipping', [OrderHeaderController::class, 'CalculateProductsAndShipping']);
    Route::post('orderHeaders/makeOrderPayInAdmin', [OrderHeaderController::class, 'makeOrderPayInAdmin']);
    Route::post('orderHeaders/getAllOrdersWithType', [OrderHeaderController::class, 'getAllOrdersWithType']);
    Route::post('orderHeaders/getAdminPrinteOrder', [OrderHeaderController::class, 'getAdminPrinteOrder']);
    Route::post('orderHeaders/getAreasByCityID', [OrderHeaderController::class, 'getAreasByCityID']);
    Route::post('orderHeaders/getSearchUserByName', [OrderHeaderController::class, 'getSearchUserByName']);
    Route::post('orderHeaders/getUserByName', [OrderHeaderController::class, 'getUserByName']);
    Route::resource('commissions', 'CommissionController')->middleware(['roleChecker:super_admin,null,null']);

    Route::resource('monthcommissions', 'MonthlyCommissionController')->middleware(['roleChecker:super_admin,null,null']);

    Route::get('levels', 'LevelsController@index')->name('levels')->middleware(['roleChecker:super_admin,null,null']);
    Route::get('wallets', 'WalletController@index')->name('wallets')->middleware(['roleChecker:super_admin,null,null']);

    Route::resource('notifications', 'NotificationsController')->middleware(['roleChecker:super_admin,casher,null']);
    Route::resource('accountTypes', 'AccountTypesController')->middleware(['roleChecker:super_admin,null,null']);
    Route::resource('AcceptedVersion', 'AcceptedVersionController')->middleware(['roleChecker:super_admin,null,null']);
    Route::get('orderHeaders/Export/ExportShippingSheetSheet', [OrderHeaderController::class, 'ExportShippingSheetSheet'])->name('orderHeaders.ExportShippingSheetSheet')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('orderHeaders/Export/ExportShippingSheetSheet', [OrderHeaderController::class, 'HandelExportShippingSheetSheet'])->name('orderHeaders.HandelExportShippingSheetSheet')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);

    Route::get('orderHeaders/change/order', [OrderHeaderController::class, 'ChangeStatusForOrder'])->name('orderHeaders.ChangeStatusForOrder')->middleware(['roleChecker:super_admin,null,null']);
    Route::post('orderHeaders/change/order', [OrderHeaderController::class, 'HandelChangeStatusForOrder'])->name('orderHeaders.HandelChangeStatusForOrder')->middleware(['roleChecker:super_admin,null,null']);
    Route::get('orderHeaders/change/getOracleNumberByOrderId', [OrderHeaderController::class, 'getOracleNumberByOrderId'])->name('orderHeaders.getOracleNumberByOrderId');
    Route::get('products/change/barcode', [ProductsController::class, 'productsBarcode'])->name('products.barcode');
    Route::post('products/updateNewBarcode', [ProductsController::class, 'updateNewBarcode'])->name('products.updateNewBarcode');
// OracleInvoices
    Route::get('oracleInvoices', [OracleInvoicesController::class, 'index'])->name('oracleInvoices.index')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('updateOracleInvoices', [OracleInvoicesController::class, 'updateOracleInvoices'])->name('updateOracleInvoices')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('refreshOracleInvoices', [OracleInvoicesController::class, 'refreshOracleInvoices'])->name('refreshOracleInvoices')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('oracleInvoices/ExportOracleInvoicesSheet', [OracleInvoicesController::class, 'ExportOracleInvoicesSheet'])->name('oracleInvoices.ExportOracleInvoicesSheet')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);

// Store Invoices To print
    Route::get('storeInvoicesPrint', [StoreInvoicesPrintController::class, 'index'])->name('storeInvoicesPrint.index')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('storeInvoicesPrint/printInvoice/{id}', [StoreInvoicesPrintController::class, 'printInvoice'])->name('storeInvoicesPrint.printInvoice')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);

    Route::get('updateProducts', [OracleProductsController::class, 'updateProductsCodes'])->name('updateOracleProducts')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::get('getProducts', [OracleProductsController::class, 'index'])->name('getOracleProducts')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::get('getOracleProduct', [OracleProductsController::class, 'getOracleProduct'])->name('getOracleProduct')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::get('getOneProductToProgram', [ProductsController::class, 'getOneProductToProgram'])->name('getOneProductToProgram')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::get('getOptionValues', [ProductsController::class, 'getOptionValues'])->name('getOptionValues')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::get('getAllProductsToProgram', [ProductsController::class, 'getAllProductsToProgram'])->name('getAllProductsToProgram')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);
    Route::get('updateProductsPrice', [OracleProductsController::class, 'updateProductsPrice'])->name('updateOracleProductsPrice')->middleware(['roleChecker:super_admin,store_manager,manager_assistant']);

    Route::resource('qrCodes', QrcodeController::class);
    Route::post('qrCodes/changeCodeStatus', [\App\Http\Controllers\Admin\QrcodeController::class, 'changeCodeStatus'])->name('changeCodeStatus');

// purchase Invoices
    Route::resource('purchaseInvoices', 'PurchaseInvoicesController')->middleware(['roleChecker:super_admin,casher,null']);
    Route::post('purchaseInvoices/CreatePurchaseInvoices', [PurchaseInvoicesController::class, 'CreatePurchaseInvoices']);
    Route::post('purchaseInvoices/getAllproducts', [PurchaseInvoicesController::class, 'getAllproducts']);
    Route::get('purchaseInvoices/Export/reports', [PurchaseInvoicesController::class, 'reports'])->name('orderHeaders.reports')->middleware(['roleChecker:super_admin,null,null']);

// reports
    Route::get('generalReports/report', [ReportsController::class, 'report'])->name('generalReports.report')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('generalReports/todayreport', [ReportsController::class, 'todayreport'])->name('generalReports.todayreport')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('generalReports/logout', [ReportsController::class, 'logout'])->name('generalReports.logout')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('generalReports/reports', [ReportsController::class, 'reports'])->name('generalReports.reports')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::get('generalReports/active_members', [ReportsController::class, 'active_members'])->name('generalReports.active_members')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);
    Route::post('generalReports/Export', [ReportsController::class, 'export'])->name('generalReports.export')->middleware(['roleChecker:super_admin,store_manager,manager_assistant,casher']);

});

