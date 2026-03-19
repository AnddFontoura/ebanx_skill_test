<?php

namespace AccountBalance;

use Account\AccountRepository;
use AccountBalanceRepository;
use App\AccountBalanceEnum;
use App\Models\AccountBalance;
use Exception;
use Illuminate\Http\JsonResponse;

class AccountBalanceService
{
    public function __construct(
        protected AccountBalanceRepository $accountBalanceRepository,
        protected AccountRepository $accountRepository
    ) {

    }
    public function newBalance(array $data)
    {
        $transactionType = AccountBalanceEnum::tryFromName($data['type']);
        $isValidAccount = $this->accountRepository->getById($data['origin']);

        if (isset($data['destination'])) {
            $isValidDestinationAccount = $this->accountRepository->getById($data['destination']);
            throw_if(!$isValidDestinationAccount, new \Exception('0', JsonResponse::HTTP_NOT_FOUND));
        }

        throw_if(!$isValidAccount, new Exception('0', JsonResponse::HTTP_NOT_FOUND));

        match ($transactionType) {
            AccountBalanceEnum::deposit,
            AccountBalanceEnum::withdraw => $this->newBalanceSave($data),
            AccountBalanceEnum::transfer => $this->newBalanceIsTransfer($data),
            default => throw new Exception('Invalid transaction type', JsonResponse::HTTP_BAD_REQUEST),
        };
    }

    public function newBalanceSave(array $data): void
    {
        $this->accountBalanceRepository->create(
            $this->fetchNewBalanceData($data)
        );
    }

    public function newBalanceIsTransfer(array $data): void
    {
        $data['type'] = AccountBalanceEnum::withdraw->value;
        $this->newBalanceSave($data);

        $data['type'] = AccountBalanceEnum::deposit->value;
        $data['origin'] = $data['destination'];
        $this->newBalanceSave($data);
    }

    public function fetchNewBalanceData(array $data): array
    {
        return [
            'type' => AccountBalanceEnum::fromName($data['type']),
            'amount' => $data['amount'],
            'origin' => $data['origin'],
        ];
    }
}