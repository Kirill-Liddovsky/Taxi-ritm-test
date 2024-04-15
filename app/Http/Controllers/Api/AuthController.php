<?php

namespace App\Http\Controllers\Api;


use App\Exceptions\InvalidAuthCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $validate = $request->validated();

        if (!auth()->attempt($validate)) {
          throw new InvalidAuthCredentialsException();
        }

        $token = auth()->user()->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'logged out'
        ]);
    }
}
