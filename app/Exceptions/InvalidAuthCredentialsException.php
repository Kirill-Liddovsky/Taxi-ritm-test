<?php

namespace App\Exceptions;

class InvalidAuthCredentialsException extends \Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['message' => 'Invalid credentials'],401);
    }
}
