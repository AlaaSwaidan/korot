<?php
use Modules\Purchases\Http\Controllers\SuppliersController;
use Modules\Purchases\Http\Controllers\PurchaseOrdersController;
use Modules\Purchases\Http\Controllers\PurchasesController;
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
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' =>['CheckActiveSession','admin:admin,/admin/login'] ], static function () {

    Route::resource('suppliers', SuppliersController::class, ['except' => 'destroy']);
    Route::get( '/suppliers/invoices/{supplier}', [SuppliersController::class,"invoices"])->name('suppliers.invoices');
    Route::post( '/suppliers/destroy', [SuppliersController::class,"destroy"])->name('suppliers.destroy');
    Route::post( '/suppliers/selected/destroy', [SuppliersController::class,"destroy_selected_rows"])->name('suppliers.selected.destroy');

    /*end -- suppliers*/

    Route::get( '/get/all-packages', [PurchasesController::class,"index"])->name('all-packages');

    /* start purchase orders*/
    Route::resource('purchase-orders', PurchaseOrdersController::class, ['except' => 'destroy']);
    Route::post( '/purchase-orders/destroy', [PurchaseOrdersController::class,"destroy"])->name('purchase-orders.destroy');
    Route::get( '/purchase-orders/confirm-page/{purchaseOrder}', [PurchaseOrdersController::class,"confirm_page"])->name('purchase-orders.confirm-page');
    Route::patch( '/purchase-orders/confirm/{purchaseOrder}', [PurchaseOrdersController::class,"confirm"])->name('purchase-orders.confirm');
    Route::post( '/purchase-orders/selected/destroy', [PurchaseOrdersController::class,"destroy_selected_rows"])->name('purchase-orders.selected.destroy');

    /*end -- suppliers*/

});
