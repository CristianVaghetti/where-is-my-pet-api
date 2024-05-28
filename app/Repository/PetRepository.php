<?php

namespace App\Repository;

use App\Helpers\FileHelper;
use App\Models\Pet;
use App\Models\PetType;
use App\Repository\BaseRepository;

class PetRepository extends BaseRepository
{
    /**
     * Create a new repository instance
     * 
     * @param Pet $model
     * @return void 
     */
    public function __construct(Pet $model)
    {
        $this->model = $model;
    }

    public function search(array $params = [], int $limit = null)
    {

        $model = $this->model->with(['shelter.city.state','shelter.responsible']);

        if (isset($params['type_id']) && $params['type_id']) {
            $model = $model->where('type_id', $params['type_id']);
        }

        if (isset($params['city_id']) && $params['city_id']) {
            $model = $model->whereHas('shelter', function ($query) use ($params){
                $query->where('city_id', $params['city_id']);
            });
        }

        if (isset($params['state_id']) && $params['state_id']) {
            $model = $model->whereHas('shelter', function ($query) use ($params){
                $query->where('state_id', $params['state_id']);
            });
        }

        if (isset($params['shelter_id']) && $params['shelter_id']) {
            $model = $model->whereHas('shelter', function ($query) use ($params){
                $query->where('id', $params['shelter_id']);
            });
        }

        $model->orderby('created_at', 'asc');

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

    public function save(array $data, bool $autoCommit = false): ?Pet
    {
        $model = null;
        try {
            $this->beginTransaction();

            if(isset($data['file'])){
                $data['image'] = FileHelper::storePath($data['file']);
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

    public function fetchTypes()
    {
        return PetType::all()->toArray();
    }
}