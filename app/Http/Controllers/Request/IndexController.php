<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RequestService\AuthHandler\EmailAuthenticationHandler;
use RequestService\Contracts\Authenticable;
use RequestService\RequestLogger;

class IndexController extends Controller implements Authenticable {
    private $request;
    private $authenticator;
    private $auth_status;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function handleRequest() {
        if ($this->request->has('email')) {
            $credentials = array(
                'email' =>  $this->request->input('email')
            );
            $this->authenticator = new EmailAuthenticationHandler($this, $credentials);
            $this->authenticator->authenticate();
            if ($this->auth_status == 0) {
                // create temporary verification hash file and token
                $logger = new RequestLogger();
                $token = $logger->log($this->request->input('email'));

                // return success JSON response
                return response()->json([
                    'auth_status'   =>  $this->auth_status,
                    'auth_token'    =>  $token
                ]);
            } else {
                // return failed JSON response
                return response()->json([
                    'auth_status'   =>  $this->auth_status,
                ]);
            }
        }
        dd('request handled');
    }

    public function authenticationSuccessful() {
        $this->auth_status = 0;
    }

    public function authenticationFailed() {
        $this->auth_status = 1;
    }
}