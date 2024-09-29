<?php

namespace App\Http\Controllers;

use App\Http\Validation\ShelterValidation;
use App\Repository\ShelterRepository;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ShelterRequest;
use App\Services\ShelterService;

class ShelterController extends Controller
{
    protected ShelterRepository $repository;
    protected ShelterValidation $validation;

    public function __construct (
        ShelterRepository $repository, 
        ShelterValidation $validation, 
        protected ShelterService $shelterService
    ) {
        $this->repository = $repository;
        $this->validation = $validation;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $shelters = [];
            $params = $request->toArray() ?? '';

            if($request->has('length')) {
                $shelters['shelters'] = $this->repository->search($params, $request->get('length'));
            } else{
                $shelters['shelters'] = $this->repository->search($params);
            }
            return ResponseHelper::responseSuccess(data: $shelters);

        }catch(\Exception $e) {
            return ResponseHelper::responseError(msg: $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShelterRequest $request)
    {
        try {
            $data = $request->all();
            
            $response = $this->validation->validate($data, 0);
            
            if ($response['success']) {
                if ($this->repository->save($data)) {
                    $response = ResponseHelper::responseSuccess(msg: 'Sucesso!');
                } else {
                    $response = ResponseHelper::responseError(msg: 'Falha!');
                }
            } else {
                $response = response()->json($response, 422);
            }
        } catch (\Exception $ex) {
            $response = ResponseHelper::responseError(msg: $ex->getMessage());
        }

        return $response;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShelterRequest $request, int $id)
    {
        try {
            $data = $request->all();
            $data['id'] = $id;
            
            $response = $this->validation->validate($data, $id);
            
            if ($response['success']) {
                if ($this->repository->save($data)) {
                    $response = ResponseHelper::responseSuccess(msg: 'Sucesso!');
                } else {
                    $response = ResponseHelper::responseError(msg: 'Falha!');
                }
            } else {
                $response = response()->json($response, 422);
            }
        } catch (\Exception $ex) {
            $response = ResponseHelper::responseError(msg: $ex->getMessage());
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            if ($this->repository->delete($id)) {
                return ResponseHelper::responseSuccess([], "Sucesso!");
            } else {
                return ResponseHelper::responseError([], "Falha!");
            }
        } catch (\Exception $ex) {
            return ResponseHelper::responseError([], $ex->getMessage());
        }
    }

    public function managementRequest(int $id)
    {
        $managementRequest = $this->shelterService->managementRequest($id);

        if (!$managementRequest) {
            return ResponseHelper::responseError([], 'Abrigo não localizado!', statusCode: 404);
        }

        return ResponseHelper::responseSuccess([], "Sucesso!");
    }
}
