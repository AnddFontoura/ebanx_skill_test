<?php

namespace App\Repository;

abstract class BaseRepository
{
    public function clearData(): void
    {
        $this->model
            ->where('deleted_at', null)
            ->delete();
    }
}