<?php

namespace App\Http\Controllers;
use App\Repository\CityRepository;
use App\Helpers\ResponseHelper;

use Illuminate\Http\Request;

class CityController extends Controller
{
    private CityRepository $repository;

    public function __construct(CityRepository $repository)
    {
        $this->repository = $repository;
    }
}
