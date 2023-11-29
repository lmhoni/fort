<?php

namespace Spiritiz\Integrals\Authenticables;

use Illuminate\Contracts\Auth\Authenticatable;


class User implements Authenticatable {

    protected $primaryKey='session_token';
    protected $identifier_field='session_token';
    protected $password_field='password';
    protected $remember_token_field='remember_token';
    protected $attributes = [];

    public function __construct(array $attributes) {
        $this->attributes = $attributes;
    }

    public function getUserAttributes() {
        return $this->attributes;
    }

    public function getAuthIdentifierName() {
        return $this->identifier_field;
    }

    public function getAuthIdentifier() {
        return $this->attributes[$this->identifier_field];
    }

    public function getAuthPassword() {
        //return $this->attributes[$this->$password_field];
    }

    public function getRememberToken() {
        //return $this->attributes[$this->$remember_token_field];
    }

    public function setRememberToken($value) {
        //$this->attributes[$this->remember_token_field]=$value;
    }

    public function getRememberTokenName() {
        //return $this->remember_token_field;
    }



}



?>
