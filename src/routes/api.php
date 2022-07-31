<?php

use App\Http\Controllers\API\V1\AdminController;
use App\Http\Controllers\API\V1\Auth\AdminAuthController;
use App\Http\Controllers\API\V1\Auth\UserAuthController;
use App\Http\Controllers\API\V1\BrandController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\FileController;
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

Route::group(['middleware' => ['api'], 'prefix' => 'v1/category'], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::post('/create', [CategoryController::class, 'create']);
        Route::put('/{uuid}', [CategoryController::class, 'edit']);
        Route::delete('/{uuid}', [CategoryController::class, 'delete']);
    });
    Route::get('/{uuid}', [CategoryController::class, 'getByUuid']);
});

Route::middleware('api')
    ->get('v1/categories', [CategoryController::class, 'categoryListing']);

Route::group(['middleware' => ['api'], 'prefix' => 'v1/brand'], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::post('/create', [BrandController::class, 'create']);
        Route::put('/{uuid}', [BrandController::class, 'edit']);
        Route::delete('/{uuid}', [BrandController::class, 'delete']);
    });
    Route::get('/{uuid}', [BrandController::class, 'getByUuid']);
});

Route::middleware('api')
    ->get('v1/brands', [BrandController::class, 'brandListing']);

Route::middleware(['api', 'auth'])
    ->post('v1/file/upload', [FileController::class, 'fileUpload']);
