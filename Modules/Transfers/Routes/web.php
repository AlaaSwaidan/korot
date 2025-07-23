<?php

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

use Modules\Transfers\Http\Controllers\TransfersMerchantController;
use Modules\Transfers\Http\Controllers\TransfersAdminController;
use Modules\Transfers\Http\Controllers\TransfersDistributorController;


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
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' =>['CheckActiveSession','admin:admin,/admin/login']], static function () {

    /*begin---merchants*/


    Route::resource('transfers', TransfersMerchantController::class, ['except' => 'destroy']);

/*merchants*/
    Route::get('/transfers/view-transfers-merchants/{merchant}', [TransfersMerchantController::class, "view_transfer"])->name('transfers.view-transfers-merchants');
    Route::get('/transfers/add-transfer-merchants/{merchant}', [TransfersMerchantController::class, "add_transfer"])->name('transfers.add-transfer-merchants');
    Route::post('/transfers/store-transfer-merchant/{merchant}', [TransfersMerchantController::class, "store_transfer"])->name('transfers.store-transfer-merchant');
/*end merchants*/
    /*admins*/
    Route::get('/transfers/view-transfers-admins/{admin}', [TransfersAdminController::class, "view_transfer"])->name('transfers.view-transfers-admins');
    Route::get('/transfers/add-transfer-admins/{admin}', [TransfersAdminController::class, "add_transfer"])->name('transfers.add-transfer-admins');
    Route::post('/transfers/store-transfer-admins/{admin}', [TransfersAdminController::class, "store_transfer"])->name('transfers.store-transfer-admins');
/*end admins*/
    /*distributors*/
    Route::get('/transfers/view-transfers-distributors/{distributor}', [TransfersDistributorController::class, "view_transfer"])->name('transfers.view-transfers-distributors');
    Route::get('/transfers/add-transfer-distributors/{distributor}', [TransfersDistributorController::class, "add_transfer"])->name('transfers.add-transfer-distributors');
    Route::post('/transfers/store-transfer-distributors/{distributor}', [TransfersDistributorController::class, "store_transfer"])->name('transfers.store-transfer-distributors');
/*end distributors*/

    Route::get('/transfers/balance-distributors-pdf/{transfer}', [TransfersDistributorController::class, "generate_pdf"])->name('transfers.balance-distributors-pdf');
    Route::get('/transfers/balance-admin-pdf/{transfer}', [TransfersAdminController::class, "generate_pdf"])->name('transfers.balance-admin-pdf');
    Route::get('/transfers/balance-merchant-pdf/{transfer}', [TransfersMerchantController::class, "generate_pdf"])->name('transfers.balance-merchant-pdf');

    /*end -- merchants*/

    /*start search*/

    Route::get('/transfers/search-merchant/{merchant}', [TransfersMerchantController::class, "search"])->name('transfers.search.merchant');
    Route::get('/transfers/search-distributor/{distributor}', [TransfersDistributorController::class, "search"])->name('transfers.search.distributor');
    Route::get('/transfers/search-admin/{admin}', [TransfersAdminController::class, "search"])->name('transfers.search.admin');


    /*end -- search*/

});
