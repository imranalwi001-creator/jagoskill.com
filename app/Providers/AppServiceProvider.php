<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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
        if (env('APP_URL')) {
            \Illuminate\Support\Facades\URL::forceRootUrl(env('APP_URL'));
        }

        Validator::extend('check_price', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^\d*\.?\d*$/', $value);
        });


        Paginator::defaultView('pagination::default');
    }
}
