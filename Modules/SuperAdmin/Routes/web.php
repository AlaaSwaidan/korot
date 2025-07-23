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

use Modules\SuperAdmin\Http\Controllers\SuperAdminController;

Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['CheckActiveSession','admin:admin,/admin/login'] ], static function () {

    /*begin---super admins*/
    Route::resource('super-admins', SuperAdminController::class, ['except' => 'destroy']);
    Route::post('/super-admins/destroy', [SuperAdminController::class, "destroy"])->name('super-admins.destroy');

    Route::get('/super-admins/change-password/{superAdmin}', [SuperAdminController::class, "showChangePasswordForm"])->name('super-admins.change-password');

    Route::post('/super-admins/change-password/{superAdmin}', [SuperAdminController::class, "updateAdminPassword"])->name('super-admins.post.change-password');

    /*end -- super admins*/
});
