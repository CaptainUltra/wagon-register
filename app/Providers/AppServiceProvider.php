<?php

namespace App\Providers;

use App\Wagon;
use App\Observers\WagonObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        Wagon::observe(WagonObserver::class);

        if (App::environment('production')) {
            $this->app->bind('path.public', function () {
                return base_path() . '/../public_html';
            });
        }
    }
}
