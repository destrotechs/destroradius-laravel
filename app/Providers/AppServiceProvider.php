<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Support\Facades\Validator;
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
    public function boot(Charts $charts)
    {
        $charts->register([
            \App\Charts\PackageSalesChart::class,
            \App\Charts\MonthlySales::class,
            \App\Charts\ItemsChart::class,
        ]);

        Validator::extend('allowed_username', function ($attribute, $value, $parameters, $validator)
        {
          $bannedUsernames = ['HEWANET','PAMEWA'];
          return !in_array(strtoupper($value), $bannedUsernames);
        });
    }
}
