<?php

namespace RequestService\AuthHandler;

abstract class AuthHandler {
    abstract public function authenticate();

    abstract public function authorize();
}