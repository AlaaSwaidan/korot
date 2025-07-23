<?php

use Modules\Company\Http\Controllers\Category\CategoryController;


/*begin---categories*/
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['CheckActiveSession','admin:admin,/admin/login'] ], static function () {

Route::resource('{company}/categories', CategoryController::class, ['except' => ['destroy','edit','update']]);
Route::post( '/categories/destroy', [CategoryController::class,"destroy"])->name('categories.destroy');
Route::post( '/categories/selected/destroy', [CategoryController::class,"destroy_selected_rows"])->name('categories.selected.destroy');
Route::get( '/categories/edit/{store}', [CategoryController::class,"edit"])->name('categories.edit');
Route::patch( '/categories/update/{store}', [CategoryController::class,"update"])->name('categories.update');

});
/*end -- categories*/

