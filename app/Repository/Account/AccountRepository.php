<?php

namespace App\Repository\Account;

use App\Models\Account;
use App\Repository\BaseRepository;

class AccountRepository extends BaseRepository
{
    public function __construct(
        protected Account $model
    ) {

    }

    public function getById(int $id)
    {
        return $this->model
            ->whereId($id)
            ->first();
    }

}