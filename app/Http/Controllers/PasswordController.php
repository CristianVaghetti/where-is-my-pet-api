<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Repository\PasswordRepository;
use App\Http\Validation\PasswordValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    protected PasswordRepository $repository;
    protected PasswordValidation $validation;

    /**
     * Create a new controller instance
     * 
     * @param PasswordRepository $repository 
     * @return void 
     */
    public function __construct(
        PasswordRepository $repository, 
        PasswordValidation $validation
    )
    {
        $this->repository = $repository;
        $this->validation = $validation;
    }

    public function forgot(ForgotPasswordRequest $request)
    {
        try {
            $data = $request->all();
            $response = $this->validation->validate($data);
            if ($response['success']) {
                if ($this->repository->forgot($data)) {
                    $response = ResponseHelper::responseSuccess([], "E-mail de atualização de senha enviado!");
                } else {
                    $response = ResponseHelper::responseError([], "Falha ao enviar email!");
                }
            } else {
                $response = response()->json($response, 422);
            }
        } catch (\Exception $ex) {
            $response = ResponseHelper::responseError([], $ex->getMessage());
        }

        return $response;
    }

    public function reset(ResetPasswordRequest $request)
    {
        try {
            $data = $request->all();
            if ($this->repository->reset($data)) {
                $response = ResponseHelper::responseSuccess([], "Alteração de senha bem-sucedida.");
            } else {
                $response = ResponseHelper::responseError([], "Falha ao atualizar a senha!");
            }
        } catch (\Exception $ex) {
            $response = ResponseHelper::responseError([], $ex->getMessage());
        }

        return $response;
    }

    public function change(ChangePasswordRequest $request)
    {
        try {
            $data = $request->all();
            $id = (int)$request->id;

            if(!Hash::check($data['password'], Auth::user()->password)){
                return ResponseHelper::responseError(msg: "Senha atual inválida!", statusCode: 401);
            }
            
            if ($this->repository->change($data, $id)) {
                $response = ResponseHelper::responseSuccess(msg: "Senha aterada com sucesso.");
            } else {
                $response = ResponseHelper::responseError(msg: "Falha ao alterar a senha!");
            }
        } catch (\Exception $ex) {
            $response = ResponseHelper::responseError(msg: $ex->getMessage());
        }

        return $response;
    }
}
