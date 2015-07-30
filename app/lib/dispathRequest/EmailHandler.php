<?php
/**
 * Created by PhpStorm.
 * User: Tech-1
 * Date: 7/29/15
 * Time: 10:28 AM
 */

namespace App\lib\dispathRequest;

use Illuminate\Support\Facades\Mail;


class EmailHandler implements dispatch {

    private $email;
    private $voucher;
    private $hashcode;
    private $body;

    function __construct($email, $voucher)
    {
        $this->email = $email;
        $this->voucher = $voucher;
    }

    /**
     *
     * @param $body
     * @return
     */
    public function emailsent()
    {
        $body = "Here is your voucher code " . $this->voucher;
        Mail::raw($body, function($message) {
            $message->to($this->email, 'Client Name');
        });

        return response()->json(['ok'], 200);
    }

    function SendOutHandler()
    {
        $this->emailsent();
    }
}