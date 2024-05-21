<?php

namespace App\Repository;

use App\Models\Shelter;
use App\Repository\BaseRepository;

class ShelterRepository extends BaseRepository
{
    /**
     * Create a new repository instance
     * 
     * @param Shelter $model
     * @return void 
     */
    public function __construct(Shelter $model)
    {
        $this->model = $model;
    }
}