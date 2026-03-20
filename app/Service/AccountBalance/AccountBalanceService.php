<?php

namespace App\Service\AccountBalance;

use App\AccountBalanceEnum;
use App\Repository\Account\AccountRepository;
use App\Repository\AccountBalance\AccountBalanceRepository;
use Exception;
use Illuminate\Support\Facades\DB;
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
    public function getBalance(array $data): ?int
    {
        $account = $this->accountRepository->getById($data['account_id']);

        throw_if(!$account, new NotFoundHttpException('0'));

        $withdraws = $this->accountBalanceRepository->sumWithdraw($data['account_id']);
        $deposits = $this->accountBalanceRepository->sumDeposit($data['account_id']);

        return $deposits - $withdraws;
    }

    /**
     * @throws \Throwable
     */
    public function newBalance(array $data): void
    {
        DB::transaction(function () use ($data) {
            $transactionType = AccountBalanceEnum::tryFromName($data['type']);

            if (isset($data['origin'])) {
                $isValidAccount = $this->accountRepository->getById($data['origin']);
                throw_if(!$isValidAccount, new NotFoundHttpException('0'));
            }

            if (isset($data['destination'])) {
                $isValidDestinationAccount = $this->accountRepository->getById($data['destination']);
                throw_if(!$isValidDestinationAccount, new NotFoundHttpException('0'));
            }

            match ($transactionType) {
                AccountBalanceEnum::deposit => $this->newBalanceDeposit($data),
                AccountBalanceEnum::withdraw => $this->newBalanceWithdraw($data),
                AccountBalanceEnum::transfer => $this->newBalanceIsTransfer($data),
                default => throw new Exception('Invalid transaction type', Response::HTTP_BAD_REQUEST),
            };
        });
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

        //Check if account has balance
        $this->accountBalanceRepository->create($data);
    }

    public function newBalanceIsTransfer(array $data): void
    {
        $this->newBalanceDeposit($data);
        $this->newBalanceWithdraw($data);
    }

    /**
     * @throws \Throwable
     */
    public function createResponse(array $data): array
    {
        $response = [];

        if (isset($data['origin'])) {
            $response['origin'] = [
                'id' => $data['origin'],
                'balance' => $this->getBalance(['account_id' => $data['origin']]),
            ];
        }

        if (isset($data['destination'])) {
            $response['destination'] = [
                'id' => $data['destination'],
                'balance' => $this->getBalance(['account_id' => $data['destination']]),
            ];
        }

        return $response;
    }
}