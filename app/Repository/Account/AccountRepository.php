<?php

namespace App\Repository\Account;

use App\Models\Accounts;
use App\Repository\BaseRepository;

class AccountRepository extends BaseRepository
{
    public function __construct(
        protected Accounts $model
    ) {

    }

    public function getById(int $id)
    {
        return $this->model
            ->whereId($id)
            ->first();
    }

}