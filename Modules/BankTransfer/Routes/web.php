<?php
use Modules\BankTransfer\Http\Controllers\BankTransferController;

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

    Route::get('/transaction/index', [BankTransferController::class, "index"])->name('transaction.index');
    Route::post('/transaction/refuse', [BankTransferController::class, "refuse"])->name('transaction.refuse');
    Route::post('/transaction/accept', [BankTransferController::class, "accept"])->name('transaction.accept');


});
