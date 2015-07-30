<?php
/**
 * Created by PhpStorm.
 * User: Tech-1
 * Date: 7/29/15
 * Time: 10:40 AM
 */

namespace App\Http\Controllers;

use App\lib\dispathRequest\EmailHandler;

use Illuminate\Http\Request;


class DispatchController extends Controller {




    // "https://api.copernica.com/profile/$profileID?access_token=$token"

    public function index()
    {
        return "welcome to lumen";
    }

    public function parseURL(Request $req)
    {
        //    $email = $req->get('email');
        //    $hash = $req->get('hashcode');
            $email = "moses.olalere@irokopartners.com";
            $hash = "hashme";

            $emailhand = new EmailHandler($email, $hash);

            $emailhand->SendOutHandler();

        return response()->json(['ok'], 200);

    }
}