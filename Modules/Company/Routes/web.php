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

Route::prefix('company')->group(function() {
    Route::get('/', 'CompanyController@index');
});
include 'stores.php';
include 'categories.php';
include 'packages.php';
include 'cards.php';
