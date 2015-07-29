<?php
namespace RequestService;

class RequestLogger {
    public function log($email) {
        // get token storage
        $token_dir = storage_path() . '/tokens/';
        $filename = $token_dir . md5($email);
        $token = $this->generateToken();
        file_put_contents($filename, $token);
        return $token;
    }

    private function generateToken() {
        return md5(time());
    }
}