<?php

namespace App\Http\Validation;

use App\Helpers\ResponseHelper;
use App\Http\Validation\IValidation;
use App\Repository\UserRepository;
use Illuminate\Support\Arr;

class UserValidation implements IValidation 
{
    /**
     * Repository of user
     *
     * @var UserRepository
     */
    protected UserRepository $repository;

    /**
     * Create a new validation intance
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository) 
    {
        $this->repository = $repository;
    }

    /**
     * Make a busines validate
     *
     * @param array $dados
     * @param integer $id
     * @return 
     */
    public function validate(array $dados, $id = 0) 
    {
        if ($this->repository->exists(Arr::only($dados, ["email"]), $id)) {
            return ResponseHelper::responseValidateError([], msg: "E-mail já cadastrado!", json: false);
        }

        if ($this->repository->exists(Arr::only($dados, ["username"]), $id)) {
            return ResponseHelper::responseValidateError([], msg: "Este usuário já está cadastrado!", json: false);
        }

        if ($id && $id > 0 && !$this->repository->hasChangedPassword($id)) {
            return ResponseHelper::responseValidateError(
                msg: "Não é possível editar um usuário que ainda não alterou sua senha no primeiro acesso.", 
                json: false
            );
        }

        return ResponseHelper::responseSuccess(msg: "", json: false);
    }

    public function validateDestroy(int $id)
    {
        $model = $this->repository->find($id);
        $shelters = $model->shelters()->where('owner', true)->get()->toArray();

        if(!empty($shelters)){
            return ResponseHelper::responseValidateError([], msg: 'Não é possível remover este usuário pois é responsável por um ou mais abrigos!', json: false);
        }

        return ResponseHelper::responseSuccess(msg: '', json: false);
    }
}
