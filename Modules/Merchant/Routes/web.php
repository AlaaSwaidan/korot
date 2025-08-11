<?php
use Modules\Merchant\Http\Controllers\NewMerchantController;
use Modules\Merchant\Http\Controllers\MerchantController;
use Modules\Merchant\Http\Controllers\MerchantPriceController;
use Modules\Merchant\Http\Controllers\SearchController;
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
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['CheckActiveSession','admin:admin,/admin/login'] ], static function () {

    /*begin---merchants*/
    Route::get( '/merchants/search', [SearchController::class,"search"])->name('merchants.search');

    Route::get( '/merchants/not-approved', [NewMerchantController::class,"index"])->name('merchants.not-approved');
    Route::post( '/merchants/accept-approve', [NewMerchantController::class,"accept_approve"])->name('merchants.accept-approve');
    Route::post( '/merchants/new/destroy', [NewMerchantController::class,"destroy"])->name('merchants.new.destroy');
    Route::post( '/merchants/new/selected/destroy', [NewMerchantController::class,"destroy_selected_rows"])->name('merchants.new.selected.destroy');


    Route::resource('merchants', MerchantController::class, ['except' => 'destroy']);
    Route::post( '/merchants/destroy', [MerchantController::class,"destroy"])->name('merchants.destroy');
    Route::post( '/merchants/destroy-token', [MerchantController::class,"destroy_token"])->name('merchants.destroy-token');
    Route::post( '/merchants/selected/destroy', [MerchantController::class,"destroy_selected_rows"])->name('merchants.selected.destroy');

    Route::get( '/merchants/change-password/{merchant}', [MerchantController::class,"showChangePasswordForm"])->name('merchants.change-password');

    Route::post( '/merchants/change-password/{merchant}', [MerchantController::class,"updateAdminPassword"])->name('merchants.post.change-password');
    Route::get( '/merchants/geidea-info/{merchant}', [MerchantController::class,"geidea_info"])->name('merchants.geidea-info');
    Route::get( '/merchants/edit-geidea-info/{merchant}', [MerchantController::class,"edit_geidea_info"])->name('merchants.edit-geidea-info');
    Route::patch( '/merchants/update-geidea/{merchant}', [MerchantController::class,"update_geidea"])->name('merchants.update-geidea');
    Route::get( '/merchants/profile-prices/{merchant}', [MerchantController::class,"prices"])->name('merchants.profile-prices');
    Route::get( '/merchants/profile-transfers/{merchant}', [MerchantController::class,"transfers"])->name('merchants.profile-transfers');
    Route::get( '/merchants/profile-collections/{merchant}', [MerchantController::class,"collections"])->name('merchants.profile-collections');
    Route::get( '/merchants/profile-sales/{merchant}', [MerchantController::class,"sales"])->name('merchants.profile-sales');
    Route::get( '/merchants/profile-processes/{merchant}', [MerchantController::class,"processes"])->name('merchants.profile-processes');
    Route::get( '/merchants/profile-accounts/{merchant}', [MerchantController::class,"accounts"])->name('merchants.profile-accounts');

    Route::get( '/merchants/profile-collections-search/{merchant}', [SearchController::class,"search_collections"])->name('merchants.profile-collections-search');
    Route::post( '/merchants/profile-collections-excel', [SearchController::class,"excel_collections"])->name('merchants.profile-collections-excel');

    Route::get( '/merchants/profile-transfers-search/{merchant}', [SearchController::class,"search_transfers"])->name('merchants.profile-transfers-search');
    Route::post( '/merchants/profile-transfers-excel', [SearchController::class,"excel_transfers"])->name('merchants.profile-transfers-excel');


    Route::get( '/merchants/profile-processes-search/{merchant}', [SearchController::class,"search_processes"])->name('merchants.profile-processes-search');


    Route::get( '/merchants/profile-sales-search/{merchant}', [SearchController::class,"search_sales"])->name('merchants.profile-sales-search');
    Route::post( '/merchants/profile-sales-excel', [SearchController::class,"excel_sales"])->name('merchants.profile-sales-excel');

    Route::get( '/merchants/profile-reports-sales/{merchant}', [MerchantController::class,"sales_reports"])->name('merchants.profile-reports-sales');
    Route::get( '/merchants/profile-reports-sales-print/{merchant}', [MerchantController::class,"sales_reports_print"])->name('merchants.profile-reports-sales-print');

    Route::get( '/merchants/profile-invoice-sales/{merchant}', [MerchantController::class,"sales_invoice"])->name('merchants.profile-invoice-sales');
    Route::get( '/merchants/profile-invoice-sales-print/{merchant}', [MerchantController::class,"sales_invoice_print"])->name('merchants.profile-invoice-sales-print');


    /*end -- merchants*/
    /* start merchants prices */
    Route::get( '/merchants/search/prices', [MerchantPriceController::class,"search"])->name('merchants.search.prices');
    Route::get( '/get/all-packages/{id}', [MerchantPriceController::class,"all_packages"])->name('get.all-packages');
    Route::get( '/get/all-imported-packages/{id}', [MerchantPriceController::class,"all_imported_packages"])->name('get.all-packages');
    Route::get( '/get/all-categories/{id}', [MerchantPriceController::class,"all_categories"])->name('get.all-packages');
    Route::patch( '/merchants/update-price/{merchant}', [MerchantPriceController::class,"update"])->name('merchants.update-price');
    Route::get( '/merchants/prices/{merchant}', [MerchantPriceController::class,"index"])->name('merchants.prices');
    Route::post( '/merchants/prices/selected/destroy', [MerchantPriceController::class,"destroy_selected_rows"])->name('merchants.selected.prices.destroy');
    Route::post( '/merchants/profile-prices/selected/destroy', [MerchantPriceController::class,"profile_destroy_selected_rows"])->name('merchants.selected.profile-prices.destroy');
    /* end merchants prices */
});
