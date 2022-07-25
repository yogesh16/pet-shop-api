<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-token', function(){
    $user = \App\Models\User::find(1);
    dd($user->generateToken());
});

Route::get('/decode', function (){
    $token = request()->token;
    dd(\App\Services\JWTService::parseToken($token));
});
