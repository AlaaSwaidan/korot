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
use Modules\Distributor\Http\Controllers\DistributorController;
use Modules\Distributor\Http\Controllers\SearchController;

Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' =>['CheckActiveSession','admin:admin,/admin/login'] ], static function () {

    /*begin---distributors*/
    Route::get( '/distributors/search', [SearchController::class,"search"])->name('distributors.search');
    Route::get( '/distributors/reports', [SearchController::class,"reports"])->name('distributors.reports');
    Route::post( '/distributors/print-reports', [SearchController::class,"generate_distributors_pdf"])->name('distributors.print-reports');

    Route::resource('distributors', DistributorController::class, ['except' => 'destroy']);
    Route::get( '/search-geadia-machine/search-machine', [DistributorController::class,"search_machine"])->name('search-geadia-machine.search-machine');
    Route::post( '/distributors/destroy', [DistributorController::class,"destroy"])->name('distributors.destroy');
    Route::post( '/distributors/destroy-token', [DistributorController::class,"destroy_token"])->name('distributors.destroy-token');
    Route::post( '/distributors/selected/destroy', [DistributorController::class,"destroy_selected_rows"])->name('distributors.selected.destroy');

    Route::get( '/distributors/profile-prices/{distributor}', [DistributorController::class,"prices"])->name('distributors.profile-prices');
    Route::get( '/distributors/profile-transfers/{distributor}', [DistributorController::class,"transfers"])->name('distributors.profile-transfers');
    Route::get( '/distributors/profile-collections/{distributor}', [DistributorController::class,"collections"])->name('distributors.profile-collections');
    Route::get( '/distributors/profile-sales/{distributor}', [DistributorController::class,"sales"])->name('distributors.profile-sales');
    Route::get( '/distributors/profile-processes/{distributor}', [DistributorController::class,"processes"])->name('distributors.profile-processes');

    Route::get( '/distributors/profile-accounts/{distributor}', [DistributorController::class,"accounts"])->name('distributors.profile-accounts');
    Route::get( '/distributors/search-by-merchants/{distributor}', [SearchController::class,"search_by_merchants"])->name('distributors.search-by-merchants');
    Route::post( '/distributors/transfers-to-merchants-excel', [SearchController::class,"transfers_collect_to_merchants_excel"])->name('distributors.transfers-to-merchants-excel');
    Route::post( '/distributors/distributors-merchants-excel', [SearchController::class,"distributor_merchants_excel"])->name('distributors.distributors-merchants-excel');
    Route::get( '/distributors/profile-collect-from-merchants/{distributor}', [DistributorController::class,"collect_from_merchants"])->name('distributors.profile-collect-from-merchants');
    Route::get( '/distributors/profile-transfers-to-merchants/{distributor}', [DistributorController::class,"transfers_to_merchants"])->name('distributors.profile-transfers-to-merchants');
    Route::get( '/distributors/profile-process-all-distributors-merchants/{distributor}', [DistributorController::class,"process_for_distributors_merchants"])->name('distributors.profile-process-all-distributors-merchants');
    Route::get( '/distributors/sales-distributors-merchants/{distributor}', [DistributorController::class,"sales_distributors_merchants"])->name('distributors.sales-distributors-merchants');
    Route::get( '/distributors/distributors-merchants/{distributor}', [DistributorController::class,"distributors_merchants"])->name('distributors.distributors-merchants');
    Route::get( '/distributors/add-merchants/{distributor}', [DistributorController::class,"add_merchants"])->name('distributors.add-merchants');
    Route::post( '/distributors/store-merchants/{distributor}', [DistributorController::class,"store_merchants"])->name('distributors.store-merchants');


    Route::get( '/distributors/search-orders-transaction/{distributor}', [SearchController::class,"search_orders_transaction"])->name('distributors.search-orders-transaction');
    Route::get( '/distributors/profile-process-search/{distributor}', [SearchController::class,"search_process"])->name('distributors.profile-process-search');
    Route::get( '/distributors/search-by-all-distributors-process/{distributor}', [SearchController::class,"search_by_distributors_process"])->name('distributors.search-by-all-distributors-process');
    Route::get( '/distributors/search-by-all-distributors-merchants-sales/{distributor}', [SearchController::class,"search_by_distributors_merchants_sales"])->name('distributors.search-by-all-distributors-merchants-sales');
    Route::post( '/distributors/excel-by-all-distributors-merchants-sales/{distributor}', [SearchController::class,"generate_pdf"])->name('distributors.excel-by-all-distributors-merchants-sales');

    Route::get( '/distributors/profile-transfers-search/{distributor}', [SearchController::class,"search_transfers"])->name('distributors.profile-transfers-search');
    Route::post( '/distributors/profile-transfers-excel', [SearchController::class,"excel_transfers"])->name('distributors.profile-transfers-excel');

    Route::get( '/distributors/profile-collections-search/{distributor}', [SearchController::class,"search_collections"])->name('distributors.profile-collections-search');
    Route::post( '/distributors/profile-collections-excel', [SearchController::class,"excel_collections"])->name('distributors.profile-collections-excel');

    Route::get( '/distributors/change-password/{distributor}', [DistributorController::class,"showChangePasswordForm"])->name('distributors.change-password');

    Route::post( '/distributors/change-password/{distributor}', [DistributorController::class,"updateAdminPassword"])->name('distributors.post.change-password');

    /*end -- distributors*/
});
