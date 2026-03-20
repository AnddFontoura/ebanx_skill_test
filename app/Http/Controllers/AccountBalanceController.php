<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountBalance\AccountBalanceNewRequest;
use App\Http\Requests\AccountBalance\AccountBalanceRequest;
use App\Service\AccountBalance\AccountBalanceService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AccountBalanceController extends Controller
{
    public function __construct(
        protected AccountBalanceService $accountBalanceService
    ) {

    }

    /**
     * @throws \Exception
     */
    public function newBalance(AccountBalanceNewRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->accountBalanceService->newBalance($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getBalance(AccountBalanceRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->accountBalanceService->getBalance($data);

        return response()->json($data, Response::HTTP_OK);
    }
}
