<?php

namespace Spiritiz\Integrals\Guards;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Auth\GuardHelpers;

use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use Spiritiz\Integrals\Providers\FortUserProvider;

class TokenGuard implements Guard {

    use GuardHelpers, Macroable;

    /**
     * The user provider implementation.
     *
     * @var \Spiritiz\Integrals\FortUserProvider
     */
    protected $provider;


    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;


    public function __construct(
        FortUserProvider $provider,
        Request $request
    ) {
        $this->provider = $provider;
        $this->request = $request;
    }


    /**
     * Get the user for the incoming request.
     *
     * @return mixed
     */
    public function user() {
        if (! is_null($this->user)) {
            return $this->user;
        }

        if ($this->request->bearerToken()) {
            return $this->user = $this->authenticateViaBearerToken($this->request);
        }

    }

    /**
     * Set the current request instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    
    /**
     * Authenticate the incoming request via the Bearer token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function authenticateViaBearerToken($request) {

        // If the access token is valid we will retrieve the user according to the user ID
        // associated with the token. We will use the provider implementation which may
        // be used to retrieve users from Eloquent. Next, we'll be ready to continue.
        $user = $this->provider->retrieveByTokenOnly(
            $this->request->bearerToken()?: null
        );

        if (! $user) {
            return;
        }


        return $user;
    }


    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = []) {
        return ! is_null((new static(
            $this->provider,
            $credentials['request'],
        ))->user());
    }




}


?>
