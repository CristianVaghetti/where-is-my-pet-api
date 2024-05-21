<?php

namespace App\Http\Controllers;
use App\Repository\StateRepository;
use App\Helpers\ResponseHelper;

use Illuminate\Http\Request;

class StateController extends Controller
{
    private StateRepository $repository;
    
    public function __construct(StateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return ResponseHelper::responseSuccess($this->repository->all(['name', 'ASC'])->toArray(), "");
    }
}
