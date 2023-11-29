<?php

namespace Spiritiz\Integrals;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

use Spiritiz\Integrals\Guards\TokenGuard;
use Spiritiz\Integrals\Providers\FortUserProvider;

class FortServiceProvider extends ServiceProvider {


    public function register () {
        $this->registerGuard();
    }


    public function boot () {

        $this->publishes([
            __DIR__.'/../config/fort.php' => config_path('fort.php'),
        ], 'fort');

    }

    protected function registerGuard()
    {
        Auth::resolved(function ($auth) {
            $auth->extend('fort', function ($app, $name, array $config) {
                return tap($this->makeGuard($config), function ($guard) {
                    app()->refresh('request', $guard, 'setRequest');
                });
            });

            $auth->provider('fort', function ($app, array $config) {
                return new FortUserProvider($config);
            });
        });
    }


    protected function makeGuard(array $config)
    {
        return new TokenGuard(
            new FortUserProvider($config),
            $this->app->make('request')
        );
    }



}
