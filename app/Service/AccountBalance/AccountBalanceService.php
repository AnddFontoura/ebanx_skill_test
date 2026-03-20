<?php

namespace App\Service\AccountBalance;

use App\AccountBalanceEnum;
use App\Repository\Account\AccountRepository;
use App\Repository\AccountBalance\AccountBalanceRepository;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccountBalanceService
{
    public function __construct(
        protected AccountBalanceRepository $accountBalanceRepository,
        protected AccountRepository $accountRepository
    ) {

    }

    public function getBalance(array $data)
    {
        $account = $this->accountRepository->getById($data['account_id']);

        throw_if(!$account, new NotFoundHttpException('0'));
    }

    public function newBalance(array $data)
    {
        $transactionType = AccountBalanceEnum::tryFromName($data['type']);
        $isValidAccount = $this->accountRepository->getById($data['origin']);

        if (isset($data['destination'])) {
            $isValidDestinationAccount = $this->accountRepository->getById($data['destination']);
            throw_if(!$isValidDestinationAccount, new NotFoundHttpException('0'));
        }

        throw_if(!$isValidAccount, new NotFoundHttpException('0'));

        match ($transactionType) {
            AccountBalanceEnum::deposit,
            AccountBalanceEnum::withdraw => $this->newBalanceSave($data),
            AccountBalanceEnum::transfer => $this->newBalanceIsTransfer($data),
            default => throw new Exception('Invalid transaction type', Response::HTTP_BAD_REQUEST),
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