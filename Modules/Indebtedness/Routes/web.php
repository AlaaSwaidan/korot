<?php

use Modules\Indebtedness\Http\Controllers\IndebtednessController;
use Modules\Indebtedness\Http\Controllers\AdminController;
use Modules\Indebtedness\Http\Controllers\MerchantController;
use Modules\Indebtedness\Http\Controllers\DistributorController;



Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['CheckActiveSession','admin:admin,/admin/login']], static function () {

    /*begin---merchants*/


    Route::resource('indebtedness', IndebtednessController::class, ['except' => 'destroy']);

    /*merchants*/
    Route::get('/indebtedness/view-indebtedness-merchants/{merchant}', [MerchantController::class, "view_indebtedness"])->name('indebtedness.view-indebtedness-merchants');
    Route::get('/indebtedness/add-indebtedness-merchants/{merchant}', [MerchantController::class, "add_indebtedness"])->name('indebtedness.add-indebtedness-merchants');
    Route::get('/indebtedness/add-repayment-merchants/{merchant}', [MerchantController::class, "add_repayment"])->name('indebtedness.add-repayment-merchants');
    Route::post('/indebtedness/store-indebtedness-merchant/{merchant}', [MerchantController::class, "store_indebtedness"])->name('indebtedness.store-indebtedness-merchant');
    Route::post('/indebtedness/store-repayment-merchant/{merchant}', [MerchantController::class, "store_repayment"])->name('indebtedness.store-repayment-merchant');
    /*end merchants*/
    /*admins*/
    Route::get('/indebtedness/view-indebtedness-admins/{admin}', [AdminController::class, "view_indebtedness"])->name('indebtedness.view-indebtedness-admins');
    Route::get('/indebtedness/add-indebtedness-admins/{admin}', [AdminController::class, "add_indebtedness"])->name('indebtedness.add-indebtedness-admins');
    Route::get('/indebtedness/add-repayment-admins/{admin}', [AdminController::class, "add_repayment"])->name('indebtedness.add-repayment-admins');
    Route::post('/indebtedness/store-indebtedness-admins/{admin}', [AdminController::class, "store_indebtedness"])->name('indebtedness.store-indebtedness-admins');
    Route::post('/indebtedness/store-repayment-admins/{admin}', [AdminController::class, "store_repayment"])->name('indebtedness.store-repayment-admins');
    /*end admins*/
    /*distributors*/
    Route::get('/indebtedness/view-indebtedness-distributors/{distributor}', [DistributorController::class, "view_indebtedness"])->name('indebtedness.view-indebtedness-distributors');
    Route::get('/indebtedness/add-indebtedness-distributors/{distributor}', [DistributorController::class, "add_indebtedness"])->name('indebtedness.add-indebtedness-distributors');
    Route::get('/indebtedness/add-repayment-distributors/{distributor}', [DistributorController::class, "add_repayment"])->name('indebtedness.add-repayment-distributors');
    Route::post('/indebtedness/store-indebtedness-distributors/{distributor}', [DistributorController::class, "store_indebtedness"])->name('indebtedness.store-indebtedness-distributors');
    Route::post('/indebtedness/store-repayment-distributors/{distributor}', [DistributorController::class, "store_repayment"])->name('indebtedness.store-repayment-distributors');
    /*end distributors*/

    Route::get('/indebtedness/balance-distributors-pdf/{transfer}', [DistributorController::class, "generate_pdf"])->name('indebtedness.balance-distributors-pdf');
    Route::get('/indebtedness/balance-admin-pdf/{transfer}', [AdminController::class, "generate_pdf"])->name('indebtedness.balance-admin-pdf');
    Route::get('/indebtedness/balance-merchant-pdf/{transfer}', [MerchantController::class, "generate_pdf"])->name('indebtedness.balance-merchant-pdf');

    /*end -- merchants*/

    /*start search*/

    Route::get('/indebtedness/search-merchant/{merchant}', [MerchantController::class, "search"])->name('indebtedness.search.merchant');
    Route::get('/indebtedness/search-distributor/{distributor}', [DistributorController::class, "search"])->name('indebtedness.search.distributor');
    Route::get('/indebtedness/search-admin/{admin}', [AdminController::class, "search"])->name('indebtedness.search.admin');


    /*end -- search*/

});
