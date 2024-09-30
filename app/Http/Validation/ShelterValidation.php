<?php

namespace App\Http\Validation;

use App\Helpers\ResponseHelper;
use App\Http\Validation\IValidation;
use App\Models\ShelterManagementRequest;
use App\Repository\ShelterRepository;
Use Illuminate\Support\Facades\Auth;
class ShelterValidation implements IValidation
{
    /**
     * Create a new validation instance.
     *
     * @param ShelterRepository $repository
     * @return void
     */
    public function __construct(
        protected ShelterRepository $repository, 
        protected ShelterManagementRequest $smrequest
    ) {}

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

    public function validateMRequest(int $id = 0)
    {
        $shelter = $this->repository->find($id);
        if (!$shelter) return ResponseHelper::responseValidateError(msg: 'Abrigo não localizado!', json: false);

        $smrequest = $this->smrequest->where(['shelter_id' => $id, 'user_id' => Auth::user()->id])->whereNull('viewed_at')->first();
        if ($smrequest) return ResponseHelper::responseValidateError(msg: 'Já existe uma solicitação em aberto!', json: false);

        # só pro intelephense não ficar incomodando
        /** @var \App\User $user */ 
        $user = Auth::user();
        $userShelter = $user->shelters()->where('shelter_id', $id)->first();
        if ($userShelter) return ResponseHelper::responseValidateError(msg: 'Você já pode gerenciar este abrigo!', json: false);

        return ResponseHelper::responseSuccess(json: false);
    }

    public function validateMApproval(array $data)
    {
        $smrequest = $this->smrequest->find($data['id']);
        if (!$smrequest) return ResponseHelper::responseValidateError(msg: 'Solicitação não localizada!', json: false);

        $shelter = $smrequest->shelter;
        if (!$shelter->my_shelter) return ResponseHelper::responseValidateError(msg: 'Você não é o responsável por este abrigo!', json: false);

        return ResponseHelper::responseSuccess(json: false);
    }
}