<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Http\Validation\ShelterValidation;
use App\Models\ShelterManagementRequest;
use App\Repository\ShelterRepository;

class ShelterService
{
    public function __construct(
        protected ShelterRepository $shelterRepository,
        protected ShelterManagementRequest $smrequest,
        protected ShelterValidation $validation,
    ) {}

    public function managementRequest(int $id)
    {
        $validation = $this->validation->validateMRequest($id);
        if(!$validation['success']) return $validation;

        $shelter = $this->shelterRepository->find($id);

        if ($this->shelterRepository->managementRequest($shelter->id)) {
            return ResponseHelper::responseSuccess(msg: 'Sucesso!');
        } else {
            return ResponseHelper::responseError(msg: 'Falha!');
        }
    }

    public function managementApproval(array $data = [])
    {
        $validation = $this->validation->validateMApproval($data);
        if(!$validation['success']) return $validation;

        $smrequest = $this->smrequest->find($data['id']);

        if ($this->shelterRepository->managementApproval($smrequest, $data['approved'])) {
            return ResponseHelper::responseSuccess(msg: 'Sucesso!');
        } else {
            return ResponseHelper::responseError(msg: 'Falha!');
        }
    }
}
