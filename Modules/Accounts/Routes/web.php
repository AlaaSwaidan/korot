<?php

use Modules\Accounts\Http\Controllers\BanksController;
use Modules\Accounts\Http\Controllers\JournalsController;
use Modules\Accounts\Http\Controllers\OutgoingsController;
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
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' =>['CheckActiveSession','admin:admin,/admin/login']], static function () {

    Route::resource('banks', BanksController::class, ['except' => 'destroy']);
    Route::post('/banks/destroy', [BanksController::class, "destroy"])->name('banks.destroy');
    Route::post('/banks/selected/destroy', [BanksController::class, "destroy_selected_rows"])->name('banks.selected.destroy');

    Route::get('/journals/generate-pdf/{journal}', [JournalsController::class, "generate_pdf"])->name('journals.generate-pdf');

    Route::get('/journals/search', [JournalsController::class, "search"])->name('journals.search');

    Route::resource('journals', JournalsController::class, ['except' => 'destroy']);
    Route::post('/journals/destroy', [JournalsController::class, "destroy"])->name('journals.destroy');
    Route::post('/journals/selected/destroy', [JournalsController::class, "destroy_selected_rows"])->name('journals.selected.destroy');



    Route::resource('outgoings', OutgoingsController::class, ['except' => 'destroy']);
    Route::get( '/outgoings/confirm-page/{outgoing}', [OutgoingsController::class,"confirm_page"])->name('outgoings.confirm-page');
    Route::patch( '/outgoings/confirm/{outgoing}', [OutgoingsController::class,"confirm"])->name('outgoings.confirm');


    Route::post('/outgoings/destroy', [OutgoingsController::class, "destroy"])->name('outgoings.destroy');
    Route::post('/outgoings/selected/destroy', [OutgoingsController::class, "destroy_selected_rows"])->name('outgoings.selected.destroy');



});
