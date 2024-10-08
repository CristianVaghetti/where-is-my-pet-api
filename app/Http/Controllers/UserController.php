<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\UserRequest;
use App\Http\Validation\UserValidation;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * Repository of user
     *
     * @var UserRepository
     */
    protected UserRepository $repository;

    /**
     * Validation of user
     *
     * @var UserValidation
     */
    protected UserValidation $validation;

    /**
     * Constructor
     *
     * @param UserRepository $repository
     * @param UserValidation $validation
     */
    public function __construct(UserRepository $repository, UserValidation $validation)
    {
        $this->repository = $repository;
        $this->validation = $validation;
    }

    public function index(Request $request)
    {
        try {
            $users = [];
            $filtros = $request->toArray() ?? [];
            
            if ($request->has('length')) {
                $users["users"] = $this->repository->search($filtros, $request->get('length'));
            } else {
                $users['users'] = $this->repository->search($filtros);
            }

            return ResponseHelper::responseSuccess(data: $users);
        } catch (\Exception $ex) {
            return ResponseHelper::responseError(msg: $ex->getMessage());
        }
    }

    /**
     * Storing a new user.
     */
    public function store(UserRequest $request)
    {
        try {
            $data = $request->all();
            $response = $this->validation->validate($data);

            if ($response['success']) {
                if ($this->repository->save($data)) {
                    $response = ResponseHelper::responseSuccess(msg: "Usuário criado com sucesso.");
                } else {
                    $response = ResponseHelper::responseError(msg: "Falha ao criar o usuário!");
                }
            } else {
                $response = ResponseHelper::responseError(data: $response['data'], msg: $response['msg'], statusCode: 422);
            }
        } catch (\Exception $ex) {
            $response = ResponseHelper::responseError(msg: $ex->getMessage());
        }

        return $response;
    }

    /**
     * Updatind a user.
     */
    public function update(UserRequest $request, int $id)
    {
        try {              
            $data = $request->all();
            $data['id'] = $id;
            
            $response = $this->validation->validate($data, $id);

            if ($response['success']) {
                if ($this->repository->save($data)) {
                    $response = ResponseHelper::responseSuccess(msg: "Usuário alterado com sucesso.");
                } else {
                    $response = ResponseHelper::responseError(msg: "Falha ao alterar os dados do usuário!");
                }
            } else {
                $response = ResponseHelper::responseError(data: $response['data'], msg: $response['msg'], statusCode: 422);
            }
        } catch (\Exception $ex) {
            $response = ResponseHelper::responseError(msg: $ex->getMessage());
        }

        return $response;
    }

    /**
     * Get user data for display.
     */
    public function show(int $id)
    {
        try {
            $user = $this->repository->find($id);

            if ($user) {
                return ResponseHelper::responseSuccess(data: $user->load('profile')->toArray());
            } else {
                return ResponseHelper::responseError(msg: "Usuário não encontrado!");
            }
        } catch (\Exception $ex) {
            return ResponseHelper::responseError(msg: $ex->getMessage());
        }
    }

    /**
     * Delete a user.
     */
    public function destroy(int $id)
    {
        try {
            if ((int)\auth()->user()->id === $id) {
                return ResponseHelper::responseSuccess(msg: "Suicídio não é a solução!", statusCode: 422);
            }

            $response = $this->validation->validateDestroy($id);

            if ($response['success']) {
                if ($this->repository->delete($id)) {
                    $response = ResponseHelper::responseSuccess(msg: "Usuário deletado com sucesso.");
                } else {
                    $response = ResponseHelper::responseError(msg: "Falha ao deletar o usuário!");
                }
            } else {
                $response = ResponseHelper::responseError(data: $response['data'], msg: $response['msg'], statusCode: 422);
            }
        } catch (\Exception $ex) {
            $response = ResponseHelper::responseError(msg: $ex->getMessage());
        }

        return $response;
    }
}
