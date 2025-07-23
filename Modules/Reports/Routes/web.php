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
use Modules\Reports\Http\Controllers\ReportsController;
use Modules\Reports\Http\Controllers\AllReportsController;

Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' =>['CheckActiveSession','admin:admin,/admin/login']], static function () {


    Route::get('/all-reports/index', [ReportsController::class, "index"])->name('all-reports.index');

    Route::get('/users-reports/index', [AllReportsController::class, "index"])->name('users-reports.index');
    Route::get('/users-reports/search', [AllReportsController::class, "index"])->name('users-reports.search');
    Route::get('/get/all-users', [AllReportsController::class, "all_users"])->name('get.all-users');

    Route::get('/all-reports/search', [ReportsController::class, "index"])->name('all-reports.search');
    Route::post('/all-reports/excel', [ReportsController::class, "excel"])->name('all-reports.excel');




});
