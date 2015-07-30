<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//['uses' => 'App\Http\Controllers\ContactController@newMessage']


$app->get('/', function () use ($app) {
    return response()->json(['ok'], 200);

});

$app->get('dispatchRequest', 'DispatchController@parseURL');