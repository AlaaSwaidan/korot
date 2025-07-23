<?php

use Modules\Role\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\GeadiaWalletController;

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

//    Route::resource('admins', 'AdminController');
//
    Route::get('/geadia-wallet/index', [GeadiaWalletController::class, "index"])->name('geadia-wallet.index');
    Route::resource('roles', RoleController::class, ['except' => 'destroy']);


    Route::post('/roles/destroy', [RoleController::class, "destroy"])->name('roles.destroy');

});
