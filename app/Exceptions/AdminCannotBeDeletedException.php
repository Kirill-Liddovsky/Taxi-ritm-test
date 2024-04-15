<?php

namespace App\Exceptions;

class AdminCannotBeDeletedException extends \Exception
{
    public function render()
    {
        return response()->json(['message' => 'User cannot be deleted'],403);
    }
}
