<?php
namespace RequestService;

class RequestLogger {
    public function log($email) {
        // get token storage
        $token_dir = storage_path() . '/tokens/';

        // create new verification token filename (from email)
        $filename = $token_dir . md5($email);

        // generate token, store in token file and return token
        $token = $this->generateToken();
        file_put_contents($filename, $token);
        return $token;
    }

    private function generateToken() {
        return md5(time());
    }
}