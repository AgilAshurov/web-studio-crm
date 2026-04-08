<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Events\TransactionSaved;
use App\Listeners\UpdateInvoice;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
//        Event::listen(TransactionSaved::class, UpdateInvoice::class);
        Schema::defaultStringLength(191);
    }
}
