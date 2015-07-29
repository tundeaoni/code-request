<?php

namespace RequestService\AuthHandler;

abstract class AuthChecker {
    abstract protected function check($details);
}