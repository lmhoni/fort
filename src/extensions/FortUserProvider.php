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
    public function __construct(UserProvider $provider, $providerName)
    {
        $this->provider = $provider;
        $this->providerName = $providerName;
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveById($identifier)
    {
        return $this->provider->retrieveById($identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveByToken($identifier, $token)
    {
        return $this->provider->retrieveByToken($identifier, $token);
    }


    public function retrieveByTokenOnly($token) {

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $token
        ])->get('http://localhost:8002/api/user', []);

        \Log::info($response);

        if ($response) {
            return $response;
        }

    }


    /**
     * {@inheritdoc}
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $this->provider->updateRememberToken($user, $token);
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveByCredentials(array $credentials)
    {
        return $this->provider->retrieveByCredentials($credentials);
    }

    /**
     * {@inheritdoc}
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $this->provider->validateCredentials($user, $credentials);
    }

    /**
     * Get the name of the user provider.
     *
     * @return string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

}