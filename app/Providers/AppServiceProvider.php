<?php

namespace App\Providers;

use App\Observers\WagonObserver;
use App\Wagon;
use Illuminate\Support\ServiceProvider;

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
        Wagon::observe(WagonObserver::class);
    }
}
