<?php

namespace App\Http\Validation;

use App\Helpers\ResponseHelper;
use App\Http\Validation\IValidation;
use App\Repository\PetRepository;
use Illuminate\Support\Arr;

class PetValidation implements IValidation
{
    /**
     * Repository of Shelter
     *
     * @var PetRepository
     */
    protected PetRepository $repository;

    /**
     * Create a new validation instance.
     *
     * @param PetRepository $repository
     * @return void
     */
    public function __construct(PetRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Make a busines validate
     *
     * @param array $dados
     * @param int|null $id
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function validate(array $dados, $id = 0)
    {
        return ResponseHelper::responseSuccess(json: false);
    }

}