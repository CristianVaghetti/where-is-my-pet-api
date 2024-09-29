<?php

namespace App\Repository;

use App\Models\Shelter;
use App\Models\State;
use App\Models\City;
use App\Models\ShelterManagementRequest;
use App\Repository\BaseRepository;
use Illuminate\Support\Facades\Auth;

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
        $model = $this->model->with('city');

        if(!isset($params['home']) && Auth::user()->profile->id !== 1){
            $model = $model->whereHas('users', function ($query){
                $query->where('user_id', Auth::user()->id);
            });
        }

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
            
            $attach = empty($data['id']);
            
            $model = parent::save(data: $data);

            if($attach) $model->users()->attach($model->id, ['user_id' => Auth::user()->id, 'owner' => true]);

            $this->commit();
        } catch (\Exception $e) {
            report($e);
            $this->rollback();
            throw new \Exception($e, 500, $e);
        }

        return $model;
    }

    public function managementRequest(int $id): bool
    {
        ShelterManagementRequest::create([
            'shelter_id' => $id,
            'user_id' => Auth::user()->id,
        ]);
        
        return true;
    }
}