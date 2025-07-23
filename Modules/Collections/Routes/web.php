<?php
use Modules\Collections\Http\Controllers\CollectionsDistributorController;
use Modules\Collections\Http\Controllers\CollectionsMerchantController;
use Modules\Collections\Http\Controllers\CollectionsController;
use Modules\Collections\Http\Controllers\CollectionsAdminController;
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

Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['CheckActiveSession','admin:admin,/admin/login']], static function () {

    /*begin---merchants*/


    Route::resource('collections', CollectionsController::class, ['except' => 'destroy']);

    /*merchants*/
    Route::get('/collections/view-collections-merchants/{merchant}', [CollectionsMerchantController::class, "view_collection"])->name('collections.view-collections-merchants');
    Route::get('/collections/add-collection-merchants/{merchant}', [CollectionsMerchantController::class, "add_collection"])->name('collections.add-collection-merchants');
    Route::post('/collections/store-collection-merchant/{merchant}', [CollectionsMerchantController::class, "store_collection"])->name('collections.store-collection-merchant');
    /*end merchants*/
    /*admins*/
    Route::get('/collections/view-collections-admins/{admin}', [CollectionsAdminController::class, "view_collection"])->name('collections.view-collections-admins');
    Route::get('/collections/add-collection-admins/{admin}', [CollectionsAdminController::class, "add_collection"])->name('collections.add-collection-admins');
    Route::post('/collections/store-collection-admins/{admin}', [CollectionsAdminController::class, "store_collection"])->name('collections.store-collection-admins');
    /*end admins*/
    /*distributors*/
    Route::get('/collections/view-collections-distributors/{distributor}', [CollectionsDistributorController::class, "view_collection"])->name('collections.view-collections-distributors');
    Route::get('/collections/add-collection-distributors/{distributor}', [CollectionsDistributorController::class, "add_collection"])->name('collections.add-collection-distributors');
    Route::post('/collections/store-collection-distributors/{distributor}', [CollectionsDistributorController::class, "store_collection"])->name('collections.store-collection-distributors');
    /*end distributors*/

    Route::get('/collections/balance-distributors-pdf/{collection}', [CollectionsDistributorController::class, "generate_pdf"])->name('collections.balance-distributors-pdf');
    Route::get('/collections/balance-admin-pdf/{collection}', [CollectionsAdminController::class, "generate_pdf"])->name('collections.balance-admin-pdf');
    Route::get('/collections/balance-merchant-pdf/{collection}', [CollectionsMerchantController::class, "generate_pdf"])->name('collections.balance-merchant-pdf');


    /*end -- merchants*/

    /*search */
    Route::get('/collections/search/merchant/{merchant}', [CollectionsMerchantController::class, "search"])->name('collections.search.merchant');
    Route::get('/collections/search/distributor/{distributor}', [CollectionsDistributorController::class, "search"])->name('collections.search.distributor');
    Route::get('/collections/search/admin/{admin}', [CollectionsAdminController::class, "search"])->name('collections.search.admin');

    /*end search */

});
