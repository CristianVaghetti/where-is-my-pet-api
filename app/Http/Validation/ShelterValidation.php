<?php

namespace App\Http\Validation;

use App\Helpers\ResponseHelper;
use App\Http\Validation\IValidation;
use App\Repository\ShelterRepository;
use Illuminate\Support\Arr;

class ShelterValidation implements IValidation
{
    /**
     * Repository of Shelter
     *
     * @var ShelterRepository
     */
    protected ShelterRepository $repository;

    /**
     * Create a new validation instance.
     *
     * @param ShelterRepository $repository
     * @return void
     */
    public function __construct(ShelterRepository $repository)
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