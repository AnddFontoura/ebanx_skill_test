<?php

namespace App\Http\Controllers;

use AccountBalance\AccountBalanceService;
use AccountBalanceRepository;
use App\Http\Requests\AccountBalance\AccountBalanceNewRequest;
use App\Http\Requests\AccountBalance\AccountBalanceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AccountBalanceController extends Controller
{
    public function __construct(
        protected AccountBalanceService $accountBalanceService
    ) {

    }

    public function newBalance(AccountBalanceNewRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->accountBalanceService->newBalance($data);

        return response()->json($data, JsonResponse::HTTP_OK);
    }

    public function getBalance(AccountBalanceRequest $request): JsonResponse
    {

    }
}
