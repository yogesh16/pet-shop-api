<?php

use App\Http\Controllers\API\V1\AdminController;
use App\Http\Controllers\API\V1\Auth\AdminAuthController;
use App\Http\Controllers\API\V1\Auth\UserAuthController;
use App\Http\Controllers\API\V1\UserController;
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

Route::group(['middleware' => ['api'], 'prefix' => 'v1/admin'], function () {
    Route::post('/login', [AdminAuthController::class, 'login']);

    //Only authorized request can access following API Endpoints.
    Route::group(['middleware' => ['auth', 'is-admin']], function () {
        Route::get('/logout', [AdminAuthController::class, 'logout']);
        Route::post('/create', [AdminController::class, 'create']);
        Route::get('/user-listing', [AdminController::class, 'userListing']);
        Route::put('/user-edit/{uuid}', [AdminController::class, 'userEdit']);
        Route::delete('/user-delete/{uuid}', [AdminController::class, 'userDelete']);
    });
});

Route::group(['middleware' => ['api'], 'prefix' => 'v1/user'], function () {
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/create', [UserController::class, 'create']);
});
