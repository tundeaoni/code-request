<?php

namespace RequestService\AuthHandler;

abstract class AuthHandler {
    const AUTH_SUCCESS = 0;
    const AUTH_FAILED  = 1;

    const AUTH_MSG_SUCCESS  = 'successful';
    const AUTH_MSG_FAILED   = 'failed';

    abstract public function authenticate();

    abstract public function authorize();
}