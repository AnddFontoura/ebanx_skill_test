<?php

class CleanerService
{
    public function __construct(
        protected AccountBalanceHistoryRepository $accountBalanceHistoryRepository,
        protected AccountBalanceRepository $accountBalanceRepository,
    )
    {

    }
    public function clearData() {
    }
}