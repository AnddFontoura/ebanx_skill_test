<?php

namespace App\Repository\AccountBalance;

use App\Models\AccountBalanceHistory;

class AccountBalanceHistoryRepository
{
    public function __construct(
        protected AccountBalanceHistory $model
    ) {

    }
}