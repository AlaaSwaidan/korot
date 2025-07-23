<?php

use Modules\Company\Http\Controllers\Packages\PackageController;


/*begin---packages*/
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['CheckActiveSession','admin:admin,/admin/login']], static function () {

Route::resource('{category}/packages', PackageController::class, ['except' => ['destroy','edit','update']]);
Route::post( '/packages/destroy', [PackageController::class,"destroy"])->name('packages.destroy');
Route::post( '/packages/selected/destroy', [PackageController::class,"destroy_selected_rows"])->name('packages.selected.destroy');
Route::get( '/packages/edit/{package}', [PackageController::class,"edit"])->name('packages.edit');
Route::patch( '/packages/update/{package}', [PackageController::class,"update"])->name('packages.update');

});
/*end -- packages*/

