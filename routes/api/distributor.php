<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Distributor\AuthController;
use App\Http\Controllers\Api\Distributor\ProfileController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\Distributor\TransactionController;
use App\Http\Controllers\Api\Distributor\IndebtednessController;
use App\Http\Controllers\Api\Distributor\HomeController;
use App\Http\Controllers\Api\Distributor\HistoryController;
use App\Http\Controllers\Api\Distributor\ProfitsController;
use App\Http\Controllers\Api\Distributor\StatisticController;
use App\Http\Controllers\Api\Distributor\NotificationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::namespace('Api')->middleware(['Lang'])->group( function () {

    Route::get( '/pdf-transfer/{id}', [HistoryController::class,"generate_pdf_transfer"]);
    Route::get( '/pdf-collection/{id}', [HistoryController::class,"generate_pdf_collection"]);

    Route::post( '/distributor-login', [AuthController::class,"login"]);

    Route::post( '/distributor-register', [AuthController::class,"register"]);
    Route::post( '/distributor-confirm-register', [AuthController::class,"confirm_register"]);
    Route::post( '/distributor-forget-password', [AuthController::class,"forgetPassword"]);
    Route::post( '/distributor-confirm-forget-password', [AuthController::class,"confirm_forget_password"]);
    Route::post( '/distributor-reset-password', [AuthController::class,"resetPassword"]);
    Route::get( '/distributor-terms-conditions', [ApiController::class,"terms_conditions"]);
    Route::group(['middleware' =>['jwt.verify','DistributorType']], function () {

        Route::post( '/distributor-logout', [AuthController::class,"logout"]);
        Route::get( '/distributor-profile', [ProfileController::class,"profile"]);
        Route::post( '/distributor-edit-profile', [ProfileController::class,"edit_profile"]);
        Route::post( '/distributor-change-password', [ProfileController::class,"change_password"]);
        Route::get( '/distributor-transactions', [TransactionController::class,"transactions"]);
        Route::get( '/distributor-all-transactions', [TransactionController::class,"all_transactions"]);


        Route::post( '/distributor-indebtedness-bank-transfer', [IndebtednessController::class,"indebtedness_transfer_bank"]);
        Route::post( '/distributor-indebtedness-online', [IndebtednessController::class,"indebtedness_online"]);
        Route::get( '/distributor-merchants', [HomeController::class,"home"]);
        Route::post( '/transfer-to-merchant', [HomeController::class,"transfer_to_merchant"]);
        Route::get( '/generate-pdf-transfer-to-merchant/{id}', [HomeController::class,"generate_pdf_transfers_to_merchant"]);
        Route::get( '/generate-pdf-collect-from-merchant/{id}', [HomeController::class,"generate_pdf_collect_from_merchant"]);
        Route::post( '/collect-to-merchant', [HomeController::class,"collect_from_merchant"]);
        Route::get( '/distributor-merchants-all-transaction/{id}', [HomeController::class,"all_merchant_transaction"]);
        Route::get( '/distributor-merchants-details/{id}', [HomeController::class,"merchant_details"]);



        Route::get( '/history', [HistoryController::class,"history"]);
        Route::get( '/distributor-statistics', [StatisticController::class,"statistics"]);
        Route::post( '/transfer-distributor-profit-to-bank', [ProfitsController::class,"transfer_profit_to_bank"]);
        Route::post( '/add-distributor-profit-to-balance', [ProfitsController::class,"add_profits_to_balance"]);

        Route::get( '/distributor-list-notifications', [NotificationController::class,"listNotifications"]);
        Route::post( '/distributor-delete-notifications/{id}', [NotificationController::class,"delete_Notifications"]);
        Route::post( '/distributor-delete-all-notifications', [NotificationController::class,"delete_all_Notifications"]);


    });

});
