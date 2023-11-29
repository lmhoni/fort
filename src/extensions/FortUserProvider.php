<?php

namespace Spiritiz\Integrals\Providers;

use Illuminate\Contracts\Auth\UserProvider;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

use Spiritiz\Integrals\Authenticables\User;



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

        $url = Config::get('fort.auth_verification_url');
        $path = Config::get('fort.data_node_path');

        $response = Http::withHeaders($headers)
                        ->get($url, []);

        if ($response->ok()) {
            $data = $this->getArrayNode($path, $response);
            return new User($data);
        }

    }

    protected function getArrayNode ($path, $items) {

        $path = str_replace('].', ' ', $path);
        $path = str_replace('][', ' ', $path);
        $path = str_replace(']', ' ', $path);
        $path = str_replace('[', ' ', $path);
        $path = str_replace('.', ' ', $path);
        $path = trim($path, ' ');

        $pathArr = explode(' ',  $path);

        foreach ($pathArr as $index => $value) {
            $items = $items[$value];
        }

        return $items;
    }



    public function retrieveById($identifier) { }

    public function retrieveByToken($identifier, $token) { }

    public function updateRememberToken(Authenticatable $user, $token) { }

    public function retrieveByCredentials(array $credentials) { }

    public function validateCredentials(Authenticatable $user, array $credentials) { }

    public function getProviderName() { }

}
