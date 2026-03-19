<?php

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
}