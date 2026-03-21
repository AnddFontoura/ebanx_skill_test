<?php

namespace App\Service\Cleaner;

use App\Repository\AccountBalance\AccountBalanceHistoryRepository;
use App\Repository\AccountBalance\AccountBalanceRepository;

class CleanerService
{
    public function __construct(
        protected AccountBalanceHistoryRepository $accountBalanceHistoryRepository,
        protected AccountBalanceRepository $accountBalanceRepository,
    )
    {

    }
    public function clearData() {
        $this->accountBalanceRepository->clearData();
        $this->accountBalanceHistoryRepository->clearData();
    }
}