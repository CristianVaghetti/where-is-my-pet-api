<?php

namespace App\Repository;

use App\Models\City;
use App\Models\State;
use App\Repository\BaseRepository;

class CityRepository extends BaseRepository
{
    protected State $state;
    public function __construct(City $model, State $state)
    {
        $this->model = $model;
        $this->state = $state;
    }

    public function getByUf($uf)
    {
        if (is_numeric($uf)) {
            return $this->model->where('state_id', $uf)->orderBy('name', 'ASC')->get();
        } else {
            $state = $this->getByShort($uf);
            
            return $this->model->where('state_id', $state->id)->orderBy('name', 'ASC')->get();
        }
    }

    public function getByShort($short)
    {
        return $this->state->where('short', $short)->first();
    }

    public function getAll()
    {
        return $this->model->orderBy('name', 'ASC')->get();
    }
}