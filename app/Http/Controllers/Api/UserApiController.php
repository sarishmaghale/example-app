<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\LogInRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    use ApiResponseTrait;

    public function login(LogInRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api_token')->plainTextToken;
            return response()->json([
                $token
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json();
    }
}
