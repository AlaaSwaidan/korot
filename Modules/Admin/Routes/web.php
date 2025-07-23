<?php

use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\SearchController;

Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['CheckActiveSession','admin:admin,/admin/login'] ], static function () {

//    Route::resource('admins', 'AdminController');
//
    Route::get('/admins/search-admins', [SearchController::class, "search_admins"])->name('admins.search-admins');

    Route::resource('admins', AdminController::class, ['except' => 'destroy']);

    Route::post('/admins/destroy', [AdminController::class, "destroy"])->name('admins.destroy');
    Route::post('/admins/selected/destroy', [AdminController::class, "destroy_selected_rows"])->name('admins.selected.destroy');

    Route::get('/admins/change-password/{admin}', [AdminController::class, "showChangePasswordForm"])->name('admins.change-password');

    Route::post('/admins/change-password/{admin}', [AdminController::class, "updateAdminPassword"])->name('admins.post.change-password');

    Route::get( '/admins/profile-accounts/{admin}', [AdminController::class,"accounts"])->name('admins.profile-accounts');


    Route::get( '/admins/profile-prices/{admin}', [AdminController::class,"prices"])->name('admins.profile-prices');
    Route::get( '/admins/profile-transfers/{admin}', [AdminController::class,"transfers"])->name('admins.profile-transfers');
    Route::get( '/admins/profile-collections/{admin}', [AdminController::class,"collections"])->name('admins.profile-collections');
    Route::get( '/admins/profile-sales/{admin}', [AdminController::class,"sales"])->name('admins.profile-sales');
    Route::get( '/admins/profile-processes/{admin}', [AdminController::class,"processes"])->name('admins.profile-processes');
    Route::get( '/admins/profile-repayments/{admin}', [AdminController::class,"repayments"])->name('admins.profile-repayments');
    Route::get( '/admins/profile-collections-from-dis/{admin}', [AdminController::class,"collections_from_dis"])->name('admins.profile-collections-from-dis');
    Route::get( '/admins/profile-transfers-from-dis/{admin}', [AdminController::class,"transfers_to_dis"])->name('admins.profile-transfers-from-dis');

    Route::get( '/admins/profile-transfers-search/{admin}', [SearchController::class,"search_transfers"])->name('admins.profile-transfers-search');
    Route::get( '/admins/profile-collections-search/{admin}', [SearchController::class,"search_collections"])->name('admins.profile-collections-search');
    Route::get( '/admins/profile-repayments-search/{admin}', [SearchController::class,"search_repayments"])->name('admins.profile-repayments-search');
    Route::get( '/admins/profile-process-search/{admin}', [SearchController::class,"search_process"])->name('admins.profile-process-search');


    Route::post( '/admins/profile-transfers-excel', [SearchController::class,"excel_transfers"])->name('admins.profile-transfers-excel');
    Route::post( '/admins/profile-collections-excel', [SearchController::class,"excel_collection"])->name('admins.profile-collections-excel');
    Route::post( '/admins/profile-repayment-excel', [SearchController::class,"excel_repayment"])->name('admins.profile-repayment-excel');


});



