<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use RequestService\AuthHandler\AuthHandler;
use RequestService\AuthHandler\EmailAuthenticationHandler;
use RequestService\Contracts\Authenticable;
use RequestService\RequestLogger;

class IndexController extends Controller implements Authenticable {
    private $request;
    private $authenticator;
    private $auth_status = AuthHandler::AUTH_FAILED;
    private $credentials;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function authenticationSuccessful() {
        $this->auth_status = AuthHandler::AUTH_SUCCESS;
    }

    public function authenticationFailed() {
        $this->auth_status = AuthHandler::AUTH_FAILED;
    }

    public function handleRequest() {
        if ($this->request->input('verification_type') == 'email') {
            if ($this->request->has('email')) {
                $this->credentials = array(
                    'email'     =>  $this->request->input('email'),
                    'token_key' =>  $this->request->input('email')
                );
                $this->verifyWithEmail();
            }
        }

        // verification done, send appropriate response
        return $this->sendResponse();
    }

    private function verifyWithEmail() {
        $this->authenticator = new EmailAuthenticationHandler($this, $this->credentials);
        $this->authenticator->authenticate();
    }

    private function sendResponse() {
        if ($this->auth_status == AuthHandler::AUTH_SUCCESS) {
            // return success JSON response
            return response()->json([
                'auth_status'   =>  $this->auth_status,
                'auth_message'  =>  AuthHandler::AUTH_MSG_SUCCESS,
                'auth_token'    =>  $this->verificationToken()
            ]);
        }

        // authentication failed
        $this->authenticationFailed();

        // return failed JSON response
        return response()->json([
            'auth_status'   =>  $this->auth_status,
            'auth_message'  =>  AuthHandler::AUTH_MSG_FAILED,
        ]);
    }

    private function verificationToken() {
        $logger = new RequestLogger();
        $token = $logger->log($this->credentials['token_key']);

        return $token;
    }
}