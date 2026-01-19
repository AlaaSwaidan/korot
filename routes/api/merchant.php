<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Merchant\AuthController;
use App\Http\Controllers\Api\Merchant\HomeController;
use App\Http\Controllers\Api\Merchant\ProfileController;
use App\Http\Controllers\Api\Merchant\TransactionController;
use App\Http\Controllers\Api\Merchant\ProfitsController;
use App\Http\Controllers\Api\Merchant\CreditController;
use App\Http\Controllers\Api\Merchant\IndebtednessController;
use App\Http\Controllers\Api\Merchant\OrderController;
use App\Http\Controllers\Api\Merchant\StatisticController;
use App\Http\Controllers\Api\ZainIntegrationController;
use App\Http\Controllers\Api\TwelveController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\Merchant\ToPupLikeCardController;
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
    Route::post( '/login', [AuthController::class,"login"]);

    Route::post( '/register', [AuthController::class,"register"]);
    Route::post( '/confirm-register', [AuthController::class,"confirm_register"]);
    Route::post( '/forget-password', [AuthController::class,"forgetPassword"]);
    Route::post( '/confirm-forget-password', [AuthController::class,"confirm_forget_password"]);
    Route::post( '/reset-password', [AuthController::class,"resetPassword"]);
    Route::get( '/terms-conditions', [ApiController::class,"terms_conditions"]);
    Route::group(['middleware' =>['jwt.verify','MerchantType']], function () {

        Route::post( '/logout', [AuthController::class,"logout"]);

        Route::get( '/all-companies/{id}', [HomeController::class,"all_companies"]);
        Route::get( '/companies', [HomeController::class,"companies"]);
        Route::get( '/departments', [HomeController::class,"departments"]);
        Route::get( '/categories/{id}', [HomeController::class,"categories"]);
        Route::get( '/packages/{id}', [HomeController::class,"packages"]);
        Route::get( '/profile', [ProfileController::class,"profile"]);
        Route::get( '/geidea-info', [ProfileController::class,"geidea_info"]);
        Route::post( '/edit-profile', [ProfileController::class,"edit_profile"]);
        Route::post( '/change-password', [ProfileController::class,"change_password"]);
        Route::get( '/transactions', [TransactionController::class,"transactions"]);
        Route::get( '/all-transactions', [TransactionController::class,"all_transactions"]);



        Route::post( '/transfer-profit-to-bank', [ProfitsController::class,"transfer_profit_to_bank"]);
        Route::post( '/add-profits-to-balance', [ProfitsController::class,"add_profits_to_balance"]);


        Route::get( '/bank-info', [CreditController::class,"bank_info"]);
        Route::post( '/buy-credit-bank-transfer', [CreditController::class,"buy_credit_bank_transfer"]);
        Route::post( '/buy-credit-online', [CreditController::class,"buy_credit_online"]);
        Route::post( '/charge-credit-online', [CreditController::class,"charge_credit_online"]);
        Route::post( '/confirm-credit-online', [CreditController::class,"confirm_credit_online"]);
        Route::get( '/credit-transaction', [CreditController::class,"credit_transaction"]);

        Route::post( '/indebtedness-bank-transfer', [IndebtednessController::class,"indebtedness_transfer_bank"]);
        Route::post( '/indebtedness-online', [IndebtednessController::class,"indebtedness_online"]);
        Route::post( '/add-order', [OrderController::class,"add_order"]);
        Route::post('/like4app/products', [ToPupLikeCardController::class, 'products']);

//        Route::post( '/add-topup', [ToPupLikeCardController::class,"toPupLikecard"]);
        Route::post( '/confirm-payment', [OrderController::class,"confirm_payment"]);
        Route::post( '/change-order-print-status', [OrderController::class,"change_order_print_status"]);
        Route::post( '/change-card-print-status', [OrderController::class,"change_card_print_status"]);
        Route::get( '/my-orders', [OrderController::class,"my_orders"]);
        Route::get( '/order-details/{id}', [OrderController::class,"order_details"]);
        Route::get( '/statistics', [StatisticController::class,"statistics"]);
        Route::get( '/merchant-reports', [StatisticController::class,"merchant_reports"]);
        Route::post( '/pay-zain', [ZainIntegrationController::class,"pinPrinting"]);
        Route::post('/purchase', [TwelveController::class, 'purchase']);
        Route::get('/products', [TwelveController::class, 'products']);
        Route::post('/categories', [TwelveController::class, 'categories']);
        Route::post('/productDetails/{product}', [TwelveController::class, 'productDetails']);
    });

});
