<?php

namespace App\Service\Cleaner;

use App\Repository\AccountBalance\AccountBalanceRepository;

class CleanerService
{
    public function __construct(
        protected AccountBalanceRepository $accountBalanceRepository,
    )
    {

    }
    public function clearData() {
        $this->accountBalanceRepository->clearData();
    }
}