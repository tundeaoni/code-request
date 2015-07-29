<?php
namespace RequestService\AuthHandler;

use RequestService\Contracts\Authenticable;

class EmailAuthenticationHandler extends AuthHandler {
    private $email;
    private $auth_seeker;
    private $authorized = false;

    public static function foo() {dd('foo');}

    public function __construct(Authenticable $auth_seeker, $credentials) {
        try {
            $this->email = $credentials['email'];
            $this->auth_seeker = $auth_seeker;
        } catch (Exception $e) {
            // email key not in credentials array
        }
    }

    public function authenticate() {
        // do the email check here
        $checker = new FileAuthChecker($this);
        $this->checkAuthorizedEmail($checker);
        if ($this->authorized) {
            $this->auth_seeker->authenticationSuccessful();
        } else {
            $this->auth_seeker->authenticationFailed();
        }
    }

    private function checkAuthorizedEmail(AuthChecker $checker) {
        $details = array(
            'check_type'    =>  'email',
            'email'         =>  $this->email
        );
        $checker->check($details);
    }

    public function authorize() {
        $this->authorized = true;
    }
}