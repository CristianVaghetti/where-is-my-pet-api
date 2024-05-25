<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\ProfileRequest;
use App\Http\Validation\ProfileValidation;
use App\Repository\ProfileRepository;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected ProfileValidation $validation;
    /**
     * Repository of profile
     *
     * @var ProfileRepository
     */
    protected ProfileRepository $repository;

    /**
     * Validation of profile
     *
     * @var ProfileValidation
     */

    /**
     * Constructor
     *
     * @param ProfileRepository $repository
     * @param ProfileValidation $validation
     */
    public function __construct(ProfileRepository $repository, ProfileValidation $validation)
    {
        $this->repository = $repository;
        $this->validation = $validation;
    }
    
    public function index(Request $request)
    {
        try {
            //Realiza a busca dos usuários
            $profiles = [];
            $busca = $request->get('filter') ?? '';
            $filtros = $request->toArray() ?? [];

            if ($request->has('length')) {
                $profiles["profiles"] = $this->repository->search($busca, $filtros, $request->get('length'));
            } else {
                $profiles['profiles'] = $this->repository->search($busca, $filtros);
            }

            return ResponseHelper::responseSuccess($profiles, "");
        } catch (\Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    public function storeUpdate(ProfileRequest $request)
    {
        try {
            $data = $request->all();
            $id = null;
            $msgSuccess = "Perfil cadastrado com sucesso.";
            $msgError   = "Falha ao cadastrar perfil!";
            
            if(isset($data['id'])) {
                $msgSuccess = "Perfil alterado com sucesso.";
                $msgError   = "Falha ao alterar perfil!";

                $id = $data['id'];
            }

            $response = $this->validation->validate($data, $id);
            
            if ($response['success']) {

                $model = $this->repository->save($data);

                if ($model) {
                    $response = ResponseHelper::responseSuccess(data: $model->toArray(), msg: $msgSuccess);
                } else {
                    $response = ResponseHelper::responseError(msg: $msgError);
                }
            } else {
                $response = response()->json($response, 422);
            }
        } catch (\Exception $e) {
            $response = ResponseHelper::responseError(msg: $e->getMessage());
        }

        return $response;
    }

    public function destroy (string $id)
    {
        try {
            $response = [];
            if ($this->repository->delete($id)) {
                $response = ResponseHelper::responseSuccess(msg: "Perfil removido com sucesso.");
            } else {
                $response = ResponseHelper::responseError(msg: "Falha ao remover perfil!");
            }
        } catch (\Exception $ex) {
            $response = ResponseHelper::responseError(msg: $ex->getMessage());
        }

        return $response;
    }
}
