<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Requests\PetRequest;
use App\Repository\PetRepository;
use App\Http\Validation\PetValidation;

class PetController extends Controller
{
    protected PetRepository $repository;
    protected PetValidation $validation;

    public function __construct(PetRepository $repository, PetValidation $validation)
    {
        $this->repository = $repository;
        $this->validation = $validation;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $pets = [];
            $params = $request->toArray() ?? '';

            if($request->has('length')) {
                $pets['pets'] = $this->repository->search($params, $request->get('length'));
            } else{
                $pets['pets'] = $this->repository->search($params);
            }
            return ResponseHelper::responseSuccess(data: $pets);

        }catch(\Exception $e) {
            return ResponseHelper::responseError(msg: $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PetRequest $request)
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
    public function update(PetRequest $request, int $id)
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

    public function fetchTypes()
    {
        $types['types'] = $this->repository->fetchTypes();
        
        return ResponseHelper::responseSuccess(data: $types);
    }
}
