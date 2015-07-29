<?php

namespace RequestService\AuthHandler;

class FileAuthChecker extends AuthChecker {
    private $authorized_senders;
    private $authenticator;
    public function __construct(AuthHandler $authenticator) {
        // authenticator class calling this authentication checker
        $this->authenticator = $authenticator;

        // Load ini configuration file for authorized senders
        $ini_file_path = storage_path() . "/ini/authorized_senders.ini";
        $this->authorized_senders = parse_ini_file($ini_file_path, true);
    }

    public function check($details) {
        // what are we checking for
        $type = $details['check_type'];
        if ($type == 'email') {
            if ($this->emailCheck($details['email'])) {
                $this->authenticator->authorize();
            }
        }
    }

    private function emailCheck($email) {
        $authorized_emails = $this->authorized_senders['email_addresses']['email'];

        if (in_array($email, $authorized_emails)) {
            return true;
        }
        return false;
    }
}