<?php

namespace App\Repository;

use App\Helpers\FileHelper;
use App\Models\Pet;
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

    public function save(array $data, bool $autoCommit = false): ?Pet
    {
        $model = null;
        try {
            $this->beginTransaction();

            if(isset($data['file'])){
                $data['photo'] = $this->_storePath($data['file']);
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

      /**
     * Store document file
     * 
     * @param null|string $photo 
     * @return string|false|null 
     * 
     * @throws LogicException 
     * @throws BindingResolutionException 
     */
    private function _storePath(?string $file): string | bool | null
    {
        $path = null;
        if ($file && !empty($file)) {
            $upFile = FileHelper::fromBase64($file);
            $path = $upFile->store("files/pets");
        }

        return $path;
    }
}