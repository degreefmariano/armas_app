<?php

namespace App\Http\Controllers;

use App\Http\Requests\Consultas\ArmasFiltrosRequest;
use App\Http\Requests\Consultas\ArmaClaveRequest;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ConsultaArmaInterface;

class ConsultaArmaController extends Controller
{
    protected $repository;

    public function __construct(ConsultaArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getArmasFiltros(ArmasFiltrosRequest $request)
    { 
        try {
            $FiltrosArma = $this->repository->getArmasFiltros($request);
            return api()->ok('Resultados', $FiltrosArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
        
    }

    public function getArmaClave(ArmaClaveRequest $request)
    { 
        try {
            $claveArma = $this->repository->getArmaClave($request);
            return api()->ok('Resultados', $claveArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
        
    }

    public function getArmaClaveAsignar(ArmaClaveRequest $request)
    { 
        try {
            $armaClaveAsignar = $this->repository->getArmaClaveAsignar($request);
            return api()->ok('Resultados', $armaClaveAsignar);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
        
    }

}