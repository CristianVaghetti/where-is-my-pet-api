<?php

namespace App\Repository;

use App\Models\Shelter;
use App\Models\State;
use App\Models\City;
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

    public function search(array $params = [], int $limit = null)
    {

        $model = $this->model;

        $model->orderby('created_at', 'desc');

        if ($limit) {
            $paginator = $model->paginate($limit);
            return [
                'total' => $paginator->total(),
                'items' => $paginator->items()
            ];
        } else {
            return $model->get();
        }
    }

    public function save(array $data, bool $autoCommit = false): ?Shelter
    {
        $model = null;
        try {
            $this->beginTransaction();

            if(isset($data['state_id']) && !is_numeric($data['state_id'])){
                $state = State::where('short', 'like', '%' . $data['state_id'] . '%')->first();
                $data['state_id'] = $state->id;
            }

            if(isset($data['city_id']) && !is_numeric($data['city_id'])){
                $city = City::where('name', 'like', '%' . $data['city_id'] . '%')->where('state_id', $data['state_id'])->first();
                $data['city_id'] = $city->id;
            }
            
            $model = parent::save(data: $data);

            $this->commit();
        } catch (\Exception $e) {
            report($e);
            $this->rollback();
            throw new \Exception($e, 500, $e);
        }

        return $model;
    }
}