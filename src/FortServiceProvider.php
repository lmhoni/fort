<?php

namespace Spiritiz\Integrals;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

use Spiritiz\Integrals\Guards\TokenGuard;

class FortServiceProvider extends ServiceProvider {


    public function register () {
        $this->registerGuard();
    }


    public function boot () {

    }

    protected function registerGuard()
    {
        Auth::resolved(function ($auth) {
            $auth->extend('fort', function ($app, $name, array $config) {
                return tap($this->makeGuard($config), function ($guard) {
                    app()->refresh('request', $guard, 'setRequest');
                });
            });
        });
    }


    protected function makeGuard(array $config)
    {
        return new TokenGuard(
            new FortUserProvider(Auth::createUserProvider($config['provider']), $config['provider']),
            $this->app->make('request')
        );
    }



}