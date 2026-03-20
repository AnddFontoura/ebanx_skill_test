<?php

namespace App\Repository\AccountBalance;

use App\AccountBalanceEnum;
use App\Models\AccountBalance;
use App\Repository\BaseRepository;

class AccountBalanceRepository extends BaseRepository
{
    public function __construct(
        protected AccountBalance $model
    )
    {

    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function sumWithdraw(int $accountId): ?int
    {
        return $this->model
            ->where('account_id', $accountId)
            ->where('type', AccountBalanceEnum::withdraw->value)
            ->sum('amount');
    }

    public function sumDeposit(int $accountId): ?int
    {
        return $this->model
            ->where('account_id', $accountId)
            ->where('type', AccountBalanceEnum::deposit->value)
            ->sum('amount');
    }
}