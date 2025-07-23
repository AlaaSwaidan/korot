<?php

namespace App\Providers;

use App\Observers\TransferObserver;
use App\Observers\OrderObserver;
use App\Models\Order;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Modules\Transfers\Entities\Transfer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        date_default_timezone_set('Asia/Riyadh');
        Paginator::useBootstrap();
        Transfer::observe(TransferObserver::class);
         Order::observe(OrderObserver::class);
    }
}
