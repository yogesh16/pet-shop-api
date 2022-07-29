<?php

use App\Http\Controllers\API\V1\AdminController;
use App\Http\Controllers\API\V1\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api'], 'prefix' => 'v1/admin'], function(){
    Route::post('/login', [AdminAuthController::class, 'login']);


    //Only authorized request can access following API Endpoints.
    Route::group(['middleware' => ['is-admin']], function(){
        Route::get('/logout', [AdminAuthController::class, 'logout']);
        Route::post('/create', [AdminController::class, 'create']);
        Route::get('/user-listing', [AdminController::class, 'userListing']);
    });
});
