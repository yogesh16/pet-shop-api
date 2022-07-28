<?php


namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\API\V1\BaseController;
use App\Http\Requests\LoginRequest;
use App\Services\JWTService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if(Auth::attempt($credentials)){
            $token = auth()->user()->generateToken();

            return $this->success(['token' => $token]);

        } else {

            return $this->error('Invalid username or password');

        }
    }
}
