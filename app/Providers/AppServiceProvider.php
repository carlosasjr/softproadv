<?php

namespace App\Providers;

use App\Models\Financial;
use App\Observers\FinancialObserver;
use Illuminate\Support\Facades\Blade;
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
        Schema::defaultStringLength('191');

        /**
         * Diretivas
         */

        Blade::if('tenant', function () {
            return (request()->getHost() != config('tenant.domain_main'));
        });

        Blade::if('tenantmain', function () {
            return (request()->getHost() == config('tenant.domain_main'));
        });


        Financial::observe(FinancialObserver::class);
    }
}
