<?php

namespace App\Http\Controllers;

use App\Http\Requests\CuibArma\CreateCuibArmaRequest;
use App\Http\Requests\CuibArma\GetCuibsArmaRequest;
use Illuminate\Http\Request;
use App\Repositories\Contracts\CuibArmaInterface;

class CuibArmaController extends Controller
{
    protected $repository;

    public function __construct(CuibArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getCuibsArma(GetCuibsArmaRequest $request)
    { 
        try {
            $cuibsArma = $this->repository->getCuibsArma($request);
            return api()->ok('Cuibs de arma', $cuibsArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function createCuibArma(CreateCuibArmaRequest $request)
    { 
        try {
            $arma = $this->repository->createCuibArma($request);
            return api()->ok('Alta exitosa', $arma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }   
    }
}
