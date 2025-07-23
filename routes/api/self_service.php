<?php
use App\Http\Controllers\Api\SelfService\SelfServiceController;



Route::get( '/self-service-companies', [SelfServiceController::class,"companies"]);
Route::get( '/self-service-packages/{id}', [SelfServiceController::class,"packages"]);
