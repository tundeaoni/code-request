<?php
namespace RequestService\Contracts;

interface Authenticable {
    public function authenticationSuccessful();

    public function authenticationFailed();
}