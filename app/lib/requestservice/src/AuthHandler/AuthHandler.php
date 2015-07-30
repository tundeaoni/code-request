<?php

namespace RequestService\AuthHandler;

abstract class AuthHandler {
    const AUTH_SUCCESS = 0;
    const AUTH_FAILED  = 1;

    abstract public function authenticate();

    abstract public function authorize();
}