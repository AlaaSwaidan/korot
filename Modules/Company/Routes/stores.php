<?php

use Modules\Company\Http\Controllers\Store\StoreController;
use Modules\Company\Http\Controllers\Store\DepartmentController;


/*begin---stores*/

Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['CheckActiveSession','admin:admin,/admin/login'] ], static function () {

Route::resource('stores', StoreController::class, ['except' => 'destroy']);
Route::post( '/stores/destroy', [StoreController::class,"destroy"])->name('stores.destroy');
Route::post( '/stores/selected/destroy', [StoreController::class,"destroy_selected_rows"])->name('stores.selected.destroy');

Route::resource('departments', DepartmentController::class, ['except' => 'destroy']);
Route::post( '/departments/destroy', [DepartmentController::class,"destroy"])->name('stores.destroy');
Route::post( '/departments/selected/destroy', [DepartmentController::class,"destroy_selected_rows"])->name('stores.selected.destroy');

});
/*end -- merchants*/

