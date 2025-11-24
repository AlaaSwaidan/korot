<?php

use Modules\Processes\Http\Controllers\ProcessesController;
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

    Route::get('/processes/search', [ProcessesController::class, "search"])->name('processes.search');
    Route::post('/processes/excel', [ProcessesController::class, "excel"])->name('processes.excel');
    Route::post('/processes/pdf', [ProcessesController::class, "pdf"])->name('processes.pdf');
    Route::resource('processes', ProcessesController::class, ['except' => 'destroy']);

    /*start search*/





    /*end -- search*/

});
