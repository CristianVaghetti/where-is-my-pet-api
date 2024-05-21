<?php

namespace App\Repository;

use App\Models\State;
use App\Repository\BaseRepository;

class StateRepository extends BaseRepository
{
    public function __construct(State $model)
    {
        $this->model = $model;
    }
}