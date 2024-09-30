<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Models\ShelterManagementRequest;
use App\Repository\ShelterRepository;
use Illuminate\Support\Facades\Auth;

class ShelterService
{
    public function __construct(
        protected ShelterRepository $shelterRepository,
        protected ShelterManagementRequest $smrequest
    ) {}

    public function managementRequest(int $id)
    {
        $shelter = $this->shelterRepository->find($id);
        if (!$shelter) return ResponseHelper::responseError(msg: 'Abrigo não localizado!');

        $smrequest = $this->smrequest->where(['shelter_id' => $id, 'user_id' => Auth::user()->id])->whereNull('viewed_at')->first();
        if ($smrequest) return ResponseHelper::responseError(msg: 'Já existe uma solicitação em aberto!');

        # só pro intelephense não ficar incomodando
        /** @var \App\User $user */ 
        $user = Auth::user();
        $userShelter = $user->shelters()->where('shelter_id', $id)->first();
        if ($userShelter) return ResponseHelper::responseError(msg: 'Você já pode gerenciar este abrigo!');

        if ($this->shelterRepository->managementRequest($shelter->id)) {
            return ResponseHelper::responseSuccess(msg: 'Sucesso!');
        } else {
            return ResponseHelper::responseError(msg: 'Falha!');
        }
    }

    public function managementApproval(array $data = [])
    {
        $smrequest = $this->smrequest->find($data['id']);
        if (!$smrequest) return ResponseHelper::responseValidateError(msg: 'Solicitação não localizada!');

        $shelter = $smrequest->shelter;
        if (!$shelter->my_shelter) return ResponseHelper::responseValidateError(msg: 'Você não é o responsável por este abrigo!');

        if ($this->shelterRepository->managementApproval($smrequest, $data['approved'])) {
            return ResponseHelper::responseSuccess(msg: 'Sucesso!');
        } else {
            return ResponseHelper::responseError(msg: 'Falha!');
        }
    }
}
