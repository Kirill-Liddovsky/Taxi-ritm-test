<?php

namespace App\Exceptions;

class UserNotFoundException extends \Exception
{
     public function render(): \Illuminate\Http\JsonResponse
     {
         return response()->json(['message' => 'User not found'],404);
     }
}
