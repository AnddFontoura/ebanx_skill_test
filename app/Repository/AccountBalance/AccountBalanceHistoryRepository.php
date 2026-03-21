<?php

namespace App\Repository\AccountBalance;

use App\Models\AccountBalanceHistory;
use App\Repository\BaseRepository;

class AccountBalanceHistoryRepository extends BaseRepository
{
    public function __construct(
        protected AccountBalanceHistory $model
    ) {

    }
}