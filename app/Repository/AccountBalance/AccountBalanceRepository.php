<?php

use App\Models\AccountBalance;

class AccountBalanceRepository
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
}