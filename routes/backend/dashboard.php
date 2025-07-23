<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CurrencyController;
use Modules\Accounts\Http\Controllers\BanksController;
use Modules\Accounts\Http\Controllers\OutgoingsController;
use App\Http\Controllers\Admin\ExportSuspendedCardController;

/* start admin control*/
Route::get('/test', function () {
    //   $ids  =range(26000, 26856);
    // $orders = \App\Models\Order::whereIn('parent_id',$ids)->delete();
    // dd($orders);
//    $orders = \App\Models\Order::where('parent_id',null)->where('id','<=',1000)->get();
//    foreach ($orders as $order){
//        $order->update([
//            'total'=>$order->card_price
//        ]);
//        $newOrder = $order->replicate();
//        $newOrder->parent_id = $order->id;
//        $newOrder->save();
//    }
//    $orders = \App\Models\Order::where('parent_id',null)->where('id','>',1000)->where('id','<=',26856)->get();
//    foreach ($orders as $order){
//        $order->update([
//            'total'=>$order->card_price
//        ]);
//        $newOrder = $order->replicate();
//        $newOrder->parent_id = $order->id;
//        $newOrder->save();
//    }
});

Route::get( '/admin/login', [LoginController::class,"showLoginForm"])->name('admin.login');
Route::post( '/admin/login', [LoginController::class,"login"])->name('admin.post.login');
Route::post( '/admin/logout', [LoginController::class,"logout"])->name('admin.logout');
Route::group(['prefix' =>'/admin', 'as' => 'admin.', 'middleware' => ['CheckActiveSession','admin:admin,/admin/login']],static function() {

    Route::get( '/importAndFilter', [ExportSuspendedCardController::class,"importAndFilter"])->name('importAndFilter');//export cards
    Route::get( '/suspended-cards/export', [ExportSuspendedCardController::class,"export"])->name('suspended-cards.export');//export cards
    Route::post( '/suspended-cards/export', [ExportSuspendedCardController::class,"post_export"])->name('suspended-cards.export');//export cards


    Route::get( '/get/all-banks', [BanksController::class,"all_banks"])->name('all-banks');
    Route::get( '/get/all-stores', [OutgoingsController::class,"all_stores"])->name('all-stores');
    Route::get( '/get/all-only-banks', [OutgoingsController::class,"all_banks"])->name('all-only-banks');
    Route::get( '/home', [HomeController::class,"home"])->name('home');
    Route::get( '/edit-profile', [ProfileController::class,"editProfile"])->name('edit-profile');
    Route::post( '/update-profile', [ProfileController::class,"updateProfile"])->name('update-profile');

    Route::get( '/change-password', [ProfileController::class,"changePassword"])->name('change-password');
    Route::post( '/update-password', [ProfileController::class,"updatePassword"])->name('update-password');
    Route::get( '/search/most-seller', [HomeController::class,"search_most"])->name('search.most-seller');
    Route::get( '/search/lowest-seller', [HomeController::class,"search_lowest"])->name('search.lowest-seller');
    Route::get( '/home/search', [HomeController::class,"home_search"])->name('home.search');

    //settings
    Route::get( '/settings', [SettingController::class,"index"])->name('settings.index');
    Route::post( '/settings/update/{setting}', [SettingController::class,"update"])->name('settings.update');

    Route::resource('currencies', CurrencyController::class, ['except' => 'destroy']);

    Route::post('/currencies/selected/destroy', [CurrencyController::class, "destroy_selected_rows"])->name('currencies.selected.destroy');

    Route::post('/currencies/destroy', [CurrencyController::class, "destroy"])->name('currencies.destroy');



});

