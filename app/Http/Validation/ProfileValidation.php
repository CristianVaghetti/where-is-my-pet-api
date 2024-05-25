<?php

namespace App\Http\Validation;

use App\Helpers\ResponseHelper;
use App\Http\Validation\IValidation;
use App\Repository\ProfileRepository;
use Illuminate\Http\JsonResponse;

class ProfileValidation implements IValidation
{
    /**
     * Repository of Profile
     *
     * @var ProfileRepository
     */
    protected ProfileRepository $repository;

    /**
     * Create a new validation instance.
     *
     * @param ProfileRepository $repository
     * @return void
     */
    public function __construct(ProfileRepository $repository)
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
    public function validate(array $dados, $id = 0): array | JsonResponse
    {
        return ResponseHelper::responseSuccess(json: false);
    }

}