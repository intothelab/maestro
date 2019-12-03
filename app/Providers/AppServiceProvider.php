<?php

namespace App\Providers;

use GuzzleHttp\Client;
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
        $this->app->singleton('AdrClient', function(){
            return new Client([
                'base_uri' => config('services.adr.url'),
                'timeout'  => 120,
                'auth' => [
                    config('services.adr.username'),
                    config('services.adr.password')
                ]
            ]);
        });
    }
}
