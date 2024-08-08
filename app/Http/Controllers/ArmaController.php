<?php

namespace App\Http\Controllers;

use App\Http\Requests\Arma\ArmaRequest;
use App\Http\Requests\Arma\CreateArmaRequest;
use App\Http\Requests\Arma\UpdateArmaRequest;
use App\Repositories\Contracts\ArmaInterface;
use App\Http\Requests\Arma\UpdateEstadoArmaRequest;
use App\Http\Requests\Arma\UpdateSituacionArmaRequest;
use Illuminate\Http\Request;

class ArmaController extends Controller
{
    protected $repository;

    public function __construct(ArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getArma(ArmaRequest $request)
    {
        try {
            $arma = $this->repository->getArma($request);
            return api()->ok('Resultado', $arma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }   
    }

    public function createArma(CreateArmaRequest $request)
    { 
        try {
            $arma = $this->repository->createArma($request);
            return api()->ok('Alta exitosa', $arma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }   
    }

    public function updateArma($ficha, UpdateArmaRequest $request)
    {
        try {
            $arma = $this->repository->updateArma($ficha, $request);
            return api()->ok('Modificación exitosa', $arma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }   
    }

    public function updateEstadoArma($ficha, UpdateEstadoArmaRequest $request)
    { 
        try {
            $arma = $this->repository->updateEstadoArma($ficha, $request);
            return api()->ok('Modificación exitosa', $arma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }   
    }

    public function updateSituacionArma($ficha, UpdateSituacionArmaRequest $request)
    {
        try {
            $arma = $this->repository->updateSituacionArma($ficha, $request);
            return api()->ok('Modificación exitosa', $arma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }   
    }

    public function getHistorialArma(ArmaRequest $request)
    { 
        try {
            $arma = $this->repository->getHistorialArma($request);
            return api()->ok('Resultado', $arma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }   
    }

    public function getArmasDepositoPorUd(Request $request)
    { 
        try {
            $armaUd = $this->repository->getArmasDepositoPorUd($request);
            return api()->ok('Resultados', $armaUd);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getArmasUdDevuelve(Request $request)
    { 
        try {
            $armaUd = $this->repository->getArmasUdDevuelve($request);
            return api()->ok('Resultados', $armaUd);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getArmasDependenciaAUdDevuelve(Request $request)
    { 
        try {
            $armasDependencia = $this->repository->getArmasDependenciaAUdDevuelve($request);
            return api()->ok('Resultados', $armasDependencia);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }
}