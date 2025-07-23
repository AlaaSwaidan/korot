<?php

use Modules\SendNotification\Http\Controllers\SendNotificationController;
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


//notifications
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' =>['CheckActiveSession','admin:admin,/admin/login']], static function () {


    Route::post( '/notifications/store', [SendNotificationController::class,"store"])->name('notifications.store');


    Route::get( '/notifications/create', [SendNotificationController::class,"create"])->name('notifications.create');


});

