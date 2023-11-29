<?php

namespace Spiritiz\Integrals\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

use Illuminate\Support\Facades\Http;


class FortUserProvider implements UserProvider {


    /**
     * The user provider instance.
     *
     * @var \Illuminate\Contracts\Auth\UserProvider
     */
    protected $provider;

    /**
     * The user provider name.
     *
     * @var string
     */
    protected $providerName;

    /**
     * Create a new Fort user provider.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  string  $providerName
     * @return void
     */
    public function __construct($config)
    {

    }

    public function retrieveByTokenOnly($token) {

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $token
        ];

        $url = 'http://localhost:8002/user';

        $response = Http::withHeaders($headers)
                        ->get($url, []);

        if ($response->ok()) {
            return $response;
        }

    }


    public function retrieveById($identifier) { }

    public function retrieveByToken($identifier, $token) { }

    public function updateRememberToken(Authenticatable $user, $token) { }

    public function retrieveByCredentials(array $credentials) { }

    public function validateCredentials(Authenticatable $user, array $credentials) { }

    public function getProviderName() { }

}
