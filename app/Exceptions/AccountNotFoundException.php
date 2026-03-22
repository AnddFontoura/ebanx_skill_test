<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AccountNotFoundException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(
            0
        , Response::HTTP_NOT_FOUND);
    }
}
