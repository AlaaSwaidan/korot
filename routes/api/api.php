<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\CronjobController;

use App\Http\Controllers\Api\ExternalServiceController;

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
Route::get( '/cancel-order-cron-job', [CronjobController::class,"cancel_order"]);
Route::get( '/duplicate-cards-cron-job', [CronjobController::class,"duplicate_cards"]);
Route::post('/test', function (Request $request) {

    $curl = curl_init();
    $time= \Carbon\Carbon::now()->timestamp;
    $hash = $time;

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://taxes.like4app.com/online/create_order",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => array(
            'deviceId' => 'b747d1ae288d896d47ba16008dee40eca58ce6e24d2ba6df0e442021d2df06824e5605e957142170b3bb2a2257ece83d',
            'email' => '3lialmuslem@gmail.com',
            'password' => '18c5fd46f0d3ba3929b88feb9e1c4ebe8cd66a5db9a5dd3363f991c727530e5917b96f86a92c4742e9ce77c8a6cf59ec',
            'securityCode' => 'acc14e116a8e14df8214abf86ab278aea3890df6b6c035414cde75980c2841278ea74f03ce108bd587516eb817eb18e7',
            'langId' => '1',
            'productId' => '376',
            'referenceId' => 'Merchant_12467',
            'time' => $time,
            'hash' => generateHash($hash),
        ),

    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return \App\Http\Controllers\Api\ApiController::respondWithSuccess(json_decode($response));
});

Route::namespace('Api')->middleware(['Lang'])->group( function () {
    include 'merchant.php';
    include 'distributor.php';
    include 'self_service.php';
    Route::get( '/update-version', [ApiController::class,"update_version"]);
    Route::get( '/shutdown-app', [ApiController::class,"shutdown_app"]);

    Route::get( '/distributor-update-version', [ApiController::class,"distributor_update_version"]);
    Route::get( '/all-orders', [ApiController::class,"my_orders"]);



    Route::middleware('check.token')->group(function () {
        Route::get( '/get-all-invoices', [ExternalServiceController::class,"external_service"]);
        Route::get( '/getinvoices', [ExternalServiceController::class,"all_service"]);
        Route::get( '/get-all-merchant-of-invoices', [ExternalServiceController::class,"external_merchant_service"]);

        // other protected routes
    });

    Route::group(['middleware' =>['jwt.verify','MerchantType']], function () {


        Route::get( '/list-notifications', [NotificationController::class,"listNotifications"]);
        Route::post( '/delete-notifications/{id}', [NotificationController::class,"delete_Notifications"]);
        Route::post( '/delete-all-notifications', [NotificationController::class,"delete_all_Notifications"]);

    });

});
