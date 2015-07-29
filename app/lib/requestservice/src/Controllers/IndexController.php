<?php
namespace RequestService\Controllers;

use \Illuminate\Http\Request;
use \RequestService\Contracts\Authenticable;
use \RequestService\AuthHandler\EmailAuthenticationHandler;

class IndexController implements Authenticable {
    private $request;
    private $authenticator;
    private $auth_status;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function validRequest() {
        if ($this->request->has('email')) {
            $credentials = array(
                'email' =>  $this->request->input('email');
            );
            $this->authenticator = new EmailAuthenticationHandler($credentials);
            $this->authenticator->authenticate($this);
            if ($this->auth_status == 0) {
                // create temporary verification hash file and token

                // return success JSON response
            } else {
                // return failed JSON response
            }
        }
    }

    public function authenticationSuccessful() {
        $this->auth_status = 0;
    }

    public function authenticationFailed() {
        $this->auth_status = 1;
    }

}