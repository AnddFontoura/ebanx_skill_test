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

    /**
     * @throws \Throwable
     */
    public function getBalance(array $data): void
    {
        $account = $this->accountRepository->getById($data['account_id']);

        throw_if(!$account, new NotFoundHttpException('0'));
    }

    /**
     * @throws \Throwable
     */
    public function newBalance(array $data): void
    {
        $transactionType = AccountBalanceEnum::tryFromName($data['type']);
        $isValidAccount = $this->accountRepository->getById($data['origin']);

        if (isset($data['destination'])) {
            $isValidDestinationAccount = $this->accountRepository->getById($data['destination']);
            throw_if(!$isValidDestinationAccount, new NotFoundHttpException('0'));
        }

        throw_if(!$isValidAccount, new NotFoundHttpException('0'));

        match ($transactionType) {
            AccountBalanceEnum::deposit => $this->newBalanceDeposit($data),
            AccountBalanceEnum::withdraw => $this->newBalanceWithdraw($data),
            AccountBalanceEnum::transfer => $this->newBalanceIsTransfer($data),
            default => throw new Exception('Invalid transaction type', Response::HTTP_BAD_REQUEST),
        };
    }

    public function newBalanceDeposit(array $data): void
    {
        $data['type'] = AccountBalanceEnum::deposit->value;
        $data['account_id'] = $data['destination'];
        $this->accountBalanceRepository->create($data);
    }

    public function newBalanceWithdraw(array $data): void
    {
        $data['type'] = AccountBalanceEnum::withdraw->value;
        $data['account_id'] = $data['origin'];
        $this->accountBalanceRepository->create($data);
    }

    public function newBalanceIsTransfer(array $data): void
    {
        $this->newBalanceDeposit($data);
        $this->newBalanceWithdraw($data);
    }
}